import makeWASocket, {
    DisconnectReason,
    Browsers,
    delay,
    makeCacheableSignalKeyStore,
    proto,
    generateMessageIDV2,
} from "baileys";
import QRCode from "qrcode";
import { Boom } from "@hapi/boom";
import { setStatus } from "./database/index.js";
import {
    getMySQLAuthState,
    clearAuthState,
    MySQLMessageStore,
    MySQLGroupMetadataCache,
    MySQLLidMappingStore,
} from "./database/authState.js";
import { IncomingMessage } from "./controllers/incomingMessage.js";
import { formatReceipt } from "./lib/helper.js";
import logger from "./lib/pino.js";
import axios from "axios";

const LARAVEL_URL = process.env.LARAVEL_URL || "http://localhost";
const INTERNAL_TOKEN = process.env.INTERNAL_TOKEN || "";

const WA_STATUS_MAP = {
    1: "sent",
    2: "delivered",
    3: "read",
    4: "read",
};

async function reportStatusToLaravel(deviceToken, waMessageId, statusCode) {
    const status = WA_STATUS_MAP[statusCode];
    if (!status || !waMessageId) return;

    try {
        await axios.post(
            `${LARAVEL_URL}/api/internal/whatsapp/status`,
            { device: deviceToken, wa_message_id: waMessageId, status },
            {
                timeout: 8000,
                headers: {
                    "Content-Type": "application/json",
                    "X-Internal-Token": INTERNAL_TOKEN,
                },
            },
        );
    } catch (error) {
        logger.error(
            "Error reportando estado a Laravel:",
            error?.response?.status || error.message,
        );
    }
}

// Almacenamiento de sockets y QR codes
const sockets = new Map();
const qrCodes = new Map();
const retryCount = new Map();
const contactsCache = new Map(); // Cache de contactos por dispositivo
const connectedSessions = new Set(); // Sesiones con conexión abierta (connection === "open")

/**
 * Generar delay aleatorio para simular comportamiento humano
 * @param {number} min - Mínimo en milisegundos (default: 1000ms)
 * @param {number} max - Máximo en milisegundos (default: 3000ms)
 * @returns {Promise<void>}
 */
async function randomDelay(min = 1000, max = 3000) {
    const delayTime = Math.floor(Math.random() * (max - min + 1)) + min;
    await delay(delayTime);
}

/**
 * Simular actividad humana antes de enviar mensaje
 * @param {object} sock - Socket de WhatsApp
 * @param {string} jid - JID del destinatario
 * @param {boolean} available - Si está disponible (default: true)
 * @returns {Promise<void>}
 */
async function simulateHumanActivity(sock, jid, available = true) {
    try {
        // Mostrar "en línea"
        if (available) {
            await sock.sendPresenceUpdate("available", jid);
            await randomDelay(500, 1500);
        }

        // Mostrar "escribiendo..."
        await sock.sendPresenceUpdate("composing", jid);

        // Delay aleatorio mientras "escribe" (1-4 segundos)
        await randomDelay(1000, 4000);

        // Dejar de escribir (paused)
        await sock.sendPresenceUpdate("paused", jid);

        // Pequeño delay antes de enviar
        await randomDelay(300, 800);
    } catch (error) {
        logger.warn(`Error simulando actividad humana: ${error.message}`);
    }
}

/**
 * Conectar a WhatsApp con Baileys 7.0
 */
