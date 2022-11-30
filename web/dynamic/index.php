<?php

// Точка входа

namespace system;

session_start();

require_once 'lib/dev.php'; // Для разработки
require_once 'settings/db.php'; // Для бд
require_once 'lib/security.php'; // Безопасность некоторых данных

date_default_timezone_set("Europe/Moscow");

// Автоподключение классов
spl_autoload_register(function ($class) {
    $path = str_replace('\\', '/', $class.'.php'); // Замена слешей в пути
    if(file_exists($path)){
        require_once $path;
    }
});

// Вызов роутера
$app = new router;