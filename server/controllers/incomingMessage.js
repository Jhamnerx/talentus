import {
    getAutoreplies,
    getDevice,
    saveMessageHistory,
} from "../database/index.js";
import { parseIncomingMessage } from "../lib/helper.js";
import axios from "axios";
import logger from "../lib/pino.js";
import { downloadMediaMessage } from "baileys";
import { writeFile, mkdir } from "fs/promises";
import path from "path";

const LARAVEL_URL = process.env.LARAVEL_URL || "http://localhost";
const INTERNAL_TOKEN = process.env.INTERNAL_TOKEN || "";
const MEDIA_ROOT = process.env.WA_MEDIA_ROOT || "./storage/app/whatsapp";

const MEDIA_EXT = {
    image: "jpg",
    video: "mp4",
    audio: "ogg",
    document: "bin",
    sticker: "webp",
};

function mapMessageType(messageType) {
    const map = {
        conversation: "text",
        extendedTextMessage: "text",
        imageMessage: "image",
        videoMessage: "video",
        audioMessage: "audio",
        documentMessage: "document",
        stickerMessage: "sticker",
        locationMessage: "location",
        contactMessage: "contact",
    };
    return map[messageType] || "text";
}

/**
 * Limpiar número de teléfono
 */
const cleanPhoneNumber = (jid) => {
    if (typeof jid !== "string") return jid;

    try {
        let cleanNumber = jid.replace(/@.*$/g, "");

        if (cleanNumber.includes(":")) {
            cleanNumber = cleanNumber.split(":")[0];
        }

        cleanNumber = cleanNumber.replace(/\D/g, "");
        return cleanNumber;
    } catch (error) {
        logger.error("Error limpiando número:", error);
        return jid;
    }
};

/**
 * Procesar mensajes entrantes
 */
export async function IncomingMessage(
    messageUpsert,
    whatsappClient,
    deviceToken = null,
) {
    try {
        if (!messageUpsert.messages || messageUpsert.messages.length === 0) {
            return;
        }

        const message = messageUpsert.messages[0];

        // Filtrar mensajes propios y de estado
        if (message.key.fromMe === true) return;
        if (message.key.remoteJid === "status@broadcast") return;

        // Parsear mensaje
        const {
            command: messageText,
            body: fullBody,
            bufferImage,
            from,
            senderName,
            messageType,
        } = await parseIncomingMessage(message);

        const remoteJid = message.key.remoteJid;
        const cleanFromNumber =
            cleanPhoneNumber(from) || cleanPhoneNumber(remoteJid);
        // Usar el token pasado directamente para evitar problemas con prefijo de país en user.id
        const deviceNumber =
            deviceToken || whatsappClient.user.id.split(":")[0];

        logger.info("📥 Mensaje entrante:", {
            from: cleanFromNumber,
            device: deviceNumber,
            message: messageText,
            type: messageType,
        });

        // Obtener dispositivo de la base de datos
        const device = await getDevice(deviceNumber);
        if (!device) {
            logger.error("Dispositivo no encontrado en BD:", deviceNumber);
            return;
        }

        // Buscar auto-respuestas
        const autoreplies = await getAutoreplies(deviceNumber);
        let responseFound = false;

        // Determinar si el mensaje viene de un grupo o chat personal
        const isGroupMessage = remoteJid.endsWith("@g.us");
        const isPersonalMessage = !isGroupMessage;

        for (const autoreply of autoreplies) {
            // ── Filtro reply_when ──────────────────────────────────────────
            const replyWhen = (autoreply.reply_when || "All").toLowerCase();
            if (replyWhen === "group" && !isGroupMessage) continue;
            if (replyWhen === "personal" && !isPersonalMessage) continue;

            // ── Coincidencia de keyword ────────────────────────────────────
            const keyword = autoreply.keyword.toLowerCase();
            const typeKeyword = (
                autoreply.type_keyword || "Equal"
            ).toLowerCase();
            const msgNormalized = messageText.toLowerCase().trim();

            const matchExact =
                typeKeyword === "equal" && msgNormalized === keyword;
            const matchContains =
                typeKeyword === "contain" && msgNormalized.includes(keyword);

            if (!matchExact && !matchContains) continue;

            responseFound = true;

            try {
                let replyData = autoreply.reply;

                // Si reply es string, intentar parsear como JSON
                if (typeof replyData === "string") {
                    try {
                        replyData = JSON.parse(replyData);
                    } catch (e) {
                        // Si no es JSON válido, crear mensaje de texto simple
                        replyData = { text: replyData };
                    }
                }

                // Enviar respuesta
                const options = autoreply.is_quoted ? { quoted: message } : {};

                await whatsappClient.sendMessage(remoteJid, replyData, options);

                logger.info("✅ Auto-respuesta enviada:", keyword);

                // Guardar en historial
                await saveMessageHistory({
                    device_id: device.id,
                    user_id: device.user_id,
                    number: cleanFromNumber,
                    type: autoreply.type,
                    message: JSON.stringify(replyData),
                    payload: replyData,
                    status: "success",
                    send_by: "api",
                    note: `Auto-reply: ${keyword}`,
                });
            } catch (error) {
                logger.error("Error enviando auto-respuesta:", error);
            }

            break; // Solo enviar la primera coincidencia
        }

        // === Persistencia omnicanal (siempre, independiente de autoreply/webhook) ===
        const waMessageId = message.key.id;
        const normalizedType = mapMessageType(messageType);
        const mediaMeta = await storeIncomingMedia(
            message,
            deviceNumber,
            waMessageId,
            normalizedType,
        );

        await persistIncomingToLaravel({
            device: deviceNumber,
            wa_message_id: waMessageId,
            from: cleanFromNumber,
            wa_jid: remoteJid,
            push_name: senderName || null,
            type: normalizedType,
            body: fullBody || messageText || null,
            timestamp: Math.floor(Date.now() / 1000),
            is_group: isGroupMessage,
            ...(mediaMeta || {}),
        });

        // Si no hay auto-respuesta, enviar webhook
        if (!responseFound && device.webhook) {
            try {
                const webhookData = {
                    device: deviceNumber,
                    from: cleanFromNumber,
                    sender: senderName,
                    message: fullBody,
                    messageText: messageText,
                    type: messageType,
                    timestamp: Date.now(),
                    remoteJid: remoteJid,
                };

                if (bufferImage) {
                    webhookData.image = bufferImage;
                }

                await axios.post(device.webhook, webhookData, {
                    timeout: 10000,
                    headers: {
                        "Content-Type": "application/json",
                    },
                });

                logger.info("📤 Webhook enviado:", device.webhook);
            } catch (error) {
                logger.error("Error enviando webhook:", error.message);
            }
        }
    } catch (error) {
        logger.error("Error procesando mensaje entrante:", error);
    }
}

