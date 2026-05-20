import "dotenv/config";
import express from "express";
import http from "http";
import { Server } from "socket.io";
import bodyParser from "body-parser";
import { existsSync } from "fs";
import * as wa from "./server/whatsapp.js";
import routes from "./server/router/index.js";
import logger from "./server/lib/pino.js";

// Crear servidor Express
const app = express();
const server = http.createServer(app);
const io = new Server(server, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"],
    },
});

const port = process.env.PORT_NODE || 3000;

// Middlewares
app.use(
    bodyParser.urlencoded({
        extended: false,
        limit: "50mb",
        parameterLimit: 100000,
    }),
);
app.use(bodyParser.json({ limit: "50mb" }));
app.use((req, res, next) => {
    res.set("Cache-Control", "no-store");
    req.io = io;
    next();
});

// Rutas estáticas
if (existsSync("./public")) {
    app.use(express.static("./public"));
}

// Importar rutas
app.use(routes);

// Ruta de health check
app.get("/health", (req, res) => {
    res.json({
        status: "ok",
        message: "Whats-Fleep Server is running",
        version: "7.0.0",
        baileys: "7.0.0-rc.9",
        timestamp: new Date().toISOString(),
    });
});

// Socket.IO eventos
io.on("connection", (socket) => {
    logger.info(`🔌 Cliente conectado: ${socket.id}`);

    socket.on("StartConnection", async (data) => {
        try {
            logger.info(`📱 Iniciando conexión para: ${data}`);
            await wa.connectToWhatsApp(data, io);
        } catch (error) {
            logger.error("Error iniciando conexión:", error);
            socket.emit("error", {
                message: "Error al iniciar conexión",
            });
        }
    });

    socket.on("LogoutDevice", async (device) => {
        try {
            logger.info(`🚪 Desconectando dispositivo: ${device}`);
            await wa.deleteCredentials(device, io);
        } catch (error) {
            logger.error("Error desconectando dispositivo:", error);
            socket.emit("error", {
                message: "Error al desconectar dispositivo",
            });
        }
    });

    socket.on("disconnect", () => {
        logger.info(`🔌 Cliente desconectado: ${socket.id}`);
    });
});

// Iniciar servidor
server.listen(port, async () => {
    console.log("╔══════════════════════════════════════════╗");
    console.log("║     Whats-Fleep Server v7.0.0           ║");
    console.log("║     Powered by Baileys v7.0.0-rc.9      ║");
    console.log("╚══════════════════════════════════════════╝");
    console.log(`🚀 Servidor escuchando en puerto: ${port}`);
    console.log(`🌍 Entorno: ${process.env.NODE_ENV || "development"}`);
    console.log(`📅 Fecha: ${new Date().toLocaleString()}`);
    console.log(`💾 Auth: MySQL Database`);
    console.log("─────────────────────────────────────────");

    // Esperar 3 segundos antes de verificar sesiones (dar tiempo a la DB)
    setTimeout(async () => {
        logger.info("🔄 Verificando y restaurando sesiones guardadas...");
        try {
            await wa.verifyAndReconnectSessions(io);
            logger.info("✅ Proceso de restauración completado");
        } catch (error) {
            logger.error("❌ Error restaurando sesiones:", error);
        }
    }, 3000);
});

// Manejo de errores no capturados
process.on("unhandledRejection", (error) => {
    logger.error("❌ Unhandled Rejection:", error);
});

process.on("uncaughtException", (error) => {
    logger.error("❌ Uncaught Exception:", error);
});

export { app, io };