export async function connectToWhatsApp(token, io = null) {
    // Si ya tiene QR, retornarlo
    if (qrCodes.has(token)) {
        if (io) {
            io.emit("qrcode", {
                token,
                data: qrCodes.get(token),
                message: "Por favor escanea con tu cuenta de WhatsApp",
            });
        }
        return {
            status: false,
            qrcode: qrCodes.get(token),
            message: "Escanea el código QR",
        };
    }

    // Si ya está conectado
    const existingSock = sockets.get(token);
    if (existingSock?.user) {
        const ppUrl = await getPpUrl(token, existingSock.user.id).catch(
            () => null,
        );

        if (io) {
            io.emit("connection-open", {
                token,
                user: existingSock.user,
                ppUrl,
            });
        }

        return {
            status: true,
            message: "Ya está conectado",
        };
    }

    try {
        // Auth State desde MySQL usando mysql-baileys
        const { state, saveCreds, removeCreds } =
            await getMySQLAuthState(token);

        // Message Store
        const messageStore = new MySQLMessageStore(token);

        // Group Metadata Cache
        const groupMetadataCache = new MySQLGroupMetadataCache(token);

        // LID Mapping Store
        const lidMappingStore = new MySQLLidMappingStore();

        // Crear socket (Baileys 7.0 usa versión estable por defecto)
        const sock = makeWASocket({
            logger: logger.child({ level: "silent" }),
            printQRInTerminal: false,
            browser: Browsers.macOS("Desktop"),
            auth: {
                creds: state.creds,
                keys: makeCacheableSignalKeyStore(state.keys, logger),
            },
            getMessage: async (key) => {
                // Obtener mensaje del store
                const message = await messageStore.getMessage(
                    key.remoteJid,
                    key.id,
                    key.fromMe,
                );
                return (
                    message || {
                        conversation: "Message not available",
                    }
                );
            },
            cachedGroupMetadata: async (jid) => {
                return await groupMetadataCache.get(jid);
            },
            markOnlineOnConnect: false,
        });

        sockets.set(token, sock);

        // === EVENTOS ===

        // Credenciales
        sock.ev.on("creds.update", saveCreds);

        // Conexión
        sock.ev.on("connection.update", async (update) => {
            const { connection, lastDisconnect, qr } = update;

            // QR Code
            if (qr) {
                const qrDataURL = await QRCode.toDataURL(qr);
                qrCodes.set(token, qrDataURL);

                if (io) {
                    io.emit("qrcode", {
                        token,
                        data: qrDataURL,
                        message: "Por favor escanea con tu cuenta de WhatsApp",
                    });
                }
            }

            // Conexión cerrada
            if (connection === "close") {
                connectedSessions.delete(token); // Marcar sesión como desconectada
                const statusCode = lastDisconnect?.error?.output?.statusCode;
                const errorMessage = lastDisconnect?.error?.message || "";

                logger.info(
                    `Conexión cerrada para ${token}. StatusCode: ${statusCode}, Error: ${errorMessage}`,
                );

                // Detectar si la sesión fue cerrada remotamente o credenciales inválidas
                const isLoggedOut = statusCode === DisconnectReason.loggedOut;
                const isUnauthorized =
                    statusCode === 401 ||
                    statusCode === DisconnectReason.badSession;
                const isConnectionFailure = statusCode === 405; // Connection Failure - credenciales corruptas
                const isTimedOut = statusCode === DisconnectReason.timedOut;
                const isConnectionLost =
                    statusCode === DisconnectReason.connectionLost;

                // Si es logout, unauthorized, bad session o connection failure (405), limpiar credenciales
                if (isLoggedOut || isUnauthorized || isConnectionFailure) {
                    logger.warn(
                        `❌ Sesión inválida detectada para ${token} (Código: ${statusCode}). Limpiando credenciales...`,
                    );

                    connectedSessions.delete(token);
                    await setStatus(token, "Disconnect");
                    await clearAuthState(token);
                    sockets.delete(token);
                    qrCodes.delete(token);
                    retryCount.delete(token);
                    contactsCache.delete(token);

                    if (isConnectionFailure) {
                        // Error 405: WhatsApp rechaza el registro (noise protocol failure).
                        // NO reconectar automáticamente - el usuario debe iniciar el escaneo manualmente.
                        logger.warn(
                            `⛔ Error 405 para ${token}: WhatsApp rechazó la conexión. Esperando acción del usuario...`,
                        );
                        if (io) {
                            io.emit("logged-out", {
                                token,
                                message:
                                    "Error de conexión con WhatsApp. Ve a la página de escaneo para obtener un nuevo QR.",
                                requiresManualReconnect: true,
                            });
                        }
                        // NO llamar connectToWhatsApp - detener el bucle
                        return;
                    }

                    if (io) {
                        io.emit("logged-out", {
                            token,
                            message:
                                "Sesión cerrada remotamente. Escanea el QR nuevamente.",
                        });
                    }

                    // Generar nuevo QR automáticamente (solo para loggedOut/unauthorized)
                    logger.info(`🔄 Generando nuevo QR para ${token}...`);
                    await delay(2000);
                    connectToWhatsApp(token, io);
                    return;
                }

                // Si es timeout o conexión perdida, intentar reconectar
                if (isTimedOut || isConnectionLost) {
                    const retries = retryCount.get(token) || 0;

                    if (retries >= 3) {
                        logger.error(
                            `⚠️ Máximo de reintentos alcanzado para ${token}. Limpiando sesión inválida...`,
                        );

                        // Después de 3 intentos fallidos, asumir que la sesión es inválida
                        await setStatus(token, "Disconnect");
                        await clearAuthState(token);
                        sockets.delete(token);
                        qrCodes.delete(token);
                        retryCount.delete(token);
                        contactsCache.delete(token);

                        if (io) {
                            io.emit("session-expired", {
                                token,
                                message:
                                    "Sesión expirada. Escanea el QR nuevamente.",
                            });
                        }

                        // Generar nuevo QR
                        await delay(2000);
                        connectToWhatsApp(token, io);
                        return;
                    }

                    retryCount.set(token, retries + 1);
                    const delayTime = Math.min(5000 * (retries + 1), 15000); // Backoff exponencial

                    logger.info(
                        `🔄 Reintentando conexión para ${token} en ${delayTime}ms (intento ${retries + 1}/3)`,
                    );
                    await delay(delayTime);
                    qrCodes.delete(token);
                    connectToWhatsApp(token, io);
                    return;
                }

                // Otros errores: intentar reconectar con límite
                const retries = retryCount.get(token) || 0;

                if (retries >= 2) {
                    logger.error(
                        `❌ Demasiados errores para ${token}. Limpiando sesión y generando nuevo QR...`,
                    );

                    // Después de 2 intentos de errores desconocidos, limpiar
                    await setStatus(token, "Disconnect");
                    await clearAuthState(token);
                    sockets.delete(token);
                    qrCodes.delete(token);
                    retryCount.delete(token);
                    contactsCache.delete(token);

                    if (io) {
                        io.emit("session-error", {
                            token,
                            message: "Error de conexión. Generando nuevo QR...",
                        });
                    }

                    // Generar nuevo QR
                    await delay(3000);
                    connectToWhatsApp(token, io);
                    return;
                }

                retryCount.set(token, retries + 1);
                logger.warn(
                    `⚠️ Error desconocido para ${token} (intento ${retries + 1}/2). Intentando reconectar en 5s...`,
                );
                await delay(5000);
                qrCodes.delete(token);
                connectToWhatsApp(token, io);
            }

            // Conexión abierta
            if (connection === "open") {
                connectedSessions.add(token);
                await setStatus(token, "Connected");
                retryCount.set(token, 0);
                qrCodes.delete(token);

                // Obtener nombre del usuario
                let userName =
                    sock.user.name || sock.user.verifiedName || "undefined";

                // Si no tiene nombre, intentar obtenerlo del número
                if (userName === "undefined") {
                    try {
                        const numberJid = sock.user.id;
                        const [contactInfo] = await sock.onWhatsApp(numberJid);
                        userName =
                            contactInfo?.verifiedName ||
                            contactInfo?.notify ||
                            "undefined";
                    } catch (error) {
                        logger.error(
                            "Error obteniendo nombre de contacto:",
                            error,
                        );
                    }
                }

                const ppUrl = await getPpUrl(token, sock.user.id).catch(
                    () => null,
                );

                // LOG COMPLETO para debugging
                logger.info(`=== DATOS DE CONEXIÓN ABIERTA ===`);
                logger.info(`Token: ${token}`);
                logger.info(`sock.user completo:`, sock.user);
                logger.info(`sock.user.name: ${sock.user?.name}`);
                logger.info(
                    `sock.user.verifiedName: ${sock.user?.verifiedName}`,
                );
                logger.info(`sock.user.id: ${sock.user?.id}`);
                logger.info(`sock.user.lid: ${sock.user?.lid}`);
                logger.info(`userName obtenido: ${userName}`);
                logger.info(`ppUrl: ${ppUrl}`);
                logger.info(
                    `Propiedades de sock.user: ${Object.keys(
                        sock.user || {},
                    ).join(", ")}`,
                );
                logger.info(`================================`);

                logger.info(`Dispositivo ${token} conectado exitosamente`);

                if (io) {
                    const eventData = {
                        token,
                        user: {
                            id: sock.user.id,
                            lid: sock.user.lid,
                            name: userName,
                        },
                        ppUrl,
                    };

                    logger.info(
                        `Emitiendo evento connection-open con:`,
                        eventData,
                    );

                    io.emit("connection-open", eventData);
                }
            }
        });

        // Mensajes entrantes
        sock.ev.on("messages.upsert", async ({ messages, type }) => {
            if (type !== "notify") return;

            for (const msg of messages) {
                // Guardar mensaje en store
                if (msg.key.remoteJid && msg.key.id) {
                    await messageStore.saveMessage(
                        msg.key.remoteJid,
                        msg.key.id,
                        msg.key.fromMe || false,
                        msg,
                    );
                }

                // Procesar mensaje
                try {
                    await IncomingMessage({ messages, type }, sock, token);
                } catch (error) {
                    logger.error("Error procesando mensaje:", error);
                }
            }
        });

        // Actualización de grupos
        sock.ev.on("groups.update", async (updates) => {
            for (const update of updates) {
                if (update.id) {
                    try {
                        // Solo actualizar metadata si la conexión está completamente abierta
                        if (!connectedSessions.has(token)) return;

                        const metadata = await sock.groupMetadata(update.id);
                        await groupMetadataCache.set(update.id, metadata);
                    } catch (error) {
                        const errMsg =
                            error?.message ||
                            error?.toString() ||
                            JSON.stringify(error) ||
                            "Error desconocido";
                        // Solo loguear si no es un error de socket cerrado (evitar spam)
                        if (
                            !errMsg.includes("Connection Closed") &&
                            !errMsg.includes("not-authorized") &&
                            !errMsg.includes("timed out")
                        ) {
                            logger.error(
                                `Error actualizando grupo ${update.id}: ${errMsg}`,
                            );
                        }
                    }
                }
            }
        });

        // LID Mappings (Baileys 7.0)
        sock.ev.on("messaging-history.set", async ({ contacts }) => {
            if (contacts && contacts.length > 0) {
                // Almacenar contactos en cache
                const deviceContacts = contactsCache.get(token) || new Map();

                for (const contact of contacts) {
                    // Guardar contacto con su número de teléfono
                    if (contact.id && contact.id.endsWith("@s.whatsapp.net")) {
                        const number = contact.id.replace(
                            "@s.whatsapp.net",
                            "",
                        );
                        deviceContacts.set(number, {
                            number: number,
                            name:
                                contact.name ||
                                contact.notify ||
                                contact.verifiedName ||
                                null,
                            notify: contact.notify || null,
                            lid: contact.lid || null,
                        });
                    }
                }

                contactsCache.set(token, deviceContacts);
                logger.info(
                    `Almacenados ${deviceContacts.size} contactos en cache para ${token}`,
                );

                // Guardar mappings LID
                const mappings = {};
                for (const contact of contacts) {
                    if (contact.lid && contact.id) {
                        mappings[contact.lid] = contact.id.split("@")[0];
                    }
                }
                if (Object.keys(mappings).length > 0) {
                    await lidMappingStore.storeLIDPNMappings(mappings);
                }
            }
        });

        // Evento de contactos upsert (actualización de contactos)
        sock.ev.on("contacts.upsert", (upsertedContacts) => {
            const deviceContacts = contactsCache.get(token) || new Map();

            for (const contact of upsertedContacts) {
                if (contact.id && contact.id.endsWith("@s.whatsapp.net")) {
                    const number = contact.id.replace("@s.whatsapp.net", "");
                    deviceContacts.set(number, {
                        number: number,
                        name:
                            contact.name ||
                            contact.notify ||
                            contact.verifiedName ||
                            null,
                        notify: contact.notify || null,
                        lid: contact.lid || null,
                    });
                }
            }

            contactsCache.set(token, deviceContacts);
            logger.debug(
                `Cache de contactos actualizado para ${token}: ${deviceContacts.size} contactos`,
            );
        });

        // Actualizaciones de mensajes
        sock.ev.on("messages.update", (updates) => {
            for (const update of updates) {
                if (update.update.status) {
                    logger.debug(
                        `Mensaje ${update.key.id} → estado ${update.update.status}`,
                    );
                    if (update.key?.fromMe) {
                        reportStatusToLaravel(
                            token,
                            update.key.id,
                            update.update.status,
                        );
                    }
                }
            }
        });

        return {
            sock,
            qrcode: qrCodes.get(token),
        };
    } catch (error) {
        logger.error(`Error conectando ${token}:`, error);
        throw error;
    }
}

