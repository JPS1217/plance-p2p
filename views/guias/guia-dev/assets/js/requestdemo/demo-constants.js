/**
 * Info de los campos de "Autenticación" para los popups del requestdemo.
 * Fuente: https://docs.placetopay.dev/en/checkout/authentication/
 *
 * Estas claves se fusionan con OPTION_INFO del explorer para que el
 * mecanismo de popup existente (data-info-key + #optionInfoPopup) las use
 * sin cambios.
 */
export const AUTH_FIELD_INFO = {
  auth_login: {
    title: "Login",
    text:
      "Identificador del sitio (login). Es una credencial pública: viaja como texto plano dentro del objeto auth en cada petición. " +
      "Es entregada al comercio al iniciar y completar el proceso de certificación de la integración con Place to Pay.",
  },
  auth_secret: {
    title: "Secret Key",
    text:
      "Llave secreta del sitio (secretKey). Es una credencial privada: nunca debe compartirse ni exponerse en código cliente, repositorios públicos, etc. " +
      "A partir de ella se genera el tranKey de cada petición. Es entregada al comercio al iniciar y completar el proceso de certificación de la integración con Place to Pay.",
  },
  auth_seed: {
    title: "Seed (AUTO)",
    text:
      "Fecha en la que se genera la autenticación, en formato ISO 8601 (ej. 2023-06-21T09:56:06-05:00). " +
      "Se genera automáticamente en cada request. El servidor solo tolera hasta 5 minutos de diferencia con la hora real (error 103).",
  },
  auth_nonce: {
    title: "Nonce (AUTO)",
    text:
      "Valor arbitrario que identifica cada petición como única. Se genera aleatoriamente y se envía codificado en Base64 (ej. base64('927342197')). " +
      "Se genera automáticamente en cada request.",
  },
  auth_trankey: {
    title: "TranKey (AUTO)",
    text:
      "Credencial generada de forma programática en CADA request con la fórmula Base64(SHA-256(nonce + seed + secretKey)). " +
      "El SHA-256 debe tomarse en su salida binaria cruda antes de aplicar Base64. Se calcula automáticamente a partir del nonce, el seed y tu secretKey.",
  },
};
