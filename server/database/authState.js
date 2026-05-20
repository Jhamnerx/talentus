import { pool } from "./index.js";
import { useMySQLAuthState } from "mysql-baileys";
import { BufferJSON } from "baileys";
import logger from "../lib/pino.js";

/**
 * MySQL Auth State para Baileys 7.0 usando mysql-baileys
 * Maneja credenciales, signal keys, app-state-sync-keys, etc.
 */
export async function getMySQLAuthState(sessionId) {
    try {
        // Obtener configuración de DB desde variables de entorno
        const dbConfig = {
            session: sessionId,
            host: process.env.DB_HOST || "127.0.0.1",
            port: parseInt(process.env.DB_PORT) || 3306,
            user: process.env.DB_USERNAME || "root",
            password: process.env.DB_PASSWORD || "",
            database: process.env.DB_DATABASE || "whats_fleep",
            tableName: "auth_states",
            retryRequestDelayMs: 200,
            maxtRetries: 10,
        };

        logger.debug(`Inicializando auth state para sesión: ${sessionId}`);

        const { state, saveCreds, removeCreds } =
            await useMySQLAuthState(dbConfig);

        return { state, saveCreds, removeCreds };
    } catch (error) {
        logger.error(
            `Error inicializando MySQL auth state para ${sessionId}:`,
            error,
        );
        throw error;
    }
}

/**
 * Limpiar credenciales de una sesión
 */
export async function clearAuthState(sessionId) {
    try {
        await pool.execute("DELETE FROM auth_states WHERE session = ?", [
            sessionId,
        ]);
        logger.info(`Credenciales eliminadas para sesión: ${sessionId}`);
        return true;
    } catch (error) {
        logger.error(`Error eliminando credenciales para ${sessionId}:`, error);
        return false;
    }
}

/**
 * LID Mapping Store for Baileys 7.0
 */
export class MySQLLidMappingStore {
    /**
     * Store LID to PN mapping
     */
    async storeLIDPNMapping(lid, pn) {
        try {
            await pool.execute(
                `INSERT INTO lid_mappings (lid, pn, created_at, updated_at) 
                 VALUES (?, ?, NOW(), NOW()) 
                 ON DUPLICATE KEY UPDATE pn = VALUES(pn), updated_at = NOW()`,
                [lid, pn],
            );
        } catch (error) {
            logger.error("Error storing LID mapping:", error);
        }
    }

    /**
     * Store multiple LID to PN mappings
     */
    async storeLIDPNMappings(mappings) {
        const tasks = [];
        for (const [lid, pn] of Object.entries(mappings)) {
            tasks.push(this.storeLIDPNMapping(lid, pn));
        }
        await Promise.all(tasks);
    }

    /**
     * Get PN for LID
     */
    async getPNForLID(lid) {
        try {
            const [rows] = await pool.execute(
                "SELECT pn FROM lid_mappings WHERE lid = ?",
                [lid],
            );
            return rows.length > 0 ? rows[0].pn : null;
        } catch (error) {
            logger.error("Error getting PN for LID:", error);
            return null;
        }
    }

    /**
     * Get LID for PN
     */
    async getLIDForPN(pn) {
        try {
            const [rows] = await pool.execute(
                "SELECT lid FROM lid_mappings WHERE pn = ?",
                [pn],
            );
            return rows.length > 0 ? rows[0].lid : null;
        } catch (error) {
            logger.error("Error getting LID for PN:", error);
            return null;
        }
    }

    /**
     * Get LIDs for multiple PNs
     */
    async getLIDsForPNs(pns) {
        const result = {};
        for (const pn of pns) {
            const lid = await this.getLIDForPN(pn);
            if (lid) result[pn] = lid;
        }
        return result;
    }
}

/**
 * Message Store for getMessage function
 */
export class MySQLMessageStore {
    constructor(sessionId) {
        this.sessionId = sessionId;
    }

    /**
     * Save message to store
     */
    async saveMessage(remoteJid, messageId, fromMe, messageData) {
        try {
            await pool.execute(
                `INSERT INTO message_store (session_id, remote_jid, message_id, from_me, message_data, created_at, updated_at) 
                 VALUES (?, ?, ?, ?, ?, NOW(), NOW()) 
                 ON DUPLICATE KEY UPDATE message_data = VALUES(message_data), updated_at = NOW()`,
                [
                    this.sessionId,
                    remoteJid,
                    messageId,
                    fromMe ? 1 : 0,
                    JSON.stringify(messageData, BufferJSON.replacer),
                ],
            );
        } catch (error) {
            logger.error("Error saving message:", error);
        }
    }

    /**
     * Get message from store
     */
    async getMessage(remoteJid, messageId, fromMe) {
        try {
            const [rows] = await pool.execute(
                "SELECT message_data FROM message_store WHERE session_id = ? AND remote_jid = ? AND message_id = ? AND from_me = ?",
                [this.sessionId, remoteJid, messageId, fromMe ? 1 : 0],
            );

            if (rows.length > 0) {
                return JSON.parse(rows[0].message_data, BufferJSON.reviver);
            }
            return null;
        } catch (error) {
            logger.error("Error getting message:", error);
            return null;
        }
    }

    /**
     * Clear old messages (older than 7 days)
     */
    async clearOldMessages() {
        try {
            await pool.execute(
                "DELETE FROM message_store WHERE session_id = ? AND created_at < DATE_SUB(NOW(), INTERVAL 7 DAY)",
                [this.sessionId],
            );
        } catch (error) {
            logger.error("Error clearing old messages:", error);
        }
    }
}

/**
 * Group Metadata Cache
 */
export class MySQLGroupMetadataCache {
    constructor(sessionId) {
        this.sessionId = sessionId;
    }

    /**
     * Get cached group metadata
     */
    async get(groupJid) {
        try {
            const [rows] = await pool.execute(
                `SELECT metadata FROM group_metadata_cache 
                 WHERE session_id = ? AND group_jid = ? 
                 AND cached_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)`,
                [this.sessionId, groupJid],
            );

            if (rows.length > 0) {
                return JSON.parse(rows[0].metadata, BufferJSON.reviver);
            }
            return null;
        } catch (error) {
            logger.error("Error getting group metadata:", error);
            return null;
        }
    }

    /**
     * Set group metadata cache
     */
    async set(groupJid, metadata) {
        try {
            await pool.execute(
                `INSERT INTO group_metadata_cache (session_id, group_jid, metadata, cached_at, created_at, updated_at) 
                 VALUES (?, ?, ?, NOW(), NOW(), NOW()) 
                 ON DUPLICATE KEY UPDATE metadata = VALUES(metadata), cached_at = NOW(), updated_at = NOW()`,
                [
                    this.sessionId,
                    groupJid,
                    JSON.stringify(metadata, BufferJSON.replacer),
                ],
            );
        } catch (error) {
            logger.error("Error setting group metadata:", error);
        }
    }

    /**
     * Clear old cache (older than 1 day)
     */
    async clearOldCache() {
        try {
            await pool.execute(
                "DELETE FROM group_metadata_cache WHERE session_id = ? AND cached_at < DATE_SUB(NOW(), INTERVAL 1 DAY)",
                [this.sessionId],
            );
        } catch (error) {
            logger.error("Error clearing old cache:", error);
        }
    }
}
