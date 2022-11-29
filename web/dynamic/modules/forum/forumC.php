<?php

namespace controllers;

use system\controller;

class forumC extends controller{
    public function __construct($page, $action){
        parent::__construct($page, $action);
        $this->dataCollect($page, $action);
    }
    
    private function dataCollect($page,$action){
        //debug($action);
        if(array_key_exists(1,$this->path) && $this->path[1] == "find"){
            $this->findTopListForming();
        }elseif($action != NULL && array_key_exists(2,$this->path) && $this->path[2] == "ratingCh"){
            $this->model->$action($this->path[3], $this->path[4], $this->path[5], $this->path[6]);
        }elseif($action != NULL && array_key_exists(2,$this->path) && ($this->path[2] == "deleteMes" || $this->path[2] == "topMes")){
            $this->model->$action($this->path[3], $this->path[4], $this->path[5]);
        }elseif($action != NULL && array_key_exists(3,$this->path)){
            $this->model->$action($this->path[3]);
        }elseif($action != NULL){
            $this->model->$action();
        }elseif(array_key_exists(2,$this->path)){
            $this->topicsForming();
        }elseif(array_key_exists(1,$this->path)){
            $this->topicsListForming();
        }else{
            $this->unitsListForming();
        }
        //<input type="hidden" value="0" name="activate" />

    }

    // Страница списка главных тем
    private function unitsListForming(){
        $units = $this->model->selectUnits();
        $data = array(
            "units" => $units
        );
        $this->view->rander('forum/views/unitsList', $data);
    }

    // Страница поиска тем
    private function findTopListForming(){
        $allTopics = $this->model->findTopicsAction();
        $date = date("Y-m-d");
        $data = array(
            "nowDate" => $date,
            "allTopics" => $allTopics,
        );
        $this->view->rander('forum/views/topicsFindList', $data);
    }

    // Страница списка топиков под главнной темой
    private function topicsListForming(){
        $allAboutTopic = $this->model->selectAllAboutUnit($this->path[1]);
        if($allAboutTopic != -1){
            $allTopics = $this->model->selectAllTopics($this->path[1]);
            $date = date("Y-m-d");
            $data = array(
                "nowDate" => $date,
                "aboutUnit" => $allAboutTopic,
                "allTopics" => $allTopics,
                "jsUpSrc" => array("https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.2/vue.js", "https://cdnjs.cloudflare.com/ajax/libs/marked/0.3.6/marked.min.js", "https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.4/lodash.min.js"),
            );
            $this->view->rander('forum/views/topicsList', $data);
        }else{
            parent::relocate('/f', 3, 'Тема не найдена!');
        }
    }

    // Страница темы
    private function topicsForming(){
        $allAboutTopic = $this->model->selectAllAboutTopic($this->path[2]); // Получаем всё о топике
        if($allAboutTopic != -1){
            $typeTopic = require($_SERVER['DOCUMENT_ROOT'].'/settings/topic_type.php');
            $this->model->upperTopicView($allAboutTopic["topicId"]); // Обновление счётчика просмотров
            $topicViews = $this->model->countTopicMessages($allAboutTopic["topicId"]); // Подсчёт сообщений в топике
            $selectedMessages = $this->model->selectMessages($allAboutTopic['type'], $this->path[2]); // Берём сообщения
            //debug($selectedMessages);
            $allAboutUnit = $this->model->selectAllAboutUnit($this->path[1]);


            $data = array(
                "typeTopic" => $typeTopic,
                'topicViews' => $topicViews,
                "messages" => $selectedMessages,
                "unit" => $allAboutUnit['name'],
                "unitSrc" => $this->path[1],
                "topicData" => $allAboutTopic,
                "nowDate" => date("Y-m-d"),

                "css" => array("topic"),
                "jsUpSrc" => array("https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.2/vue.js", "https://cdnjs.cloudflare.com/ajax/libs/marked/0.3.6/marked.min.js", "https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.4/lodash.min.js"),
                "jsSrc" => array(),
            );
            $this->view->rander('forum/views/topic', $data);
        }else{
            parent::relocate('/f', 3, 'Топик не найден!');
        }
    }
}