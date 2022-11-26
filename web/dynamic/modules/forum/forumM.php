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
                $time = date("H:i:s");
                $text = $mysqli->real_escape_string(str_replace(array("\r\n", "\n", "\r"), '\n', $_POST['text']));
                $mysqli->query("INSERT INTO topic VALUES (NULL, ".$_COOKIE['id'].", ".$chechUrl['id'].", '".$date."', '".$name."', ".$type.", 0, 0);");
                $topicId = mysqli_fetch_assoc($mysqli->query("SELECT topic_id FROM topic WHERE idUserCreator = '".$_COOKIE['id']."' ORDER BY topic_id DESC;"));
                
                $mysqli->query("
                CREATE TABLE messagesForTopicId".$topicId['topic_id']." (
                    id int(11) NOT NULL AUTO_INCREMENT,
                    idUser int(11) NOT NULL,
                    idUserRef int(11) NOT NULL,
                    message text NOT NULL,
                    date date NOT NULL,
                    time time NOT NULL,
                    rating int(11) NOT NULL,
                    atribute int(11) NOT NULL,
                    photo int(11) NOT NULL,
                    PRIMARY KEY (id)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                ");

                $mysqli->query("INSERT INTO messagesForTopicId".$topicId['topic_id']." VALUES (NULL, ".$_COOKIE['id'].", 0, '".$text."', '".$date."', '".$time."', 0, 0, ".$fileStatus.");");
                
                $mysqli->query("
                CREATE TABLE filesForTopicId".$topicId['topic_id']." (
                    id int(11) NOT NULL AUTO_INCREMENT,
                    idMessage int(11) NOT NULL,
                    type varchar(80) NOT NULL,
                    ext varchar(80) NOT NULL,
                    PRIMARY KEY (id)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                ");

                mkdir($_SERVER['DOCUMENT_ROOT']."/files/forum/".$mainTopic."/".$topicId['topic_id']);

                if($fileStatus == 1){
                    $this->messageFileUpload($mainTopic, $topicId['topic_id'], 1);
                }

                $mysqli->query("
                CREATE TABLE raitingForTopicId".$topicId['topic_id']." (
                  idRait int(11) NOT NULL AUTO_INCREMENT,
                  idMes int(11) NOT NULL,
                  idUser int(11) NOT NULL,
                  rait int(11) NOT NULL,
                  PRIMARY KEY (idRait)
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
            $fileName = $k['name'];
            $fileFormat = explode('/',$fileType)[1];
            $mainTopic = $mysqli->real_escape_string($mainTopic);
            $topicId = $mysqli->real_escape_string($topicId);
            $messageId = $mysqli->real_escape_string($messageId);
            $fileExt = explode('.',$fileName);
            $fileExt = strtolower(end($fileExt)); // END требует передачи по ссылке, поэтому в 2 строки!
            $mysqli->query("INSERT INTO filesForTopicId".$topicId." VALUES (NULL, ".$messageId.", '".$fileFormat."', '".$fileExt."');");
            $fileId = mysqli_fetch_assoc($mysqli->query("SELECT id FROM filesForTopicId".$topicId." WHERE idMessage = ".$messageId." ORDER BY id DESC LIMIT 1;"));
            $fileTmp = $k['tmp_name'];
            $filename = $fileId['id'].'.'.$fileExt;
            move_uploaded_file($fileTmp, $uploaddir.$filename);
        }
        $mysqli->close();
    }

    public function addMessageAction($topicId){
    if (!empty($_POST) && array_key_exists('login', $_COOKIE)) {
        $mysqli = openmysqli();
        $topicId = $mysqli->real_escape_string($topicId);
        $mainTopicSrc = mysqli_fetch_assoc($mysqli->query("SELECT idMainTopic  FROM topic WHERE topic_id  = '".$topicId."';"));
        $mainTopicSrc = mysqli_fetch_assoc($mysqli->query("SELECT topicName FROM maintopic WHERE id = '".$mainTopicSrc['idMainTopic']."';"));
        $mysqli->close();
        if(!$_POST['text'])
        relocate('/f/'.$mainTopicSrc['topicName'].'/'.$topicId, 3, 'Неверное заполнение некоторых полей!');
        elseif(!topicTextCheck($_POST['text']))
            relocate('/f/'.$mainTopicSrc['topicName'].'/'.$topicId, 3, 'Неправильно заполнено поле сообщения!');
        else{
            $fileStatus = 0;
            if($_FILES['messageFiles']["type"][0] != "" && (count($_FILES['messageFiles']['name']) > 5)){
                relocate('/f/'.$mainTopicSrc['topicName'].'/'.$topicId, 3, 'Слишком много файлов, можно загрузить не более 5!');
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
                        relocate('/f/'.$mainTopicSrc['topicName'].'/'.$topicId, 3, 'Ошибка загрузки файлов: '.$fileCheck.'!');
                        exit;
                    }
                    $fileStatus = 1;
            }
            $mysqli = openmysqli();      
            $date = date("Y-m-d");
            $time = date("H:i:s");
            $text = $mysqli->real_escape_string(str_replace(array("\r\n", "\n", "\r"), '\n', $_POST['text']));
            $mysqli->query("INSERT INTO messagesForTopicId".$topicId." VALUES (NULL, ".$_COOKIE['id'].", 0, '".$text."', '".$date."', '".$time."', 0, 0, ".$fileStatus.");");
            $messageId = mysqli_fetch_assoc($mysqli->query("SELECT id FROM messagesForTopicId".$topicId." WHERE idUser = '".$_COOKIE['id']."' ORDER BY id DESC LIMIT 1;"));
            if($fileStatus == 1){
                $this->messageFileUpload($mainTopicSrc['topicName'], $topicId, $messageId['id']);
            }
            $mysqli->close();
            relocate('/f/'.$mainTopicSrc['topicName'].'/'.$topicId, 2, 'Сообщение добавлено!');
        }
    }else
        relocate('/f');
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
        }else
            return -1;
    }

    // Обновление топика
    public function changeTopicAction($id){
        if (!empty($_POST) && $_POST['name'] && $_POST['mainTopicSrc']) {
            if(!$_POST['name'] || !topicNameCheck($_POST['name']) || !$_POST['mainTopicSrc'])
                relocate('/f/'.$_POST['mainTopicSrc'].'/'.$id, 3, 'Неверное заполнение некоторых полей!');
            else{
            $mysqli = openmysqli();
            $id = $mysqli->real_escape_string($id);
            $chechUrl = $mysqli->query("SELECT 'topic_id' FROM topic WHERE topic_id = '".$id."';");
            if($chechUrl->num_rows == 0){
                $mysqli->close();
                relocate('/f/'.$_POST['mainTopicSrc'].'/'.$id, 3, 'Топик с не найден!');
            }
            $name = $mysqli->real_escape_string($_POST['name']);
            $mysqli->query("UPDATE topic SET topic_name = '".$name."' WHERE topic_id = '".$id."';");
            $mysqli->close();
            relocate('/f/'.$_POST['mainTopicSrc'].'/'.$id, 2, 'Изменена тема '.$name.'!');
            }
        }else
            relocate('/f');
    }

    public function ratingChAction($movement, $mainTopic, $topicId, $message){
        if (array_key_exists('id', $_COOKIE)) {
            if($movement > 1 || $movement < -1 || $movement == 0){
                relocate('/f/'.$mainTopic.'/'.$topicId, 2, 'Ошибка оценки!');
            }else{
                $mysqli = openmysqli();
                $movement = $mysqli->real_escape_string($movement);
                $mainTopic = $mysqli->real_escape_string($mainTopic);
                $topicId = $mysqli->real_escape_string($topicId);
                $message = $mysqli->real_escape_string($message);

                // Дополнить добавлением в рейтинг юзера (возможно убрать рейтинг сообщения)
                // Разделить модель на 3 файла

                $checkExist = $mysqli->query("SELECT * FROM raitingForTopicId".$topicId." WHERE idUser = ".$_COOKIE['id']." AND idMes = '".$message."';");
                //debug($checkExist);
                if($checkExist->num_rows != 0){
                    $mysqli->close();
                    relocate('/f/'.$mainTopic.'/'.$topicId, 2, 'Оценка уже есть, не хитри!');
                }else{
                    $mesRait = mysqli_fetch_assoc($mysqli->query("SELECT rating FROM messagesForTopicId".$topicId." WHERE id = '".$message."';"));
                    $mysqli->query("UPDATE messagesForTopicId".$topicId." SET rating = '".$mesRait['rating'] + $movement."' WHERE id = '".$message."';");
                    $mesUswrCreator = mysqli_fetch_assoc($mysqli->query("SELECT idUser FROM messagesForTopicId".$topicId." WHERE id = '".$message."';"));
                    $userRait = mysqli_fetch_assoc($mysqli->query("SELECT user_rating FROM users WHERE user_id = '".$mesUswrCreator['idUser']."';"));
                    $mysqli->query("UPDATE users SET user_rating = '".$userRait['user_rating'] + $movement."' WHERE user_id = '".$mesUswrCreator['idUser']."';");
                    $mysqli->query("INSERT INTO raitingForTopicId".$topicId." VALUES (NULL, ".$message.", ".$_COOKIE['id'].", ".$movement.");");
                }
                $mysqli->close();
                relocate('/f/'.$mainTopic.'/'.$topicId, 2, 'Оценка поставлена!');
            }
        }else
            relocate('/f');
    }

    public function selectRating(){

    }

    // Взятие всех топиков по теме
    public function selectAllTopics($urlName){
        $mysqli = openmysqli();
        $urlName = $mysqli->real_escape_string($urlName);
        $topic = mysqli_fetch_assoc($mysqli->query("SELECT id FROM maintopic WHERE topicName = '".$urlName."';"));
        $topics = $mysqli->query("SELECT * FROM topic INNER JOIN users ON topic.idUserCreator = users.user_id AND topic.idMainTopic = '".$topic['id']."';");
        $mysqli->close();
        return $topics;
    }

    public function selectMessages($type, $id){
        $mysqli = openmysqli();
        $topMessage = -1;
        $topType = -1;
        $all;
        if($type == 2){
            $topMessage = $mysqli->query("SELECT * FROM messagesForTopicId".$id." INNER JOIN users ON messagesForTopicId".$id.".idUser = users.user_id AND messagesForTopicId".$id.".atribute = 1;");
            if($topMessage->num_rows == 0){
                $topMessage = $mysqli->query("SELECT * FROM messagesForTopicId".$id." INNER JOIN users ON messagesForTopicId".$id.".idUser = users.user_id AND messagesForTopicId".$id.".rating = (SELECT max(rating) FROM messagesForTopicId".$id.");");
                $topType = 2;
            }else{
                $topType = 1;
            }
            $topMessage = mysqli_fetch_assoc($topMessage);
            $all = $mysqli->query("SELECT * FROM messagesForTopicId".$id." INNER JOIN users ON messagesForTopicId".$id.".idUser = users.user_id AND messagesForTopicId".$id.".id != ".$topMessage['id']." ORDER BY messagesForTopicId".$id.".id DESC;");
        }else{
            $all = $mysqli->query("SELECT * FROM messagesForTopicId".$id." INNER JOIN users ON messagesForTopicId".$id.".idUser = users.user_id ORDER BY messagesForTopicId".$id.".id DESC;");
        }

        $raiting = array();
        array_push($raiting, "0"); // array_search почему-то не видит 1 элемент, поэтому заглушка
        $raitingCount = $mysqli->query("SELECT * FROM raitingForTopicId".$id.";");
        foreach ($raitingCount as $kay){
            array_push($raiting, $kay['idMes'].$kay['idUser']);
        }

        $files = array();
        //array_push($files, "0"); // array_search почему-то не видит 1 элемент, поэтому заглушка
        $filesSelect = $mysqli->query("SELECT id FROM messagesForTopicId".$id." WHERE photo = 1;");
        $allFiles = mysqli_fetch_assoc($mysqli->query("SELECT id FROM messagesForTopicId".$id." WHERE photo = 1 ORDER BY ID DESC LIMIT 1;"));
        $i = 0;
        while ($i < $allFiles['id']){
            array_push($files, "0");
            $i++;
        }
        foreach ($filesSelect as $kay){
            $fulesForMessage = $mysqli->query("SELECT * FROM filesForTopicId".$id." WHERE idMessage = ".$kay['id'].";");
            $fulesForMessageArr = array();
            foreach ($fulesForMessage as $kay2){
                $arr = array('id' => $kay2['id'], 'type' => $kay2['type'], 'ext' => $kay2['ext']);
                array_push($fulesForMessageArr,$arr);
            }
            $files[$kay['id']] = $fulesForMessageArr;
        }
        //debug($fulesForMessageArr);
        //debug($files);

        //debug($raiting);
        $mysqli->close();
        $data = array(
            'topMessage' => $topMessage,
            'topType' => $topType,
            'raiting' => $raiting,
            'files' => $files,
            'all' => $all
        );
        return $data;
    }

    public function upperTopicView($id){
        $mysqli = openmysqli();
        $id = $mysqli->real_escape_string($id);
        $topicViews = mysqli_fetch_assoc($mysqli->query("SELECT viewAllTime, viewLastTime FROM topic WHERE topic_id = '".$id."';"));
        $mysqli->query("UPDATE topic SET viewAllTime = '".++$topicViews['viewAllTime']."', viewLastTime = '".++$topicViews['viewLastTime']."' WHERE topic_id = '".$id."';");
        $mysqli->close();
    }

    public function countTopicMessages($id){
        $mysqli = openmysqli();
        $id = $mysqli->real_escape_string($id);
        $topicCountMessages = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(id) FROM messagesForTopicId".$id.";"));
        $mysqli->close();
        return $topicCountMessages['COUNT(id)'];
    }

    public function topMesAction($mainTopic, $topicId, $message){
        if($message == 1){
            relocate('/f/'.$mainTopic.'/'.$topicId, 3, 'Первое сообщение сделать ответом нельзя!');
        }else{
            $mysqli = openmysqli();
            $message = $mysqli->real_escape_string($message);
            $topicId = $mysqli->real_escape_string($topicId);
            $deletedRaitAttr = $mysqli->query("SELECT id FROM messagesForTopicId".$topicId." WHERE atribute = 1;");
            if($deletedRaitAttr->num_rows != 0){
                $deletedRaitAttr = mysqli_fetch_assoc($deletedRaitAttr);
                $mysqli->query("UPDATE messagesForTopicId".$topicId." SET atribute = 0 WHERE id = ".$deletedRaitAttr['id'].";");
            }
            $mysqli->query("UPDATE messagesForTopicId".$topicId." SET atribute = 1 WHERE id = ".$message.";");
            $mysqli->close();
            relocate('/f/'.$mainTopic.'/'.$topicId, 2, 'Ответ помечен, как лучший!');
        }
    }


    public function deleteMesAction($mainTopic, $topicId, $message){
        if($message == 1){
            relocate('/f/'.$mainTopic.'/'.$topicId, 3, 'Первое сообщение удалить нельзя!');
        }else{
            $mysqli = openmysqli();
            $message = $mysqli->real_escape_string($message);
            $topicId = $mysqli->real_escape_string($topicId);
            $deletedFiles = mysqli_fetch_assoc($mysqli->query("SELECT photo FROM messagesForTopicId".$topicId." WHERE id  = '".$message."';"));
            if($deletedFiles['photo'] == 1){
                $dir = $_SERVER['DOCUMENT_ROOT']."/files/forum/".$mainTopic."/".$topicId."/";
                $deletedFiles = $mysqli->query("SELECT id FROM filesForTopicId".$topicId." WHERE idMessage = '".$message."';");
                foreach ($deletedFiles as $kay){
                    $file = glob($dir.$kay['id'].".*");
                    unlink($file[0]);
                }
                $mysqli->query("DELETE FROM filesForTopicId".$topicId." WHERE idMes = '".$message."';");
            }
            $mysqli->query("DELETE FROM raitingForTopicId".$topicId." WHERE idMessage = '".$message."';");
            $mysqli->query("DELETE FROM messagesForTopicId".$topicId." WHERE id  = '".$message."';");
            $mysqli->close();
            relocate('/f/'.$mainTopic.'/'.$topicId, 2, 'Сообщение удалено!');
        }
    } 

    // Удаление топика
    public function deleteTopicAction($id){
        $mysqli = openmysqli();
        $id = $mysqli->real_escape_string($id);
        $deletedTopic = mysqli_fetch_assoc($mysqli->query("SELECT * FROM topic WHERE topic_id  = '".$id."';"));
        $mainTopic = mysqli_fetch_assoc($mysqli->query("SELECT topicName FROM maintopic WHERE id = '".$deletedTopic['idMainTopic']."';"));
        $dir = $_SERVER['DOCUMENT_ROOT']."/files/forum/".$mainTopic['topicName']."/".$id;
        $this->deleteFolder($dir);
        $mysqli->query("DROP TABLE filesForTopicId".$id.";");
        $mysqli->query("DROP TABLE messagesForTopicId".$id.";");
        $mysqli->query("DROP TABLE raitingForTopicId".$id.";");
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