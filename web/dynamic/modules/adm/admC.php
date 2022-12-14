<?php

namespace controllers;

use system\controller;

class admC extends controller{
    public function __construct($page, $action){
        parent::__construct($page, $action);
        $this->pageSelect($page, $action);
    }

    // Выбор страницы
    private function pageSelect($page,$action){
        if($action != NULL && array_key_exists(1,$this->path) && array_key_exists(2,$this->path) && array_key_exists(3,$this->path)){
            $this->model->$action($this->path[3]);
        }elseif($action != NULL){
            $this->model->$action();
        }elseif(array_key_exists(1,$this->path) && $this->path[1] == "users" && chAccess("ban"))
            $this->usersPage();
        else
            $this->admPage();
    }

    // Формирование главной страницы админки
    private function admPage(){
        $css = array();
        $js = array();
        $dataToView = array(
            "statuses" => $this->getStatuses(),
            "css" => $css, 
            "js" => $js
        );
        $this->view->rander('adm/views/adm', $dataToView, 'adm/views/admLayout', 'Админ панель');
    }

    // Формирование страницы с пользователями
    private function usersPage(){
        $allUsers = $this->model->selectCountUsers();
        $users = $this->model->selectFromUsers();

        $css = array();
        $js = array();
        $dataToView = array(
            "statuses" => $this->getStatuses(),
            "allUsers" => $allUsers,
            "users" => $users,
            "css" => $css, 
            "js" => $js
        );
        $this->view->rander('adm/views/users', $dataToView, 'adm/views/admLayout', 'Админ панель - пользователи');
    }

    // Взятие массива статусов
    private function getStatuses(){
        return require($_SERVER['DOCUMENT_ROOT'].'/settings/status.php');
    }
}