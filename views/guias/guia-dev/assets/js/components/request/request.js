import {
  $,
  $$,
  colorize,
  getSelectedOptionValue,
  parseJsonDetailed,
  copyToClipboard,
} from "../../core/utils.js";
import { URLS } from "../../core/constants.js";

export function initRequest(state) {
  if (!state.currentTab) state.currentTab = "preview";
  if (!state.card) state.card = "4111111111111111";
  if (!state.lastBody) state.lastBody = {};

  bindRequestEvents(state);

  return {
    updateAll: () => updateAll(state),
    buildBody: () => buildBody(state),
    genAuth: () => genAuth(),
    setTab: (tab, el) => setTab(state, tab, el),
    resetBody: () => resetBody(state),
    beautify: () => beautify(state),
    copyJson: (event) => copyJson(state, event),
    updateSendAvailability: () => updateSendAvailability(state),
  };
}

function bindRequestEvents(state) {
  $("#btnResetBody")?.addEventListener("click", () => resetBody(state));
  $("#btnBeautify")?.addEventListener("click", () => beautify(state));
  $("#btnCopyJson")?.addEventListener("click", (e) => copyJson(state, e));

  $$(".json-tab[data-tab]").forEach((tabEl) => {
    tabEl.addEventListener("click", () =>
      setTab(state, tabEl.dataset.tab, tabEl),
    );
  });
}

export function initEditor(state) {
  const textarea = $("#jsonEditor");
  if (!textarea || typeof CodeMirror === "undefined") return;

  state.cmEditor = CodeMirror.fromTextArea(textarea, {
    mode: "application/json",
    lineNumbers: true,
    lineWrapping: true,
    indentUnit: 2,
    tabSize: 2,
    gutters: ["CodeMirror-linenumbers", "cm-error-gutter"],
  });

  state.cmEditor.on("change", () => validateEditor(state));
}

function validateEditor(state) {
  const cm = state.cmEditor;
  if (!cm) return;

  clearEditorError(state);
  const result = parseJsonDetailed(cm.getValue());

  if (result.valid) {
    state.editorValid = true;
    state.lastBody = result.value;
    if (state.currentTab === "preview")
      $("#jsonPreview").innerHTML = colorize(state.lastBody);
    hideEditorError();
  } else {
    state.editorValid = false;
    showEditorError(result);
    if (result.line) markEditorErrorLine(state, result.line - 1);
  }

  updateSendAvailability(state);
}

function clearEditorError(state) {
  const cm = state.cmEditor;
  if (!cm) return;
  cm.clearGutter("cm-error-gutter");
  if (state.editorErrorLine != null) {
    cm.removeLineClass(state.editorErrorLine, "background", "cm-error-line");
    state.editorErrorLine = null;
  }
}

function markEditorErrorLine(state, lineIndex) {
  const cm = state.cmEditor;
  if (!cm || lineIndex < 0 || lineIndex >= cm.lineCount()) return;
  const marker = document.createElement("div");
  marker.className = "cm-error-marker";
  marker.title = "Error de sintaxis JSON";
  cm.setGutterMarker(lineIndex, "cm-error-gutter", marker);
  cm.addLineClass(lineIndex, "background", "cm-error-line");
  state.editorErrorLine = lineIndex;
}

function showEditorError(result) {
  const banner = $("#jsonErrorBanner");
  if (!banner) return;
  const where =
    result.line != null ? ` (línea ${result.line}, columna ${result.column})` : "";
  $("#jsonErrorText").textContent = `JSON inválido${where}: ${result.message}`;
  banner.style.display = "flex";
}

function hideEditorError() {
  const banner = $("#jsonErrorBanner");
  if (banner) banner.style.display = "none";
}

function updateSendAvailability(state) {
  const btn = $("#btnSend");
  if (!btn) return;
  const blocking = state.currentTab === "edit" && state.editorValid === false;
  btn.disabled = blocking;
  btn.title = blocking
    ? "Corrige el JSON del Request Body antes de enviar"
    : "";
}

export function genAuth() {
  const seed = new Date().toISOString();
  const nonce = (
    Math.random().toString(36).slice(2) + Math.random().toString(36).slice(2)
  ).slice(0, 32);
  const nonceB64 = btoa(nonce);
  const tranKey = btoa(nonce + seed).slice(0, 44) + "==";

  $("#fSeed") && ($("#fSeed").value = seed);
  $("#fNonce") && ($("#fNonce").value = nonceB64.slice(0, 20) + "...");
  $("#fTranKey") && ($("#fTranKey").value = tranKey.slice(0, 20) + "...");

  return { login: $("#fLogin")?.value || "", tranKey, nonce: nonceB64, seed };
}

export function buildBody(state) {
  const auth = genAuth();
  const ref = $("#fRef")?.value || "";
  const desc = $("#fDesc")?.value || "";
  const cur = $("#fCurrency")?.value || "COP";
  const amt = parseFloat($("#fAmount")?.value || 0) || 0;
  const ep = getSelectedOptionValue("serviceOption");

  if (ep === "gw_process") {
    return {
      auth,
      payer: {
        name: "Usuario Demo",
        surname: "Pruebas",
        email: "demo@ejemplo.com",
      },
      payment: {
        reference: ref,
        description: desc,
        amount: { currency: cur, total: amt },
      },
      instrument: {
        card: { number: state.card, expiration: "12/26", cvv: "123" },
      },
    };
  }

  if (ep === "link") {
    return {
      auth,
      reference: ref,
      description: desc,
      payment: { amount: { currency: cur, total: amt } },
    };
  }

  // Web Checkout (wc_session): la forma del "payment" cambia según el tipo de
  // pago seleccionado, siguiendo la documentación de Place to Pay:
  // https://docs.placetopay.dev/checkout/create-session/
  return buildWebCheckoutBody(auth, { ref, desc, cur, amt });
}

