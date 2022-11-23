<?php

use system\model;

require_once 'lib/formCheck.php'; // Проверка форм

class forumM extends model{
    // Взятие главных тем
    public function selectMainTopics($quantity = -1){
        return parent::selectMainTopics($quantity);
    }

    public function addMainAction(){
        if (!empty($_POST) || (array_key_exists('status', $_COOKIE) && decode($_COOKIE['status']) != 2)) {
            if(!$_POST['name'] || !mainTopicNameCheck($_POST['name']) || !$_POST['icon'] || !$_POST['descr'])
                relocate('/f', 3, 'Неверное заполнение некоторых полей!');
            if(!mainTopicIconCheck($_POST['icon']))
                relocate('/f', 3, 'Неправильно заполнено поле иконки!');
            if(!mainTopicDescrCheck($_POST['descr']))
                relocate('/f', 3, 'Неправильно заполнено поле описания!');
            $mysqli = openmysqli();
            $name = $mysqli->real_escape_string($_POST['name']);
            $topUrl = $mysqli->real_escape_string(translitToUrl($_POST['name']));
            $chechUrl = $mysqli->query("SELECT 'id' FROM maintopic WHERE topicName = '".$topUrl."';");
            if($chechUrl->num_rows != 0){
                $mysqli->close();
                relocate('/f', 3, 'Топик с таким преобразованным URL ('.$name.' -> '.$topUrl.') уже существует: <a href="/f/'.$topUrl.'">'.$topUrl.'</a>!');
            }
            $date = date("Y-m-d");
            $icon = $mysqli->real_escape_string($_POST['icon']);
            $descr = $mysqli->real_escape_string($_POST['descr']);
            $mysqli->query("INSERT INTO maintopic VALUES (NULL, '".$topUrl."', '".$name."', '".$descr."', '".$date."', '".$icon."');");
            $mysqli->close();
            relocate('/f', 2, 'Добавлена тема <a href="/f/'.$topUrl.'">'.$name.'</a>!');
        }else
            relocate('/f');
    }
}