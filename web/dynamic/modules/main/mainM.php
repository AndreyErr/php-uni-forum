<?php

use system\model;

class mainM extends model{
    // Взятие тем для главной страницы
    public function selectTopics($quantity = 6){
        $mysqli = openmysqli();
        $resultArr = $mysqli->query("SELECT * FROM maintopic ORDER BY id DESC LIMIT ".$quantity.";");
        $mysqli->close();
        return $resultArr;
    }
}