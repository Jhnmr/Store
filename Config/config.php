<?php
// Configuración básica del sitio
define('BASE_URL', 'http://localhost/Tienda/');
define('TITLE', 'Mi Tienda Online');
define('MONEDA', 'USD');

// Información de contacto de la tienda
define('DIRECCION', '123 Tu Dirección');
define('TELEFONO', '+1234567890');
define('EMAIL', 'contacto@tutienda.com');
define('HORARIO', '09:00 - 18:00');

// Redes sociales
define('FACEBOOK', 'https://facebook.com/tutienda');
define('INSTAGRAM', 'https://instagram.com/tutienda');
define('TWITTER', 'https://twitter.com/tutienda');
define('WHATSAPP', '+1234567890');

// Configuración de la base de datos
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBNAME', 'tienda');
define('CHARSET', 'utf8');

// Configuración de PayPal
define('CLIENT_ID', '');

// Configuración de correo
define('EMPRESA', 'Mi Empresa S.A.');
define('EMAIL_REMITENTE', 'no-reply@shop.com');
define('EMAIL_HOST', 'smtp.gmail.com');
define('EMAIL_USER', 'tu@email.com');
define('EMAIL_PASS', 'tu_password');
define('EMAIL_PORT', 465);
define('DESCRIPCION_EMPRESA', 'Somos una tienda especializada en ofrecer productos de alta calidad.');

// Límites y tamaños
define('MAX_FILE_SIZE', 2097152); // 2MB
define('ITEMS_PER_PAGE', 12);

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'tmp/error.log');

?>