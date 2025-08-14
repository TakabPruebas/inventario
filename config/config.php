<?php
// Archivo: /config/config.php

//define('DB_HOST', '192.168.56.3');
//define('DB_HOST', 'localhost:3308');
//define('DB_NAME', 'takab_inventario');
//define('DB_USER', 'mau');
//define('DB_PASS', 'mau');           //Cambia esto a la contraseña real

define('DB_HOST', '192.168.1.253');
define('DB_NAME', 'takab_inventario');
define('DB_USER', 'inventario');
define('DB_PASS', 'AdminTakab123');           //Cambia esto a la contraseña real
define('DB_CHARSET', 'utf8mb4'); 

// Opcional: Puerto (para XAMPP/WAMP suele ser 3306)
define('DB_PORT', 3308);

// Opciones extra
define('APP_NAME', 'Sistema de Inventario TAKAB');
define('APP_LANG', 'es_MX');
date_default_timezone_set('America/Mexico_City'); // Cambia según tu país/ciudad


