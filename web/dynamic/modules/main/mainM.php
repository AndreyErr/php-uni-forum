<?php

use system\model;

class mainM extends model{
    // Взятие главных тем для главной страницы
    public function selectMainTopics($quantity = 6){
        return parent::selectMainTopics($quantity);
    }

    public function selectRecomendedTopics($count = 2){
        $mysqli = openmysqli();
        $count = $mysqli->real_escape_string($count);
        $topics = $mysqli->query("SELECT * FROM topic LEFT JOIN maintopic ON topic.idMainTopic = maintopic.id ORDER BY topic.viewAllTime DESC LIMIT ".$count.";");
        if($topics->num_rows == 0)
            $topics = -1;
        return $topics;
    }
}