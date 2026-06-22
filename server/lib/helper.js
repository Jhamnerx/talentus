import { downloadContentFromMessage } from "baileys";
import logger from "./pino.js";

/**
 * Format phone number to WhatsApp format
 * @param {string} receipt - Phone number to format
 * @returns {string} Formatted phone number
 */
export function formatReceipt(receipt) {
    try {
        // Si ya es un JID de grupo, retornar tal cual
        if (receipt.endsWith("@g.us")) {
            return receipt;
        }

        // Si ya está formateado, retornar tal cual
        if (
            receipt.endsWith("@c.us") ||
            receipt.endsWith("@s.whatsapp.net") ||
            receipt.endsWith("@lid")
        ) {
            return receipt;
        }

        // Limpiar número (solo dígitos)
        let formatted = receipt.replace(/\D/g, "");

        // Convertir números locales (ejemplo: 0xxx a 62xxx para Indonesia)
        // Ajusta según tu país
        if (formatted.startsWith("0")) {
            formatted = "62" + formatted.substr(1);
        }

        // Agregar sufijo de WhatsApp
        if (!formatted.endsWith("@s.whatsapp.net")) {
            formatted += "@s.whatsapp.net";
        }

        return formatted;
    } catch (error) {
        logger.error("Error formatting receipt:", error);
        return receipt;
    }
}

/**
 * Ejecutar forEach de manera asíncrona
 */
export async function asyncForEach(array, callback) {
    for (let index = 0; index < array.length; index++) {
        await callback(array[index], index, array);
    }
}

/**
 * Remover caracteres prohibidos
 */
export function removeForbiddenCharacters(input) {
    return input.replace(/[^a-zA-Z0-9 #\/:\.\-]/g, "");
}

/**
 * Parsear mensaje entrante de WhatsApp
 */
export async function parseIncomingMessage(msg) {
    const messageType = Object.keys(msg.message || {})[0];

    let body = "";
    let bufferImage = null;

    switch (messageType) {
        case "conversation":
            body = msg.message.conversation;
            break;
        case "imageMessage":
            body = msg.message.imageMessage.caption || "";
            try {
                const stream = await downloadContentFromMessage(
                    msg.message.imageMessage,
                    "image",
                );
                let buffer = Buffer.from([]);
                for await (const chunk of stream) {
                    buffer = Buffer.concat([buffer, chunk]);
                }
                bufferImage = buffer.toString("base64");
            } catch (error) {
                logger.error("Error downloading image:", error);
            }
            break;
        case "videoMessage":
            body = msg.message.videoMessage.caption || "";
            break;
        case "extendedTextMessage":
            body = msg.message.extendedTextMessage.text;
            break;
        case "messageContextInfo":
            if (msg.message.listResponseMessage) {
                body = msg.message.listResponseMessage.title;
            } else if (msg.message.buttonsResponseMessage) {
                body = msg.message.buttonsResponseMessage.selectedDisplayText;
            }
            break;
        default:
            body = "";
    }

    const command = removeForbiddenCharacters(body.toLowerCase());
    const senderName = msg?.pushName || "";
    const from = msg.key.remoteJid.split("@")[0];

    return {
        command,
        body,
        bufferImage,
        from,
        senderName,
        messageType,
    };
}

/**
 * Sleep function
 */
export function sleep(ms) {
    return new Promise((resolve) => setTimeout(resolve, ms));
}
