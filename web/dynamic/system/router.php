<?php

namespace system;

class router{
    // Разбиение пути на состовляющие
    public function __construct(){
        $path = explode('/', trim($_SERVER['REDIRECT_URL'], '/'));
        $this->router($path);
    }

    // Выбор контроллера (по первому параметру ссылки)
    private function router($path){
        $page = $path[0] = $this->selectControllerByPage($path[0]);
        if(!$this->chAccess($page)){
            header('Location: /err/404.html');
            exit;
        }
        $controller = $this->checkController($path);
        $model = $this->checkModel($path);
        if($controller != "NOT_FOUND" && $model != "NOT_FOUND"){
            $model = $path[0].'M';
            $action = $this->checkAction($path);
            new $controller($page, $action);
        }else
            header('Location: /err/404.html');
    }

    // Преобразование страницы
    private function selectControllerByPage($page){
        if ($page == "" || $page == "main" || $page == "error")
            $page = "main";
        if ($page == "f" || $page == "forum")
            $page = "forum";
        if ($page == "u" || $page == "user")
            $page = "user";
        return $page;
    }

    // Проверка существования контроллера
    private function checkController($path){
        // Задание пути к контроллеру
        $controllerPath = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$path[0].'/'.$path[0].'C.php';
        // Задание пути к классу контроллера
        $controllerClass = "controllers\\".$path[0].'C';
        if(file_exists($controllerPath)){
            require_once $controllerPath;
            if(class_exists($controllerClass))
                return $controllerClass;
        }
        return "NOT_FOUND";
    }

    // Проверка существования модели
    private function checkModel($path){
        if ($path[0] == "") 
            $path[0] = "main";
        // Задание пути к модели
        $modelPath = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$path[0].'/'.$path[0].'M.php';
        // Задание пути к классу модели
        $modelClass = $path[0].'M';
        if(file_exists($modelPath)){
            require_once $modelPath;
            if(class_exists($modelClass))
                return $modelClass;
        }
        return "NOT_FOUND";
    }

    // Проверка существования действия
    private function checkAction($path){
        if (array_key_exists(1, $path) && array_key_exists(2, $path) && $path[1] == 'a'){
            $act = $path[2].'Action';
            if(method_exists($path[0].'M', $act))
                return $act;
        }
        return NULL;
    }

    // Проверка на доступ к модулю
    private function chAccess($module){
        // Массив доступа к модулям
        $access = (require 'settings/access.php')['modules'];
        if(array_key_exists($module, $access))
            if(!array_key_exists('id', $_COOKIE) || array_search(decode($_COOKIE['status']), $access[$module]) === false)
                return false;
        return true;
    }
}