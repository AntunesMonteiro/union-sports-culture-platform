// Union microsite - mobile nav + smooth scroll
(() => {
    const burger = document.getElementById("uc-burger");
    const mobileNav = document.getElementById("uc-mobile-nav");
  
    if (burger && mobileNav) {
      burger.addEventListener("click", () => {
        mobileNav.classList.toggle("is-open");
      });
  
      // fechar menu ao clicar num link
      mobileNav.querySelectorAll("a").forEach((a) => {
        a.addEventListener("click", () => mobileNav.classList.remove("is-open"));
      });
    }
  
    // Smooth scroll para anchors internas (#...)
    document.querySelectorAll('a[href^="#"]').forEach((link) => {
      link.addEventListener("click", (e) => {
        const id = link.getAttribute("href");
        const target = document.querySelector(id);
        if (!target) return;
  
        e.preventDefault();
        target.scrollIntoView({ behavior: "smooth", block: "start" });
      });
    });
  
    // ===== Reservas: limitar hora por dia (UX) =====
    const dateEl = document.getElementById("date");
    const timeEl = document.getElementById("time");
    const timeHint = document.getElementById("timeHint");
  
    function setTimeLimits() {
      if (!dateEl || !timeEl) return;
      if (!dateEl.value) return;
  
      const d = new Date(dateEl.value + "T00:00:00");
      const day = d.getDay(); // 0=Dom ... 6=Sáb
  
      // Segunda (1) fechado
      if (day === 1) {
        timeEl.min = "";
        timeEl.max = "";
        if (timeHint) timeHint.textContent = "Fechado à segunda-feira. Escolhe outra data.";
        return;
      }
  
      // Ter–Sex: 16:00–22:30 | Sáb/Dom: 09:00–22:30
      const isTueToFri = day >= 2 && day <= 5;
      timeEl.min = isTueToFri ? "16:00" : "09:00";
      timeEl.max = "22:30";
  
      if (timeHint) {
        timeHint.textContent = isTueToFri
          ? "Ter–Sex: 16:00–22:30"
          : "Sáb–Dom: 09:00–22:30";
      }
  
      // Se já tiver uma hora fora do limite, limpa
      if (timeEl.value && (timeEl.value < timeEl.min || timeEl.value > timeEl.max)) {
        timeEl.value = "";
      }
    }
  
    if (dateEl && timeEl) {
      dateEl.addEventListener("change", setTimeLimits);
      setTimeLimits();
    }
  
    // ===== Reservas: mostrar última reserva guardada (premium) =====
    const lastBox = document.getElementById("uc-last-reservation");
    if (lastBox) {
      try {
        const raw = localStorage.getItem("union_last_reservation");
        if (raw) {
          const data = JSON.parse(raw);
  
          // expirar em 24h
          const savedAt = new Date(data.savedAt || 0).getTime();
          const isFresh = Date.now() - savedAt < 24 * 60 * 60 * 1000;
  
          if (isFresh && data.summary) {
            const s = data.summary;
  
            lastBox.style.display = "block";
            lastBox.innerHTML = `
              <div class="uc-alert uc-alert-success">
                <strong>Última reserva enviada</strong>
                <div style="margin-top:8px; color: rgba(231,234,241,.78);">
                  <div><strong>Nome:</strong> ${s.customer_name ?? "—"} · <strong>Pessoas:</strong> ${s.num_people ?? "—"}</div>
                  <div><strong>Data:</strong> ${s.date ?? "—"} · <strong>Hora:</strong> ${s.time ?? "—"}</div>
                </div>
                <div style="margin-top:12px; display:flex; gap:10px; flex-wrap:wrap;">
                  <button type="button" id="uc-clear-last" class="uc-btn-ghost">Limpar</button>
                </div>
              </div>
            `;
  
            const clearBtn = document.getElementById("uc-clear-last");
            if (clearBtn) {
              clearBtn.addEventListener("click", () => {
                localStorage.removeItem("union_last_reservation");
                lastBox.style.display = "none";
                lastBox.innerHTML = "";
              });
            }
          }
        }
      } catch (e) {
        localStorage.removeItem("union_last_reservation");
      }
    }
  
    // ===== Success: scroll automático para feedback =====
    const success = document.getElementById("reserva-sucesso");
    if (success) success.scrollIntoView({ behavior: "smooth", block: "start" });
  })();
  