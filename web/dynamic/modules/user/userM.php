<?php

use system\model;

require_once 'lib/formCheck.php'; // Проверка форм

class userM extends model{
    
    // Регистрация пользователя
    public function regAction(){
        if (!empty($_POST) && !chAccess("reg")) {
            if(!passCheck($_POST['pass']) || $_POST['pass'] != $_POST['pass2'] || !nameCheck($_POST['name']) || !loginCheck($_POST['login']) || !emailCheck($_POST['email']))
                parent::relocate('/u/reg', 3, 'Ошибка регистрации: неправильный формат некоторых полей!');
            else{
                $mysqli = openmysqli();
                $login = $mysqli->real_escape_string($_POST['login']);
                $testLogin = $mysqli->query("SELECT userId FROM users WHERE login = '".$login."';");
                if($testLogin->num_rows >= 1){
                    parent::relocate('/u/reg', 3, 'Пользователь с логином '.$login .' уже существует!');
                    $mysqli->close();
                }else{
                    $name = mb_convert_case($mysqli->real_escape_string($_POST['name']), MB_CASE_TITLE, "UTF-8");
                    $photo = rand(-1, -9); // Включительно
                    $pass = hashPass($mysqli->real_escape_string($_POST['pass']));
                    $email = $mysqli->real_escape_string($_POST['email']);
                    $date = date("Y-m-d");
                    $mysqli->query("INSERT INTO users VALUES (NULL, '".$login."', 0, '".$name."', '".$email."', '".$pass."', ".$photo.", '".$date."', 0);");
                }
                $id = mysqli_fetch_assoc($mysqli->query("SELECT userId FROM users WHERE login = '".$login."';"));
                $mysqli->close();
                $cookTime = time()+(3600);
                setcookie("id", $id['userId'], $cookTime, "/");
                setcookie("login", encode($_POST['login']), $cookTime, "/");
                setcookie("status", encode('0'), $cookTime, "/");
                setcookie("photo", $photo, $cookTime, "/");
                parent::relocate('/u', 2, 'Добро пожаловать на форум, '.$name);
            }
        }else
            parent::relocate('/');
    }

    // Авторизация пользователя
    public function authorizeAction(){
        if (!empty($_POST) && !chAccess("login")) {
            if(!$_POST['pass'] || !loginCheck($_POST['login']))
                parent::relocate('/', 3, 'Неверные логин или пароль!');
            else{
                $mysqli = openmysqli();
                $login = $mysqli->real_escape_string($_POST['login']);
                $pass = $mysqli->real_escape_string($_POST['pass']);
                $userCh = $mysqli->query("SELECT * FROM users WHERE login = '".$login."';");
                $userban = $mysqli->query("SELECT * FROM usersBanOnSite WHERE loginUser = '".$login."';");
                $user = mysqli_fetch_assoc($userCh);
                $mysqli->close();
                if($userCh->num_rows == 0 || !password_verify($pass, $user['pass']))
                    parent::relocate('/', 3, 'Неверные логин или пароль или пользователя не существует!');
                elseif($userban->num_rows != 0){
                    parent::relocate('/', 3, 'Данный аккаунт заблокирован на сайте!');
                }else{
                    $cookTime = 0;
                    if(array_key_exists('rememb', $_POST) && $_POST['rememb'] == "yes")
                        $cookTime = time()+(3600 * 24 * 10);
                    else
                        $cookTime = time()+(3600);
                    if($user['photo'] == 0)
                        $photo = $user['userId'];
                    else 
                        $photo = $user['photo'];
                    setcookie("id", $user['userId'], $cookTime, "/");
                    setcookie("login", encode($user['login']), $cookTime, "/");
                    setcookie("status", encode($user['status']), $cookTime, "/");
                    setcookie("photo", $photo, $cookTime, "/");
                    parent::relocate('/u');
                }
            }
        }else
            parent::relocate('/');
    }

