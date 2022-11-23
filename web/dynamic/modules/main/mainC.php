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
        $mainTopics = $this->model->selectMainTopics(6);
        $data = array("mainTop" => $mainTopics);
        $this->view->rander('main/views/'.$this->path[0], $data);
    }
}