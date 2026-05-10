import mysql2 from "mysql2/promise";
import dotenv from "dotenv";
import autoReplyCache from "../lib/cache.js";

dotenv.config();

// Create connection pool
export const pool = mysql2.createPool({
    host: process.env.DB_HOST || "localhost",
    user: process.env.DB_USERNAME || "root",
    database: process.env.DB_DATABASE || "whats_fleep",
    password: process.env.DB_PASSWORD || "",
    waitForConnections: true,
    connectionLimit: 10,
    queueLimit: 0,
    enableKeepAlive: true,
    keepAliveInitialDelay: 0,
});

/**
 * Update device status in database
 * @param {string} deviceBody - Device identifier
 * @param {string} status - Status: 'Connected' or 'Disconnect'
 */
export async function setStatus(deviceBody, status) {
    try {
        const query = "UPDATE devices SET status = ? WHERE body = ?";
        await pool.execute(query, [status, deviceBody]);
        console.log(`Device ${deviceBody} status updated to ${status}`);
        return true;
    } catch (error) {
        console.error("Error updating device status:", error);
        return false;
    }
}

/**
 * Execute a database query
 * @param {string} query - SQL query
 * @param {array} params - Query parameters
 */
export async function dbQuery(query, params = []) {
    try {
        const [results] = await pool.execute(query, params);
        return results;
    } catch (error) {
        console.error("Database query error:", error);
        throw error;
    }
}

/**
 * Get device by body
 */
export async function getDevice(deviceBody) {
    try {
        const query = "SELECT * FROM devices WHERE body = ? LIMIT 1";
        const [results] = await pool.execute(query, [deviceBody]);
        return results[0] || null;
    } catch (error) {
        console.error("Error getting device:", error);
        return null;
    }
}

/**
 * Get autoreplies by device (con caché en RAM)
 */
export async function getAutoreplies(deviceBody) {
    const cacheKey = `autoreplies_${deviceBody}`;

    const cached = autoReplyCache.get(cacheKey);
    if (cached !== undefined) {
        return cached;
    }

    try {
        const query =
            "SELECT * FROM autoreplies WHERE device = ? AND status = 1";
        const [results] = await pool.execute(query, [deviceBody]);
        autoReplyCache.set(cacheKey, results);
        return results;
    } catch (error) {
        console.error("Error getting autoreplies:", error);
        return [];
    }
}

/**
 * Limpiar todo el caché de autoreplies
 */
export function clearAutorepliesCache() {
    autoReplyCache.flushAll();
}

/**
 * Save message history
 */
export async function saveMessageHistory(data) {
    try {
        const query = `
            INSERT INTO message_histories 
            (device_id, user_id, number, type, message, payload, status, send_by, note) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        `;
        const params = [
            data.device_id,
            data.user_id,
            data.number,
            data.type,
            data.message,
            JSON.stringify(data.payload),
            data.status,
            data.send_by,
            data.note || null,
        ];
        await pool.execute(query, params);
        return true;
    } catch (error) {
        console.error("Error saving message history:", error);
        return false;
    }
}

/**
 * Update campaign blast status
 */
export async function updateBlastStatus(blastId, status) {
    try {
        const query = "UPDATE blasts SET status = ? WHERE id = ?";
        await pool.execute(query, [status, blastId]);
        return true;
    } catch (error) {
        console.error("Error updating blast status:", error);
        return false;
    }
}
