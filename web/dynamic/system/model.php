<?php

namespace system;

class model{

    // Подключение файла со стандартными функциями
    protected function specialDataConnect(){
        return require 'settings/config_data.php'; // Некоторые стандартные функции
    }

    // Взятие главных тем (исп в 2 моделях)
    protected function selectUnits($quantity = -1){
        $mysqli = openmysqli();
        if($quantity == -1)
            $resultArr = $mysqli->query("SELECT * FROM unit ORDER BY unitId DESC;");
        else
            $resultArr = $mysqli->query("SELECT * FROM unit ORDER BY unitId DESC LIMIT ".$quantity.";");
        $mysqli->close();
        return $resultArr;
    }

    public function relocate($page, $status = -1, $message = ''){
        if($status != -1)
            $_SESSION['message'] = [$status, $message];
        header('Location: '.$page);
    }
}