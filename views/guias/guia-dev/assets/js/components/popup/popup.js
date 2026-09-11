import { OPTION_INFO } from "../../core/constants.js";
import { $ } from "../../core/utils.js";

export function initPopup() {
  const api = { showOptionInfo, closeOptionInfo };

  // Botones info (data-info-key). Los de Autenticación (.auth-info) NO abren
  // popup: su click muestra la descripción en la tarjeta "Explora la
  // autenticación" (ver initAuthHelp en requestdemo-app.js).
  document
    .querySelectorAll(".info-action[data-info-key]:not(.auth-info)")
    .forEach((btn) => {
      btn.addEventListener("click", (e) => {
        e.stopPropagation();
        const key = btn.dataset.infoKey;
        api.showOptionInfo(key);
      });
    });

  // Cerrar popup
  const closeBtn = document.getElementById("optionInfoCloseBtn");
  if (closeBtn) {
    closeBtn.addEventListener("click", () => api.closeOptionInfo());
  }

  // Click fuera → cerrar
  document.addEventListener("click", (e) => {
    const popup = document.getElementById("optionInfoPopup");
    if (!popup || popup.style.display === "none") return;

    const isInside = popup.contains(e.target);
    const isInfoBtn = e.target.closest(".info-action");
    if (!isInside && !isInfoBtn) api.closeOptionInfo();
  });

  return api;
}

export function showOptionInfo(key, event) {
  if (event) event.stopPropagation();

  const popup = document.getElementById("optionInfoPopup");
  const title = document.getElementById("optionInfoTitle");
  const text = document.getElementById("optionInfoText");

  if (!popup || !title || !text) return;

  const info = OPTION_INFO[key];
  if (!info) {
    popup.style.display = "none";
    return;
  }

  title.textContent = info.title;
  text.textContent = info.text;
  popup.style.display = "flex";
}

export function closeOptionInfo() {
  const popup = document.getElementById("optionInfoPopup");
  if (!popup) return;
  popup.style.display = "none";
}