    // Смена имени
    public function changeNameAction(){
        if (chAccess("сhInProfile") && (!empty($_POST) || $_COOKIE['login'])) {
            if(!nameCheck($_POST['name']))
                parent::relocate('/u', 3, 'Неправильный формат имени!');
            else{
                $mysqli = openmysqli();
                $name = mb_convert_case($mysqli->real_escape_string($_POST['name']), MB_CASE_TITLE, "UTF-8");
                $mysqli->query("UPDATE users SET name = '".$name."' WHERE login = '".decode($_COOKIE['login'])."';");
                $mysqli->close();
                parent::relocate('/u', 2, 'Имя изменено на '.$name);
            }
        }else
            parent::relocate('/');
    }

    // Смена пароля
    public function changePassAction(){
        if (!empty($_POST) && chAccess("сhInProfile")) {
            if(!$_POST['oldPass'] || !passCheck($_POST['pass']) || $_POST['pass'] != $_POST['pass2'])
                parent::relocate('/u', 3, 'Неправильный формат нового пароля или проверка повторения пароля не прошла!');
            else{
                $mysqli = openmysqli();
                $oldPass = $mysqli->real_escape_string($_POST['oldPass']);
                $pass = hashPass($mysqli->real_escape_string($_POST['pass']));
                $testPass = mysqli_fetch_assoc($mysqli->query("SELECT pass FROM users WHERE login = '".decode($_COOKIE['login'])."';"));
                if(!$testPass['pass'] || !password_verify($oldPass, $testPass['pass'])){
                    $mysqli->close();
                    parent::relocate('/u', 3, 'Неверный старый пароль! Вспомните его для смены или создайте новый аккаунт!');
                }else
                    $mysqli->query("UPDATE users SET pass = '".$pass."' WHERE login = '".decode($_COOKIE['login'])."';");
                $mysqli->close();
                parent::relocate('/u', 2, 'Пароль был изменён!');
            }
        }else
            parent::relocate('/');
    }

    // Смена email
    public function changeEmailAction(){
        if (!empty($_POST) && chAccess("сhInProfile")) {
            if(!emailCheck($_POST['email']))
                parent::relocate('/u', 3, 'Неправильный формат email!');
            else{
                $mysqli = openmysqli();
                $email = $mysqli->real_escape_string($_POST['email']);
                $mysqli->query("UPDATE users SET email = '".$email."' WHERE login = '".decode($_COOKIE['login'])."';");
                $mysqli->close();
                parent::relocate('/u', 2, 'Email изменён на '.$email);
            }
        }else
            parent::relocate('/');
    }

    // Изменение аватарки
    public function updatePhotoAction(){
        if(chAccess("сhInProfile")){
            $uploaddir = $_SERVER['DOCUMENT_ROOT'].'/files/img/avatar/';
            if (!empty($_FILES)) {
                $error = "";
                $fileName = $_FILES['avatar']['name'];
                $fileSize = $_FILES['avatar']['size'];
                $fileType = $_FILES['avatar']['type'];
                $fileFormat = explode('/',$fileType)[1];
                $fileExt = explode('.',$fileName);
                $fileExt = strtolower(end($fileExt)); // END требует передачи по ссылке, поэтому в 2 строки!
                $expensions = array("000","jpeg","jpg","png");
                if(!array_search($fileFormat, $expensions)) {
                    $error = 'Неправильный формат файла'; 
                }elseif ($fileSize == 0) {
                    $error = 'Файл пустой';
                }elseif($fileSize > 2097152){ // Биты
                    $error = 'Файл > 2mb';  
                }
                if($error == ""){
                    $fileTmp = $_FILES['avatar']['tmp_name'];
                    $filename = $_COOKIE['id'].'.png';
                    move_uploaded_file($fileTmp, $uploaddir.$filename);
                    $mysqli = openmysqli();
                    $mysqli->query("UPDATE users SET photo = 0 WHERE login = '".decode($_COOKIE['login'])."';");
                    $mysqli->close();
                    setcookie("photo", $_COOKIE['id'], time()+(3600), "/");
                    parent::relocate('/u', 2, "Файл загружен!");
                }else{
                    parent::relocate('/u', 3, $error."!");
                }
            }else
                parent::relocate('/u');
        }else
            parent::relocate('/');
    }

