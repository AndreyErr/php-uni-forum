<?php

namespace controllers;

use system;
use main\models;

class mainC{
    public function __construct($page){ // $page - вызванный контроллер, $path[0] - требуемая страница
        // Подключение модели и представления
        $path = explode('/', trim($_SERVER['REDIRECT_URL'], '/'));
        if ($path[0] == "")
            $path[0] = $page = "main";
        require_once($_SERVER['DOCUMENT_ROOT'].'/'.$page.'/'.$page.'M.php'); // Задание пути к модели
        require_once($_SERVER['DOCUMENT_ROOT'].'/system/view.php'); // Задание пути к модели
        $model = $page.'M';
        $view = 'view';
        $model = new $model;
        $view = new $view;

        $a = array(1, 2, 3, 4, 5);
        $b = array(1, 2, 3, 4, 5);
        $c = array("a" => $a, "b" => $b);
        //debug($path[0]);
        $view->rander($path[0], $c);


    }
}