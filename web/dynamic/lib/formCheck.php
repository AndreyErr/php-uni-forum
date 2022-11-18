<?php


function nameCheck($name){
    if(!preg_match('/^[a-zA-Zа-яА-ЯёЁ]{2,25}$/u', $name))
        return false;
    return true;
}

function loginCheck($login){
    if(!preg_match('/^(?=.*[a-zA-Z])[a-zA-Z0-9]{4,20}$/u', $login))
        return false;
    return true;
}

function passCheck($pass){
    if(!preg_match('/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{5,16}$/', $pass))
        return false;
    return true;
}

function emailCheck($email){
    if(!preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email))
        return false;
    return true;
}