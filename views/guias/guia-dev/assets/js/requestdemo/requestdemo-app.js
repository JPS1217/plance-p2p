/**
 * App del "Request Demo".
 *
 * Reutiliza los componentes del Payment API Explorer (sidebar, request,
 * response, popup) pero SIN la pantalla de bienvenida ni la navegación por
 * secciones: la vista arranca directamente en el layout de exploración,
 * fijada al flujo de Pago Básico de Web Checkout (crear sesión).
 *
 * Diferencias respecto a lab_index:
 *  - No hay welcome screen ni template-loader: el HTML del shell ya está
 *    embebido en requestdemo.php.
 *  - El panel central muestra SOLO Raw JSON (sin Preview ni Editar).
 *  - Se añaden popups informativos a cada campo de "Autenticación".
 */
import { state } from "../core/state.js";
import { initSidebar, onEpChange } from "../components/sidebar/sidebar.js";
import { initRequest } from "../components/request/request.js";
import { initResponse } from "../components/response/response.js";
import { initPopup } from "../components/popup/popup.js";
import { initTheme } from "../components/theme/theme.js";
import { OPTION_INFO } from "../core/constants.js";
import { AUTH_FIELD_INFO } from "./demo-constants.js";
import { initDemoDropdowns } from "./demo-dropdowns.js";
import { $, $$, selectSingleOption } from "../core/utils.js";

// Fusiona la info de los campos de autenticación en el catálogo que usa el
// popup, para reutilizar el mecanismo existente (data-info-key).
Object.assign(OPTION_INFO, AUTH_FIELD_INFO);

function initFieldHelp() {
  const title = $("#authHelpTitle");
  const text = $("#authHelpText");
  const steps = $("#authHelpSteps");
  const result = $("#authHelpResult");
  const aside = $("#authHelp");
  const kicker = aside ? aside.querySelector(".auth-help-kicker") : null;

  if (!title || !text) return;

  // Copia por defecto para restaurar el panel cuando no hay campo activo.
  const DEFAULT_KICKER = kicker ? kicker.textContent : "Campo seleccionado";
  const defaultTitle = title.textContent;
  const defaultText = text.textContent;

  // Los campos con descripción: cada .field-group con data-info-key en las
  // secciones Autenticación y Datos del pago.
  const fields = $$(
    "#secAuth .field-group[data-info-key], #secPago .field-group[data-info-key]",
  );

  let lockedKey = null; // clave del campo fijado (o null = modo hover)

  // Pinta la descripción del campo indicado por su clave en la tarjeta 3.
  function render(key) {
    const info = key ? OPTION_INFO[key] : null;
    if (!info) return;

    title.textContent = info.title;

    // Resalta el fragmento info.highlight dentro del párrafo principal.
    text.replaceChildren();
    const hl = info.highlight || "";
    const parts = hl ? info.text.split(hl) : [info.text];
    text.appendChild(document.createTextNode(parts[0]));
    if (hl) {
      text.appendChild(document.createElement("br"));
      const span = document.createElement("span");
      span.className = "auth-help-highlight";
      span.textContent = hl;
      text.appendChild(span);
      text.appendChild(document.createTextNode(parts[1] || ""));
    }

    // Pasos (lista numerada) — opcional.
    if (steps) {
      steps.replaceChildren();
      if (Array.isArray(info.steps) && info.steps.length) {
        info.steps.forEach((s) => {
          const li = document.createElement("li");
          li.textContent = s;
          steps.appendChild(li);
        });
        steps.style.display = "";
      } else {
        steps.style.display = "none";
      }
    }

    // Resultado / errores comunes — opcional (string o array).
    if (result) {
      result.replaceChildren();
      const items = Array.isArray(info.result)
        ? info.result.slice()
        : info.result
          ? [info.result]
          : [];

      if (items.length) {
        const heading = document.createElement("h3");
        heading.className = "auth-help-result-title";
        heading.textContent = "Errores comunes";
        result.appendChild(heading);

        const ul = document.createElement("ul");
        ul.className = "auth-help-result-list";
        items.forEach((r) => {
          const li = document.createElement("li");
          if (typeof r === "string") {
            li.textContent = r;
          } else {
            li.appendChild(document.createTextNode(r.text || ""));
            if (Array.isArray(r.sublist) && r.sublist.length) {
              const sublist = document.createElement("ul");
              sublist.className = "auth-help-result-sublist";
              r.sublist.forEach((subitem) => {
                const subli = document.createElement("li");
                const label = document.createElement("strong");
                label.textContent = `${subitem.label || ""} `;
                subli.appendChild(label);
                subli.appendChild(document.createTextNode(subitem.value || ""));
                sublist.appendChild(subli);
              });
              li.appendChild(sublist);
            }
          }
          ul.appendChild(li);
        });
        result.appendChild(ul);
        result.style.display = "";
      } else {
        result.style.display = "none";
      }
    }
  }

  // Refleja el estado (fijado vs hover) en el kicker y en el resaltado del campo.
  function setKickerLocked(locked) {
    if (!kicker) return;
    if (locked) {
      kicker.textContent = "📌 Fijado — clic para soltar";
      kicker.classList.add("is-locked");
    } else {
      kicker.textContent = DEFAULT_KICKER;
      kicker.classList.remove("is-locked");
    }
  }

  function markLockedField(field) {
    fields.forEach((f) => {
      const locked = f === field;
      f.classList.toggle("is-locked", locked);
      const pin = f.querySelector(".field-pin");
      if (pin) {
        pin.classList.toggle("bi-pin-fill", locked);
        pin.classList.toggle("bi-pin-angle", !locked);
      }
    });
  }

  function clearLockedField() {
    fields.forEach((f) => {
      f.classList.remove("is-locked");
      const pin = f.querySelector(".field-pin");
      if (pin) {
        pin.classList.remove("bi-pin-fill");
        pin.classList.add("bi-pin-angle");
      }
    });
  }

  fields.forEach((field) => {
    const key = field.dataset.infoKey;

    // Hover / focus → previsualiza (solo si no hay nada fijado).
    const preview = () => {
      if (lockedKey) return;
      render(key);
    };
    field.addEventListener("mouseenter", preview);
    field.addEventListener("focusin", preview);

    // Clic → fijar / soltar / cambiar de campo fijado.
    field.addEventListener("click", (event) => {
      // No interferir con interacciones reales del input/select.
      event.stopPropagation();
      if (lockedKey === key) {
        // Ya estaba fijado este mismo → soltar y volver a modo hover.
        lockedKey = null;
        clearLockedField();
        setKickerLocked(false);
      } else {
        // Fijar este campo (o cambiar el fijado a este).
        lockedKey = key;
        render(key);
        markLockedField(field);
        setKickerLocked(true);
      }
    });

    // Enter / Espacio con foco en el campo = clic (accesibilidad).
    field.addEventListener("keydown", (event) => {
      if (event.key === "Enter" || event.key === " ") {
        // Evita hacer toggle si el foco está en el input interno escribiendo.
        if (event.target.closest("input, select, textarea, button")) return;
        event.preventDefault();
        field.click();
      }
    });
  });

  // Clic fuera de cualquier campo → soltar y volver a modo hover.
  document.addEventListener("click", (event) => {
    if (!lockedKey) return;
    if (event.target.closest("#secAuth .field-group[data-info-key], #secPago .field-group[data-info-key]")) {
      return;
    }
    lockedKey = null;
    clearLockedField();
    setKickerLocked(false);
  });

  // Leniencia de hover: al salir del área de campos y sin nada fijado, se
  // conserva la última descripción mostrada (no se vacía el panel). Solo al
  // soltar un fijado se restaura el texto por defecto, cosa que ya hace
  // setKickerLocked(false) dejando la última descripción visible.
  void defaultTitle;
  void defaultText;
}

