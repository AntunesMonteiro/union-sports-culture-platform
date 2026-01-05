import ReservationLog from "../models/ReservationLog.js";

export async function getStats(req, res) {
  const from = req.query.from ? new Date(req.query.from) : new Date(Date.now() - 7 * 24 * 3600 * 1000);
  const to = req.query.to ? new Date(req.query.to) : new Date();

  const pipeline = [
    { $match: { createdAt: { $gte: from, $lte: to } } },
    {
      $group: {
        _id: {
          day: { $dateToString: { format: "%Y-%m-%d", date: "$createdAt" } },
          action: "$action"
        },
        total: { $sum: 1 }
      }
    },
    { $sort: { "_id.day": 1 } }
  ];

  const rows = await ReservationLog.aggregate(pipeline);

  return res.json({
    range: { from, to },
    rows
  });
}
