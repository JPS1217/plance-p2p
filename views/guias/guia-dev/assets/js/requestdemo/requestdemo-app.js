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
import { $, $$ } from "../core/utils.js";

// Fusiona la info de los campos de autenticación en el catálogo que usa el
// popup, para reutilizar el mecanismo existente (data-info-key).
Object.assign(OPTION_INFO, AUTH_FIELD_INFO);

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

  // Sincroniza el estado inicial de la sección Operación (URL, tipo de pago).
  onEpChange({ updateAll: () => requestApi.updateAll?.() });

  // Render inicial del Raw JSON.
  requestApi.updateAll?.();
  const rawTab = $$('.json-tab[data-tab="raw"]')[0];
  requestApi.setTab?.("raw", rawTab);
}

window.addEventListener("DOMContentLoaded", boot);
