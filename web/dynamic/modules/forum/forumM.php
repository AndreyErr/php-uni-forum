<?php

use system\model;

require_once 'lib/formCheck.php'; // Проверка форм

class forumM extends model{
    
    // Взятие главных тем
    public function selectUnits($quantity = 100){
        return parent::selectUnits($quantity);
    }

    // Создание главной темы
    public function addUnitAction(){
        if (chAccess("unit") && !empty($_POST)) {
            if(!$_POST['name'] || !unitNameCheck($_POST['name']) || !$_POST['icon'] || !$_POST['descr'])
                parent::relocate('/f', 3, 'Неверное заполнение некоторых полей!');
            elseif(!unitIconCheck($_POST['icon']))
                parent::relocate('/f', 3, 'Неправильно заполнено поле иконки!');
            elseif(!unitDescrCheck($_POST['descr']))
                parent::relocate('/f', 3, 'Неправильно заполнено поле описания!');
            else{
            $mysqli = openmysqli();
            $name = $mysqli->real_escape_string($_POST['name']);
            $unitUrl = $mysqli->real_escape_string($this->translitToUrl($_POST['name']));
            $chechUrl = $mysqli->query("SELECT unitId FROM unit WHERE unitUrl = '".$unitUrl."';");
            if($chechUrl->num_rows != 0){
                $mysqli->close();
                parent::relocate('/f', 3, 'Топик с таким преобразованным URL ('.$name.' -> '.$unitUrl.') уже существует: <a href="/f/'.$unitUrl.'">'.$unitUrl.'</a>!');
                exit;
            }
            $date = date("Y-m-d");
            $icon = $mysqli->real_escape_string($_POST['icon']);
            $descr = $mysqli->real_escape_string($_POST['descr']);
            $mysqli->query("INSERT INTO unit VALUES (NULL, '".$unitUrl."', '".$name."', '".$descr."', '".$date."', '".$icon."');");
            $mysqli->close();
            mkdir($_SERVER['DOCUMENT_ROOT']."/files/forum/".$unitUrl);
            parent::relocate('/f/'.$unitUrl, 2, 'Добавлена тема <a href="/f/'.$unitUrl.'">'.$name.'</a>!');
            }
        }else
        parent::relocate('/f');
    }

    // Перевод русского текста в английский
    private function translitToUrl($value){
        $converter = array(
            'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
            'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
            'й' => 'i',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
            'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
            'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
            'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
            'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
        );    
        $value = mb_strtolower($value);
        $value = strtr($value, $converter);
        $value = mb_ereg_replace('[^-0-9a-z]', '-', $value);
        $value = mb_ereg_replace('[-]+', '-', $value);
        $value = trim($value, '-');	    
        return $value;
    }

    // Обновление главной темы
    public function changeUnitAction(){
        if (chAccess("unit") && !empty($_POST) && $_POST['url']) {
            if(!$_POST['name'] || !unitNameCheck($_POST['name']) || !$_POST['icon'] || !$_POST['descr'])
                parent::relocate('/f/'.$_POST['url'], 3, 'Неверное заполнение некоторых полей!');
            elseif(!unitIconCheck($_POST['icon']))
                parent::relocate('/f/'.$_POST['url'], 3, 'Неправильно заполнено поле иконки!');
            elseif(!unitDescrCheck($_POST['descr']))
                parent::relocate('/f/'.$_POST['url'], 3, 'Неправильно заполнено поле описания!');
            else{
            $mysqli = openmysqli();
            $unitUrl = $mysqli->real_escape_string($_POST['url']);
            $chechUrl = $mysqli->query("SELECT unitId FROM unit WHERE unitUrl = '".$unitUrl."';");
            if($chechUrl->num_rows == 0){
                $mysqli->close();
                parent::relocate('/f/'.$unitUrl, 3, 'Топик с таким не найден');
            }
            $name = $mysqli->real_escape_string($_POST['name']);
            $icon = $mysqli->real_escape_string($_POST['icon']);
            $descr = $mysqli->real_escape_string($_POST['descr']);
            $mysqli->query("UPDATE unit SET name = '".$name."', descr = '".$descr."', icon = '".$icon."' WHERE unitUrl = '".$unitUrl."';");
            $mysqli->close();
            parent::relocate('/f/'.$unitUrl, 2, 'Изменена тема '.$name.'!');
            }
        }else
            parent::relocate('/f');
    }

