<?php

namespace controllers;

use system\controller;

class admC extends controller{
    public function __construct($page, $action){
        parent::__construct($page, $action);
        $this->dataCollect($page, $action);
    }

    // Формирование данных для представления
    private function dataCollect($page,$action){
        if($action != NULL && array_key_exists(1,$this->path) && array_key_exists(2,$this->path) && array_key_exists(3,$this->path)){
            $this->model->$action($this->path[3]);
        }elseif($action != NULL){
            $this->model->$action();
        }elseif(array_key_exists(1,$this->path) && $this->path[1] == "users")
            $this->usersPage();
        else
            $this->admPage();
    }

    // Формирование главной страницы админки
    private function admPage(){
        $css = array();
        $js = array();
        $dataToView = array(
            "css" => $css, 
            "js" => $js
        );
        $this->view->rander('adm/views/adm', $dataToView, 'adm/views/admLayout');
    }

    // Формирование страницы с пользователями
    private function usersPage(){
        $css = array();
        $js = array();
        $allUsers = $this->model->selectCountUsers();
        $users = $this->model->selectFromUsers();
        $dataToView = array(
            "css" => $css, 
            "js" => $js,
            "allUsers" => $allUsers,
            "users" => $users
        );
        $this->view->rander('adm/views/users', $dataToView, 'adm/views/admLayout');
    }
}