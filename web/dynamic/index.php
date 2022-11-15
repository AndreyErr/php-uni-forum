<?php

namespace system;

require_once 'lib/dev.php'; // Для разработки
require_once 'settings/db.php'; // Для бд
$mysqli = openmysqli();
require_once($_SERVER['DOCUMENT_ROOT'].'/system/route.php'); // Задание пути к главному крнтроллеру (роутеру)

$app = new route;