    // Взятие темы
    public function selectAllAboutUnit($unitUrl){
        $mysqli = openmysqli();
        $unitUrl = $mysqli->real_escape_string($unitUrl);
        $topic = mysqli_fetch_assoc($mysqli->query("SELECT * FROM unit WHERE unitUrl  = '".$unitUrl."';"));
        $mysqli->close();
        if(!$topic)
            $topic = -1;
        return $topic;
    }

    // Создание подтемы
    public function addTopicAction($unit){
        if (!empty($_POST) && chAccess("topic")) {
            if(!$_POST['name'] || !topicNameCheck($_POST['name']) || !$_POST['type'] || !$_POST['text'] || $_POST['type'] < 1 || $_POST['type'] > 2)
                parent::relocate('/f/'.$unit, 3, 'Неверное заполнение некоторых полей!');
            elseif(!topicTextCheck($_POST['text']))
                parent::relocate('/f/'.$unit, 3, 'Неправильно заполнено поле сообщения!');
            else{
                $mysqli = openmysqli();
                $chechUrl = mysqli_fetch_assoc($mysqli->query("SELECT unitId FROM unit WHERE unitUrl = '".$unit."';"));
                if($chechUrl == NULL){
                    $mysqli->close();
                    parent::relocate('/f', 3, 'Темы не существует!');
                }
                $name = $mysqli->real_escape_string($_POST['name']);
                $type = $mysqli->real_escape_string($_POST['type']);
                $date = date("Y-m-d");
                $time = date("H:i:s");
                $text = $mysqli->real_escape_string(str_replace(array("\r\n", "\n", "\r"), '\n', $_POST['text']));
                $mysqli->query("INSERT INTO topic VALUES (NULL, ".$_COOKIE['id'].", ".$chechUrl['unitId'].", '".$date."', '".$name."', ".$type.", 0);");
                $topicId = mysqli_fetch_assoc($mysqli->query("SELECT topicId FROM topic WHERE idUserCreator = '".$_COOKIE['id']."' ORDER BY topicId DESC;"));

                $mysqli->query("
                CREATE TABLE messagesForTopicId".$topicId['topicId']." (
                    messageId int(11) NOT NULL AUTO_INCREMENT,
                    idUser int(11) NOT NULL COMMENT 'id пользователя написавшего сообщение',
                    message text NOT NULL,
                    idMesRef int(11) NOT NULL COMMENT 'id сообщения, на который дан ответ',
                    date date NOT NULL,
                    time time NOT NULL,
                    rating int(11) NOT NULL COMMENT 'Рейтинг сообщения',
                    atribute int(11) NOT NULL COMMENT 'Атрибуты (используется как индикатор ответа на вопрос)',
                    files int(11) NOT NULL COMMENT 'Флаг наличия файлов',
                    PRIMARY KEY (messageId)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                ");
                
                $mysqli->query("
                CREATE TABLE filesForTopicId".$topicId['topicId']." (
                    fileId int(11) NOT NULL AUTO_INCREMENT,
                    idMessage int(11) NOT NULL COMMENT 'К какому сообщению принадлежат файлы',
                    type varchar(80) NOT NULL COMMENT 'Mime-тип файла',
                    ext varchar(80) NOT NULL COMMENT 'Присланное расширение файла',
                    PRIMARY KEY (fileId)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                ");

                mkdir($_SERVER['DOCUMENT_ROOT']."/files/forum/".$unit."/".$topicId['topicId']);

                $fileStatus = $this->messageFileUpload($unit, $topicId['topicId'], '1');
                if ($fileStatus == 'OK')
                    $fileStatus = 1;
                elseif($fileStatus == 'OK_NO_FILE')
                    $fileStatus = 0;
                else{
                    $deleteTopicStatus = $this->deleteTopic($topicId['topicId'], $unit);
                    if($deleteTopicStatus == 'OK')
                        parent::relocate('/f/'.$unit, 3, $fileStatus);
                    else
                        parent::relocate('/f/'.$unit, 3, 'Ошибка отката создания топика: '.$deleteTopicStatus.'!');
                }

                $mysqli->query("INSERT INTO messagesForTopicId".$topicId['topicId']." VALUES (NULL, ".$_COOKIE['id'].", '".$text."', 0, '".$date."', '".$time."', 0, 0, ".$fileStatus.");");

                $mysqli->query("
                CREATE TABLE raitingForTopicId".$topicId['topicId']." (
                  raitId int(11) NOT NULL AUTO_INCREMENT,
                  idMes int(11) NOT NULL,
                  idUser int(11) NOT NULL,
                  rait int(11) NOT NULL,
                  PRIMARY KEY (raitId)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                ");
                $mysqli->close();
                parent::relocate('/f/'.$unit.'/'.$topicId['topicId'], 2, 'Добавлена тема <a href="/f/'.$unit.'/'.$topicId['topicId'].'">'.$name.'</a>!');
            }
        }else
            parent::relocate('/f');
    }

    // Загрузка файлов для сообщений
    private function messageFileUpload($unitUrl, $topicId, $messageId){// тема, топик, id сообщения
        $fileUploadStatus = "Неизвестная ошибка при загрузке файлов (messageFileUpload)";
        if($_FILES['messageFiles']["type"][0] != "" && (count($_FILES['messageFiles']['name']) > parent::specialDataGet('fileData/messageFiles/maxFilesCount'))){
            return 'Слишком много файлов, можно загрузить не более '.parent::specialDataGet('fileData/messageFiles/maxFilesCount').'!';
        }elseif($_FILES['messageFiles']["type"][0] != ""){

            // Группировка данных из $_FILES['messageFiles'] по файлам 
            $files = array();
            foreach($_FILES['messageFiles'] as $k => $l) {
                foreach($l as $i => $v) {
                    $files[$i][$k] = $v;
                }
            }		
            $_FILES['messageFiles'] = $files;

            $mysqli = openmysqli();
            foreach($_FILES['messageFiles'] as $k) {
                $fileFormat = $k['type'];
                $fileName = $k['name'];
                $fileFormat = explode('/',$fileFormat)[1];
                $unitUrl = $mysqli->real_escape_string($unitUrl);
                $topicId = $mysqli->real_escape_string($topicId);
                $messageId = $mysqli->real_escape_string($messageId);
                $fileExt = explode('.',$fileName);
                $fileExt = strtolower(end($fileExt)); // END требует передачи по ссылке, поэтому в 2 строки!
                //////ПЕРЕДЕЛАТЬ
                $mysqli->query("INSERT INTO filesForTopicId".$topicId." VALUES (NULL, ".$messageId.", '".$fileFormat."', '".$fileExt."');");
                $fileId = mysqli_fetch_assoc($mysqli->query("SELECT fileId FROM filesForTopicId".$topicId." WHERE idMessage = ".$messageId." ORDER BY fileId DESC LIMIT 1;"));
                ///////////////
                $fileUploadStatus = parent::fileUpload('messageFiles', $k, $fileId['fileId'], '', $unitUrl."/".$topicId."/");
                if ($fileUploadStatus == 'OK') {
                    return "OK";
                }
            }
            $mysqli->close();
            return $fileUploadStatus;
        }else{
            return 'OK_NO_FILE';
        }
    }

    // Создание сообщения
    public function addMessageAction($topicId){
    if (chAccess("topic") && !empty($_POST) && array_key_exists('login', $_COOKIE)) {
        $mysqli = openmysqli();
        $topicId = $mysqli->real_escape_string($topicId);
        $unitSrc = mysqli_fetch_assoc($mysqli->query("SELECT idUnit  FROM topic WHERE topicId  = '".$topicId."';"));
        $unitSrc = mysqli_fetch_assoc($mysqli->query("SELECT unitId, unitUrl FROM unit WHERE unitId = '".$unitSrc['idUnit']."';"));
        $mysqli->close();
        if(!$_POST['text'])
        parent::relocate('/f/'.$unitSrc['unitUrl'].'/'.$topicId, 3, 'Неверное заполнение некоторых полей!');
        elseif(!topicTextCheck($_POST['text']))
            parent::relocate('/f/'.$unitSrc['unitUrl'].'/'.$topicId, 3, 'Неправильно заполнено поле сообщения!');
        else{
            $fileStatus = 0;
            if ($_FILES['messageFiles']["type"][0] != "")
                $fileStatus = 1;
            $mysqli = openmysqli(); 
            $ref = $mysqli->real_escape_string(trim($_POST['ref']));
            $messSrc = $mysqli->query("SELECT messageId FROM messagesForTopicId".$topicId." WHERE messageId = ".$ref.";");
            if($messSrc == NULL || $messSrc->num_rows == 0)
                $ref = 0;     
            $date = date("Y-m-d");
            $time = date("H:i:s");
            $text = $mysqli->real_escape_string(str_replace(array("\r\n", "\n", "\r"), '\n', $_POST['text']));
            // ПОМЕНЯТЬ НА ТРАНЗАКЦИИ
            $mysqli->query("INSERT INTO messagesForTopicId".$topicId." VALUES (NULL, ".$_COOKIE['id'].", '".$text."', ".$ref.", '".$date."', '".$time."', 0, 0, ".$fileStatus.");");
            $messageId = mysqli_fetch_assoc($mysqli->query("SELECT messageId FROM messagesForTopicId".$topicId." WHERE idUser = '".$_COOKIE['id']."' ORDER BY messageId DESC LIMIT 1;"));
            ///////////////////////////
            $mysqli->close();
            $fileStatus = $this->messageFileUpload($unitSrc['unitUrl'], $topicId, $messageId['messageId']);
            if($fileStatus != 'OK' && $fileStatus != 'OK_NO_FILE'){
                $deleteMessageStatus = $this->deleteMesage($unitSrc['unitId'], $topicId, $messageId['messageId']);
                if($deleteMessageStatus == 'OK')
                    parent::relocate('/f/'.$unitSrc['unitUrl'].'/'.$topicId, 3, $fileStatus);
                else
                    parent::relocate('/f/'.$unitSrc['unitUrl'].'/'.$topicId, 3, 'Ошибка отката сообщения сообщения: '.$deleteMessageStatus.'!');
            }
            parent::relocate('/f/'.$unitSrc['unitUrl'].'/'.$topicId, 2, 'Сообщение добавлено!');
        }
    }else
        parent::relocate('/f');
    }

    // Взятие всего о топике
    public function selectAllAboutTopic($topicId){
        if(is_numeric($topicId)){
            $mysqli = openmysqli();
            $topicId = $mysqli->real_escape_string($topicId);
            $topic = mysqli_fetch_assoc($mysqli->query("SELECT * FROM topic LEFT JOIN users ON topic.idUserCreator = users.userId WHERE  topic.topicId = '".$topicId."';"));
            $mysqli->close();
            if(!$topic)
                $topic = -1;
            return $topic;
        }else
            return -1;
    }

    // Обновление топика
    public function changeTopicAction($id){
        if (!empty($_POST) && $_POST['name'] && $_POST['unitSrc'] && chAccess("topic")) {
            if(!$_POST['name'] || !topicNameCheck($_POST['name']) || !$_POST['unitSrc'])
                parent::relocate('/f/'.$_POST['unitSrc'].'/'.$id, 3, 'Неверное заполнение некоторых полей!');
            else{
                $mysqli = openmysqli();
                $id = $mysqli->real_escape_string($id);
                $chechUrl = $mysqli->query("SELECT * FROM topic WHERE topicId = '".$id."';");
                if($chechUrl->num_rows == 0){
                    $mysqli->close();
                    parent::relocate('/f/'.$_POST['unitSrc'].'/'.$id, 3, 'Топик с не найден!');
                }
                $chechUrl = mysqli_fetch_assoc($chechUrl);
                if(chAccess("controlTopic") || $chechUrl['idUserCreator'] == $_COOKIE['id']){
                    $name = $mysqli->real_escape_string($_POST['name']);
                    $mysqli->query("UPDATE topic SET topicName = '".$name."' WHERE topicId = '".$id."';");
                    $mysqli->close();
                    parent::relocate('/f/'.$_POST['unitSrc'].'/'.$id, 2, 'Изменена тема '.$name.'!');
                }else
                    parent::relocate('/f/'.$_POST['unitSrc'].'/'.$id, 3, 'У вас нет прав изменять топик!');
            }
        }else
            parent::relocate('/f');
    }

    // Установка оценки
    public function ratingChAction($movement, $unit, $topicId, $message){
        if (array_key_exists('id', $_COOKIE)) {
            if($movement > 1 || $movement < -1 || $movement == 0){
                parent::relocate('/f/'.$unit.'/'.$topicId, 2, 'Ошибка оценки!');
            }else{
                $mysqli = openmysqli();
                $movement = $mysqli->real_escape_string($movement);
                $unit = $mysqli->real_escape_string($unit);
                $topicId = $mysqli->real_escape_string($topicId);
                $message = $mysqli->real_escape_string($message);
                $checkExist = $mysqli->query("SELECT * FROM raitingForTopicId".$topicId." WHERE idUser = ".$_COOKIE['id']." AND idMes = '".$message."';");
                if($checkExist->num_rows != 0){
                    $mysqli->close();
                    parent::relocate('/f/'.$unit.'/'.$topicId, 2, 'Оценка уже есть, не хитри!');
                }else{
                    $mesRait = mysqli_fetch_assoc($mysqli->query("SELECT rating FROM messagesForTopicId".$topicId." WHERE messageId = '".$message."';"));
                    $mysqli->query("UPDATE messagesForTopicId".$topicId." SET rating = '".$mesRait['rating'] + $movement."' WHERE messageId = '".$message."';");
                    $mesUswrCreator = mysqli_fetch_assoc($mysqli->query("SELECT idUser FROM messagesForTopicId".$topicId." WHERE messageId = '".$message."';"));
                    $userRait = mysqli_fetch_assoc($mysqli->query("SELECT userRating FROM users WHERE userId = '".$mesUswrCreator['idUser']."';"));
                    if($userRait)
                        $mysqli->query("UPDATE users SET userRating = '".$userRait['userRating'] + $movement."' WHERE userId = '".$mesUswrCreator['idUser']."';");
                    $mysqli->query("INSERT INTO raitingForTopicId".$topicId." VALUES (NULL, ".$message.", ".$_COOKIE['id'].", ".$movement.");");
                }
                $mysqli->close();
                parent::relocate('/f/'.$unit.'/'.$topicId, 2, 'Оценка поставлена!');
            }
        }else
            parent::relocate('/f');
    }

    // Взятие всех топиков по теме
    public function selectAllTopics($unitUrl){
        $mysqli = openmysqli();
        $unitUrl = $mysqli->real_escape_string($unitUrl);
        $unit = mysqli_fetch_assoc($mysqli->query("SELECT unitId FROM unit WHERE unitUrl = '".$unitUrl."';"));
        $topics = $mysqli->query("SELECT * FROM topic LEFT JOIN users ON topic.idUserCreator = users.userId WHERE topic.idUnit = '".$unit['unitId']."' ORDER BY topic.topicId DESC;");
        $mysqli->close();
        return $topics;
    }

    // Взятие всех топиков по форме поиска
    public function findTopicsAction(){
        if($_POST['find']){
            $mysqli = openmysqli();
            $find = $mysqli->real_escape_string($_POST['find']);
            $topics = $mysqli->query("SELECT * FROM topic LEFT JOIN users ON topic.idUserCreator = users.userId LEFT JOIN unit ON topic.idUnit = unit.unitId WHERE topic.topicName LIKE '%".$find."%' ORDER BY topic.topicId DESC;");
            $mysqli->close();
            return $topics;
        }else
            return -1;
    }

    // Взятие сообщений из бд
    public function selectMessages($type, $id){
        $mysqli = openmysqli();
        $topMessage = -1;
        $topType = -1;
        $all = -1;
        if($type == 2){
            $topMessage = $mysqli->query("SELECT * FROM messagesForTopicId".$id." LEFT JOIN users ON messagesForTopicId".$id.".idUser = users.userId WHERE messagesForTopicId".$id.".atribute = 1;");
            if($topMessage->num_rows == 0){
                $topMessage = $mysqli->query("SELECT * FROM messagesForTopicId".$id." LEFT JOIN users ON messagesForTopicId".$id.".idUser = users.userId WHERE messagesForTopicId".$id.".rating = (SELECT max(rating) FROM messagesForTopicId".$id.");");
                $topType = 2;
            }else{
                $topType = 1;
            }
            $topMessage = mysqli_fetch_assoc($topMessage);
            $all = $mysqli->query("SELECT * FROM messagesForTopicId".$id." LEFT JOIN users ON messagesForTopicId".$id.".idUser = users.userId WHERE messagesForTopicId".$id.".messageId != ".$topMessage['messageId']." ORDER BY messagesForTopicId".$id.".messageId DESC;");
        }else{
            $all = $mysqli->query("SELECT * FROM messagesForTopicId".$id." LEFT JOIN users ON messagesForTopicId".$id.".idUser = users.userId ORDER BY messagesForTopicId".$id.".messageId DESC;");
        }

        // Выборка рейтинга для сообщений
        $raiting = array();
        array_push($raiting, "0");
        $raitingCount = $mysqli->query("SELECT * FROM raitingForTopicId".$id.";");
        foreach ($raitingCount as $kay){
            array_push($raiting, $kay['idMes'].$kay['idUser']);
        }

        // Выборка файлов для сообщений
        $files = array();
        $filesSelect = $mysqli->query("SELECT messageId FROM messagesForTopicId".$id." WHERE files = 1;");
        $allFiles = mysqli_fetch_assoc($mysqli->query("SELECT messageId FROM messagesForTopicId".$id." WHERE files = 1 ORDER BY messageId DESC LIMIT 1;"));
        $i = 0;
        if($allFiles != NULL)
            while ($i < $allFiles['messageId']){
                array_push($files, "0");
                $i++;
            }
        if($allFiles != NULL)
            foreach ($filesSelect as $kay){
                $fulesForMessage = $mysqli->query("SELECT * FROM filesForTopicId".$id." WHERE idMessage = ".$kay['messageId'].";");
                $fulesForMessageArr = array();
                foreach ($fulesForMessage as $kay2){
                    $arr = array('fileId' => $kay2['fileId'], 'type' => $kay2['type'], 'ext' => $kay2['ext']);
                    array_push($fulesForMessageArr,$arr);
                }
                $files[$kay['messageId']] = $fulesForMessageArr;
            }
        $i = 0;
        if($allFiles != NULL)
            while ($i < $allFiles['messageId']){
                if($files[$i] == "0")
                    unset($files[$i]);
                $i++;
            }

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

    // Взятие сообщений из бд (Короткая версия)
    public function selectMessagesSmalVers($id){
        $mysqli = openmysqli();
        $all = $mysqli->query("SELECT * FROM messagesForTopicId".$id." LEFT JOIN users ON messagesForTopicId".$id.".idUser = users.userId ORDER BY messagesForTopicId".$id.".messageId DESC;");
        $mysqli->close();
        return $all;
    }

    // Поднятие рейтинга
    public function upperTopicView($id){
        $mysqli = openmysqli();
        $id = $mysqli->real_escape_string($id);
        $topicViews = mysqli_fetch_assoc($mysqli->query("SELECT viewAllTime FROM topic WHERE topicId = '".$id."';"));
        $mysqli->query("UPDATE topic SET viewAllTime = '".++$topicViews['viewAllTime']."' WHERE topicId = '".$id."';");
        $mysqli->close();
    }

    // Подсчёт кол-ва сообщений
    public function countTopicMessages($id){
        $mysqli = openmysqli();
        $id = $mysqli->real_escape_string($id);
        $topicCountMessages = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(messageId) FROM messagesForTopicId".$id.";"));
        $mysqli->close();
        return $topicCountMessages['COUNT(messageId)'];
    }

    // Пометить как ответ на вопрос или самы популярный ответ
    public function topMesAction($unit, $topicId, $message){
        if($message == 1){
            parent::relocate('/f/'.$unit.'/'.$topicId, 3, 'Первое сообщение сделать ответом нельзя!');
        }else{
            $mysqli = openmysqli();
            $message = $mysqli->real_escape_string($message);
            $topicId = $mysqli->real_escape_string($topicId);
            $deletedRaitAttr = $mysqli->query("SELECT messageId FROM messagesForTopicId".$topicId." WHERE atribute = 1;");
            if($deletedRaitAttr->num_rows != 0){
                $deletedRaitAttr = mysqli_fetch_assoc($deletedRaitAttr);
                $mysqli->query("UPDATE messagesForTopicId".$topicId." SET atribute = 0 WHERE messageId = ".$deletedRaitAttr['messageId'].";");
            }
            $mysqli->query("UPDATE messagesForTopicId".$topicId." SET atribute = 1 WHERE messageId = ".$message.";");
            $mysqli->close();
            parent::relocate('/f/'.$unit.'/'.$topicId, 2, 'Ответ помечен, как лучший!');
        }
    }

    // Удаление сообщения
    public function deleteMesAction($unit, $topicId, $message){
        if($message == 1){
            parent::relocate('/f/'.$unit.'/'.$topicId, 3, 'Первое сообщение удалить нельзя!');
        }else{

            $deleteMessageStatus = $this->deleteMesage($unit, $topicId, $message);

            if($deleteMessageStatus == 'OK')
                parent::relocate('/f/'.$unit.'/'.$topicId, 2, 'Сообщение удалено!');
            else
                parent::relocate('/f/'.$unit.'/'.$topicId, 3, $deleteMessageStatus);
        }
    } 

    // Удаление сообщения
    private function deleteMesage($unit, $topicId, $message){
        if(chAccess("topic")){
            $mysqli = openmysqli();
            $topicId = $mysqli->real_escape_string($topicId);
            $messageDel = mysqli_fetch_assoc($mysqli->query("SELECT idUser FROM messagesForTopicId".$topicId." WHERE messageId  = '".$message."';"));
            if(chAccess("controlTopic") || $messageDel['idUser'] == $_COOKIE['id']){
                $deletedFiles = mysqli_fetch_assoc($mysqli->query("SELECT files FROM messagesForTopicId".$topicId." WHERE messageId  = '".$message."';"));
                if($deletedFiles['files'] == 1){
                    $dir = parent::specialDataGet('FILE_SERVER').parent::specialDataGet('fileData/messageFiles/folder').$unit."/".$topicId."/";
                    $deletedFiles = $mysqli->query("SELECT fileId FROM filesForTopicId".$topicId." WHERE idMessage = '".$message."';");
                    foreach ($deletedFiles as $kay){
                        $file = glob($dir.$kay['fileId'].".*");
                        if(isset($file[0]))
                            unlink($file[0]);
                    }
                    $mysqli->query("DELETE FROM filesForTopicId".$topicId." WHERE idMes = '".$message."';");
                }
                $mysqli->query("DELETE FROM raitingForTopicId".$topicId." WHERE idMessage = '".$message."';");
                $mysqli->query("DELETE FROM messagesForTopicId".$topicId." WHERE messageId  = '".$message."';");
                $mysqli->close();
                return 'OK';
            }else
                return 'У вас нет прав для удаления сообщения!';
        }
        return 'У вас нет прав для удаления сообщения!';
    } 

    // Удаление топика
    public function deleteTopicAction($id){
            $mysqli = openmysqli();
            $id = $mysqli->real_escape_string($id);
            $deletedTopic = mysqli_fetch_assoc($mysqli->query("SELECT * FROM topic WHERE topicId  = '".$id."';"));
            $unit = mysqli_fetch_assoc($mysqli->query("SELECT unitUrl FROM unit WHERE unitId = '".$deletedTopic['idUnit']."';"));
            $mysqli->close();
            $deleteTopicStatus = $this->deleteTopic($id, $unit['unitUrl']);
            if($deleteTopicStatus == 'OK')
                parent::relocate('/f/'.$unit['unitUrl'], 2, 'Удалён топик '.$deletedTopic['topicName'].'!');
            else
                parent::relocate('/f/'.$unit['unitUrl'], 3, $deleteTopicStatus);
    }

    // Удаление топика
    private function deleteTopic($id, $unitUrl){
        if(chAccess("topic")){
            $mysqli = openmysqli();
            $id = $mysqli->real_escape_string($id);
            $deletedTopic = mysqli_fetch_assoc($mysqli->query("SELECT * FROM topic WHERE topicId  = '".$id."';"));
            if(chAccess("controlTopic") || $deletedTopic['idUserCreator'] == $_COOKIE['id']){
                $dir = parent::specialDataGet('FILE_SERVER').parent::specialDataGet('fileData/messageFiles/folder').$unitUrl."/".$id;
                $this->deleteFolder($dir);
                $mysqli->query("DROP TABLE IF EXISTS filesForTopicId".$id.";");
                $mysqli->query("DROP TABLE IF EXISTS messagesForTopicId".$id.";");
                $mysqli->query("DROP TABLE IF EXISTS raitingForTopicId".$id.";");
                $mysqli->query("DELETE FROM topic WHERE topicId  = '".$id."';");
                $mysqli->close();
                return 'OK';
            }else{
                $mysqli->close();
                return 'У вас нет прав на удаление топика '.$deletedTopic['topicName'].'!';
            }
        }else
            return 'Ошибка доступа!';
    }

    // Удаление главной темы
    public function deleteUnitAction($id){
        if(chAccess("unit")){
            $mysqli = openmysqli();
            $id = $mysqli->real_escape_string($id);
            $deletedSubTopics = $mysqli->query("SELECT topicId FROM topic WHERE idUnit  = '".$id."';");
            $deletedUnit = mysqli_fetch_assoc($mysqli->query("SELECT unitUrl FROM unit WHERE unitId  = '".$id."';"));
            foreach ($deletedSubTopics as $kay){
                $this->deleteTopicAction($kay['topicId']);
            }
            $dir = $_SERVER['DOCUMENT_ROOT']."/files/forum/".$deletedUnit['unitUrl'];
            $this->deleteFolder($dir);
            $mysqli->query("DELETE FROM unit WHERE unitId  = '".$id."';");
            $mysqli->close();
            parent::relocate('/f', 2, 'Удалена тема '.$deletedUnit['unitUrl'].' со всеми подтемами!');
        }else
            parent::relocate('/');
    }

    // Удаление папки со всем содержимым
    private function deleteFolder($path){
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