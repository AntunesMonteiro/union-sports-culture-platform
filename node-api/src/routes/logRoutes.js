import { Router } from "express";
import { createLog, getLogsByReservation, searchLogs } from "../controllers/logController.js";

const router = Router();

router.post("/", createLog);
router.get("/", searchLogs);
router.get("/:reservationId", getLogsByReservation);

export default router;
