export function apiKeyMiddleware(req, res, next) {
    const requiredKey = process.env.API_KEY;
    if (!requiredKey) return next(); 
  
    const provided = req.header("x-api-key");
    if (!provided || provided !== requiredKey) {
      return res.status(401).json({ message: "Unauthorized" });
    }
  
    next();
  }
  