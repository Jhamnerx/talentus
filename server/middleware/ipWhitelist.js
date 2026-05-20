import { pool } from "../database/index.js";
import logger from "../lib/pino.js";

/**
 * Middleware para verificar IP whitelist
 */
export async function checkIpWhitelist(req, res, next) {
    try {
        // Obtener IP del cliente
        let clientIp = req.ip || req.connection.remoteAddress;

        // Manejar headers de proxy
        if (req.headers["x-forwarded-for"]) {
            const forwardedIps = req.headers["x-forwarded-for"].split(",");
            clientIp = forwardedIps[0].trim();
        } else if (req.headers["x-real-ip"]) {
            clientIp = req.headers["x-real-ip"];
        }

        // Limpiar IP (remover ::ffff: de IPv6)
        clientIp = clientIp.replace(/^::ffff:/, "");

        logger.info("🔍 Verificando IP:", clientIp);

        // Verificar si la protección está habilitada
        const ipProtectionEnabled =
            process.env.IP_PROTECTION_ENABLED === "true";

        if (!ipProtectionEnabled) {
            logger.info("✅ Protección de IP deshabilitada");
            return next();
        }

        // Verificar en base de datos
        const [ipRecords] = await pool.execute(
            "SELECT * FROM ip_whitelists WHERE (ip_address = ? OR domain IS NOT NULL) AND is_active = 1",
            [clientIp]
        );

        // Verificar IP exacta
        const ipMatch = ipRecords.find(
            (record) => record.ip_address === clientIp
        );
        if (ipMatch) {
            logger.info("✅ IP autorizada:", clientIp);
            return next();
        }

        // Verificar dominio de origen
        const origin = req.headers["origin"] || req.headers["referer"];
        if (origin) {
            const parsedUrl = new URL(origin);
            const host = parsedUrl.hostname;

            const domainMatch = ipRecords.find((record) => {
                if (!record.domain) return false;
                return (
                    host === record.domain || host.endsWith("." + record.domain)
                );
            });

            if (domainMatch) {
                logger.info("✅ Dominio autorizado:", host);
                return next();
            }
        }

        // Verificar IPs en variables de entorno como fallback
        const allowedIps = (process.env.ALLOWED_IPS || "")
            .split(",")
            .map((ip) => ip.trim())
            .filter(Boolean);
        const allowedDomains = (process.env.ALLOWED_DOMAINS || "")
            .split(",")
            .map((d) => d.trim())
            .filter(Boolean);

        if (allowedIps.includes(clientIp)) {
            logger.info("✅ IP autorizada (env):", clientIp);
            return next();
        }

        if (origin && allowedDomains.length > 0) {
            const parsedUrl = new URL(origin);
            const host = parsedUrl.hostname;

            const domainMatch = allowedDomains.some(
                (domain) => host === domain || host.endsWith("." + domain)
            );

            if (domainMatch) {
                logger.info("✅ Dominio autorizado (env):", host);
                return next();
            }
        }

        // Registrar intento de acceso no autorizado
        logger.warn("❌ Acceso denegado:", {
            ip: clientIp,
            path: req.path,
            method: req.method,
            origin: origin,
            userAgent: req.headers["user-agent"],
        });

        // Retornar error
        return res.status(403).json({
            status: false,
            message: "Acceso denegado. IP no autorizada.",
            ip: clientIp,
        });
    } catch (error) {
        logger.error("Error en middleware de IP whitelist:", error);

        // En caso de error, permitir acceso si está en desarrollo
        if (process.env.NODE_ENV === "development") {
            return next();
        }

        return res.status(500).json({
            status: false,
            message: "Error verificando permisos",
        });
    }
}
