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
            relocate('/f/'.$topUrl, 2, 'Добавлена тема <a href="/f/'.$topUrl.'">'.$name.'</a>!');
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

    // Взятие темы
    public function selectAllAboutMainTopic($urlName){
        $mysqli = openmysqli();
        $urlName = $mysqli->real_escape_string($urlName);
        $topic = mysqli_fetch_assoc($mysqli->query("SELECT * FROM maintopic WHERE topicName  = '".$urlName."';"));
        $mysqli->close();
        if(!$topic)
            $topic = -1;
        return $topic;
    }

    // Создание подтемы
    public function addTopicAction($mainTopic){
        if (!empty($_POST) && array_key_exists('login', $_COOKIE)) {
            //debug($_FILES);
            if(!$_POST['name'] || !topicNameCheck($_POST['name']) || !$_POST['type'] || !$_POST['text'] || $_POST['type'] < 1 || $_POST['type'] > 2)
                relocate('/f/'.$mainTopic, 3, 'Неверное заполнение некоторых полей!');
            elseif(!topicTextCheck($_POST['text']))
                relocate('/f/'.$mainTopic, 3, 'Неправильно заполнено поле сообщения!');
            else{
                $fileStatus = 0;
                //debug(count($_FILES['messageFiles']['name']));
                if($_FILES['messageFiles']["type"][0] != "" && (count($_FILES['messageFiles']['name']) > 5)){
                    relocate('/f/'.$mainTopic, 3, 'Слишком много файлов, можно загрузить не более 5!'); // 413 ошибка при большом запросе СДЕДАТЬ СТРАНИЦУ
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
                            relocate('/f/'.$mainTopic, 3, 'Ошибка загрузки файлов: '.$fileCheck.'!');
                            exit;
                        }
                        $fileStatus = 1;
                        
                }
                $mysqli = openmysqli();
                $chechUrl = mysqli_fetch_assoc($mysqli->query("SELECT id FROM maintopic WHERE topicName = '".$mainTopic."';"));
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
                $topicId = mysqli_fetch_assoc($mysqli->query("SELECT topic_id FROM topic WHERE idUserCreator = '".$_COOKIE['id']."' ORDER BY topic_id DESC;"));
                
                $mysqli->query("
                CREATE TABLE messagesForTopicId".$topicId['topic_id']." (
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

                $mysqli->query("INSERT INTO messagesForTopicId".$topicId['topic_id']." VALUES (NULL, ".$_COOKIE['id'].", 0, '".$text."', '".$datetime."', 0, 0, ".$fileStatus.");");
                
                $mysqli->query("
                CREATE TABLE filesForTopicId".$topicId['topic_id']." (
                    id int(11) NOT NULL AUTO_INCREMENT,
                    idMessage int(11) NOT NULL,
                    type varchar(80) NOT NULL,
                    PRIMARY KEY (id)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                ");

                mkdir($_SERVER['DOCUMENT_ROOT']."/files/forum/".$mainTopic."/".$topicId['topic_id']);

                if($fileStatus == 1){
                    $this->messageFileUpload($mainTopic, $topicId['topic_id'], 1);
                }

                $mysqli->query("
                CREATE TABLE banForTopicId".$topicId['topic_id']." (
                    id int(11) NOT NULL AUTO_INCREMENT,
                    IdUser int(11) NOT NULL,
                    dateTime datetime NOT NULL,
                    PRIMARY KEY (id)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                ");
                $mysqli->close();
                relocate('/f/'.$mainTopic.'/'.$topicId['topic_id'], 2, 'Добавлена тема <a href="/f/'.$mainTopic.'/'.$topicId['topic_id'].'">'.$name.'</a>!');
            }
        }else
            relocate('/f');
    }

    // Проверка файлов для сообщений
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

    // Загрузка файлов для сообщений
    public function messageFileUpload($mainTopic, $topicId, $messageId){// тема, топик, id сообщения
        $mysqli = openmysqli();
        $uploaddir = $_SERVER['DOCUMENT_ROOT']."/files/forum/".$mainTopic."/".$topicId."/";
        foreach($_FILES['messageFiles'] as $k) {
            $fileType = $k['type'];
            $fileFormat = explode('/',$fileType)[1];
            $mainTopic = $mysqli->real_escape_string($mainTopic);
            $topicId = $mysqli->real_escape_string($topicId);
            $messageId = $mysqli->real_escape_string($messageId);
            $mysqli->query("INSERT INTO filesForTopicId".$topicId." VALUES (NULL, ".$messageId.", '".$fileFormat."');");
            $fileId = mysqli_fetch_assoc($mysqli->query("SELECT id FROM filesForTopicId".$topicId." WHERE idMessage = ".$messageId." ORDER BY id DESC LIMIT 1;"));
            $fileName = $k['name'];
            $fileTmp = $k['tmp_name'];
            $fileExt = explode('.',$fileName);
            $fileExt = strtolower(end($fileExt)); // END требует передачи по ссылке, поэтому в 2 строки!
            $filename = $fileId['id'].'.'.$fileExt;
            move_uploaded_file($fileTmp, $uploaddir.$filename);
            $mysqli->close();
        }
    }

    // Взятие всего о топике
    public function selectAllAboutTopic($topicId){
        if(is_numeric($topicId)){
            $mysqli = openmysqli();
            $topicId = $mysqli->real_escape_string($topicId);
            $topic = mysqli_fetch_assoc($mysqli->query("SELECT * FROM topic INNER JOIN users ON topic.idUserCreator = users.user_id AND topic.topic_id = '".$topicId."';"));///////////////////////////////////////////////////////
            $mysqli->close();
            if(!$topic)
                $topic = -1;
            return $topic;
        }
        return -1;
    }

    // Обновление топика
    public function changeTopicAction($id){
        if (!empty($_POST) && $_POST['name'] && $_POST['mainTopic']) {
            if(!$_POST['name'] || !topicNameCheck($_POST['name']) || !$_POST['mainTopic'])
                relocate('/f/'.$_POST['mainTopic'].'/'.$id, 3, 'Неверное заполнение некоторых полей!');
            else{
            $mysqli = openmysqli();
            $id = $mysqli->real_escape_string($id);
            $chechUrl = $mysqli->query("SELECT 'topic_id' FROM topic WHERE topic_id = '".$id."';");
            if($chechUrl->num_rows == 0){
                $mysqli->close();
                relocate('/f/'.$_POST['mainTopic'].'/'.$id, 3, 'Топик с не найден!');
            }
            $name = $mysqli->real_escape_string($_POST['name']);
            $mysqli->query("UPDATE topic SET topic_name = '".$name."' WHERE topic_id = '".$id."';");
            $mysqli->close();
            relocate('/f/'.$_POST['mainTopic'].'/'.$id, 2, 'Изменена тема '.$name.'!');
            }
        }else
            relocate('/f');
    }

    // Взятие всех топиков по теме
    public function selectAllTopics($urlName){
        $mysqli = openmysqli();
        $urlName = $mysqli->real_escape_string($urlName);
        $topic = mysqli_fetch_assoc($mysqli->query("SELECT id FROM maintopic WHERE topicName  = '".$urlName."';"));
        $topics = $mysqli->query("SELECT * FROM topic INNER JOIN users ON topic.idUserCreator = users.user_id AND topic.idMainTopic = '".$topic['id']."';");
        $mysqli->close();
        return $topics;
    }

    // Удаление топика
    public function deleteTopicAction($id){
        $mysqli = openmysqli();
        $id = $mysqli->real_escape_string($id);
        $deletedTopic = mysqli_fetch_assoc($mysqli->query("SELECT * FROM topic WHERE topic_id  = '".$id."';"));
        $mainTopic = mysqli_fetch_assoc($mysqli->query("SELECT topicName FROM maintopic WHERE id  = '".$deletedTopic['idMainTopic']."';"));
        $dir = $_SERVER['DOCUMENT_ROOT']."/files/forum/".$mainTopic['topicName']."/".$id;
        $this->deleteFolder($dir);
        $mysqli->query("DROP TABLE banForTopicId".$id.";");
        $mysqli->query("DROP TABLE filesForTopicId".$id.";");
        $mysqli->query("DROP TABLE messagesForTopicId".$id.";");
        $mysqli->query("DELETE FROM topic WHERE topic_id  = '".$id."';");
        $mysqli->close();
        relocate('/f/'.$mainTopic['topicName'], 2, 'Удалён топик '.$deletedTopic['topic_name'].'!');
    }

    // Удаление главной темы
    public function deleteMainAction($id){
        $mysqli = openmysqli();
        $id = $mysqli->real_escape_string($id);
        $deletedSubTopics = $mysqli->query("SELECT topic_id FROM topic WHERE idMainTopic  = '".$id."';");
        $deletedMainTopic = mysqli_fetch_assoc($mysqli->query("SELECT topicName FROM maintopic WHERE id  = '".$id."';"));
        foreach ($deletedSubTopics as $kay){
            $this->deleteTopicAction($kay['topic_id']);
        }
        $dir = $_SERVER['DOCUMENT_ROOT']."/files/forum/".$deletedMainTopic['topicName'];
        $this->deleteFolder($dir);
        $mysqli->query("DELETE FROM maintopic WHERE id  = '".$id."';");
        $mysqli->close();
        relocate('/f', 2, 'Удалена тема '.$deletedMainTopic['topicName'].' со всеми подтемами!');
    }

    // Удаление папки со всем содержимым
    public function deleteFolder($path){
        if (is_dir($path) === true){
            $files = array_diff(scandir($path), array('.', '..'));  
            foreach ($files as $file){
                $this->deleteFolder(realpath($path) . '/' . $file);
            }   
            return rmdir($path);
        }else if (is_file($path) === true){
            return unlink($path);
        }
        return false;
    }

}