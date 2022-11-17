<?php

namespace controllers;

use system;
use main\models;

class userC{
    public function __construct($page, $action){ // $page - вызванный контроллер, $path[0] - требуемая страница
        // Подключение модели и представления
        //debug($action);
        $path = explode('/', trim($_SERVER['REDIRECT_URL'], '/'));
        if(!array_key_exists(1,$path)) $path[1] = "";
        require_once($_SERVER['DOCUMENT_ROOT'].'/modules/'.$page.'/'.$page.'M.php'); // Задание пути к модели
        require_once($_SERVER['DOCUMENT_ROOT'].'/system/view.php'); // Задание пути к модели
        $model = $page.'M';
        $view = 'view';
        $model = new $model;
        $view = new $view;
        if($action != NULL){
            $model->$action();
        }
        if ($path[1] == "reg"){
            $css = "reg";
            $js = "formValid";
            $c = array("css" => $css, "js" => $js);
            $view->rander('user/views/regisration', $c);
        }else{
            $view->rander('user/views/'.$page.'Select');
        }

    }
}