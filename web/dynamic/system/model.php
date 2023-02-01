<?php

namespace system;

class model{

    // Подключение файла с базовыми настройками
    protected static function specialDataGet($get){
        $secData = require 'settings/config_data.php'; // Некоторые стандартные переменные в массиве (см. config_data.php)
        if(is_array($secData) && array_key_exists($get, $secData))
            return $secData[$get];
        return 'getErr';
    }

    // Взятие главных тем (исп в 2 моделях)
    protected function selectUnits($quantity = -1){ // Число нужных записей
        $mysqli = openmysqli();
        if($quantity == -1)
            $resultArr = $mysqli->query("SELECT * FROM unit ORDER BY unitId DESC;");
        else
            $resultArr = $mysqli->query("SELECT * FROM unit ORDER BY unitId DESC LIMIT ".$quantity.";");
        $mysqli->close();
        return $resultArr;
    }

    // Загрузка файлов
    // Аргументы: откуда пришёл запрос, объект файл, новое имя, новое расширение, нестандартный путь
    protected function fileUpload($tupe, $file, $newName, $setExt = '', $src = ''){
        
        $secData = require 'settings/config_data.php'; // Некоторые стандартные переменные в массиве (см. config_data.php)

        $error = "";
        if(!isset($file[$tupe]))
            $this->relocate('/u', 3, "Не совпадает тип в html и тип в настойках вункции загрузки (тип ".$tupe." не найден)!");
        
        $fileName = $file[$tupe]['name'];
        $fileSize = $file[$tupe]['size'];
        $fileType = $file[$tupe]['type'];
        $fileExt = explode('.',$fileName);
        $fileExt = strtolower(end($fileExt));

        if(array_search($fileExt, $secData['fileData'][$tupe]['extensions']) === false) {
            $error = 'Неправильный формат файла "'.$fileName.'" ('.$fileExt.')'; 
        }elseif ($fileSize == 0) {
            $error = 'Файл "'.$fileName.'" пустой';
        }elseif($fileSize > $secData['fileData'][$tupe]['maxSize']){ // Биты
            $error = 'Файл "'.$fileName.'" слишком большого размера (больше '. $secData["fileData"][$tupe]["maxSize"]/1024/1024 .' мб)';  
        }

        if($error == ""){
            $fileTmp = $file[$tupe]['tmp_name'];
            if ($setExt != '')
                $fileExt = $setExt;
            $fileNewName = $newName.'.'.$fileExt;
            if ($src == '')
                $src = $secData['fileData'][$tupe]['folder'];

            move_uploaded_file($fileTmp, $src.$fileNewName); // Загрузка файла

            // Проверка по mime-типу
            if($secData['mimeTypeCheck'] == true){
                exec('file -i ' . $src.$fileNewName, $fileExt); // Запись mime типа методами linux
    
                // Проверяем на совподение mime типа по массиву резрешённых
                $isCorrect = false;
                foreach ($secData['fileData'][$tupe]['mimeExtensions'] as &$value) {
                    // Выборка meme-типа из ответа для стравнения с разреш. форматами
                    // Отсекаем перую часть, чтоб в проверку не попал путь файла
                    if (strripos(explode(':', $fileExt[0])[1], $value)) {
                        $isCorrect = true;
                        break;
                    }
                }
                if ($isCorrect == false){
                    exec('rm ' .$src.$fileNewName, $fileExt);
                    $error = 'Неправильный mime формат файла "'.$fileName.'"!<hr>Это могло произойти, если вы вручную поменяли расшерение оригинального файла!<br><br>Mime-тип оригинального файла - '.explode(':', $fileExt[0])[1];
                }
            }
        }
        if($error != "")
            $this->relocate('/u', 3, $error.'!');
    }

    // Кастомная переадресация
    public static function relocate($page, $status = -1, $message = ''){ // Путь, тип сообщения (не обяз), сообщение (не обяз)
        if($status != -1)
            $_SESSION['message'] = [$status, $message]; // Сессия с Собщением
        header('Location: '.$page);
    }
}