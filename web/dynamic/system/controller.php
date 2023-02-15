<?php

namespace system;

class controller{

    protected $path; // Путь, разбитый на массив
    protected $model; // Объект модели
    protected $view; // Объект представления

    public function __construct($page, $action){ // Страница подключения и действие
        // Подключение модели и представления
        $path = explode('/', trim($_SERVER['REDIRECT_URL'], '/'));
        if ($path[0] == "")
            $path[0] = $page = "main";
        // Задание пути к модели
        require_once($_SERVER['DOCUMENT_ROOT'].'/modules/'.$page.'/'.$page.'M.php');
        // Задание пути к представлению
        require_once($_SERVER['DOCUMENT_ROOT'].'/system/view.php');
        $model = $page.'M';
        $view = 'view';
        $this->path = $path;
        $this->model = new $model;
        $this->view = new $view;
    }
}