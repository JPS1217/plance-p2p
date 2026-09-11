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

const AUTH_FIELD_EXAMPLES = {
  auth_login: '"login": "2d9eaf1e662518756a3d78806543af5b"',
  auth_secret: '"secretKey": "3YC5brb5eAR4xBGQ"',
  auth_seed: '"seed": "2023-06-21T09:56:06-05:00"',
  auth_nonce: '"nonce": "OTI3MzQyMTk3"',
  auth_trankey:
    '"tranKey": "Base64(SHA-256(nonce + seed + secretKey))"',
};

function initAuthHelp() {
  const title = $("#authHelpTitle");
  const text = $("#authHelpText");
  const steps = $("#authHelpSteps");
  const result = $("#authHelpResult");

  if (!title || !text) return;

  // Ahora el disparador es el icono ⓘ (.info-action.auth-info) de cada campo,
  // no la etiqueta. Al hacer clic muestra la descripción en la tarjeta 3 y ya
  // NO abre popup (popup.js excluye los .auth-info).
  $$("#secAuth .info-action.auth-info").forEach((btn) => {
    const showHelp = () => {
      const key = btn.dataset.infoKey;
      const info = key ? AUTH_FIELD_INFO[key] : null;
      if (!info) return;

      title.textContent = info.title;
      text.textContent = info.text;

      // Pasos (lista numerada) — opcional
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

      // Resultado / cómo se ve el valor final — opcional.
      // Se admite string o array; se muestra como viñetas dentro de la caja
      // con borde naranja. El ejemplo JSON del campo se agrega como una
      // viñeta final (en monoespaciado) dentro de la MISMA caja.
      if (result) {
        result.replaceChildren();
        const items = Array.isArray(info.result)
          ? info.result.slice()
          : info.result
            ? [info.result]
            : [];

        const ul = document.createElement("ul");
        ul.className = "auth-help-result-list";

        items.forEach((r) => {
          const li = document.createElement("li");
          li.textContent = r;
          ul.appendChild(li);
        });

        // Ejemplo JSON como última viñeta en monoespaciado.
        const jsonExample = AUTH_FIELD_EXAMPLES[key];
        if (jsonExample) {
          const li = document.createElement("li");
          const code = document.createElement("code");
          code.className = "auth-help-result-code";
          code.textContent = jsonExample;
          li.appendChild(code);
          ul.appendChild(li);
        }

        if (ul.children.length) {
          result.appendChild(ul);
          result.style.display = "";
        } else {
          result.style.display = "none";
        }
      }
    };

    btn.addEventListener("click", (event) => {
      event.stopPropagation();
      showHelp();
    });
    btn.addEventListener("keydown", (event) => {
      if (event.key === "Enter" || event.key === " ") {
        event.preventDefault();
        showHelp();
      }
    });
  });
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
  initAuthHelp();
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
