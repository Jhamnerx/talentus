import express from "express";
import * as wa from "../whatsapp.js";
import {
    getDevice,
    saveMessageHistory,
    clearAutorepliesCache,
} from "../database/index.js";
import { checkIpWhitelist } from "../middleware/ipWhitelist.js";
import logger from "../lib/pino.js";

const router = express.Router();

/**
 * @route POST /backend-clearCache
 * @desc Limpiar caché de autoreplies (llamado desde Laravel al guardar/editar/eliminar)
 */
router.post("/backend-clearCache", (req, res) => {
    clearAutorepliesCache();
    logger.info("🧹 Caché de autoreplies limpiado");
    return res.json({ status: "success" });
});

/**
 * @route POST /api/send-message
 * @desc Enviar mensaje de texto
 */
router.post("/api/send-message", checkIpWhitelist, async (req, res) => {
    try {
        const { token, number, message, simulateTyping = true } = req.body;

        if (!token || !number || !message) {
            return res.status(400).json({
                status: false,
                message: "Token, número y mensaje son requeridos",
            });
        }

        // Verificar si el dispositivo está conectado
        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        // Enviar mensaje con simulación de actividad humana
        const result = await wa.sendText(
            token,
            number,
            message,
            simulateTyping,
        );

        // Obtener dispositivo y guardar historial
        const device = await getDevice(token);
        if (device) {
            await saveMessageHistory({
                device_id: device.id,
                user_id: device.user_id,
                number: number,
                type: "text",
                message: message,
                payload: { text: message },
                status: "success",
                send_by: "api",
            });
        }

        res.json({
            status: true,
            message: "Mensaje enviado exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error enviando mensaje:", error);
        res.status(500).json({
            status: false,
            message: "Error enviando mensaje",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/send-media
 * @desc Enviar multimedia
 */
router.post("/api/send-media", checkIpWhitelist, async (req, res) => {
    try {
        const { token, number, type, url, caption, fileName } = req.body;

        if (!token || !number || !type || !url) {
            return res.status(400).json({
                status: false,
                message: "Token, número, tipo y URL son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const result = await wa.sendMedia(
            token,
            number,
            type,
            url,
            caption,
            false,
            fileName,
        );

        const device = await getDevice(token);
        if (device) {
            await saveMessageHistory({
                device_id: device.id,
                user_id: device.user_id,
                number: number,
                type: type,
                message: caption || url,
                payload: { url, caption, type },
                status: "success",
                send_by: "api",
            });
        }

        res.json({
            status: true,
            message: "Media enviada exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error enviando media:", error);
        res.status(500).json({
            status: false,
            message: "Error enviando media",
            error: error.message,
        });
    }
});

/**
 * @route GET /api/device-status/:token
 * @desc Verificar estado de dispositivo y detectar sesiones inválidas
 */
router.get("/api/device-status/:token", checkIpWhitelist, async (req, res) => {
    try {
        const { token } = req.params;
        const isConnected = wa.isConnected(token);

        const device = await getDevice(token);

        // Verificar si hay credenciales en DB
        const { pool } = await import("../database/index.js");
        const [authRecords] = await pool.execute(
            "SELECT COUNT(*) as count FROM auth_states WHERE session = ?",
            [token],
        );

        const hasCredentials = authRecords[0].count > 0;
        const dbStatus = device?.status || "Unknown";

        // Detectar sesión potencialmente inválida
        const isPotentiallyInvalid =
            hasCredentials && !isConnected && dbStatus === "Connected";

        res.json({
            status: true,
            data: {
                connected: isConnected,
                device: device?.body || token,
                dbStatus: dbStatus,
                hasCredentials: hasCredentials,
                isPotentiallyInvalid: isPotentiallyInvalid,
                warning: isPotentiallyInvalid
                    ? "Sesión probablemente inválida. Considera usar /api/clean-invalid-session"
                    : null,
            },
        });
    } catch (error) {
        res.status(500).json({
            status: false,
            message: "Error verificando estado",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/clean-invalid-session
 * @desc Limpiar sesión inválida y regenerar QR
 */
router.post(
    "/api/clean-invalid-session",
    checkIpWhitelist,
    async (req, res) => {
        try {
            const { token } = req.body;

            if (!token) {
                return res.status(400).json({
                    status: false,
                    message: "Token es requerido",
                });
            }

            logger.info(`🧹 Limpiando sesión inválida para ${token}...`);

            // Eliminar credenciales y limpiar estado
            await wa.deleteCredentials(token, req.io);

            // Esperar un momento antes de reiniciar
            await new Promise((resolve) => setTimeout(resolve, 2000));

            // Intentar reconectar (generará nuevo QR)
            await wa.connectToWhatsApp(token, req.io);

            res.json({
                status: true,
                message: "Sesión inválida limpiada. Nuevo QR generado.",
                data: { token },
            });
        } catch (error) {
            logger.error("Error limpiando sesión inválida:", error);
            res.status(500).json({
                status: false,
                message: "Error limpiando sesión",
                error: error.message,
            });
        }
    },
);

/**
 * @route POST /api/delete-credentials
 * @desc Eliminar credenciales de dispositivo
 */
router.post("/api/delete-credentials", checkIpWhitelist, async (req, res) => {
    try {
        const { device } = req.body;

        if (!device) {
            return res.status(400).json({
                status: false,
                message: "Device es requerido",
            });
        }

        const result = await wa.deleteCredentials(device);

        res.json({
            status: true,
            message: "Credenciales eliminadas exitosamente",
            data: { deleted: result },
        });
    } catch (error) {
        res.status(500).json({
            status: false,
            message: "Error eliminando credenciales",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/send-bulk
 * @desc Enviar mensajes masivos con delays aleatorios para simular comportamiento humano
 */
router.post("/api/send-bulk", checkIpWhitelist, async (req, res) => {
    try {
        const {
            token,
            messages,
            minDelay = 2000, // Delay mínimo entre mensajes (ms)
            maxDelay = 5000, // Delay máximo entre mensajes (ms)
            simulateTyping = true, // Simular escritura
        } = req.body;

        if (!token || !messages || !Array.isArray(messages)) {
            return res.status(400).json({
                status: false,
                message: "Token y array de mensajes son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const results = [];
        const device = await getDevice(token);

        for (const msg of messages) {
            try {
                const result = await wa.sendText(
                    token,
                    msg.number,
                    msg.message,
                    simulateTyping,
                );
                results.push({
                    number: msg.number,
                    status: "success",
                    result,
                });

                if (device) {
                    await saveMessageHistory({
                        device_id: device.id,
                        user_id: device.user_id,
                        number: msg.number,
                        type: "text",
                        message: msg.message,
                        payload: { text: msg.message },
                        status: "success",
                        send_by: "api",
                    });
                }

                // Delay aleatorio entre mensajes para evitar detección de bot
                const randomDelayTime =
                    Math.floor(Math.random() * (maxDelay - minDelay + 1)) +
                    minDelay;
                await new Promise((resolve) =>
                    setTimeout(resolve, randomDelayTime),
                );
            } catch (error) {
                results.push({
                    number: msg.number,
                    status: "failed",
                    error: error.message,
                });
            }
        }

        res.json({
            status: true,
            message: "Proceso de envío masivo completado",
            data: {
                total: messages.length,
                results,
            },
        });
    } catch (error) {
        logger.error("Error en envío masivo:", error);
        res.status(500).json({
            status: false,
            message: "Error en envío masivo",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/send-image
 * @desc Enviar imagen (Baileys 7.0)
 */
router.post("/api/send-image", checkIpWhitelist, async (req, res) => {
    try {
        const {
            token,
            number,
            imageUrl,
            caption,
            simulateTyping = true,
        } = req.body;

        if (!token || !number || !imageUrl) {
            return res.status(400).json({
                status: false,
                message: "Token, número e imageUrl son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const result = await wa.sendImage(
            token,
            number,
            imageUrl,
            caption,
            simulateTyping,
        );

        const device = await getDevice(token);
        if (device) {
            await saveMessageHistory({
                device_id: device.id,
                user_id: device.user_id,
                number: number,
                type: "image",
                message: caption || imageUrl,
                payload: { imageUrl, caption },
                status: "success",
                send_by: "api",
            });
        }

        res.json({
            status: true,
            message: "Imagen enviada exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error enviando imagen:", error);
        res.status(500).json({
            status: false,
            message: "Error enviando imagen",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/send-video
 * @desc Enviar video (Baileys 7.0)
 */
router.post("/api/send-video", checkIpWhitelist, async (req, res) => {
    try {
        const {
            token,
            number,
            videoUrl,
            caption,
            simulateTyping = true,
        } = req.body;

        if (!token || !number || !videoUrl) {
            return res.status(400).json({
                status: false,
                message: "Token, número y videoUrl son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const result = await wa.sendVideo(
            token,
            number,
            videoUrl,
            caption,
            simulateTyping,
        );

        const device = await getDevice(token);
        if (device) {
            await saveMessageHistory({
                device_id: device.id,
                user_id: device.user_id,
                number: number,
                type: "video",
                message: caption || videoUrl,
                payload: { videoUrl, caption },
                status: "success",
                send_by: "api",
            });
        }

        res.json({
            status: true,
            message: "Video enviado exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error enviando video:", error);
        res.status(500).json({
            status: false,
            message: "Error enviando video",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/send-audio
 * @desc Enviar audio (Baileys 7.0)
 */
router.post("/api/send-audio", checkIpWhitelist, async (req, res) => {
    try {
        const {
            token,
            number,
            audioUrl,
            ptt = false,
            simulateTyping = true,
        } = req.body;

        if (!token || !number || !audioUrl) {
            return res.status(400).json({
                status: false,
                message: "Token, número y audioUrl son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const result = await wa.sendAudio(
            token,
            number,
            audioUrl,
            ptt,
            simulateTyping,
        );

        const device = await getDevice(token);
        if (device) {
            await saveMessageHistory({
                device_id: device.id,
                user_id: device.user_id,
                number: number,
                type: "audio",
                message: audioUrl,
                payload: { audioUrl, ptt },
                status: "success",
                send_by: "api",
            });
        }

        res.json({
            status: true,
            message: "Audio enviado exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error enviando audio:", error);
        res.status(500).json({
            status: false,
            message: "Error enviando audio",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/send-document
 * @desc Enviar documento (Baileys 7.0)
 */
router.post("/api/send-document", checkIpWhitelist, async (req, res) => {
    try {
        const {
            token,
            number,
            documentUrl,
            fileName,
            mimetype,
            simulateTyping = true,
        } = req.body;

        if (!token || !number || !documentUrl || !fileName) {
            return res.status(400).json({
                status: false,
                message: "Token, número, documentUrl y fileName son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const result = await wa.sendDocument(
            token,
            number,
            documentUrl,
            fileName,
            mimetype,
            simulateTyping,
        );

        const device = await getDevice(token);
        if (device) {
            await saveMessageHistory({
                device_id: device.id,
                user_id: device.user_id,
                number: number,
                type: "document",
                message: fileName,
                payload: { documentUrl, fileName, mimetype },
                status: "success",
                send_by: "api",
            });
        }

        res.json({
            status: true,
            message: "Documento enviado exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error enviando documento:", error);
        res.status(500).json({
            status: false,
            message: "Error enviando documento",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/send-contact
 * @desc Enviar contacto (Baileys 7.0)
 */
router.post("/api/send-contact", checkIpWhitelist, async (req, res) => {
    try {
        const { token, number, contactName, contactNumber } = req.body;

        if (!token || !number || !contactName || !contactNumber) {
            return res.status(400).json({
                status: false,
                message:
                    "Token, número, contactName y contactNumber son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const result = await wa.sendContact(
            token,
            number,
            contactName,
            contactNumber,
        );

        const device = await getDevice(token);
        if (device) {
            await saveMessageHistory({
                device_id: device.id,
                user_id: device.user_id,
                number: number,
                type: "contact",
                message: contactName,
                payload: { contactName, contactNumber },
                status: "success",
                send_by: "api",
            });
        }

        res.json({
            status: true,
            message: "Contacto enviado exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error enviando contacto:", error);
        res.status(500).json({
            status: false,
            message: "Error enviando contacto",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/send-location
 * @desc Enviar ubicación (Baileys 7.0)
 */
router.post("/api/send-location", checkIpWhitelist, async (req, res) => {
    try {
        const { token, number, latitude, longitude, name } = req.body;

        if (!token || !number || !latitude || !longitude) {
            return res.status(400).json({
                status: false,
                message: "Token, número, latitude y longitude son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const result = await wa.sendLocation(
            token,
            number,
            latitude,
            longitude,
            name,
        );

        const device = await getDevice(token);
        if (device) {
            await saveMessageHistory({
                device_id: device.id,
                user_id: device.user_id,
                number: number,
                type: "location",
                message: name || `${latitude},${longitude}`,
                payload: { latitude, longitude, name },
                status: "success",
                send_by: "api",
            });
        }

        res.json({
            status: true,
            message: "Ubicación enviada exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error enviando ubicación:", error);
        res.status(500).json({
            status: false,
            message: "Error enviando ubicación",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/send-reaction
 * @desc Enviar reacción a mensaje (Baileys 7.0 - NUEVO)
 */
router.post("/api/send-reaction", checkIpWhitelist, async (req, res) => {
    try {
        const { token, messageKey, emoji } = req.body;

        if (!token || !messageKey || !emoji) {
            return res.status(400).json({
                status: false,
                message: "Token, messageKey y emoji son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const result = await wa.sendReaction(token, messageKey, emoji);

        res.json({
            status: true,
            message: "Reacción enviada exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error enviando reacción:", error);
        res.status(500).json({
            status: false,
            message: "Error enviando reacción",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/edit-message
 * @desc Editar mensaje enviado (Baileys 7.0 - NUEVO)
 */
router.post("/api/edit-message", checkIpWhitelist, async (req, res) => {
    try {
        const { token, messageKey, newText } = req.body;

        if (!token || !messageKey || !newText) {
            return res.status(400).json({
                status: false,
                message: "Token, messageKey y newText son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const result = await wa.editMessage(token, messageKey, newText);

        res.json({
            status: true,
            message: "Mensaje editado exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error editando mensaje:", error);
        res.status(500).json({
            status: false,
            message: "Error editando mensaje",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/delete-message
 * @desc Eliminar mensaje
 */
router.post("/api/delete-message", checkIpWhitelist, async (req, res) => {
    try {
        const { token, messageKey } = req.body;

        if (!token || !messageKey) {
            return res.status(400).json({
                status: false,
                message: "Token y messageKey son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const result = await wa.deleteMessage(token, messageKey);

        res.json({
            status: true,
            message: "Mensaje eliminado exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error eliminando mensaje:", error);
        res.status(500).json({
            status: false,
            message: "Error eliminando mensaje",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/pin-message
 * @desc Fijar mensaje en chat (Baileys 7.0)
 */
router.post("/api/pin-message", checkIpWhitelist, async (req, res) => {
    try {
        const { token, messageKey, pinType, time } = req.body;

        if (!token || !messageKey) {
            return res.status(400).json({
                status: false,
                message: "Token y messageKey son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        // pinType: 0 = unpin, 1 = pin for all (default)
        // time: 86400 (24h), 604800 (7d), 2592000 (30d) - default 24h
        const result = await wa.pinMessage(
            token,
            messageKey,
            pinType || 1,
            time || 86400,
        );

        res.json({
            status: true,
            message:
                pinType === 0
                    ? "Mensaje desfijado"
                    : "Mensaje fijado exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error fijando mensaje:", error);
        res.status(500).json({
            status: false,
            message: "Error fijando mensaje",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/check-whatsapp
 * @desc Verificar si un número está en WhatsApp
 */
router.post("/api/check-whatsapp", checkIpWhitelist, async (req, res) => {
    try {
        const { token, number } = req.body;

        if (!token || !number) {
            return res.status(400).json({
                status: false,
                message: "Token y número son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const result = await wa.checkWhatsApp(token, number);

        res.json({
            status: true,
            message: "Verificación completada",
            data: result,
        });
    } catch (error) {
        logger.error("Error verificando número:", error);
        res.status(500).json({
            status: false,
            message: "Error verificando número",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/keep-alive
 * @desc Mantener sesión activa y verificar estado
 */
router.post("/api/keep-alive", checkIpWhitelist, async (req, res) => {
    try {
        const { token } = req.body;

        if (!token) {
            return res.status(400).json({
                status: false,
                message: "Token es requerido",
            });
        }

        const result = await wa.keepSessionAlive(token);

        res.json({
            status: result.status,
            message: result.message,
            user: result.user || null,
        });
    } catch (error) {
        logger.error("Error en keep-alive:", error);
        res.status(500).json({
            status: false,
            message: "Error verificando sesión",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/verify-sessions
 * @desc Verificar y reconectar todas las sesiones guardadas
 */
router.post("/api/verify-sessions", async (req, res) => {
    try {
        await wa.verifyAndReconnectSessions();

        res.json({
            status: true,
            message: "Verificación de sesiones iniciada",
        });
    } catch (error) {
        logger.error("Error verificando sesiones:", error);
        res.status(500).json({
            status: false,
            message: "Error verificando sesiones",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/send-group-message
 * @desc Enviar mensaje de texto a grupo
 */
router.post("/api/send-group-message", checkIpWhitelist, async (req, res) => {
    try {
        const { token, groupId, message } = req.body;

        if (!token || !groupId || !message) {
            return res.status(400).json({
                status: false,
                message: "Token, groupId y mensaje son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const result = await wa.sendGroupText(token, groupId, message);

        const device = await getDevice(token);
        if (device) {
            await saveMessageHistory({
                device_id: device.id,
                user_id: device.user_id,
                number: groupId,
                type: "group_text",
                message: message,
                payload: { text: message, groupId: groupId },
                status: "success",
                send_by: "api",
            });
        }

        res.json({
            status: true,
            message: "Mensaje enviado al grupo exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error enviando mensaje a grupo:", error);
        res.status(500).json({
            status: false,
            message: "Error enviando mensaje al grupo",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/send-group-image
 * @desc Enviar imagen a grupo
 */
router.post("/api/send-group-image", checkIpWhitelist, async (req, res) => {
    try {
        const { token, groupId, imageUrl, caption } = req.body;

        if (!token || !groupId || !imageUrl) {
            return res.status(400).json({
                status: false,
                message: "Token, groupId e imageUrl son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const result = await wa.sendGroupImage(
            token,
            groupId,
            imageUrl,
            caption,
        );

        const device = await getDevice(token);
        if (device) {
            await saveMessageHistory({
                device_id: device.id,
                user_id: device.user_id,
                number: groupId,
                type: "group_image",
                message: caption || "Image",
                payload: {
                    imageUrl: imageUrl,
                    caption: caption,
                    groupId: groupId,
                },
                status: "success",
                send_by: "api",
            });
        }

        res.json({
            status: true,
            message: "Imagen enviada al grupo exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error enviando imagen a grupo:", error);
        res.status(500).json({
            status: false,
            message: "Error enviando imagen al grupo",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/send-group-video
 * @desc Enviar video a grupo
 */
router.post("/api/send-group-video", checkIpWhitelist, async (req, res) => {
    try {
        const { token, groupId, videoUrl, caption } = req.body;

        if (!token || !groupId || !videoUrl) {
            return res.status(400).json({
                status: false,
                message: "Token, groupId y videoUrl son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const result = await wa.sendGroupVideo(
            token,
            groupId,
            videoUrl,
            caption,
        );

        const device = await getDevice(token);
        if (device) {
            await saveMessageHistory({
                device_id: device.id,
                user_id: device.user_id,
                number: groupId,
                type: "group_video",
                message: caption || "Video",
                payload: {
                    videoUrl: videoUrl,
                    caption: caption,
                    groupId: groupId,
                },
                status: "success",
                send_by: "api",
            });
        }

        res.json({
            status: true,
            message: "Video enviado al grupo exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error enviando video a grupo:", error);
        res.status(500).json({
            status: false,
            message: "Error enviando video al grupo",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/send-group-audio
 * @desc Enviar audio a grupo
 */
router.post("/api/send-group-audio", checkIpWhitelist, async (req, res) => {
    try {
        const { token, groupId, audioUrl, ptt } = req.body;

        if (!token || !groupId || !audioUrl) {
            return res.status(400).json({
                status: false,
                message: "Token, groupId y audioUrl son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const result = await wa.sendGroupAudio(
            token,
            groupId,
            audioUrl,
            ptt || false,
        );

        const device = await getDevice(token);
        if (device) {
            await saveMessageHistory({
                device_id: device.id,
                user_id: device.user_id,
                number: groupId,
                type: "group_audio",
                message: "Audio",
                payload: {
                    audioUrl: audioUrl,
                    ptt: ptt || false,
                    groupId: groupId,
                },
                status: "success",
                send_by: "api",
            });
        }

        res.json({
            status: true,
            message: "Audio enviado al grupo exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error enviando audio a grupo:", error);
        res.status(500).json({
            status: false,
            message: "Error enviando audio al grupo",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/send-group-document
 * @desc Enviar documento a grupo
 */
router.post("/api/send-group-document", checkIpWhitelist, async (req, res) => {
    try {
        const { token, groupId, documentUrl, fileName, mimetype } = req.body;

        if (!token || !groupId || !documentUrl) {
            return res.status(400).json({
                status: false,
                message: "Token, groupId y documentUrl son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const result = await wa.sendGroupDocument(
            token,
            groupId,
            documentUrl,
            fileName || "document.pdf",
            mimetype,
        );

        const device = await getDevice(token);
        if (device) {
            await saveMessageHistory({
                device_id: device.id,
                user_id: device.user_id,
                number: groupId,
                type: "group_document",
                message: fileName || "Document",
                payload: {
                    documentUrl: documentUrl,
                    fileName: fileName,
                    mimetype: mimetype,
                    groupId: groupId,
                },
                status: "success",
                send_by: "api",
            });
        }

        res.json({
            status: true,
            message: "Documento enviado al grupo exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error enviando documento a grupo:", error);
        res.status(500).json({
            status: false,
            message: "Error enviando documento al grupo",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/send-group-media
 * @desc Enviar multimedia a grupo (imagen, video, audio, documento)
 */
router.post("/api/send-group-media", checkIpWhitelist, async (req, res) => {
    try {
        const { token, groupId, type, url, caption, fileName, ptt } = req.body;

        if (!token || !groupId || !type || !url) {
            return res.status(400).json({
                status: false,
                message: "Token, groupId, tipo y URL son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const result = await wa.sendGroupMedia(
            token,
            groupId,
            type,
            url,
            caption,
            ptt || false,
            fileName,
        );

        const device = await getDevice(token);
        if (device) {
            await saveMessageHistory({
                device_id: device.id,
                user_id: device.user_id,
                number: groupId,
                type: `group_${type}`,
                message: caption || fileName || type,
                payload: {
                    type: type,
                    url: url,
                    caption: caption,
                    fileName: fileName,
                    groupId: groupId,
                },
                status: "success",
                send_by: "api",
            });
        }

        res.json({
            status: true,
            message: "Media enviada al grupo exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error enviando media a grupo:", error);
        res.status(500).json({
            status: false,
            message: "Error enviando media al grupo",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/fetch-groups
 * @desc Obtener todos los grupos del dispositivo con participantes
 */
router.post("/api/fetch-groups", checkIpWhitelist, async (req, res) => {
    try {
        const { token } = req.body;

        if (!token) {
            return res.status(400).json({
                status: false,
                message: "Token es requerido",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const groups = await wa.fetchGroups(token);

        res.json({
            status: true,
            message: "Grupos obtenidos exitosamente",
            groups: groups,
        });
    } catch (error) {
        logger.error("Error obteniendo grupos:", error);
        res.status(500).json({
            status: false,
            message: "Error obteniendo grupos",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/fetch-contacts
 * @desc Obtener todos los contactos del dispositivo
 */
router.post("/api/fetch-contacts", checkIpWhitelist, async (req, res) => {
    try {
        const { token } = req.body;

        if (!token) {
            return res.status(400).json({
                status: false,
                message: "Token es requerido",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const contacts = await wa.fetchContacts(token);

        res.json({
            status: true,
            message: "Contactos obtenidos exitosamente",
            contacts: contacts,
        });
    } catch (error) {
        logger.error("Error obteniendo contactos:", error);
        res.status(500).json({
            status: false,
            message: "Error obteniendo contactos",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/send-image-base64
 * @desc Enviar imagen desde base64
 */
router.post("/api/send-image-base64", checkIpWhitelist, async (req, res) => {
    try {
        const { token, number, base64, caption } = req.body;

        if (!token || !number || !base64) {
            return res.status(400).json({
                status: false,
                message: "Token, número y base64 son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const result = await wa.sendImageBase64(
            token,
            number,
            base64,
            caption || "",
        );

        const device = await getDevice(token);
        if (device) {
            await saveMessageHistory(device.user_id, {
                deviceId: device.id,
                number,
                message: caption || "[Imagen]",
                type: "image",
                status: "sent",
            });
        }

        res.json({
            status: true,
            message: "Imagen enviada exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error enviando imagen base64:", error);
        res.status(500).json({
            status: false,
            message: "Error enviando imagen",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/send-button
 * @desc Enviar mensaje con botones
 */
router.post("/api/send-button", checkIpWhitelist, async (req, res) => {
    try {
        const { token, number, message, buttons, footer, image } = req.body;

        if (!token || !number || !message || !buttons) {
            return res.status(400).json({
                status: false,
                message: "Token, número, mensaje y botones son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const result = await wa.sendButton(
            token,
            number,
            message,
            buttons,
            footer || "",
            image || "",
        );

        const device = await getDevice(token);
        if (device) {
            await saveMessageHistory(device.user_id, {
                deviceId: device.id,
                number,
                message: message + " [Botones]",
                type: "button",
                status: "sent",
            });
        }

        res.json({
            status: true,
            message: "Mensaje con botones enviado exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error enviando botones:", error);
        res.status(500).json({
            status: false,
            message: "Error enviando botones",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/send-template
 * @desc Enviar plantilla con botones
 */
router.post("/api/send-template", checkIpWhitelist, async (req, res) => {
    try {
        const { token, number, message, buttons, footer, image } = req.body;

        if (!token || !number || !message || !buttons) {
            return res.status(400).json({
                status: false,
                message: "Token, número, mensaje y botones son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const result = await wa.sendTemplate(
            token,
            number,
            message,
            buttons,
            footer || "",
            image || "",
        );

        const device = await getDevice(token);
        if (device) {
            await saveMessageHistory(device.user_id, {
                deviceId: device.id,
                number,
                message: message + " [Plantilla]",
                type: "template",
                status: "sent",
            });
        }

        res.json({
            status: true,
            message: "Plantilla enviada exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error enviando plantilla:", error);
        res.status(500).json({
            status: false,
            message: "Error enviando plantilla",
            error: error.message,
        });
    }
});

/**
 * @route POST /api/send-list
 * @desc Enviar mensaje de lista
 */
router.post("/api/send-list", checkIpWhitelist, async (req, res) => {
    try {
        const { token, number, message, sections, footer, title, buttonText } =
            req.body;

        if (!token || !number || !message || !sections) {
            return res.status(400).json({
                status: false,
                message: "Token, número, mensaje y secciones son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        const result = await wa.sendList(
            token,
            number,
            message,
            sections,
            footer || "",
            title || "",
            buttonText || "Opciones",
        );

        const device = await getDevice(token);
        if (device) {
            await saveMessageHistory(device.user_id, {
                deviceId: device.id,
                number,
                message: message + " [Lista]",
                type: "list",
                status: "sent",
            });
        }

        res.json({
            status: true,
            message: "Lista enviada exitosamente",
            data: result,
        });
    } catch (error) {
        logger.error("Error enviando lista:", error);
        res.status(500).json({
            status: false,
            message: "Error enviando lista",
            error: error.message,
        });
    }
});

export default router;
