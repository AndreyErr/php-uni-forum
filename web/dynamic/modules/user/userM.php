<?php

use system\model;

require_once 'lib/formCheck.php'; // Проверка форм

class userM extends model{
    
    // Регистрация пользователя
    public function regAction(){
        if (!empty($_POST)) {
            if(!passCheck($_POST['pass']) || $_POST['pass'] != $_POST['pass2'] || !nameCheck($_POST['name']) || !loginCheck($_POST['login']) || !emailCheck($_POST['email']))
                relocate('/u/reg', 3, 'Ошибка регистрации: неправильный формат некоторых полей!');
            else{
                $mysqli = openmysqli();
                $name = mb_convert_case($mysqli->real_escape_string($_POST['name']), MB_CASE_TITLE, "UTF-8");
                $login = $mysqli->real_escape_string($_POST['login']);
                $photo = rand(1, 9); // Включительно
                $photo = 1; // ЗАГЛУШКА ////////////////////////////////////////////////////////////////
                $testLogin = $mysqli->query("SELECT id FROM users WHERE login = '".$login."';");
                if($testLogin->num_rows >= 1){
                    relocate('/u/reg', 3, 'Пользователь с логином '.$login .' уже существует!');
                    $mysqli->close();
                }else{
                    $pass = hashPass($mysqli->real_escape_string($_POST['pass']));
                    $email = $mysqli->real_escape_string($_POST['email']);
                    $date = date("Y-m-d");
                    $mysqli->query("INSERT INTO users VALUES (NULL, '".$login."', 0, '".$name."', '".$email."', '".$pass."', ".$photo.", '".$date."', '', 0);");
                }
                $id = mysqli_fetch_assoc($mysqli->query("SELECT id FROM users WHERE login = '".$login."';"));
                $mysqli->close();
                $cookTime = time()+(3600);
                setcookie("id", $id['id'], $cookTime, "/");
                setcookie("login", encode($_POST['login']), $cookTime, "/");
                setcookie("status", encode('0'), $cookTime, "/");
                setcookie("photo", $photo, $cookTime, "/");
                relocate('/u', 2, 'Добро пожаловать на форум, '.$name);
            }
        }else
            relocate('/u/reg');
    }

    // Авторизация пользователя
    public function authorizeAction(){
        if (!empty($_POST)) {
            if(!$_POST['pass'] || !loginCheck($_POST['login']))
                relocate('/', 3, 'Неверные логин или пароль!');
            else{
                $mysqli = openmysqli();
                $login = $mysqli->real_escape_string($_POST['login']);
                $pass = $mysqli->real_escape_string($_POST['pass']);
                $user1 = $mysqli->query("SELECT * FROM users WHERE login = '".$login."';");
                $userban = $mysqli->query("SELECT * FROM banSite WHERE loginUser = '".$login."';");
                $user = mysqli_fetch_assoc($user1);
                $mysqli->close();
                if($user1->num_rows == 0 || !password_verify($pass, $user['pass']))
                    relocate('/', 3, 'Неверные логин или пароль или пользователя не существует!');
                elseif($userban->num_rows != 0){
                    relocate('/', 3, 'Данный аккаунт заблокирован на сайте!');
                }else{
                    $cookTime = 0;
                    if(array_key_exists('rememb', $_POST) && $_POST['rememb'] == "yes")
                        $cookTime = time()+(3600 * 24 * 10);
                    else
                        $cookTime = time()+(3600);
                    if($user['photo'] == 0)
                        $photo = $user['id'];
                    else 
                        $photo = $user['photo'];
                    setcookie("id", $user['id'], $cookTime, "/");
                    setcookie("login", encode($user['login']), $cookTime, "/");
                    setcookie("status", encode($user['status']), $cookTime, "/");
                    setcookie("photo", $photo, $cookTime, "/");
                    relocate('/u');
                }
            }
        }else
            relocate('/');
    }

    // Смена имени
    public function changeNameAction(){
        if (!empty($_POST) || $_COOKIE['login']) {
            if(!nameCheck($_POST['name']))
                relocate('/u', 3, 'Неправильный формат имени!');
            else{
                $mysqli = openmysqli();
                $name = mb_convert_case($mysqli->real_escape_string($_POST['name']), MB_CASE_TITLE, "UTF-8");
                $mysqli->query("UPDATE users SET name = '".$name."' WHERE login = '".decode($_COOKIE['login'])."';");
                $mysqli->close();
                relocate('/u', 2, 'Имя изменено на '.$name);
            }
        }else
            relocate('/u');
    }

    // Смена пароля
    public function changePassAction(){
        if (!empty($_POST)) {
            if(!$_POST['oldPass'] || !passCheck($_POST['pass']) || $_POST['pass'] != $_POST['pass2'])
                relocate('/u', 3, 'Неправильный формат нового пароля или проверка повторения пароля не прошла!');
            else{
                $mysqli = openmysqli();
                $oldPass = $mysqli->real_escape_string($_POST['oldPass']);
                $pass = hashPass($mysqli->real_escape_string($_POST['pass']));
                $testPass = mysqli_fetch_assoc($mysqli->query("SELECT pass FROM users WHERE login = '".decode($_COOKIE['login'])."';"));
                if(!$testPass['pass'] || !password_verify($oldPass, $testPass['pass'])){
                    $mysqli->close();
                    relocate('/u', 3, 'Неверный старый пароль! Вспомните его для смены или создайте новый аккаунт!');
                }else
                    $mysqli->query("UPDATE users SET pass = '".$pass."' WHERE login = '".decode($_COOKIE['login'])."';");
                $mysqli->close();
                relocate('/u', 2, 'Пароль был изменён!');
            }
        }else
            relocate('/u');
    }

