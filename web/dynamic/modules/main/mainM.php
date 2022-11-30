<?php

use system\model;

class mainM extends model{
    // Взятие главных тем для главной страницы
    public function selectUnits($quantity = 6){
        return parent::selectUnits($quantity);
    }

    // Выборка постов для рекомендаций на главной странице
    public function selectRecomendedTopics($count = 2){
        $mysqli = openmysqli();
        $count = $mysqli->real_escape_string($count);
        $topics = $mysqli->query("SELECT * FROM topic LEFT JOIN unit ON topic.idUnit = unit.unitId ORDER BY topic.viewAllTime DESC LIMIT ".$count.";");
        if($topics->num_rows == 0)
            $topics = -1;
        return $topics;
    }
}