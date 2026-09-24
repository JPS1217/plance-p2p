<section id="welcomeScreen" class="welcome-guide-screen">
  <aside class="guide-sidebar">
    <div class="guide-brand">
      <span class="guide-dot"></span>
      <div>
        <h2>API Explorer</h2>
        <small>Guía de usuario</small>
      </div>
      <button
        class="sidebar-toggle"
        data-theme-toggle
        type="button"
        style="margin-left:auto;"
        title="Cambiar a modo claro"
      >
        <i class="bi bi-sun-fill" data-theme-icon></i>
      </button>
    </div>

    <nav class="guide-nav">
      <button class="guide-link active" data-target="g-home">Bienvenido</button>
      <button class="guide-link" data-target="g-session">Crear sesión</button>
      <button class="guide-link" data-target="g-process">Procesar pagos</button>
      <button class="guide-link" data-target="g-links">Generar links</button>
      <button class="guide-link" data-target="g-errors">Simular errores</button>
    </nav>

    <div class="sidebar-actions">
      <button id="goExplorerBtn" class="welcome-btn full">
        <i class="bi bi-rocket-takeoff"></i>
        Ir al Explorer
      </button>
      <a href="../../../guia-developer.php" class="welcome-btn secondary full">
        <i class="bi bi-file-earmark-code"></i>
        Ver Guía Developer
      </a>
      <a href="../../../index.php" class="welcome-btn secondary full">
        <i class="bi bi-house-door"></i>
        Volver al inicio
      </a>
    </div>
  </aside>

  <main class="guide-content" id="guideContent">
    <!-- template-loader inyecta aquí:
         g-home.php, g-session.php, g-process.php, g-links.php, g-errors.php -->
  </main>
</section>
