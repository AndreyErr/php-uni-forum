<?php

namespace system;

class model{

    // Подключение файла с настройками
    protected function specialDataConnect(){
        return require 'settings/config_data.php'; // Некоторые стандартные переменные в массиве (см. config_data.php)
    }

    // Взятие главных тем (исп в 2 моделях)
    protected function selectUnits($quantity = -1){ // Число нужных записей
        $mysqli = openmysqli();
        if($quantity == -1)
            $resultArr = $mysqli->query("SELECT * FROM unit ORDER BY unitId DESC;");
        else
            $resultArr = $mysqli->query("SELECT * FROM unit ORDER BY unitId DESC LIMIT ".$quantity.";");
        $mysqli->close();
        return $resultArr;
    }

    // Кастомная переадресация
    public function relocate($page, $status = -1, $message = ''){ // Путь, тип сообщения (не обяз), сообщение (не обяз)
        if($status != -1)
            $_SESSION['message'] = [$status, $message]; // Сессия с Собщением
        header('Location: '.$page);
    }
}