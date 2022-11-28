<?php

// Общесайтовые функции безопасности

// Хеширование пароля
function hashPass($pass){
    return password_hash($pass, PASSWORD_DEFAULT);
}

// Кодирование строки
function encode($str){
    return base64_encode($str);
}

// Декодирование строки
function decode($str){
    return base64_decode($str);
}

// Проверка на доступ к модулю
function chAccess($actions){
    $access = (require 'settings/access.php')['actions']; // Массив доступа к модулям
    if(array_key_exists($actions, $access))
        if(!array_key_exists('status', $_COOKIE) || array_search(decode($_COOKIE['status']), $access[$actions]) === false)
            return false;
    return true;
}