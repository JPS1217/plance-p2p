<?php
session_start();

if (!isset($_SESSION["usuario"]) && empty($_SESSION["invitado"])) {
  echo '<script>
            alert("Por favor, inicie sesión para acceder a esta página.");
            window.location.href = "../../../index.php";
            </script>';
  session_destroy();
  die();
}
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ejemplo de construcción de un request — Pago Básico | Plance</title>

  <!-- Vendor -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link
    href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Barlow:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap"
    rel="stylesheet" />

  <!-- Base CSS (reutilizadas del explorer) -->
  <link rel="stylesheet" href="assets/css/base/variables.css" />
  <link rel="stylesheet" href="assets/css/base/reset.css" />
  <link rel="stylesheet" href="assets/css/base/layout.css" />

  <!-- Component CSS (reutilizadas) -->
  <link rel="stylesheet" href="assets/css/components/topbar/topbar.css" />
  <link rel="stylesheet" href="assets/css/components/sidebar/sidebar.css" />
  <link rel="stylesheet" href="assets/css/components/request/request.css" />
  <link rel="stylesheet" href="assets/css/components/response/response.css" />
  <link rel="stylesheet" href="assets/css/components/popup/popup.css" />

  <!-- CSS específica del demo -->
  <link rel="stylesheet" href="assets/css/requestdemo/requestdemo.css" />
</head>

