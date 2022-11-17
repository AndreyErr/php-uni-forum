<?php

namespace controllers;

use system;
use main\models;

class forumC{
    public function __construct($page, $action){ // $page - вызванный контроллер, $path[0] - требуемая страница
        // Подключение модели и представления
        $path = explode('/', trim($_SERVER['REDIRECT_URL'], '/'));
        require_once($_SERVER['DOCUMENT_ROOT'].'/modules/'.$page.'/'.$page.'M.php'); // Задание пути к модели
        require_once($_SERVER['DOCUMENT_ROOT'].'/system/view.php'); // Задание пути к модели
        $model = $page.'M';
        $view = 'view';
        $model = new $model;
        $view = new $view;
        //echo($model->test());
        $view->rander('forum/views/'.$page.'Select');
        //<input type="hidden" value="0" name="activate" />

    }
}