<?php

use system\model;

class mainM extends model{
    // Взятие главных тем для главной страницы
    public function selectMainTopics($quantity = 6){
        return parent::selectMainTopics($quantity);
    }
}