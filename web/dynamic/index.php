<?php

namespace system;

require_once 'lib/dev.php'; // Для разработки

require_once($_SERVER['DOCUMENT_ROOT'].'/system/route.php'); // Задание пути к 

$app = new route;