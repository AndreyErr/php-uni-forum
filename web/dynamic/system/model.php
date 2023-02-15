<?php

namespace system;

class model{

    // Подключение файла с базовыми настройками (запрос настройки по форме xxx/xxx/xx)
    // Пример: получение пути загрузки аватарок: 'fileData/avatar/folder'
    public static function specialDataGet($get = ""){
        $secData = require 'settings/config_data.php'; // Некоторые стандартные переменные в массиве (см. config_data.php)
        if ($get != "") {
            $get = explode('/', $get);
            foreach ($get as &$value)
                if (isset($secData[$value]))
                    $secData = $secData[$value];
                else
                    self::relocate('/', -1, 'Не найдена настойка ' . $get . ' в файле "config_data"');
        }
        return $secData;
    }

    // Взятие главных тем (исп в 2 моделях)
    protected function selectUnits($quantity = 100){ // Число нужных записей
        $mysqli = openmysqli();
        $resultArr = $mysqli->query("SELECT * FROM unit ORDER BY unitId DESC LIMIT ".$quantity.";");
        $mysqli->close();
        return $resultArr;
    }

    // Загрузка файлов
    // Аргументы: откуда пришёл запрос (назание поля загрузки файлов), объект файл, новое имя, новое расширение,
    // нестандартный путь (в дополнение к основному из файла настроек)
    protected function fileUpload($tupe, $file, $newName, $setExt = '', $addonSrc = ''){
        $secData = $this->specialDataGet();
        self::checkConfigData('file' ,$tupe);

        $error = "";
        // Название поля в форме и в настройках должны совпадать
        if (!isset($file[$tupe])) {
            // Дополнительная проверка для множества файлов 
            // (при отправле множества файлов через foreach, тип файлов может не передаваться в них самих (в корню)
            //  поэтому пробуем подставить тип в корень)
            $file = [$tupe => $file];
            if (!isset($file[$tupe]))
                return "Не совпадает тип в html и тип в настойках функции загрузки (тип " . $tupe . " не найден)!";
        }
        
        $fileName = $file[$tupe]['name'];
        $fileSize = $file[$tupe]['size'];
        $fileExt = explode('.',$fileName);
        $fileExt = strtolower(end($fileExt));

        if(array_search($fileExt, $secData['fileData'][$tupe]['extensions']) === false) {
            $error = 'Неправильный формат файла "'.$fileName.'" ('.$fileExt.')'; 
        }elseif ($fileSize == 0) {
            $error = 'Файл "'.$fileName.'" пустой';
        }elseif($fileSize > $secData['fileData'][$tupe]['maxSize']){ // Биты
            $error = 'Файл "'.$fileName.'" слишком большого размера (больше '
                .$secData["fileData"][$tupe]["maxSize"]/1024/1024 .' мб)';  
        }

        if($error == ""){
            $fileTmp = $file[$tupe]['tmp_name'];
            if ($setExt != '')
                $fileExt = $setExt;
            $fileNewName = $newName.'.'.$fileExt;
            $src = $secData['FILE_SERVER'].$secData['fileData'][$tupe]['folder'].ltrim($addonSrc, '/');

            move_uploaded_file($fileTmp, $src.$fileNewName); // Загрузка файла

            // Проверка по mime-типу
            if($secData['mimeTypeCheck'] == true && !(isset($secData['fileData'][$tupe]['mimeTypeCheck']) 
            && $secData['fileData'][$tupe]['mimeTypeCheck'] == false)){
                if(!isset($secData['fileData'][$tupe]['mimeExtensions'])){
                    exec('rm ' .$src.$fileNewName, $fileExt);
                    self::relocate('/', -1, 'Неправильная настройка fileData => '
                        .$tupe.' - отсутствует mimeTypeCheck при включённой функции mimeTypeCheck');
                }
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
                    $error = 'Неправильный mime формат файла "'.$fileName
                        .'"!<hr>Это могло произойти, если вы вручную поменяли расшерение оригинального файла!<br>'
                        .'<br>Mime-тип оригинального файла - '
                        .explode(':', $fileExt[0])[1];
                }
            }
        }
        if ($error != "")
            return $error.'!';
        return 'OK';
    }

    // Проверка файла config_data.php (обязательных параметров)
    public static function checkConfigData($tupe = '', $data = ''){
        $secData = require 'settings/config_data.php';
        if ($tupe != '' && is_array($secData) && !isset($secData['UNBAN_LOGIN']) || !isset($secData['STANDART_TITLE']) 
            || !isset($secData['STATUS_UNBAN']) || !isset($secData['EMAIL']) || !isset($secData['FILE_SERVER'])) {
            header('Location: /err/wrongSettings.html');
            exit;
        }elseif($tupe == 'file' &&  $data != ''){
            if(!isset($secData['fileData'][$data]['folder']) || !isset($secData['fileData'][$data]['extensions']) 
                || !isset($secData['fileData'][$data]['maxSize']) || !isset($secData['fileData'][$data]['maxFilesCount']))
                self::relocate('/', -1, 'Неправильная настройка fileData => '.$data);
        }
    }

    // Кастомная переадресация
    public static function relocate($page, $status = -2, $message = ''){ // Путь, тип сообщения (не обяз), сообщение (не обяз)
        if($status != -2 && $message != '')
            $_SESSION['message'] = [$status, $message]; // Сессия с Собщением
        header('Location: '.$page);
        exit;
    }
}