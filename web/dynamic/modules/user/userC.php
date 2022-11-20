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
        }else if($path[1] == "reg" || ($path[1] == "" && !array_key_exists('login', $_COOKIE))){
            $css = array("formCh");
            $js = array("formValid");
            $dataToView = array(
                "css" => $css, 
                "js" => $js
            );
            $view->rander('user/views/regisration', $dataToView);
        }else{
            $css = array("user", "formCh");
            $js = array();
            $allAboutActualUser = $model->SelectAllAboutUser(decode($_COOKIE['login']));
            $status = require($_SERVER['DOCUMENT_ROOT'].'/config/status.php');
            $status = $status[$allAboutActualUser['status']];
            $dataToView = array(
                "css" => $css, 
                "js" => $js, 
                "user" => $allAboutActualUser, 
                "userstatus" => $status
            );
            $view->rander('user/views/'.$page, $dataToView);
        }

    }
}