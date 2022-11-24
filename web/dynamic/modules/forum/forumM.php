<?php

use system\model;

require_once 'lib/formCheck.php'; // Проверка форм

class forumM extends model{
    // Взятие главных тем
    public function selectMainTopics($quantity = -1){
        return parent::selectMainTopics($quantity);
    }

    // Создание главной темы
    public function addMainAction(){
        if (!empty($_POST) && array_key_exists('status', $_COOKIE) && decode($_COOKIE['status']) == 2) {
            if(!$_POST['name'] || !mainTopicNameCheck($_POST['name']) || !$_POST['icon'] || !$_POST['descr'])
                relocate('/f', 3, 'Неверное заполнение некоторых полей!');
            elseif(!mainTopicIconCheck($_POST['icon']))
                relocate('/f', 3, 'Неправильно заполнено поле иконки!');
            elseif(!mainTopicDescrCheck($_POST['descr']))
                relocate('/f', 3, 'Неправильно заполнено поле описания!');
            else{
            $mysqli = openmysqli();
            $name = $mysqli->real_escape_string($_POST['name']);
            $topUrl = $mysqli->real_escape_string(translitToUrl($_POST['name']));
            $chechUrl = $mysqli->query("SELECT 'id' FROM maintopic WHERE topicName = '".$topUrl."';");
            if($chechUrl->num_rows != 0){
                $mysqli->close();
                relocate('/f', 3, 'Топик с таким преобразованным URL ('.$name.' -> '.$topUrl.') уже существует: <a href="/f/'.$topUrl.'">'.$topUrl.'</a>!');
            }
            $date = date("Y-m-d");
            $icon = $mysqli->real_escape_string($_POST['icon']);
            $descr = $mysqli->real_escape_string($_POST['descr']);
            $mysqli->query("INSERT INTO maintopic VALUES (NULL, '".$topUrl."', '".$name."', '".$descr."', '".$date."', '".$icon."');");
            $mysqli->close();
            mkdir($_SERVER['DOCUMENT_ROOT']."/files/forum/".$topUrl);
            relocate('/f', 2, 'Добавлена тема <a href="/f/'.$topUrl.'">'.$name.'</a>!');
            }
        }else
            relocate('/f');
    }

    // Обновление главной темы
    public function changeMainAction(){
        if (!empty($_POST) && $_POST['url'] && array_key_exists('status', $_COOKIE) && decode($_COOKIE['status']) == 2) {
            if(!$_POST['name'] || !mainTopicNameCheck($_POST['name']) || !$_POST['icon'] || !$_POST['descr'])
                relocate('/f/'.$_POST['url'], 3, 'Неверное заполнение некоторых полей!');
            elseif(!mainTopicIconCheck($_POST['icon']))
                relocate('/f/'.$_POST['url'], 3, 'Неправильно заполнено поле иконки!');
            elseif(!mainTopicDescrCheck($_POST['descr']))
                relocate('/f/'.$_POST['url'], 3, 'Неправильно заполнено поле описания!');
            else{
            $mysqli = openmysqli();
            $url = $mysqli->real_escape_string($_POST['url']);
            $chechUrl = $mysqli->query("SELECT 'id' FROM maintopic WHERE topicName = '".$url."';");
            if($chechUrl->num_rows == 0){
                $mysqli->close();
                relocate('/f/'.$url, 3, 'Топик с таким не найден');
            }
            $name = $mysqli->real_escape_string($_POST['name']);
            $icon = $mysqli->real_escape_string($_POST['icon']);
            $descr = $mysqli->real_escape_string($_POST['descr']);
            $mysqli->query("UPDATE maintopic SET name = '".$name."', descr = '".$descr."', icon = '".$icon."' WHERE topicName = '".$url."';");
            $mysqli->close();
            relocate('/f/'.$url, 2, 'Изменена тема '.$name.'!');
            }
        }else
            relocate('/f');
    }

    public function selectAllAboutTopic($urlName){
        $mysqli = openmysqli();
        $urlName = $mysqli->real_escape_string($urlName);
        $topic = mysqli_fetch_assoc($mysqli->query("SELECT * FROM maintopic WHERE topicName  = '".$urlName."';"));
        $mysqli->close();
        if(!$topic)
            $topic = -1;
        return $topic;
    }

