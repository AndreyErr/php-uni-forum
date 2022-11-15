<?php

// Подключение к бд
function openmysqli(): mysqli {
    $conn = new mysqli("Mysql_db", "root", "root", "forum");
    if ($conn->connect_error) {
        debug("Connection failed: " . $conn->connect_error); ///////////////////////////////////////////////
    } 
    return $conn;
}