<body>
  <div id="appShell">
    <!-- <header class="topbar">
        <a class="btn-sm" href="../../../home.php">
          <i class="bi bi-arrow-left"></i> Volver al inicio
        </a>
        <div class="d-flex align-items-center gap-3">
          <div
            class="sidebar-toggle"
            id="sidebarToggle"
          </div>
          <button
            class="sidebar-toggle"
            data-theme-toggle
            type="button"
            title="Cambiar modo claro / oscuro"
          >
            <i class="bi bi-sun-fill" data-theme-icon></i>
          </button>
          <div class="brand-dot"></div>
          <div>
            <div class="brand-name">Ejemplo de request</div>
            <div class="brand-sub">· Pago Básico — Web Checkout</div>
          </div>
        </div>
        <div class="env-badge">
          <i class="bi bi-circle-fill" style="font-size: 0.45rem"></i> Sandbox /
          Test
        </div>
      </header> -->

    <!-- Título de la vista -->
    <div class="demo-title-bar">
      <h1>Construye tu petición</h1>
      <p>
        Puedes examinar los elementos que conforman un request de ejemplo para crear una sesión. Ajusta los valores y
        envía la petición para ver la respuesta del mock.
      </p>
    </div>

    <div class="demo-layout" id="labLayout">
      <!-- Fila 1: Panel de operación (Servicio / Tipo de pago / Simular respuesta) -->
      <div class="demo-layout-op">
        <!-- ===================== OPERACION ===================== -->
        <section class="panel-left demo-section-panel">
          <div class="url-bar">
            <span class="method-pill">POST</span>
            <span class="url-text" id="urlDisplay">https://checkout-test.placetopay.com/api/session</span>
          </div>

          <!-- Operación (campos como desplegables de opción única) -->
          <div class="field-group">
            <label class="field-label">Servicio</label>
            <div class="demo-dropdown">
              <button type="button" class="demo-dropdown-trigger" aria-haspopup="listbox">
                <span class="dd-label">Web Checkout — Crear sesión</span>
                <i class="bi bi-chevron-down dd-chev"></i>
              </button>
              <div class="option-grid demo-dropdown-menu" id="serviceOptions" role="listbox">
                <div class="checkbox-option checked">
                  <input type="checkbox" name="serviceOption" value="wc_session" checked />
                  <span>Web Checkout — Crear sesión</span>
                  <button type="button" class="info-action" data-info-key="wc_session" aria-label="Información">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="serviceOption" value="gw_process" />
                  <span>API Gateway — Procesar pago</span>
                  <button type="button" class="info-action" data-info-key="gw_process" aria-label="Información">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="serviceOption" value="link" />
                  <span>Link de Pagos — Generar link</span>
                  <button type="button" class="info-action" data-info-key="link" aria-label="Información">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="field-group tipo-pago-group show" id="tipoPagoGroup">
            <label class="field-label">Tipo de pago</label>
            <div class="demo-dropdown">
              <button type="button" class="demo-dropdown-trigger" aria-haspopup="listbox">
                <span class="dd-label">Pago básico</span>
                <i class="bi bi-chevron-down dd-chev"></i>
              </button>
              <div class="option-grid demo-dropdown-menu" id="paymentTypeOptions" role="listbox">
                <div class="checkbox-option checked">
                  <input type="checkbox" name="paymentType" value="basico" checked /><span>Pago básico</span><button
                    type="button" class="info-action" data-info-key="basico">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="paymentType" value="partial" /><span>Pagos Parciales</span><button
                    type="button" class="info-action" data-info-key="partial">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="paymentType" value="recurrencia" /><span>Pago Recurrente</span><button
                    type="button" class="info-action" data-info-key="recurrencia">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="paymentType" value="dispersion" /><span>Pago con Dispersión</span><button
                    type="button" class="info-action" data-info-key="dispersion">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="paymentType" value="preauth" /><span>Pago con
                    Preautorización</span><button type="button" class="info-action" data-info-key="preauth">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="paymentType" value="token" /><span>Suscripción + Token
                    (tokenización)</span><button type="button" class="info-action" data-info-key="token">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="paymentType" value="suscripcion" /><span>Pago +
                    Suscripción</span><button type="button" class="info-action" data-info-key="suscripcion">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="field-group">
            <label class="field-label">Simular respuesta</label>
            <div class="demo-dropdown">
              <button type="button" class="demo-dropdown-trigger" aria-haspopup="listbox">
                <span class="dd-label">Automático (según tarjeta)</span>
                <i class="bi bi-chevron-down dd-chev"></i>
              </button>
              <div class="option-grid demo-dropdown-menu" id="simModeOptions" role="listbox">
                <div class="checkbox-option checked">
                  <input type="checkbox" name="simMode" value="auto" checked /><span>Automático (según
                    tarjeta)</span><button type="button" class="info-action" data-info-key="auto">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="ok" /><span>Aprobada (00)</span><button type="button"
                    class="info-action" data-info-key="ok">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="pending" /><span>Pendiente (?-)</span><button
                    type="button" class="info-action" data-info-key="pending">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="e100" /><span>100 · UsernameToken no
                    proporcionado.</span><button type="button" class="info-action" data-info-key="e100">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="e101" /><span>101 · Identificador de sitio no
                    existe.</span><button type="button" class="info-action" data-info-key="e101">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="e102" /><span>102 · El hash de TranKey no
                    coincide.</span><button type="button" class="info-action" data-info-key="e102">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="e103" /><span>103 · Fecha de la semilla mayor de 5
                    minutos.</span><button type="button" class="info-action" data-info-key="e103">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="e104" /><span>104 · Sitio inactivo.</span><button
                    type="button" class="info-action" data-info-key="e104">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="e105" /><span>105 · Sitio expirado.</span><button
                    type="button" class="info-action" data-info-key="e105">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="e106" /><span>106 · Credenciales
                    expiradas.</span><button type="button" class="info-action" data-info-key="e106">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="e107" /><span>107 · UsernameToken mal
                    definido.</span><button type="button" class="info-action" data-info-key="e107">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="e200" /><span>200 · Saltar encabezado
                    SOAP.</span><button type="button" class="info-action" data-info-key="e200">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="e10001" /><span>10001 · Contacte a
                    Soporte.</span><button type="button" class="info-action" data-info-key="e10001">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="e96" /><span>96 · Malfuncionamiento del
                    sistema.</span><button type="button" class="info-action" data-info-key="e96">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="e68" /><span>68 · Respuesta tardía.</span><button
                    type="button" class="info-action" data-info-key="e68">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="R1" /><span>R1 · Autorización revocada.</span><button
                    type="button" class="info-action" data-info-key="R1">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="R3" /><span>R3 · Todas las autorizaciones
                    revocadas.</span><button type="button" class="info-action" data-info-key="R3">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="e13" /><span>13 · Monto inválido.</span><button
                    type="button" class="info-action" data-info-key="e13">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="e61" /><span>61 · Monto máximo
                    excedido.</span><button type="button" class="info-action" data-info-key="e61">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="XR" /><span>XR · Respuesta inválida.</span><button
                    type="button" class="info-action" data-info-key="XR">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="XE" /><span>XE · Tipo de tarjeta
                    inválido.</span><button type="button" class="info-action" data-info-key="XE">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="XX" /><span>XX · Configuraciones
                    inválidas.</span><button type="button" class="info-action" data-info-key="XX">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="eBR" /><span>BR · Solicitud incorrecta.</span><button
                    type="button" class="info-action" data-info-key="eBR">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="eX3" /><span>X3 · Error de validación.</span><button
                    type="button" class="info-action" data-info-key="eX3">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="eXA" /><span>XA · Rechazo financiero.</span><button
                    type="button" class="info-action" data-info-key="eXA">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="eNF" /><span>NF · No encontrado.</span><button
                    type="button" class="info-action" data-info-key="eNF">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="e05" /><span>05 · Error externo.</span><button
                    type="button" class="info-action" data-info-key="e05">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
                <div class="checkbox-option">
                  <input type="checkbox" name="simMode" value="eXH" /><span>XH · Error interno.</span><button
                    type="button" class="info-action" data-info-key="eXH">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="field-hint">
              Fuerza el código de respuesta que devolverá el mock.
            </div>

            <button class="btn-send" id="btnSend">
              <i class="bi bi-send-fill"></i> Enviar request
            </button>
          </div>

        </section>
      </div>
      <!-- Fila 2: Autenticación + Explora la autenticación -->
      <div class="demo-layout-auth">

        <!-- ===================== AUTENTICACION ===================== -->
        <section class="panel-left demo-section-panel">
          <div class="section" id="secAuth">
            <div class="section-head" data-section-toggle="secAuth">
              <span class="panel-title">Autenticación</span><i class="bi bi-chevron-down chev"></i>
            </div>
            <div class="section-body">
              <div class="field-group">
                <label class="field-label">
                  Login <span class="req">*</span>
                  <button type="button" class="info-action" data-info-key="auth_login"
                    aria-label="¿Cómo se genera el login?">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </label>
                <input type="text" class="field-input" id="fLogin" value="2d9eaf1e662518756a3d78806543af5b" />
              </div>
              <div class="field-group">
                <label class="field-label">
                  Secret Key <span class="req">*</span>
                  <button type="button" class="info-action" data-info-key="auth_secret"
                    aria-label="¿Cómo se genera el secret key?">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </label>
                <input type="password" class="field-input" id="fSecret" value="3YC5brb5eAR4xBGQ" />
              </div>
              <div class="field-group">
                <label class="field-label">
                  Seed <span class="auto-tag">AUTO</span>
                  <button type="button" class="info-action" data-info-key="auth_seed"
                    aria-label="¿Cómo se genera el seed?">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </label>
                <input type="text" class="field-input auto" id="fSeed" readonly />
              </div>
              <div class="field-group">
                <label class="field-label">
                  Nonce <span class="auto-tag">AUTO</span>
                  <button type="button" class="info-action" data-info-key="auth_nonce"
                    aria-label="¿Cómo se genera el nonce?">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </label>
                <input type="text" class="field-input auto" id="fNonce" readonly />
              </div>
              <div class="field-group">
                <label class="field-label">
                  TranKey <span class="auto-tag">AUTO</span>
                  <button type="button" class="info-action" data-info-key="auth_trankey"
                    aria-label="¿Cómo se genera el tranKey?">
                    <i class="bi bi-info-circle"></i>
                  </button>
                </label>
                <input type="text" class="field-input auto" id="fTranKey" readonly />
                
              </div>
            </div>
          </div>

          <!-- ===================== DATOS DEL PAGO (mismo nivel que Autenticación) ===================== -->
          <div class="section" id="secPago">
            <div class="section-head" data-section-toggle="secPago">
              <span class="panel-title">Datos del pago</span><i class="bi bi-chevron-down chev"></i>
            </div>
            <div class="section-body">
              <div class="field-group">
                <label class="field-label">Referencia <span class="req">*</span></label><input type="text"
                  class="field-input" id="fRef" value="LAB-001" />
              </div>
              <div class="field-group">
                <label class="field-label">Descripción</label><input type="text" class="field-input" id="fDesc"
                  value="Prueba de pago" />
              </div>
              <div class="field-group">
                <label class="field-label">Moneda</label><select class="field-select" id="fCurrency">
                  <option value="COP">COP — Peso colombiano</option>
                  <option value="USD">USD — Dólar (Panamá / Belize)</option>
                  <option value="CRC">CRC — Colón costarricense</option>
                </select>
              </div>
              <div class="field-group">
                <label class="field-label">Monto <span class="req">*</span></label><input type="number"
                  class="field-input" id="fAmount" value="50000" />
              </div>
            </div>
          </div>

        </section>

        <aside class="auth-help" id="authHelp" aria-live="polite">
          <span class="auth-help-kicker">Campo seleccionado</span>
          <h2 id="authHelpTitle">Explora la autenticación</h2>
          <p id="authHelpText">
            Selecciona una etiqueta de autenticación para ver cómo se forma el
            campo y un ejemplo de su valor.
          </p>
          <ol id="authHelpSteps" class="auth-help-steps"></ol>
          <div id="authHelpResult" class="auth-help-result"></div>
          <pre id="authHelpExample" class="auth-help-example"></pre>
        </aside>
      </div>

      <!-- Fila 3: Request Body + Response -->
      <div class="demo-layout-io">
        <!-- Request Body — solo Raw JSON -->
          <section class="panel-center">
            <div class="pcenter-header">
              <span class="panel-title" style="margin: 0">Request Body</span>
              <div class="header-btns">
                <button class="btn-sm" id="btnResetBody">
                  <i class="bi bi-arrow-repeat"></i> Regenerar
                </button>
                <button class="btn-sm" id="btnBeautify">
                  <i class="bi bi-magic"></i> Beautify
                </button>
                <button class="btn-sm" id="btnCopyJson">
                  <i class="bi bi-clipboard"></i> Copiar
                </button>
              </div>
            </div>
            <div class="json-editor-wrap">
              <div class="json-tabs">
                <div class="json-tab active" data-tab="raw">Raw JSON</div>
              </div>
              <div class="json-error-banner" id="jsonErrorBanner" style="display: none">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span id="jsonErrorText"></span>
              </div>
              <!-- Estos nodos existen porque request.js los referencia,
                   pero permanecen ocultos por la CSS del demo. -->
              <div class="json-view" id="jsonPreview"></div>
              <pre class="json-raw" id="jsonRaw" style="display: block"></pre>
              <div class="editor-container" id="editorContainer">
                <textarea id="jsonEditor"></textarea>
              </div>
              <div class="edit-banner" id="editBanner"></div>
            </div>
          </section>

          <section class="panel-right">
            <div class="pright-header">
              <span class="panel-title" style="margin: 0">Response</span>
              <div class="status-row">
                <div class="sdot idle" id="sdot"></div>
                <span id="stext" style="color: var(--muted)">En espera</span>
              </div>
            </div>
            <div class="resp-empty" id="respEmpty">
              <div class="resp-empty-icon">
                <i class="bi bi-arrow-left-right"></i>
              </div>
              <div style="font-size: 0.85rem">
                Envía un request para ver la respuesta
              </div>
            </div>
            <div class="json-tabs" id="respTabs" style="display: none">
              <div class="json-tab active" data-resp-tab="preview">Preview</div>
              <div class="json-tab" data-resp-tab="raw">Raw JSON</div>
            </div>
            <div class="resp-body" id="respBody"></div>
            <pre class="resp-raw" id="respRaw"></pre>
            <div class="resp-meta" id="respMeta">
              <span class="rcode" id="rcode"></span><span id="rtime"></span><span id="rgw"></span>
            </div>
            <button class="btn-clear" id="btnClearResp">
              <i class="bi bi-arrow-counterclockwise"></i> Limpiar respuesta
            </button>
          </section>
      </div>
    </div>

    <!-- Popup informativo (reutilizado por popup.js) -->
    <div class="info-popup" id="optionInfoPopup" style="display: none">
      <div class="info-popup-head">
        <div>
          <h3 id="optionInfoTitle"></h3>
        </div>
        <button type="button" class="info-popup-close" id="optionInfoCloseBtn" aria-label="Cerrar">
          <i class="bi bi-x"></i>
        </button>
      </div>
      <p id="optionInfoText"></p>
    </div>
  </div>

  <!-- Vendor JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- App del demo -->
  <script type="module" src="assets/js/requestdemo/requestdemo-app.js"></script>
</body>

</html>