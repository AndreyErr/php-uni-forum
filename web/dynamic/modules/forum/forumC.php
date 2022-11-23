<?php

namespace controllers;

use system\controller;

class forumC extends controller{
    public function __construct($page, $action){
        parent::__construct($page, $action);
        $this->dataCollect($page, $action);
    }
    
    private function dataCollect($page,$action){
        if($action != NULL){
            $this->model->$action();
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

    // Страница списка тем под главнной темой
    private function topicsListForming(){
        $allAboutTopic = $this->model->selectAllAboutTopic($this->path[1]);
        $data = array(
            "aboutMainTopic" => $allAboutTopic
        );
        $this->view->rander('forum/views/topicsList', $data);
    }
}