/**
 * Obtener URL de foto de perfil
 */
async function getPpUrl(token, jid) {
    try {
        const sock = sockets.get(token);
        if (!sock) return null;

        const ppUrl = await sock.profilePictureUrl(jid, "image");
        return ppUrl;
    } catch (error) {
        return null;
    }
}

/**
 * Enviar mensaje de texto
 */
export async function sendText(token, to, text, simulateTyping = true) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    const jid = formatReceipt(to);

    // Simular actividad humana si está habilitado
    if (simulateTyping) {
        await simulateHumanActivity(sock, jid);
    }

    return await sock.sendMessage(jid, { text });
}

/**
 * Enviar mensaje con formato JSON
 */
export async function sendMessage(token, to, message, simulateTyping = true) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    const messageObj =
        typeof message === "string" ? JSON.parse(message) : message;
    const jid = formatReceipt(to);

    // Simular actividad humana si está habilitado
    if (simulateTyping) {
        await simulateHumanActivity(sock, jid);
    }

    return await sock.sendMessage(jid, messageObj);
}

/**
 * Enviar imagen
 */
export async function sendImage(
    token,
    to,
    imageUrl,
    caption,
    simulateTyping = true,
) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    const jid = formatReceipt(to);

    // Simular actividad humana si está habilitado
    if (simulateTyping) {
        await simulateHumanActivity(sock, jid);
    }

    return await sock.sendMessage(jid, {
        image: { url: imageUrl },
        caption,
    });
}

