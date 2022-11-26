<?php
// Small bug fix
namespace controllers;

use system\controller;

class forumC extends controller{
    public function __construct($page, $action){
        parent::__construct($page, $action);
        $this->dataCollect($page, $action);
    }
    
    private function dataCollect($page,$action){
        //debug($action);
        if($action != NULL && array_key_exists(2,$this->path) && $this->path[2] == "ratingCh"){
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
            $this->mainTopListForming();
        }
        //<input type="hidden" value="0" name="activate" />

    }

    // Страница списка главных тем
    private function mainTopListForming(){
        $mainTopics = $this->model->selectMainTopics();
        $data = array(
            "mainTop" => $mainTopics
        );
        $this->view->rander('forum/views/mainTopList', $data);
    }

    // Страница списка топиков под главнной темой
    private function topicsListForming(){
        $allAboutTopic = $this->model->selectAllAboutMainTopic($this->path[1]);
        if($allAboutTopic != -1){
            $allTopics = $this->model->selectAllTopics($this->path[1]);
            $date = date("Y-m-d");
            $data = array(
                "nowDate" => $date,
                "aboutMainTopic" => $allAboutTopic,
                "allTopics" => $allTopics,
                "jsUpSrc" => array("https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.2/vue.js", "https://cdnjs.cloudflare.com/ajax/libs/marked/0.3.6/marked.min.js", "https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.4/lodash.min.js"),
            );
            $this->view->rander('forum/views/topicsList', $data);
        }else{
            relocate('/f', 3, 'Тема не найдена!');
        }
    }

    // Страница темы
    private function topicsForming(){
        $allAboutTopic = $this->model->selectAllAboutTopic($this->path[2]); // Получаем всё о топике
        if($allAboutTopic != -1){
            $typeTopic = require($_SERVER['DOCUMENT_ROOT'].'/settings/topic_type.php');
            $this->model->upperTopicView($allAboutTopic["topic_id"]); // Обновление счётчика просмотров
            $topicViews = $this->model->countTopicMessages($allAboutTopic["topic_id"]); // Подсчёт сообщений в топике
            $selectedMessages = $this->model->selectMessages($allAboutTopic['type'], $this->path[2]); // Берём сообщения
            //debug($selectedMessages);
            $allAboutMainTopic = $this->model->selectAllAboutMainTopic($this->path[1]);


            $data = array(
                "typeTopic" => $typeTopic,
                'topicViews' => $topicViews,
                "messages" => $selectedMessages,
                "mainTopic" => $allAboutMainTopic['name'],
                "mainTopicSrc" => $this->path[1],
                "topicData" => $allAboutTopic,
                "nowDate" => date("Y-m-d"),

                "css" => array("topic"),
                "jsUpSrc" => array("https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.2/vue.js", "https://cdnjs.cloudflare.com/ajax/libs/marked/0.3.6/marked.min.js", "https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.4/lodash.min.js"),
                "jsSrc" => array(),
            );
            $this->view->rander('forum/views/topic', $data);
        }else{
            relocate('/f', 3, 'Топик не найден!');
        }
    }
}