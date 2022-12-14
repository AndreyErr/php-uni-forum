<?php

// Библиотека с функциями проверки форм


// Для пользователей

// Имя
function nameCheck($name){
    if(!preg_match('/^[a-zA-Zа-яА-ЯёЁ]{2,25}$/u', $name))
        return false;
    return true;
}

// Логин
function loginCheck($login){
    if(!preg_match('/^(?=.*[a-zA-Z])[a-zA-Z0-9]{4,20}$/u', $login))
        return false;
    return true;
}

// Пароль
function passCheck($pass){
    if(!preg_match('/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{5,16}$/', $pass))
        return false;
    return true;
}

// Email
function emailCheck($email){
    if(!preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email))
        return false;
    return true;
}


// Для главной темы

// Название
function unitNameCheck($name){
    if(!preg_match('/^[a-zA-Zа-яА-ЯёЁ1-9\s]{2,25}$/u', $name))
        return false;
    return true;
}

// Иконка
function unitIconCheck($icon){
    if(!preg_match('/(<i\sclass="fa-.*\sfa-.*"><\/i>)$/u', $icon) || strlen($icon) < 10 || strlen($icon) > 70)
        return false;
    return true;
}

// Описание
function unitDescrCheck($descr){
    if(!preg_match('/^[a-zA-Zа-яА-ЯёЁ1-9\s.\-\+\_\=\/\&\^\:\;\"\#\!\%\@\&\,\.\(\)]+$/u', $descr) || strlen($descr) < 10 || strlen($descr) > 400)
        return false;
    return true;
}


// Для подтем

// Название
function topicNameCheck($name){
    if(!preg_match('/^[a-zA-Zа-яА-ЯёЁ1-9\s\!\?\-]{3,70}$/u', $name))
        return false;
    return true;
}

// Сообщение
function topicTextCheck($text){
    if(strlen($text) < 1 || strlen($text) > 1000)
        return false;
    return true;
}