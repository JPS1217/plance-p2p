/**
 * Convierte los grupos de opción única (Servicio / Tipo de pago /
 * Simular respuesta) en menús desplegables tipo "select":
 *
 *  - El trigger muestra SOLO la opción actualmente seleccionada.
 *  - Al hacer clic se despliega el menú con todas las opciones.
 *  - Se conserva el markup original (.checkbox-option + inputs con name),
 *    de modo que sidebar.js (selectSingleOption / getSelectedOptionValue /
 *    updateSimModeOptions) sigue funcionando sin cambios.
 *
 * Cada .demo-dropdown envuelve:
 *    <button.demo-dropdown-trigger><span.dd-label/><i.dd-chev/></button>
 *    <div.demo-dropdown-menu.option-grid> ...checkbox-option... </div>
 */
import { $$ } from "../core/utils.js";

function labelFor(menu) {
  const checked = menu.querySelector(
    '.checkbox-option input[type="checkbox"]:checked',
  );
  const source = checked
    ? checked.closest(".checkbox-option")
    : menu.querySelector(".checkbox-option");
  const span = source?.querySelector("span");
  return span ? span.textContent.trim().replace(/\s+/g, " ") : "—";
}

function syncTriggerLabel(dropdown) {
  const menu = dropdown.querySelector(".demo-dropdown-menu");
  const label = dropdown.querySelector(".dd-label");
  if (menu && label) label.textContent = labelFor(menu);
}

function closeAll(except = null) {
  $$(".demo-dropdown.open").forEach((dd) => {
    if (dd !== except) dd.classList.remove("open");
  });
}

// Posiciona el menú (position: fixed) justo bajo el trigger, escapando el
// contenedor con overflow del panel para que no desplace los campos ni
// dispare la barra de scroll del panel. Si no cabe abajo, lo abre hacia arriba.
function positionMenu(dropdown) {
  const trigger = dropdown.querySelector(".demo-dropdown-trigger");
  const menu = dropdown.querySelector(".demo-dropdown-menu");
  if (!trigger || !menu) return;

  const rect = trigger.getBoundingClientRect();
  const gap = 4;
  const maxH = 260; // debe coincidir con max-height en CSS

  menu.style.width = `${rect.width}px`;
  menu.style.left = `${rect.left}px`;

  const spaceBelow = window.innerHeight - rect.bottom;
  if (spaceBelow < maxH + gap && rect.top > spaceBelow) {
    // Abrir hacia arriba
    menu.style.top = "auto";
    menu.style.bottom = `${window.innerHeight - rect.top + gap}px`;
  } else {
    menu.style.bottom = "auto";
    menu.style.top = `${rect.bottom + gap}px`;
  }
}

export function initDemoDropdowns() {
  const dropdowns = $$(".demo-dropdown");
  if (!dropdowns.length) return;

  const syncAll = () => dropdowns.forEach(syncTriggerLabel);

  const openDropdown = (dropdown) => {
    closeAll(dropdown);
    positionMenu(dropdown);
    dropdown.classList.add("open");
  };

  dropdowns.forEach((dropdown) => {
    const trigger = dropdown.querySelector(".demo-dropdown-trigger");
    const menu = dropdown.querySelector(".demo-dropdown-menu");
    if (!trigger || !menu) return;

    // Etiqueta inicial
    syncTriggerLabel(dropdown);

    // Abrir / cerrar
    trigger.addEventListener("click", (e) => {
      e.stopPropagation();
      if (dropdown.classList.contains("open")) {
        dropdown.classList.remove("open");
      } else {
        openDropdown(dropdown);
      }
    });

    // Evita que un clic dentro del menú lo cierre por el listener de "fuera".
    menu.addEventListener("click", (e) => e.stopPropagation());

    // Al seleccionar una opción del menú: sidebar.js ya actualizó el estado
    // (marcó .checked). Refrescamos TODAS las etiquetas (un cambio de Servicio
    // puede reasignar la opción de "Simular respuesta") y cerramos este menú.
    menu.addEventListener("click", (e) => {
      const opt = e.target.closest(".checkbox-option");
      if (!opt) return;
      // Deja que el handler de sidebar procese primero el cambio de selección.
      setTimeout(() => {
        syncAll();
        dropdown.classList.remove("open");
      }, 0);
    });

    // Mantener la etiqueta sincronizada ante cambios programáticos
    // (p.ej. updateSimModeOptions reasigna la opción cuando cambia el servicio).
    menu
      .querySelectorAll('.checkbox-option input[type="checkbox"]')
      .forEach((input) => {
        input.addEventListener("change", syncAll);
      });
  });

  // Cerrar al hacer clic fuera
  document.addEventListener("click", () => closeAll());

  // Cerrar con Escape
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeAll();
  });

  // Al redimensionar cerramos el menú abierto (position: fixed no sigue al trigger).
  window.addEventListener("resize", () => closeAll());

  // Al hacer scroll en un contenedor EXTERNO (el panel, la ventana) cerramos,
  // porque el menú fixed quedaría desanclado del trigger. Pero si el scroll
  // ocurre DENTRO del propio menú abierto, lo dejamos para poder desplazar
  // las opciones.
  window.addEventListener(
    "scroll",
    (e) => {
      const openMenu = document.querySelector(
        ".demo-dropdown.open .demo-dropdown-menu",
      );
      if (openMenu && e.target && openMenu.contains(e.target)) return;
      closeAll();
    },
    true, // captura: incluye el scroll de contenedores internos
  );
}