    // Создание подтемы
    public function addThemeAction($mainTheme){
        if (!empty($_POST) && array_key_exists('login', $_COOKIE)) {
            //debug($_FILES);
            if(!$_POST['name'] || !topicNameCheck($_POST['name']) || !$_POST['type'] || !$_POST['text'] || $_POST['type'] < 1 || $_POST['type'] > 2)
                relocate('/f/'.$mainTheme, 3, 'Неверное заполнение некоторых полей!');
            elseif(!topicTextCheck($_POST['text']))
                relocate('/f/'.$mainTheme, 3, 'Неправильно заполнено поле сообщения!');
            else{
                $photoStatus = 0;
                //debug(count($_FILES['messageFiles']['name']));
                if($_FILES['messageFiles']["type"][0] != "" && (count($_FILES['messageFiles']['name']) > 5)){
                    relocate('/f/'.$mainTheme, 3, 'Слишком много файлов, можно загрузить не более 5!'); // 413 ошибка при большом запросе СДЕДАТЬ СТРАНИЦУ
                    exit;
                }elseif($_FILES['messageFiles']["type"][0] != ""){
                    $files = array();
                        foreach($_FILES['messageFiles'] as $k => $l) {
                        	foreach($l as $i => $v) {
                        		$files[$i][$k] = $v;
                        	}
                        }		
                        $_FILES['messageFiles'] = $files;
                        $fileCheck = $this->messageFileCheck();
                        if($fileCheck != 0){
                            relocate('/f/'.$mainTheme, 3, 'Ошибка загрузки файлов: '.$fileCheck.'!');
                            exit;
                        }
                        $photoStatus = 1;
                        
                }
                $mysqli = openmysqli();
                $chechUrl = mysqli_fetch_assoc($mysqli->query("SELECT id FROM maintopic WHERE topicName = '".$mainTheme."';"));
                if(!$chechUrl['id']){
                    $mysqli->close();
                    relocate('/f', 3, 'Топик с таким преобразованным URL ('.$name.' -> '.$topUrl.') уже существует: <a href="/f/'.$topUrl.'">'.$topUrl.'</a>!');
                }
                $name = $mysqli->real_escape_string($_POST['name']);
                $type = $mysqli->real_escape_string($_POST['type']);
                $date = date("Y-m-d");
                $datetime = date("Y-m-d H:i:s");
                $text = $mysqli->real_escape_string($_POST['text']);
                $mysqli->query("INSERT INTO topic VALUES (NULL, ".$_COOKIE['id'].", ".$chechUrl['id'].", '".$date."', '".$name."', ".$type.", 0, 0);");
                $themeId = mysqli_fetch_assoc($mysqli->query("SELECT id FROM topic WHERE idUserCreator = '".$_COOKIE['id']."' ORDER BY id DESC;"));
                
                $mysqli->query("
                CREATE TABLE messagesForTopicId".$themeId['id']." (
                    id int(11) NOT NULL AUTO_INCREMENT,
                    idUser int(11) NOT NULL,
                    idUserRef int(11) NOT NULL,
                    message text NOT NULL,
                    datatime datetime NOT NULL,
                    rating int(11) NOT NULL,
                    atribute int(11) NOT NULL,
                    photo int(11) NOT NULL,
                    PRIMARY KEY (id)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                ");

                $mysqli->query("INSERT INTO messagesForTopicId".$themeId['id']." VALUES (NULL, ".$_COOKIE['id'].", 0, '".$text."', '".$datetime."', 0, 0, ".$photoStatus.");");
                
                $mysqli->query("
                CREATE TABLE photoForTopicId".$themeId['id']." (
                    id int(11) NOT NULL AUTO_INCREMENT,
                    idMessage int(11) NOT NULL,
                    type varchar(11) NOT NULL,
                    PRIMARY KEY (id)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                ");

                mkdir($_SERVER['DOCUMENT_ROOT']."/files/forum/".$mainTheme."/".$themeId['id']);

                if($photoStatus == 1){
                    $uploaddir = $_SERVER['DOCUMENT_ROOT']."/files/forum/".$mainTheme."/".$themeId['id']."/";
                    foreach($_FILES['messageFiles'] as $k) {
                        $fileType = $k['type'];
                        $fileFormat = explode('/',$fileType)[1];
                        $mysqli->query("INSERT INTO photoForTopicId".$themeId['id']." VALUES (NULL, 1, '".$fileFormat."');");
                        $photoId = mysqli_fetch_assoc($mysqli->query("SELECT id FROM photoForTopicId".$themeId['id']." WHERE idMessage = 1 ORDER BY id DESC;"));
                        $fileName = $k['name'];
                        $fileTmp = $k['tmp_name'];
                        $fileExt = explode('.',$fileName);
                        $fileExt = strtolower(end($fileExt)); // END требует передачи по ссылке, поэтому в 2 строки!
                        $filename = $photoId['id'].'.'.$fileExt;
                        move_uploaded_file($fileTmp, $uploaddir.$filename);
                    }
                }

                $mysqli->query("
                CREATE TABLE banForTopic".$themeId['id']." (
                    id int(11) NOT NULL AUTO_INCREMENT,
                    IdUser int(11) NOT NULL,
                    dateTime datetime NOT NULL,
                    PRIMARY KEY (id)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                ");
                $mysqli->close();
                relocate('/f/'.$mainTheme.'/'.$themeId['id'], 2, 'Добавлена тема <a href="/f/'.$mainTheme.'/'.$themeId['id'].'">'.$name.'</a>!');
            }
        }else
            relocate('/f');
    }

    public function messageFileCheck(){
        foreach($_FILES['messageFiles'] as $k) {
            $error = "";
            $fileName = $k['name'];
            $fileSize = $k['size'];
            $fileTmp = $k['tmp_name'];
            $fileType = $k['type'];
            $fileFormat = explode('/',$fileType)[1];
            $fileExt = explode('.',$fileName);
            $fileExt = strtolower(end($fileExt)); // END требует передачи по ссылке, поэтому в 2 строки!
            $expensions = array("000","jpeg","jpg","png", "plain", "pdf", "octet-stream", "vnd.openxmlformats-officedocument.wordprocessingml.document");
            if(!array_search($fileFormat, $expensions)) {
                $error = 'Формат файла "'.$fileFormat.'" (.'.$fileExt.') в файле "'.$fileName.'" не поддерживается'; 
            }elseif ($fileSize == 0) {
                $error = 'Файл '.$fileName.' пустой';
            }elseif($fileSize > 2097152){ // Биты
                $error = 'Файл '.$fileName.' слишком большой (> 2mb)';  
            }
        }
        if($error == "")
            return 0;
        else
            return $error;
    }

    // Удаление главной темы
    public function deleteMainAction(){
        krik("УДАЛЕНИЕ ТЕМЫ");
        //Удаление всех связанных с ней таблиц
    }

}