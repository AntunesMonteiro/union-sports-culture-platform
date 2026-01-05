import ReservationLog from "../models/ReservationLog.js";

export async function createLog(req, res) {
  const payload = req.body;

  if (!payload?.reservation_id || !payload?.action) {
    return res.status(422).json({ message: "reservation_id and action are required" });
  }

  const doc = await ReservationLog.create({
    reservation_id: Number(payload.reservation_id),
    action: payload.action,
    source: payload.source ?? "laravel",
    actor_user_id: payload.actor_user_id ?? null,
    old_status: payload.old_status ?? null,
    new_status: payload.new_status ?? null,
    meta: payload.meta ?? {}
  });

  return res.status(201).json({ message: "created", id: doc._id });
}

export async function getLogsByReservation(req, res) {
  const reservationId = Number(req.params.reservationId);

  if (!reservationId) {
    return res.status(422).json({ message: "reservationId invalid" });
  }

  const logs = await ReservationLog.find({ reservation_id: reservationId })
    .sort({ createdAt: 1 })
    .lean();

  return res.json({ reservation_id: reservationId, logs });
}

export async function searchLogs(req, res) {
  const reservationId = req.query.reservation_id ? Number(req.query.reservation_id) : null;
  const action = req.query.action ?? null;
  const from = req.query.from ? new Date(req.query.from) : null;
  const to = req.query.to ? new Date(req.query.to) : null;

  const filter = {};
  if (reservationId) filter.reservation_id = reservationId;
  if (action) filter.action = action;

  if (from || to) {
    filter.createdAt = {};
    if (from) filter.createdAt.$gte = from;
    if (to) filter.createdAt.$lte = to;
  }

  const logs = await ReservationLog.find(filter)
    .sort({ createdAt: -1 })
    .limit(200)
    .lean();

  return res.json({ count: logs.length, logs });
}
