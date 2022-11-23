<?php

namespace system;

class model{

    // Подключение файла со стандартными функциями
    protected function specialDataConnect(){
        return require 'config/config_data.php'; // Некоторые стандартные функции
    }

    // Взятие главных тем (исп в 2 моделях)
    protected function selectMainTopics($quantity = -1){
        $mysqli = openmysqli();
        if($quantity == -1)
            $resultArr = $mysqli->query("SELECT * FROM maintopic ORDER BY id DESC;");
        else
            $resultArr = $mysqli->query("SELECT * FROM maintopic ORDER BY id DESC LIMIT ".$quantity.";");
        $mysqli->close();
        return $resultArr;
    }
}