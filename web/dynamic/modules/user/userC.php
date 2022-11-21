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
        }else if($this->path[1] != "" ){
            $this->userPageForming($page, $this->path[1]);
        }else{
            $this->userPageForming($page, decode($_COOKIE['login']));
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
    private function userPageForming($page, $user){
        $css = array("user", "formCh");
        $js = array();
        $allAboutActualUser = $this->model->SelectAllAboutUser($user);
        $status = require($_SERVER['DOCUMENT_ROOT'].'/config/status.php');
        if($allAboutActualUser != -1){
            $status = $status[$allAboutActualUser['status']];
            $statusdig = $allAboutActualUser['status'];
        }else{
            $status = $status[-1];
            $statusdig = -1;
        }
        $dataToView = array(
            "css" => $css, 
            "js" => $js, 
            "user" => $allAboutActualUser,
            "userstatusdig" => $statusdig,
            "userstatus" => $status,
            "decodedMyLogin" => decode($_COOKIE['login'])
        );
        $this->view->rander('user/views/'.$page, $dataToView, 'user/views/userLayout');
    }
}