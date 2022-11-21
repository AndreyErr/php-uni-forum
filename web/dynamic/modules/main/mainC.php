<?php

namespace controllers;

use system\controller;

class mainC extends controller{
    public function __construct($page, $action){ // $page - вызванный контроллер, $path[0] - требуемая страница
        parent::__construct($page, $action);
        $this->dataCollect();
    }

    // Формирование данных для представления
    private function dataCollect(){
        $mainTopics = $this->model->selectTopics(6);
        $a = array(1, 2, 3, 4, 5);
        $b = array(1, 2, 3, 4, 5);
        $c = array("a" => $a, "b" => $b, "mainTop" => $mainTopics);
        //debug($path[0]);
        //debug($c);
        $this->view->rander('main/views/'.$this->path[0], $c);
    }
}