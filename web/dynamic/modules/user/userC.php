<?php

namespace controllers;

use system\controller;

class userC extends controller{
    public function __construct($page, $action){ // $page - вызванный контроллер, $path[0] - требуемая страница
        parent::__construct($page, $action);
        $this->dataCollect($page, $action);
    }

    // Формирование данных для представления
    private function dataCollect($page,$action){
        if(!array_key_exists(1,$this->path)) $this->path[1] = "";
        if($action != NULL){
            $this->model->$action();
        }else if($this->path[1] == "reg" || ($this->path[1] == "" && !array_key_exists('login', $_COOKIE))){
            $this->regForming();
        }else{
            $this->userRegForming($page);
        }
    }

    // Формирование страницы регистрации
    private function regForming(){
        $css = array("formCh");
        $js = array("formValid");
        $dataToView = array(
            "css" => $css, 
            "js" => $js
        );
        $this->view->rander('user/views/regisration', $dataToView);
    }

    // Формирование страницы зарег пользователя
    private function userRegForming($page){
        $css = array("user", "formCh");
        $js = array();
        $allAboutActualUser = $this->model->SelectAllAboutUser(decode($_COOKIE['login']));
        $status = require($_SERVER['DOCUMENT_ROOT'].'/config/status.php');
        $status = $status[$allAboutActualUser['status']];
        $dataToView = array(
            "css" => $css, 
            "js" => $js, 
            "user" => $allAboutActualUser, 
            "userstatus" => $status
        );
        $this->view->rander('user/views/'.$page, $dataToView);
    }
}