/**
 * Enviar video
 */
export async function sendVideo(
    token,
    to,
    videoUrl,
    caption,
    simulateTyping = true,
) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    const jid = formatReceipt(to);

    // Simular actividad humana si está habilitado
    if (simulateTyping) {
        await simulateHumanActivity(sock, jid);
    }

    return await sock.sendMessage(jid, {
        video: { url: videoUrl },
        caption,
    });
}

/**
 * Enviar audio
 */
export async function sendAudio(
    token,
    to,
    audioUrl,
    ptt = false,
    simulateTyping = true,
) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    const jid = formatReceipt(to);

    // Simular actividad humana si está habilitado
    if (simulateTyping) {
        // Para audio, simular "grabando" en lugar de "escribiendo"
        await sock.sendPresenceUpdate("available", jid);
        await randomDelay(500, 1500);
        await sock.sendPresenceUpdate("recording", jid);
        await randomDelay(1000, 3000);
        await sock.sendPresenceUpdate("paused", jid);
        await randomDelay(300, 800);
    }

    return await sock.sendMessage(jid, {
        audio: { url: audioUrl },
        ptt,
        mimetype: "audio/mpeg",
    });
}

/**
 * Enviar documento
 */
export async function sendDocument(
    token,
    to,
    documentUrl,
    fileName,
    mimetype,
    simulateTyping = true,
) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    const jid = formatReceipt(to);

    // Simular actividad humana si está habilitado
    if (simulateTyping) {
        await simulateHumanActivity(sock, jid);
    }

    return await sock.sendMessage(jid, {
        document: { url: documentUrl },
        fileName,
        mimetype: mimetype || getMimeType(fileName.split(".").pop()),
    });
}