/**
 * Construye el CreateSessionRequest de Web Checkout adaptando la estructura
 * al "Tipo de pago" (input[name="paymentType"]). El campo "Simular respuesta"
 * NO afecta este cuerpo (solo afecta la respuesta simulada en la tarjeta 5).
 */
function buildWebCheckoutBody(auth, { ref, desc, cur, amt }) {
  const tipo = getSelectedOptionValue("paymentType") || "basico";

  // Estructura base "payment" común a la mayoría de los tipos.
  const payment = {
    reference: ref,
    description: desc,
    amount: { currency: cur, total: amt },
  };

  const body = { auth };

  switch (tipo) {
    // Pago básico: payment simple.
    case "basico":
      body.payment = payment;
      break;

    // Pagos parciales: payment.allowPartial = true. No admite impuestos.
    case "partial":
      body.payment = { ...payment, allowPartial: true };
      break;

    // Pago recurrente: payment.recurring con la estructura Recurrence.
    case "recurrencia":
      body.payment = {
        ...payment,
        recurring: {
          periodicity: "M",
          interval: "1",
          nextPayment: isoDatePlusDays(30),
          maxPeriods: 12,
          dueDate: isoDatePlusDays(365),
          notificationUrl: "https://tu-sitio.com/notificacion",
        },
      };
      break;

    // Pago con dispersión: payment.dispersion (arreglo de DispersionRequests).
    // La suma de las dispersiones debe igualar el total; misma moneda.
    case "dispersion": {
      const first = Math.round(amt * 0.7 * 100) / 100;
      const second = Math.round((amt - first) * 100) / 100;
      body.payment = {
        ...payment,
        dispersion: [
          {
            amount: { total: first, currency: cur },
            agreement: 30,
            agreementType: "AIRLINE",
          },
          {
            amount: { total: second, currency: cur },
            agreementType: "MERCHANT",
          },
        ],
      };
      break;
    }

    // Preautorización (check-in): type = "checkin" a nivel raíz + payment base.
    // No admite pagos mixtos ni dispersos; la moneda se mantiene fija.
    case "preauth":
      body.type = "checkin";
      body.payment = payment;
      break;

    // Suscripción + Token (tokenización): NO se envía "payment", se envía la
    // estructura "subscription" para tokenizar el medio de pago.
    case "token":
      body.subscription = {
        reference: ref,
        description: desc || "Suscripción de prueba",
      };
      break;

    // Pago + Suscripción: pago normal con payment.subscribe = true para
    // ofrecer al usuario guardar (tokenizar) su medio de pago.
    case "suscripcion":
      body.payment = { ...payment, subscribe: true };
      break;

    default:
      body.payment = payment;
  }

  body.returnUrl = "https://tu-sitio.com/retorno";
  return body;
}

// Fecha ISO (YYYY-MM-DD) a N días de hoy, para los campos de recurrencia.
function isoDatePlusDays(days) {
  const d = new Date();
  d.setDate(d.getDate() + days);
  return d.toISOString().slice(0, 10);
}

export function updateAll(state) {
  if (state.currentTab !== "edit") {
    state.lastBody = buildBody(state);
  }

  const ep = getSelectedOptionValue("serviceOption");
  $("#urlDisplay") &&
    ($("#urlDisplay").textContent = URLS[ep] || "https://docs.placetopay.dev/");

  if (state.currentTab === "preview")
    $("#jsonPreview").innerHTML = colorize(state.lastBody);
  if (state.currentTab === "raw")
    $("#jsonRaw").textContent = JSON.stringify(state.lastBody, null, 2);
}

export function resetBody(state) {
  state.lastBody = buildBody(state);
  if (state.currentTab === "edit" && state.cmEditor)
    state.cmEditor.setValue(JSON.stringify(state.lastBody, null, 2));
  updateAll(state);
}

export function beautify(state) {
  const rawTab = $$('.json-tab[data-tab="raw"]')[0];
  if (rawTab) setTab(state, "raw", rawTab);
  $("#jsonRaw") &&
    ($("#jsonRaw").textContent = JSON.stringify(state.lastBody, null, 2));
}

export function setTab(state, tab, el) {
  state.currentTab = tab;
  $$(".json-tab").forEach((t) => t.classList.remove("active"));
  el?.classList.add("active");

  $("#jsonPreview").style.display = "none";
  $("#jsonRaw").style.display = "none";
  $("#editorContainer").classList.remove("active");
  $("#editBanner").classList.remove("show");

  if (tab === "preview") {
    $("#jsonPreview").style.display = "block";
    $("#jsonPreview").innerHTML = colorize(state.lastBody);
  } else if (tab === "raw") {
    $("#jsonRaw").style.display = "block";
    $("#jsonRaw").textContent = JSON.stringify(state.lastBody, null, 2);
  } else if (tab === "edit") {
    $("#editorContainer").classList.add("active");
    $("#editBanner").classList.add("show");
    if (state.cmEditor) {
      state.cmEditor.setValue(JSON.stringify(state.lastBody, null, 2));
      setTimeout(() => state.cmEditor?.refresh?.(), 80);
    }
  }

  if (tab !== "edit") {
    state.editorValid = true;
    clearEditorError(state);
    hideEditorError();
  }
  updateSendAvailability(state);
}

export async function copyJson(state, event) {
  await copyToClipboard(JSON.stringify(state.lastBody, null, 2));
  const btn = event?.currentTarget || $("#btnCopyJson");
  if (!btn) return;
  const old = btn.innerHTML;
  btn.innerHTML = '<i class="bi bi-check2"></i> Copiado!';
  setTimeout(() => (btn.innerHTML = old), 1200);
}