    // Удаление аватарки
    public function deletePhotoAction(){
        if(chAccess("сhInProfile")){
            $uploaddir = '/files/img/avatar/';
            if ($_COOKIE['photo'] != 0) {
                if ($_COOKIE['photo'] >= 0) {
                    $photo = rand(-1, -9); // Вулючительно
                    $mysqli = openmysqli();
                    $mysqli->query("UPDATE users SET photo = ".$photo." WHERE login = '".decode($_COOKIE['login'])."';");
                    $mysqli->close();
                    unlink($_SERVER['DOCUMENT_ROOT'].$uploaddir.$_COOKIE['photo'].".png");
                    setcookie("photo", $photo, time()+(3600), "/");
                    parent::relocate('/u', 2, 'Аватар удалён!');
                }else
                    parent::relocate('/u', 3, 'Вы не загружали аватарку :(');
            }else
                parent::relocate('/u');
        }else
            parent::relocate('/');
    }
    
    // Выход из аккаунта
    public function exitAction(){
        if(chAccess("сhInProfile")){
            setcookie('id', '', time() - 3600, '/');
            setcookie('login', '', time() - 3600, '/');
            setcookie('status', '', time() - 3600, '/');
            setcookie('photo', '', time() - 3600, '/');
        }
        parent::relocate('/');
    }

    // Всё о пользователе
    public function SelectAllAboutUser($login){
        $mysqli = openmysqli();
        $login = $mysqli->real_escape_string($login);
        $user = mysqli_fetch_assoc($mysqli->query("SELECT * FROM users WHERE login = '".$login."';"));
        if(array_key_exists('login', $_COOKIE) && !$user && $login == decode($_COOKIE['login']))
            $this->exitAction();
        $mysqli->close();
        $lastTopics = -1;
        if(!$user)
            $user = -1;
        else{
            $lastTopics = $this->selectLastTopics($user['userId'], 4);
            if($lastTopics->num_rows == 0)
                $lastTopics = -1;
        }
        $dataOutput = array(
            "allAboutUser" => $user,
            "lastTopics" => $lastTopics,
        );
        return $dataOutput;
    }

    // Последние топики пользователя + главный топик
    private function selectLastTopics($id, $count = 4){
        $mysqli = openmysqli();
        $id = $mysqli->real_escape_string($id);
        $count = $mysqli->real_escape_string($count);
        $topics = $mysqli->query("SELECT * FROM topic LEFT JOIN unit ON topic.idUnit = unit.unitId WHERE topic.idUserCreator = ".$id." ORDER BY topic.topicId DESC LIMIT ".$count.";");
        return $topics;
    }

    // Проверка блокировки пользователя
    public function userBanStat($login){
        $mysqli = openmysqli();
        $login = $mysqli->real_escape_string($login);
        $user = $mysqli->query("SELECT * FROM usersBanOnSite WHERE loginUser = '".$login."';");
        if(array_key_exists('login', $_COOKIE) && $login == decode($_COOKIE['login']) && $user->num_rows != 0)
            $this->exitAction();
        $mysqli->close();
        if($user->num_rows == 0)
            return 0;
        return 1;
    }

    // Удаление аккаунта
    public function deleteAccAction(){
        if(chAccess("deleteAkk") && decode($_COOKIE['login']) != view::specialDataGet('UNBAN_LOGIN')){
            $mysqli = openmysqli();
            $deletFoto = mysqli_fetch_assoc($mysqli->query("SELECT photo FROM users WHERE userId = ".$_COOKIE['id'].";"));
            if($deletFoto['photo'] == 0){
                $dir = $_SERVER['DOCUMENT_ROOT']."/files/img/avatar/".$_COOKIE['id'].".png";
                unlink($dir);
            }
            $mysqli->query("DELETE FROM users WHERE userId = ".$_COOKIE['id'].";");
            $mysqli->close();
            setcookie('id', '', time() - 3600, '/');
            setcookie('login', '', time() - 3600, '/');
            setcookie('status', '', time() - 3600, '/');
            setcookie('photo', '', time() - 3600, '/');
            parent::relocate('/', 2, 'Аккаунт удалён! До новых встреч!');
        }else
            parent::relocate('/');
    }
}