/**
 * Enviar multimedia (legacy - mantener compatibilidad)
 */
export async function sendMedia(
    token,
    to,
    type,
    url,
    caption = null,
    ptt = false,
    fileName = null,
) {
    switch (type) {
        case "image":
            return await sendImage(token, to, url, caption);
        case "video":
            return await sendVideo(token, to, url, caption);
        case "audio":
            return await sendAudio(token, to, url, ptt);
        case "document":
        case "pdf":
        case "docx":
        case "xlsx":
            return await sendDocument(
                token,
                to,
                url,
                fileName || `document.${type}`,
                getMimeType(type),
            );
        default:
            throw new Error(`Tipo de media no soportado: ${type}`);
    }
}

/**
 * Enviar contacto
 */
export async function sendContact(token, to, contactName, contactNumber) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    const jid = formatReceipt(to);
    const vcard = `BEGIN:VCARD
VERSION:3.0
FN:${contactName}
TEL;type=CELL;type=VOICE;waid=${contactNumber}:+${contactNumber}
END:VCARD`;

    return await sock.sendMessage(jid, {
        contacts: {
            displayName: contactName,
            contacts: [{ vcard }],
        },
    });
}

/**
 * Enviar ubicación
 */
export async function sendLocation(token, to, latitude, longitude, name) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    const jid = formatReceipt(to);
    return await sock.sendMessage(jid, {
        location: {
            degreesLatitude: latitude,
            degreesLongitude: longitude,
            name,
        },
    });
}

/**
 * Reaccionar a mensaje (Baileys 7.0)
 */
export async function sendReaction(token, messageKey, emoji) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    return await sock.sendMessage(messageKey.remoteJid, {
        react: {
            text: emoji,
            key: messageKey,
        },
    });
}

/**
 * Editar mensaje (Baileys 7.0)
 */
export async function editMessage(token, messageKey, newText) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    return await sock.sendMessage(messageKey.remoteJid, {
        text: newText,
        edit: messageKey,
    });
}

/**
 * Eliminar mensaje
 */
export async function deleteMessage(token, messageKey) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    return await sock.sendMessage(messageKey.remoteJid, {
        delete: messageKey,
    });
}

/**
 * Fijar mensaje (Baileys 7.0)
 * @param {string} token - Device token
 * @param {object} messageKey - Message key to pin (remoteJid, id, fromMe)
 * @param {number} pinType - 0 = unpin, 1 = pin for all
 * @param {number} time - Duration in seconds: 86400 (24h), 604800 (7d), 2592000 (30d)
 */
export async function pinMessage(token, messageKey, pinType = 1, time = 86400) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    return await sock.sendMessage(messageKey.remoteJid, {
        pin: messageKey,
        type: pinType, // 0 = unpin, 1 = pin for all
        time: time, // 86400 = 24h, 604800 = 7d, 2592000 = 30d
    });
}

/**
 * Marcar como leído
 */
export async function markAsRead(token, messageKey) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    await sock.readMessages([messageKey]);
}

/**
 * Verificar si número está en WhatsApp
 */
export async function checkWhatsApp(token, number) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    const jid = formatReceipt(number);
    const [result] = await sock.onWhatsApp(jid);
    return result;
}

/**
 * Cambiar presencia
 */
export async function updatePresence(token, jid, presence) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    await sock.sendPresenceUpdate(presence, jid);
}

/**
 * Enviar imagen desde base64
 */
export async function sendImageBase64(token, to, base64Image, caption = "") {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    const jid = formatReceipt(to);

    // Remover prefijo data:image si existe
    const base64Data = base64Image.replace(/^data:image\/\w+;base64,/, "");
    const buffer = Buffer.from(base64Data, "base64");

    return await sock.sendMessage(jid, {
        image: buffer,
        caption,
    });
}

