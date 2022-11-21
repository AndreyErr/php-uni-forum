<?php

namespace system;

abstract class model{
    public function specialDataConnect(){
        return require 'config/config_data.php'; // Некоторые стандартные функции
    }
}