/**
 * Descarga el media del mensaje y lo guarda en el disco compartido de Laravel.
 * Devuelve metadatos o null si no hay media.
 */
async function storeIncomingMedia(message, deviceToken, waMessageId, type) {
    const mediaTypes = ["image", "video", "audio", "document", "sticker"];
    if (!mediaTypes.includes(type)) return null;

    try {
        const buffer = await downloadMediaMessage(message, "buffer", {});
        const ext = MEDIA_EXT[type] || "bin";
        const safeId = String(waMessageId).replace(/[^a-zA-Z0-9_-]/g, "_");
        const dir = path.join(MEDIA_ROOT, deviceToken);
        await mkdir(dir, { recursive: true });

        const fileName = `${safeId}.${ext}`;
        const fullPath = path.join(dir, fileName);
        await writeFile(fullPath, buffer);

        const content = message.message || {};
        const node =
            content.imageMessage ||
            content.videoMessage ||
            content.audioMessage ||
            content.documentMessage ||
            content.stickerMessage ||
            {};

        return {
            media_path: `whatsapp/${deviceToken}/${fileName}`,
            mime_type: node.mimetype || null,
            file_name: node.fileName || fileName,
            file_size: buffer.length,
        };
    } catch (error) {
        logger.error("Error descargando media WA:", error.message);
        return null;
    }
}

/**
 * Persiste el mensaje entrante en Laravel (endpoint interno).
 */
async function persistIncomingToLaravel(payload) {
    try {
        await axios.post(`${LARAVEL_URL}/api/internal/whatsapp/incoming`, payload, {
            timeout: 10000,
            headers: {
                "Content-Type": "application/json",
                "X-Internal-Token": INTERNAL_TOKEN,
            },
        });
    } catch (error) {
        logger.error(
            "Error persistiendo mensaje en Laravel:",
            error?.response?.status || error.message,
        );
    }
}