/**
 * Enviar mensaje con botones (Baileys 7.0)
 */
export async function sendButton(
    token,
    to,
    message,
    buttons,
    footer = "",
    image = "",
) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    const jid = formatReceipt(to);

    // Parsear botones si vienen como JSON string
    const buttonsList =
        typeof buttons === "string" ? JSON.parse(buttons) : buttons;

    const messageContent = {
        text: message,
        footer: footer,
        buttons: buttonsList.map((btn, index) => ({
            buttonId: `btn_${index + 1}`,
            buttonText: { displayText: btn.displayText || btn },
            type: 1,
        })),
        headerType: 1,
    };

    // Si hay imagen, agregarla
    if (image) {
        if (image.startsWith("data:image")) {
            const base64Data = image.replace(/^data:image\/\w+;base64,/, "");
            messageContent.image = Buffer.from(base64Data, "base64");
        } else {
            messageContent.image = { url: image };
        }
        messageContent.headerType = 4; // Image header
    }

    return await sock.sendMessage(jid, messageContent);
}

/**
 * Enviar plantilla con botones (Baileys 7.0)
 */
export async function sendTemplate(
    token,
    to,
    message,
    buttons,
    footer = "",
    image = "",
) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    const jid = formatReceipt(to);

    // Parsear botones si vienen como JSON string
    const templateButtons =
        typeof buttons === "string" ? JSON.parse(buttons) : buttons;

    const messageContent = {
        text: message,
        footer: footer,
        templateButtons: templateButtons,
        headerType: 1,
    };

    // Si hay imagen, agregarla
    if (image) {
        if (image.startsWith("data:image")) {
            const base64Data = image.replace(/^data:image\/\w+;base64,/, "");
            messageContent.image = Buffer.from(base64Data, "base64");
        } else {
            messageContent.image = { url: image };
        }
        messageContent.headerType = 4; // Image header
    }

    return await sock.sendMessage(jid, messageContent);
}

/**
 * Enviar mensaje de lista (Baileys 7.0)
 */
export async function sendList(
    token,
    to,
    message,
    sections,
    footer = "",
    title = "",
    buttonText = "Opciones",
) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    const jid = formatReceipt(to);

    // Parsear secciones si vienen como JSON string
    const rawSections =
        typeof sections === "string" ? JSON.parse(sections) : sections;

    // Normalizar secciones al formato proto de Baileys
    const sectionsList = rawSections.map((sec, si) => ({
        title: sec.title || sec.sectionTitle || `Sección ${si + 1}`,
        rows: (sec.rows || []).map((row, ri) => ({
            title: row.title || row.displayText || `Opción ${ri + 1}`,
            description: row.description || "",
            rowId: row.rowId || row.id || `row_${si}_${ri}`,
        })),
    }));

    // En Baileys 7.x sendMessage no maneja listMessage vía generateWAMessageContent.
    // Construimos el proto directamente y usamos relayMessage para enviarlo.
    const protoMsg = proto.Message.fromObject({
        listMessage: proto.Message.ListMessage.fromObject({
            title: title || "",
            description: message,
            buttonText: buttonText,
            listType: proto.Message.ListMessage.ListType.SINGLE_SELECT,
            sections: sectionsList,
            footerText: footer,
        }),
    });

    return await sock.relayMessage(jid, protoMsg, {
        messageId: generateMessageIDV2(),
    });
}

/**
 * Obtener tipo MIME según extensión
 */
function getMimeType(type) {
    const mimeTypes = {
        pdf: "application/pdf",
        docx: "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        xlsx: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        xls: "application/vnd.ms-excel",
        doc: "application/msword",
        txt: "text/plain",
        zip: "application/zip",
        rar: "application/x-rar-compressed",
    };

    return mimeTypes[type] || "application/octet-stream";
}

/**
 * Logout de dispositivo
 */
export async function deleteCredentials(token, io = null) {
    // 1. Intentar logout del socket (puede fallar si ya está desconectado — ignorar)
    const sock = sockets.get(token);
    if (sock) {
        try {
            await sock.logout();
        } catch (logoutErr) {
            logger.warn(
                `⚠️ sock.logout() falló para ${token} (continuando limpieza): ${logoutErr?.message || String(logoutErr)}`,
            );
        }
    }

    // 2. Limpiar siempre, independientemente de si logout falló
    try {
        await clearAuthState(token);
    } catch (e) {
        logger.warn(
            `⚠️ clearAuthState falló para ${token}: ${e?.message || String(e)}`,
        );
    }

    try {
        await setStatus(token, "Disconnect");
    } catch (e) {
        logger.warn(
            `⚠️ setStatus falló para ${token}: ${e?.message || String(e)}`,
        );
    }

    // Limpiar memoria
    sockets.delete(token);
    qrCodes.delete(token);
    retryCount.delete(token);
    contactsCache.delete(token);
    connectedSessions.delete(token);

    if (io) {
        io.emit("message", {
            token,
            message: "Dispositivo desconectado y credenciales eliminadas",
        });
    }

    logger.info(`✅ Credenciales eliminadas para ${token}`);
    return true;
}

