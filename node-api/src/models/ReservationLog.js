import mongoose from "mongoose";

const ReservationLogSchema = new mongoose.Schema(
  {
    reservation_id: { type: Number, index: true, required: true },
    action: {
      type: String,
      enum: ["reservation_created", "status_changed", "email_sent", "email_failed", "note"],
      required: true
    },
    source: { type: String, default: "laravel" }, 
    actor_user_id: { type: Number, default: null }, 
    old_status: { type: String, default: null },
    new_status: { type: String, default: null },
    meta: { type: Object, default: {} }
  },
  { timestamps: true }
);

export default mongoose.model("ReservationLog", ReservationLogSchema);
