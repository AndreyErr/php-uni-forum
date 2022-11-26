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
        $units = $this->model->selectUnits(6);
        $recomendedTopics = $this->model->selectRecomendedTopics(2);
        $data = array(
            "mainTop" => $units,
            "recomendedTopics" => $recomendedTopics
        );
        $this->view->rander('main/views/'.$this->path[0], $data);
    }
}