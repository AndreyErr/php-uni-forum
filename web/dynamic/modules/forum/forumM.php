<?php

use system\model;

require_once 'lib/formCheck.php'; // Проверка форм

class forumM extends model{
    // Взятие главных тем
    public function selectMainTopics($quantity = -1){
        return parent::selectMainTopics($quantity);
    }

    // Создание главной темы
    public function addMainAction(){
        if (!empty($_POST) || (array_key_exists('status', $_COOKIE) && decode($_COOKIE['status']) != 2)) {
            if(!$_POST['name'] || !mainTopicNameCheck($_POST['name']) || !$_POST['icon'] || !$_POST['descr'])
                relocate('/f', 3, 'Неверное заполнение некоторых полей!');
            elseif(!mainTopicIconCheck($_POST['icon']))
                relocate('/f', 3, 'Неправильно заполнено поле иконки!');
            elseif(!mainTopicDescrCheck($_POST['descr']))
                relocate('/f', 3, 'Неправильно заполнено поле описания!');
            else{
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
            }
        }else
            relocate('/f');
    }

    // Обновление главной темы
    public function changeMainAction(){
        //debug(mainTopicDescrCheck($_POST['descr']));
        if (!empty($_POST) || $_POST['url'] || (array_key_exists('status', $_COOKIE) && decode($_COOKIE['status']) != 2)) {
            if(!$_POST['name'] || !mainTopicNameCheck($_POST['name']) || !$_POST['icon'] || !$_POST['descr'])
                relocate('/f/'.$_POST['url'], 3, 'Неверное заполнение некоторых полей!');
            elseif(!mainTopicIconCheck($_POST['icon']))
                relocate('/f/'.$_POST['url'], 3, 'Неправильно заполнено поле иконки!');
            elseif(!mainTopicDescrCheck($_POST['descr']))
                relocate('/f/'.$_POST['url'], 3, 'Неправильно заполнено поле описания!');
            else{
            $mysqli = openmysqli();
            $url = $mysqli->real_escape_string($_POST['url']);
            $chechUrl = $mysqli->query("SELECT 'id' FROM maintopic WHERE topicName = '".$url."';");
            if($chechUrl->num_rows == 0){
                $mysqli->close();
                relocate('/f/'.$url, 3, 'Топик с таким не найден');
            }
            $name = $mysqli->real_escape_string($_POST['name']);
            $icon = $mysqli->real_escape_string($_POST['icon']);
            $descr = $mysqli->real_escape_string($_POST['descr']);
            $mysqli->query("UPDATE maintopic SET name = '".$name."', descr = '".$descr."', icon = '".$icon."' WHERE topicName = '".$url."';");
            $mysqli->close();
            relocate('/f/'.$url, 2, 'Изменена тема '.$name.'!');
            }
        }else
            relocate('/f');
    }

    public function selectAllAboutTopic($urlName){
        $mysqli = openmysqli();
        $urlName = $mysqli->real_escape_string($urlName);
        $topic = mysqli_fetch_assoc($mysqli->query("SELECT * FROM maintopic WHERE topicName  = '".$urlName."';"));
        $mysqli->close();
        if(!$topic)
            $topic = -1;
        return $topic;
    }

    // Удаление главной темы
    public function deleteMainAction(){
        krik("УДАЛЕНИЕ ТЕМЫ");
        //Удаление всех связанных с ней таблиц
    }
}