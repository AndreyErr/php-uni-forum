<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

function debug($str){
    echo '<pre style="background-color: #00BFFF; padding: 10px;">';
    var_dump($str);
    echo '</pre>';
    exit;
}

function krik($str){
    echo '<pre style="background-color: #FA8072; padding: 10px;">'.$str.'</pre>';
    exit;
}