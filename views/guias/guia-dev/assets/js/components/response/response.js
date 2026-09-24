import { $, $$, colorize, getSelectedOptionValue } from "../../core/utils.js";
import { SIM, AUTO_CARD_OUTCOME } from "../../core/constants.js";

export function initResponse(state, deps = {}) {
  if (!state.responseTab) state.responseTab = "preview";

  $("#btnSend")?.addEventListener("click", () => sendReq(state, deps));
  $("#btnClearResp")?.addEventListener("click", () => clearResp(state));

  $$(".json-tab[data-resp-tab]").forEach((tabEl) => {
    tabEl.addEventListener("click", () =>
      setRespTab(state, tabEl.dataset.respTab, tabEl),
    );
  });

  return {
    sendReq: () => sendReq(state, deps),
    clearResp: () => clearResp(state),
  };
}

function renderRespTab(state) {
  const isRaw = state.responseTab === "raw";
  $("#respBody").style.display = isRaw ? "none" : "block";
  $("#respRaw").style.display = isRaw ? "block" : "none";
}

export function setRespTab(state, tab, el) {
  state.responseTab = tab;
  $$(".json-tab[data-resp-tab]").forEach((t) => t.classList.remove("active"));
  el?.classList.add("active");
  renderRespTab(state);
}

export function sendReq(state, deps = {}) {
  const btn = $("#btnSend");
  if (!btn) return;

  document.querySelector(".panel-center")?.scrollIntoView({
    behavior: "smooth",
    block: "start",
  });

  btn.disabled = true;
  btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Enviando...';

  $("#sdot").className = "sdot loading";
  $("#stext").textContent = "Procesando...";
  $("#respEmpty").style.display = "none";
  $("#respBody").style.display = "none";

  const ep = getSelectedOptionValue("serviceOption");
  const sim = getSelectedOptionValue("simMode");
  const t0 = Date.now();

  setTimeout(() => {
    const ms = Date.now() - t0;
    // "auto" no es una clave de SIM: el resultado depende de la tarjeta
    // de prueba seleccionada (Aprueba / Pendiente / Rechaza).
    const simKey =
      sim === "auto" ? AUTO_CARD_OUTCOME[state.card] || "ok" : sim;
    const cfg = SIM[simKey] || {
      kind: "ok",
      http: "200 OK",
      status: "OK",
      reason: "00",
      message: "OK",
    };

    const resp = {
      status: {
        status: cfg.status,
        reason: cfg.reason,
        message: cfg.message,
        date: new Date().toISOString(),
      },
      reference: $("#fRef")?.value || "",
      service: ep,
    };

    state.lastResponse = resp;

    const kind = cfg.kind || "ok";
    $("#sdot").className = `sdot ${kind}`;
    $("#stext").textContent = cfg.http;
    $("#respBody").innerHTML = colorize(resp);
    $("#respRaw").textContent = JSON.stringify(resp, null, 2);
    $("#respTabs").style.display = "flex";
    renderRespTab(state);

    $("#rcode").textContent = cfg.http;
    $("#rcode").className = `rcode ${kind}`;
    $("#rtime").textContent = `${ms}ms`;
    $("#rgw").textContent = ep;
    $("#respMeta").style.display = "flex";

    btn.innerHTML = '<i class="bi bi-send-fill"></i> Enviar request';
    if (deps.updateSendAvailability) deps.updateSendAvailability();
    else btn.disabled = false;
  }, 600);
}

export function clearResp(state) {
  if (state) state.lastResponse = null;
  $("#respEmpty").style.display = "flex";
  $("#respBody").style.display = "none";
  $("#respRaw").style.display = "none";
  $("#respTabs").style.display = "none";
  $("#respMeta").style.display = "none";
  $("#sdot").className = "sdot idle";
  $("#stext").textContent = "En espera";
}
