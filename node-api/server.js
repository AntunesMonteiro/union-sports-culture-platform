import "dotenv/config";
import express from "express";
import cors from "cors";
import helmet from "helmet";
import morgan from "morgan";
import { connectDB } from "./src/config/db.js";
import { apiKeyMiddleware } from "./src/middlewares/apiKey.js";

import logRoutes from "./src/routes/logRoutes.js";
import statsRoutes from "./src/routes/statsRoutes.js";

const app = express();

app.use(helmet());
app.use(morgan("dev"));

app.use(
  cors({
    origin: process.env.CORS_ORIGIN?.split(",") ?? "*",
    credentials: true
  })
);

app.use(express.json({ limit: "1mb" }));

// API_KEY
app.use(apiKeyMiddleware);

app.get("/health", (req, res) => res.json({ ok: true }));

app.use("/api/logs", logRoutes);
app.use("/api/stats", statsRoutes);

const PORT = process.env.PORT || 4000;

async function start() {
  await connectDB(process.env.MONGO_URI);
  app.listen(PORT, () => console.log(`🚀 Node API on http://localhost:${PORT}`));
}

start().catch((err) => {
  console.error("❌ Failed to start:", err);
  process.exit(1);
});
