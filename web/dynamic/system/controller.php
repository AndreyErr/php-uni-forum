<?php

namespace system;

class controller{

    protected $path;
    protected $model;
    protected $view;

    public function __construct($page, $action){
        // Подключение модели и представления
        $path = explode('/', trim($_SERVER['REDIRECT_URL'], '/'));
        if ($path[0] == "")
            $path[0] = $page = "main";
        require_once($_SERVER['DOCUMENT_ROOT'].'/modules/'.$page.'/'.$page.'M.php'); // Задание пути к модели
        require_once($_SERVER['DOCUMENT_ROOT'].'/system/view.php'); // Задание пути к представлению
        $model = $page.'M';
        $view = 'view';
        $this->path = $path;
        $this->model = new $model;
        $this->view = new $view;
    }
}