/**
 * Verificar si dispositivo está conectado
 */
export function isConnected(token) {
    const sock = sockets.get(token);
    return sock && sock.user ? true : false;
}

/**
 * Obtener socket de dispositivo
 */
export function getSocket(token) {
    return sockets.get(token);
}

/**
 * Verificar y reconectar sesiones activas desde la base de datos
 * (Keep-alive para sesiones persistentes)
 */
export async function verifyAndReconnectSessions(io = null) {
    try {
        const { pool } = await import("./database/index.js");
        // Actualizado para la nueva estructura de tabla con mysql-baileys
        const [devices] = await pool.execute(
            "SELECT DISTINCT session FROM auth_states WHERE id = 'creds'",
        );

        logger.info(`Verificando ${devices.length} sesiones guardadas...`);

        for (const device of devices) {
            const token = device.session;

            // Si ya está conectado, skip
            if (isConnected(token)) {
                logger.debug(`${token} ya está conectado`);
                continue;
            }

            // Si está en proceso de conexión (tiene QR), skip
            if (qrCodes.has(token)) {
                logger.debug(`${token} está esperando escaneo de QR`);
                continue;
            }

            // Intentar reconectar
            logger.info(`Restaurando sesión para ${token}...`);
            await connectToWhatsApp(token, io);

            // Delay para no sobrecargar
            await delay(2000);
        }

        logger.info("Verificación de sesiones completada");
    } catch (error) {
        logger.error("Error verificando sesiones:", error);
    }
}

/**
 * Mantener sesión activa (keep-alive)
 * Verifica el estado y reconecta automáticamente si es necesario
 */
export async function keepSessionAlive(token) {
    try {
        const sock = sockets.get(token);

        // Si no existe el socket o no tiene usuario
        if (!sock || !sock.user) {
            logger.warn(
                `Sesión ${token} no existe en memoria, reconectando...`,
            );

            // Reconectar desde la base de datos
            const reconnected = await connectToWhatsApp(token);

            if (reconnected?.sock?.user) {
                return {
                    status: true,
                    message: "Sesión reconectada exitosamente",
                    user: reconnected.sock.user,
                };
            }

            return {
                status: false,
                message: "Esperando escaneo de QR",
            };
        }

        // Verificar estado del WebSocket
        const wsState = sock.ws?.readyState;

        // Estados: 0=CONNECTING, 1=OPEN, 2=CLOSING, 3=CLOSED
        if (wsState !== 1) {
            logger.warn(
                `Socket ${token} no está activo (readyState: ${wsState}), reconectando...`,
            );

            // Limpiar socket inactivo
            sockets.delete(token);

            // Reconectar
            const reconnected = await connectToWhatsApp(token);

            if (reconnected?.sock?.user) {
                return {
                    status: true,
                    message: "Sesión reconectada exitosamente",
                    user: reconnected.sock.user,
                };
            }

            return {
                status: false,
                message: "Reconectando...",
            };
        }

        // Socket activo y funcionando
        logger.debug(`Sesión ${token} está activa (readyState: ${wsState})`);
        return {
            status: true,
            message: "Sesión activa",
            user: sock.user,
        };
    } catch (error) {
        logger.error(`Error verificando sesión ${token}:`, error);

        // En caso de error, intentar reconectar
        try {
            sockets.delete(token);
            await connectToWhatsApp(token);
            return { status: false, message: "Reconectando después de error" };
        } catch (reconnectError) {
            logger.error(`Error reconectando ${token}:`, reconnectError);
            return { status: false, message: error.message };
        }
    }
}

/**
 * Enviar mensaje de texto a grupo
 */
export async function sendGroupText(token, groupId, text) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    // Asegurar que el groupId tenga el formato correcto
    const jid = groupId.endsWith("@g.us") ? groupId : `${groupId}@g.us`;
    return await sock.sendMessage(jid, { text });
}

/**
 * Enviar imagen a grupo
 */
export async function sendGroupImage(token, groupId, imageUrl, caption) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    const jid = groupId.endsWith("@g.us") ? groupId : `${groupId}@g.us`;
    return await sock.sendMessage(jid, {
        image: { url: imageUrl },
        caption,
    });
}

/**
 * Enviar video a grupo
 */
export async function sendGroupVideo(token, groupId, videoUrl, caption) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    const jid = groupId.endsWith("@g.us") ? groupId : `${groupId}@g.us`;
    return await sock.sendMessage(jid, {
        video: { url: videoUrl },
        caption,
    });
}

