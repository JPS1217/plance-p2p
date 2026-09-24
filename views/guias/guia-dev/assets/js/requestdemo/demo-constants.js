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
      "Es el identificador público de tu comercio ante Place to Pay. Puedes pensar en él como tu \"usuario\". " +
      "que permite identificar quién está enviando cada solicitud." +
      "Place to Pay te lo entrega como parte de las credenciales de testing o productivas; no debes crearlo tú ni modificarlo.",


    highlight:
      "Place to Pay te lo entrega como parte de las credenciales de testing o productivas",


    steps: [
      "Busca el correo o documento de credenciales entregado por Place to Pay.",
      "Copia el valor del campo \"login\" tal cual, sin espacios ni saltos de línea.",
      "Utiliza el mismo Login en todas las peticiones realizadas desde tu integración",
    ],
    result: [
      "Es un texto fijo: siempre el mismo para tu sitio.",
      "Se envía dentro del objeto \"auth\".",
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
    title: "Seed",
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
    title: "Nonce",
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
    title: "TranKey",
    text:
      "Se calcula de nuevo en CADA petición combinando tres datos — el nonce, el seed y tu secretKey — y aplicando dos transformaciones (SHA-256 y luego Base64). " +
      "Estos son los pasos para que lo implementes en tu desarrollo:",
    steps: [
      "Pega los tres datos en este orden, sin espacios: primero el nonce ORIGINAL (el de antes de codificarlo en Base64), luego el seed, luego tu secretKey. Es decir el texto: nonce + seed + secretKey.",
      "Calcula el hash SHA-256 de ese texto. Importante: usa la salida BINARIA cruda del SHA-256 (los bytes), NO el típico texto hexadecimal.",
      "Codifica esos bytes en Base64.",
      "El texto resultante es el tranKey. Ponlo en el campo \"tranKey\" junto al login, el nonce (Base64) y el seed.",
    ],
    result: [
      "En la fórmula nonce + seed + secretKey, el símbolo '+' representa la operación de concatenación de tu lenguaje de programación; NO debes agregar los caracteres '+' al texto generado.",
      "Después de calcular el SHA-256, utiliza los bytes binarios originales del hash para generar el Base64.",
      {
        text: "No confundas la fórmula que se aplica con el valor que se envía en el campo nonce:",
        sublist: [
          {
            label: "Incorrecto:",
            value: "SHA-256(Base64(nonce) + seed + secretKey)",
          },
          {
            label: "Correcto:",
            value: "SHA-256(nonce + seed + secretKey)",
          },
        ],
      },
      "Ejemplo — fórmula: tranKey = Base64(SHA-256(\"927342197\" + \"2023-06-21T09:56:06-05:00\" + \"3YC5brb5eAR4xBGQ\")).",
    ],
  },

  // ── Datos del pago ──
  pay_reference: {
    title: "Referencia",
    text:
      "Es tu identificador propio para esta transacción: el número o código con el que TÚ reconoces el pedido en tu sistema (por ejemplo el número de factura, de orden o de reserva). " +
      "Place to Pay te lo devuelve en la respuesta y en las notificaciones, así que te sirve para cruzar cada pago con el pedido correcto en tu base de datos.",
    highlight: "el número o código con el que TÚ reconoces el pedido en tu sistema",
    steps: [
      "Usa un valor único por transacción (no repitas la misma referencia para dos cobros distintos).",
      "Genera el valor desde tu sistema: normalmente es el id del pedido o de la factura.",
      "Guárdalo: lo recibirás de vuelta en la respuesta para conciliar el pago.",
    ],
    result: [
      "Debe ser única por cada intento de pago.",
      "Viaja dentro del objeto \"payment\".",
    ],
  },

  pay_description: {
    title: "Descripción",
    text:
      "Es un texto corto y legible que describe qué se está pagando (por ejemplo \"Plan Premium - Junio\" o \"Recarga 360 esmeraldas\"). " +
      "Se le muestra al cliente durante el pago y te ayuda a identificar la operación de un vistazo. No afecta el cobro; es puramente informativo.",
    highlight: "Se le muestra al cliente durante el pago",
    steps: [
      "Escribe algo breve y claro que el comprador reconozca.",
      "Evita datos sensibles: es un texto visible.",
    ],
    result: [
      "Texto libre y opcional.",
      "Viaja dentro del objeto \"payment\".",
    ],
  },

  pay_currency: {
    title: "Moneda",
    text:
      "Es la moneda en la que se cobra, en código ISO de 3 letras (COP, USD, CRC…). " +
      "Debe corresponder a una moneda habilitada para tu comercio; el monto que envíes se interpreta en esta moneda.",
    highlight: "en código ISO de 3 letras",
    steps: [
      "Elige la moneda habilitada para tu sitio (aquí: COP, USD o CRC).",
      "Asegúrate de que el monto esté expresado en esa misma moneda.",
    ],
    result: [
      "Viaja en payment.amount.currency.",
      "Debe estar habilitada para tu comercio.",
    ],
  },

  pay_amount: {
    title: "Monto",
    text:
      "Es el valor total a cobrar, expresado en la moneda seleccionada. " +
      "En monedas sin decimales (como COP) se envía el número entero (50000 = $50.000 COP). El mock usa el monto para decidir el resultado en el modo \"Automático (según tarjeta)\".",
    highlight: "expresado en la moneda seleccionada",
    steps: [
      "Escribe el total exacto a cobrar en la moneda elegida.",
      "No incluyas separadores de miles ni el símbolo de moneda; solo el número.",
    ],
    result: [
      "Viaja en payment.amount.total.",
      "Debe ser mayor que cero (un monto inválido devuelve el error 13).",
    ],
  },
};
