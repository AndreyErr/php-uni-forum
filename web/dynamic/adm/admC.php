<?php

namespace controllers;

use sustem;
use adm\models;

class admC{
    public function __construct(){
        // Подключение модели и представления
        $path = explode('/', trim($_SERVER['REDIRECT_URL'], '/'));
        require_once($_SERVER['DOCUMENT_ROOT'].'/'.$path[0].'/'.$path[0].'M.php'); // Задание пути к модели
        require_once($_SERVER['DOCUMENT_ROOT'].'/'.$path[0].'/'.$path[0].'V.php'); // Задание пути к модели
        $model = $path[0].'M';
        $view = $path[0].'V';
        $model = new $model;
        $view = new $view;
        $view->test(" ".$model->test());
    }
}