<?php

namespace system;

use system;

class route{
    // Разбиение пути на состовляющие
    public function __construct(){
        $path = explode('/', trim($_SERVER['REDIRECT_URL'], '/'));
        $this->router($path);
    }

    // Выбор контроллера (по первому параметру ссылки)
    public function router($path)
    {
        $page = $path[0];
        if ($path[0] == "" || $path[0] == "about")
            $path[0] = $page = "main";
        $controller = $this->checkController($path);
        $model = $this->checkModel($path);
        //$view = $this->checkView($path);
        if($controller != "-1" && $model != "-1" /*&& $view != "-1"*/){
            $model = $path[0].'M';
            //$view = $path[0].'V';
            $controllerClass = new $controller($page);
        }    
        else
            krik("//////////Ошибка контроллер или модель не найдена");
    }

    // Проверка существования контроллера
    public function checkController($path){
        $controllerPath = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$path[0].'/'.$path[0].'C.php'; // Задание пути к контроллеру
        $controllerClass = "controllers\\".$path[0].'C'; // Задание пути к классу контроллера
        if(file_exists($controllerPath)){
            require_once $controllerPath;
            if(class_exists($controllerClass))
                return $controllerClass;
        }
        return -1;
    }

    // Проверка существования модели
    public function checkModel($path){
        if ($path[0] == "") 
            $path[0] = "main";
        $modelPath = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$path[0].'/'.$path[0].'M.php'; // Задание пути к модели
        $modelClass = $path[0].'M'; // Задание пути к классу модели
        if(file_exists($modelPath)){
            require_once $modelPath;
            if(class_exists($modelClass))
                return $modelClass;
        }
        return -1;
    }

    // Проверка существования образа
    // public function checkView($path){
    //     if ($path[0] == "") 
    //         $path[0] = "main";
    //     $viewPath = $_SERVER['DOCUMENT_ROOT'].'/'.$path[0].'/'.$path[0].'V.php'; // Задание пути к модели
    //     $viewClass = $path[0].'V'; // Задание пути к классу образа
    //     if(file_exists($viewPath)){
    //         require_once $viewPath;
    //         if(class_exists($viewClass))
    //             return $viewClass;
    //     }
    //     return -1;
    // }
}