/**
 * Info de los campos de "Autenticación" para el panel "Explora la autenticación"
 * (y los popups) del requestdemo.
 * Fuente: https://docs.placetopay.dev/en/checkout/authentication/
 *
 * Estas claves se fusionan con OPTION_INFO del explorer para que el
 * mecanismo de popup existente (data-info-key + #optionInfoPopup) las use
 * sin cambios.
 *
 * Estructura de cada entrada:
 *   title  -> encabezado del campo
 *   text   -> explicación en lenguaje sencillo (1er párrafo)
 *   steps? -> lista de pasos (opcional) para construir el valor, pensada
 *             para usuarios con poco conocimiento técnico
 *   result?-> qué obtienes al final / cómo se ve el resultado (opcional)
 *
 * El texto está escrito para personas que quizá no son técnicas y que están
 * armando su primera petición a Place to Pay: se evita la jerga y se explica
 * el "por qué" además del "cómo".
 */
export const AUTH_FIELD_INFO = {
  auth_login: {
    title: "Login",
    text:
      "Es el identificador público de tu comercio ante Place to Pay: piensa en él como tu \"usuario\". " +
      "No es secreto — viaja como texto plano dentro del objeto \"auth\" en cada petición, así que Place to Pay sabe quién está enviando la solicitud. " +
      "Place to Pay te lo entrega cuando terminas el proceso de certificación de tu integración; no lo inventas tú.",
    steps: [
      "Ubica el correo o documento de credenciales que te entregó Place to Pay al certificar tu sitio.",
      "Copia el valor del campo \"login\" tal cual, sin espacios ni saltos de línea.",
      "Pégalo en el campo Login. El mismo login se usa en todas tus peticiones.",
    ],
    result: [
      "Es un texto fijo: siempre el mismo para tu sitio.",
      "Se envía sin cifrar dentro del objeto \"auth\".",
    ],
  },

  auth_secret: {
    title: "Secret Key",
    text:
      "Es la contraseña privada de tu comercio. A diferencia del login, esta NUNCA se envía en la petición ni se muestra: solo se usa, en tu servidor, para calcular el tranKey de cada solicitud. " +
      "Trátala como una contraseña: no la publiques en código del navegador, ni en repositorios públicos, ni se la compartas a nadie. Place to Pay también te la entrega al certificar tu sitio.",
    steps: [
      "Toma la \"secretKey\" del mismo correo de credenciales que te dio Place to Pay.",
      "Guárdala solo en tu servidor (por ejemplo en una variable de entorno), nunca en el código que corre en el navegador.",
      "Úsala únicamente como ingrediente para calcular el tranKey (ver el campo TranKey); no la incluyas en el JSON que envías.",
    ],
    result: [
      "Es un valor secreto que se queda solo en tu servidor.",
      "Jamás aparece en la petición que se envía a Place to Pay.",
    ],
  },

  auth_seed: {
    title: "Seed (AUTO)",
    text:
      "Es la fecha y hora exactas en que armaste la petición, escritas en formato ISO 8601 (por ejemplo 2023-06-21T09:56:06-05:00). " +
      "Sirve para que Place to Pay sepa que la solicitud es reciente. En esta guía se genera sola en cada envío, así que no tienes que escribirla a mano.",
    steps: [
      "Toma la fecha y hora actuales de tu servidor.",
      "Inclúyela con la zona horaria (la parte -05:00 del ejemplo) en formato ISO 8601.",
      "Envíala en el campo \"seed\". Debe coincidir con la hora real: si tu reloj está desfasado más de 5 minutos, Place to Pay rechaza la petición con el error 103.",
    ],
    result: [
      "Una marca de tiempo como \"2023-06-21T09:56:06-05:00\".",
      "Aquí se rellena automáticamente en cada envío.",
    ],
  },

  auth_nonce: {
    title: "Nonce (AUTO)",
    text:
      "Es un número al azar que hace que cada petición sea única e irrepetible (\"nonce\" = número usado una sola vez). " +
      "Evita que alguien reenvíe una copia de tu petición. En esta guía se genera solo en cada envío.",
    steps: [
      "Genera un valor aleatorio nuevo para cada petición (por ejemplo un número o unos bytes al azar).",
      "Conviértelo a texto Base64 antes de enviarlo. Guarda también el valor ORIGINAL (sin codificar): lo necesitarás para calcular el tranKey.",
      "Envía la versión en Base64 en el campo \"nonce\".",
    ],
    result: [
      "El nonce ORIGINAL se usa para calcular el tranKey.",
      "En el JSON viaja su versión en Base64, p. ej. \"OTI3MzQyMTk3\".",
    ],
  },

  auth_trankey: {
    title: "TranKey (AUTO)",
    text:
      "Es la \"firma\" de la petición: demuestra que conoces la secretKey SIN enviarla. Se calcula de nuevo en CADA petición combinando tres ingredientes — el nonce, el seed y tu secretKey — y aplicando dos transformaciones (SHA-256 y luego Base64). " +
      "Aquí se calcula automáticamente, pero estos son los pasos exactos por si lo implementas en tu servidor:",
    steps: [
      "Pega los tres ingredientes en este orden, sin espacios: primero el nonce ORIGINAL (el de antes de codificarlo en Base64), luego el seed, luego tu secretKey. Es decir el texto: nonce + seed + secretKey.",
      "Calcula el hash SHA-256 de ese texto. Importante: usa la salida BINARIA cruda del SHA-256 (los bytes), NO el típico texto hexadecimal.",
      "Codifica esos bytes en Base64.",
      "El texto resultante es el tranKey. Ponlo en el campo \"tranKey\" junto al login, el nonce (Base64) y el seed.",
    ],
    result: [
      "Obtienes un texto en Base64, distinto en cada petición, p. ej. \"cm96cHI0dWE2cDhtcTBjaXVkYWQ=\".",
      "Ejemplo — ingredientes: nonce = \"927342197\", seed = \"2023-06-21T09:56:06-05:00\", secretKey = \"3YC5brb5eAR4xBGQ\".",
      "Ejemplo — fórmula: tranKey = Base64(SHA-256(\"927342197\" + \"2023-06-21T09:56:06-05:00\" + \"3YC5brb5eAR4xBGQ\")).",
    ],
  },
};
