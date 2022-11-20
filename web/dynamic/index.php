<?php

namespace system;

session_start();

require_once 'lib/dev.php'; // Для разработки
require_once 'settings/db.php'; // Для бд
require_once 'lib/security.php'; // Безопасность некоторых данных
require_once 'system/standartFunct.php'; // Некоторые стандартные функции
require_once($_SERVER['DOCUMENT_ROOT'].'/system/route.php'); // Задание пути к главному крнтроллеру (роутеру)

date_default_timezone_set("Europe/Moscow");

$app = new route;