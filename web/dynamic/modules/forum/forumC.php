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
        }else{
            $mainTopics = $this->model->selectMainTopics();
            $data = array(
                "mainTop" => $mainTopics
            );
            $this->view->rander('forum/views/'.$page, $data);
        }
        //<input type="hidden" value="0" name="activate" />

    }
}