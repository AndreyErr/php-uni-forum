<?php

class view{
    // Рендер нужного вида 
    public function rander($path, $data = []){
        extract($data);
        $path = $_SERVER['DOCUMENT_ROOT'].'/modules/main/views/'.$path.'.php'; // ИЗМЕНИТЬ ПУТЬ
        if (file_exists($path)){
            ob_start();
            require $path;
            $content = ob_get_clean();
            $content = $this->randlayouts($content, $data = []);
            echo $content;
        }else
        krik("//////////Ошибка представление не найдено");
    }

    // Рендер доп контента (шипки и подвала)
    public function randlayouts($content, $data = []){
        $path = $_SERVER['DOCUMENT_ROOT'].'/modules/views/headerFooter.php';
        if (file_exists($path)){
            ob_start();
            require $path;
            return ob_get_clean();
        }else
        krik("//////////Ошибка layout не найден");
    }
}