<?php

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