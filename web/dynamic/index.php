<?php

namespace system;

session_start();

require_once 'lib/dev.php'; // Для разработки
require_once 'settings/db.php'; // Для бд
require_once 'lib/security.php'; // Безопасность некоторых данных
require_once 'lib/standartFunct.php'; // Некоторые стандартные функции
require_once($_SERVER['DOCUMENT_ROOT'].'/system/route.php'); // Задание пути к главному крнтроллеру (роутеру)

date_default_timezone_set("Europe/Moscow");

// Автоподключение классов
// Срабатывает перед выводом ошибки
spl_autoload_register(function ($class) {
    $path = str_replace('\\', '/', $class.'.php'); // Замена слешей в пути
    if(file_exists($path)){
        require $path;
    }
});

$app = new route;