/**
 * Enviar audio a grupo
 */
export async function sendGroupAudio(token, groupId, audioUrl, ptt = false) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    const jid = groupId.endsWith("@g.us") ? groupId : `${groupId}@g.us`;
    return await sock.sendMessage(jid, {
        audio: { url: audioUrl },
        ptt,
        mimetype: "audio/mpeg",
    });
}

/**
 * Enviar documento a grupo
 */
export async function sendGroupDocument(
    token,
    groupId,
    documentUrl,
    fileName,
    mimetype,
) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    const jid = groupId.endsWith("@g.us") ? groupId : `${groupId}@g.us`;
    return await sock.sendMessage(jid, {
        document: { url: documentUrl },
        fileName,
        mimetype: mimetype || getMimeType(fileName.split(".").pop()),
    });
}

/**
 * Enviar multimedia a grupo (legacy - compatibilidad)
 */
export async function sendGroupMedia(
    token,
    groupId,
    type,
    url,
    caption = null,
    ptt = false,
    fileName = null,
) {
    switch (type) {
        case "image":
            return await sendGroupImage(token, groupId, url, caption);
        case "video":
            return await sendGroupVideo(token, groupId, url, caption);
        case "audio":
            return await sendGroupAudio(token, groupId, url, ptt);
        case "document":
        case "pdf":
        case "docx":
        case "xlsx":
            return await sendGroupDocument(
                token,
                groupId,
                url,
                fileName || `document.${type}`,
                getMimeType(type),
            );
        default:
            throw new Error(`Tipo de media no soportado: ${type}`);
    }
}

/**
 * Obtener todos los grupos del dispositivo con sus participantes
 */
export async function fetchGroups(token) {
    const sock = sockets.get(token);
    if (!sock) {
        throw new Error("Dispositivo no conectado");
    }

    try {
        const chats = await sock.groupFetchAllParticipating();
        const groups = [];

        for (const groupId in chats) {
            const group = chats[groupId];

            // Solo incluir grupos (no chats individuales)
            if (groupId.endsWith("@g.us")) {
                const participants = group.participants
                    .map((p) => {
                        const number = (p.phoneNumber || "")
                            .replace("@s.whatsapp.net", "")
                            .replace("@c.us", "");

                        return {
                            number: number,
                            name: p.notify || p.name || null,
                            isAdmin:
                                p.admin === "admin" || p.admin === "superadmin",
                        };
                    })
                    .filter((p) => p.number); // descartar entradas sin número

                groups.push({
                    id: groupId,
                    name: group.subject || "Sin nombre",
                    participants: participants,
                    participantCount: participants.length,
                    creation: group.creation,
                    owner: group.owner
                        ? group.owner
                              .replace("@s.whatsapp.net", "")
                              .replace("@c.us", "")
                        : null,
                });
            }
        }

        logger.info(
            `Obtenidos ${groups.length} grupos del dispositivo ${token}`,
        );
        return groups;
    } catch (error) {
        logger.error(`Error obteniendo grupos de ${token}:`, error);
        throw error;
    }
}

/**
 * Obtener todos los contactos del dispositivo
 */
export async function fetchContacts(token) {
    const sock = sockets.get(token);
    if (!sock) {
        throw new Error("Dispositivo no conectado");
    }

    try {
        const contacts = [];
        const seenNumbers = new Set();

        // Método 1: Cache de contactos sincronizados (recomendado)
        const cachedContacts = contactsCache.get(token);
        if (cachedContacts && cachedContacts.size > 0) {
            logger.info(
                `Usando cache de contactos: ${cachedContacts.size} contactos`,
            );

            for (const [number, contact] of cachedContacts.entries()) {
                if (!seenNumbers.has(number)) {
                    seenNumbers.add(number);
                    contacts.push({
                        number: number,
                        name: contact.name,
                        pushName: contact.notify,
                    });
                }
            }
        }

        // Método 2: Store (Baileys 6.x - legacy)
        if (contacts.length === 0 && sock.store && sock.store.contacts) {
            logger.info("Usando sock.store.contacts (legacy)");

            for (const [jid, contact] of Object.entries(sock.store.contacts)) {
                if (jid.endsWith("@s.whatsapp.net")) {
                    const number = jid.replace("@s.whatsapp.net", "");
                    if (!seenNumbers.has(number)) {
                        seenNumbers.add(number);
                        contacts.push({
                            number: number,
                            name: contact.name || contact.notify || null,
                            pushName: contact.notify || null,
                        });
                    }
                }
            }
        }

        logger.info(
            `Obtenidos ${contacts.length} contactos únicos del dispositivo ${token}`,
        );
        return contacts;
    } catch (error) {
        logger.error(`Error obteniendo contactos de ${token}:`, error);
        throw error;
    }
}
