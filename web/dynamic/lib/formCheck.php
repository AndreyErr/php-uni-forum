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

function mainTopicNameCheck($name){
    if(!preg_match('/^[a-zA-Zа-яА-ЯёЁ1-9\s]{2,25}$/u', $name))
        return false;
    return true;
}

function mainTopicIconCheck($icon){
    if(!preg_match('/(<i\sclass="fa-.*\sfa-.*"><\/i>)$/u', $icon) || strlen($icon) < 10 || strlen($icon) > 70)
        return false;
    return true;
}

function mainTopicDescrCheck($descr){
    if(!preg_match('/^[a-zA-Zа-яА-ЯёЁ1-9\s.\-+_=\/&^:;"#!%@&,.]+$/u', $descr) || strlen($descr) < 10 || strlen($descr) > 400)
        return false;
    return true;
}