<?php

function hashPass($pass){
    return password_hash($pass, PASSWORD_DEFAULT);
}

///кодир и декодир
function codeStr($str){
    return base64_encode($str);
}

function decodeStr($str){
    return base64_decode($str);
}