    // Смена email
    public function changeEmailAction(){
        if (!empty($_POST)) {
            if(!emailCheck($_POST['email']))
                relocate('/u', 3, 'Неправильный формат email!');
            else{
                $mysqli = openmysqli();
                $email = $mysqli->real_escape_string($_POST['email']);
                $mysqli->query("UPDATE users SET email = '".$email."' WHERE login = '".decode($_COOKIE['login'])."';");
                $mysqli->close();
                relocate('/u', 2, 'Email изменён на '.$email);
            }
        }else
            relocate('/u');
    }

    // Изменение аватарки ИСПРАВИТЬ
    public function updatePhotoAction(){
        $uploaddir = $_SERVER['DOCUMENT_ROOT'].'/files/img/avatar/';
        if (!empty($_FILES)) {
            $error = "";
            $fileName = $_FILES['avatar']['name'];
            $fileSize = $_FILES['avatar']['size'];
            $fileTmp = $_FILES['avatar']['tmp_name'];
            $fileType = $_FILES['avatar']['type'];
            $fileExt = explode('.',$fileName);
            $fileExt = strtolower(end($fileExt)); // END требует передачи по ссылке, поэтому в 2 строки!
            //debug($fileName);
            $expensions = array("lpeg","jpg","png");
            if ($fileSize == 0) {
                $error = 'Файл пустой';
            }else if($fileSize > 2097152){ // Биты
                $error = 'Файл > 2mb';  
            }else if(!array_search($fileExt, $expensions)) {
                $error = 'Неправильный формат файла!'; 
            }
            if($error == ""){
                $filename = $_COOKIE['id'].'.png';
                move_uploaded_file($fileTmp, $uploaddir.$filename);
                $mysqli = openmysqli();
                $mysqli->query("UPDATE users SET photo = 0 WHERE login = '".decode($_COOKIE['login'])."';");
                $mysqli->close();
                setcookie("photo", $_COOKIE['id'], time()+(3600), "/");
                relocate('/u', 2, "Файл загружен!");
            }else{
                relocate('/u', 3, $error."!");
            }
        }else
            relocate('/u');
    }

    // Удаление аватарки
    public function deletePhotoAction(){
        $uploaddir = '/files/img/avatar/';
        if ($_COOKIE['photo'] != 0) {
            if ($_COOKIE['photo'] >= 0) {
                $photo = rand(1, 9); // Вулючительно
                $photo = 1; // ЗАГЛУШКА ////////////////////////////////////////////////////////////////
                $mysqli = openmysqli();
                $mysqli->query("UPDATE users SET photo = ".$photo." WHERE login = '".decode($_COOKIE['login'])."';");
                $mysqli->close();
                unlink($_SERVER['DOCUMENT_ROOT'].$uploaddir.$_COOKIE['photo'].".png");
                setcookie("photo", $photo, time()+(3600), "/");
                relocate('/u', 2, 'Аватар удалён!');
            }else
                relocate('/u', 3, 'Вы не загружали аватарку :(');
        }else
            relocate('/u');
    }
    
    // Выход из аккаунта
    public function exitAction(){
        if(array_key_exists('login', $_COOKIE)){
            setcookie('id', '', time() - 3600, '/');
            setcookie('login', '', time() - 3600, '/');
            setcookie('status', '', time() - 3600, '/');
            setcookie('photo', '', time() - 3600, '/');
            relocate('/');
        }else
            relocate('/', 3, 'Вы не в аккаунте, чтоб из него выходить!');
    }

    // Всё о пользователе
    public function SelectAllAboutUser($login){
        $mysqli = openmysqli();
        $login = $mysqli->real_escape_string($login);
        $user = mysqli_fetch_assoc($mysqli->query("SELECT * FROM users WHERE login = '".$login."';"));
        if(array_key_exists('login', $_COOKIE) && !$user && $login == decode($_COOKIE['login']))
            $this->exitAction();
        $mysqli->close();
        if(!$user)
            $user = -1;
        return $user;
    }

    // Проверка блокировки пользователя
    public function userBanStat($login){
        $mysqli = openmysqli();
        $login = $mysqli->real_escape_string($login);
        $user = $mysqli->query("SELECT * FROM banSite WHERE loginUser = '".$login."';");
        if(array_key_exists('login', $_COOKIE) && $login == decode($_COOKIE['login']) && $user->num_rows != 0)
            $this->exitAction();
        $mysqli->close();
        if($user->num_rows == 0)
            return 0;
        return 1;
    }

    // Удаление аккаунта
    public function deleteAccAction(){
        krik("УДАЛЕНИЕ АККАУНТА");
        //Изменение всех связанных с акк тем и постов на удалённый id
        //Удаление фото юзера
        //Удаление из таблицы юзеров
        //Уничтожение сеесий
    }
}