/**
 * Preselecciona el "Tipo de pago" según el parámetro de consulta ?tipo=
 * (p. ej. requestdemo.php?tipo=basico al llegar desde una tarjeta de home.php).
 *
 * Supuesto actual: todas las opciones corresponden al servicio Web Checkout,
 * así que solo se ajusta paymentType; el servicio permanece en "wc_session".
 * El valor debe coincidir con un input[name="paymentType"] existente; si no
 * coincide, no se hace nada (se conserva la opción por defecto "basico").
 */
function preselectFromQuery() {
  const params = new URLSearchParams(window.location.search);
  const tipo = params.get("tipo");
  if (!tipo) return;

  const input = document.querySelector(
    `input[name="paymentType"][value="${CSS.escape(tipo)}"]`,
  );
  if (input) selectSingleOption(input, "paymentType");
}

function boot() {
  initTheme();

  // El demo solo trabaja el flujo Raw JSON: forzamos la pestaña "raw".
  state.currentTab = "raw";

  const requestApi = initRequest(state) || {};

  document.addEventListener("app:force-update", () => requestApi.updateAll?.());

  const sidebarApi =
    initSidebar(state, { updateAll: () => requestApi.updateAll?.() }) || {};

  $("#sidebarToggle")?.addEventListener("click", () =>
    sidebarApi.toggleSidebar?.(),
  );

  initResponse(state, {
    updateSendAvailability: () => requestApi.updateSendAvailability?.(),
  });

  initPopup();
  initFieldHelp();
  // Sincroniza el estado inicial de la sección Operación (URL, tipo de pago).
  onEpChange({ updateAll: () => requestApi.updateAll?.() });

  // Preselección según el parámetro ?tipo= (p. ej. al llegar desde home.php).
  // Debe ir ANTES de initDemoDropdowns para que la etiqueta del desplegable
  // refleje la opción elegida.
  preselectFromQuery();

  // Convierte Servicio / Tipo de pago / Simular respuesta en desplegables.
  initDemoDropdowns();

  // Render inicial del Raw JSON.
  requestApi.updateAll?.();
  const rawTab = $$('.json-tab[data-tab="raw"]')[0];
  requestApi.setTab?.("raw", rawTab);
}

window.addEventListener("DOMContentLoaded", boot);
