<?php

// Подключение к бд

function openmysqli(): mysqli {
    $conn = new mysqli("Mysql_db", "root", "root", "forum"); // Сервер, пользователь, пароль, бд
    if ($conn->connect_error) {
        echo ("Connection failed: " . $conn->connect_error);
        exit;
    } 
    return $conn;
}