<?php

class mainM{
    public function test(){
        return 368;
    }

    public function selectTopics($quantity = 5){
        $mysqli = openmysqli();
        $resultArr = $mysqli->query("SELECT * FROM maintopic ORDER BY id DESC LIMIT ".$quantity.";");
        $mysqli->close();
        return $resultArr;
    }
}