<?php

require_once 'lib/formCheck.php'; // Проверка форм

class userM{
    
    // Регистрация пользователя
    public function regAction(){
        if (!empty($_POST)) {
            if(!passCheck($_POST['pass']) || $_POST['pass'] != $_POST['pass2'] || !nameCheck($_POST['name']) || !loginCheck($_POST['login']) || !emailCheck($_POST['email']))
                relocate('/u/reg', 3, 'Ошибка регистрации: неправильный формат некоторых полей!');
            else{
                $mysqli = openmysqli();
                $name = mb_convert_case($mysqli->real_escape_string($_POST['name']), MB_CASE_TITLE, "UTF-8");
                $login = $mysqli->real_escape_string($_POST['login']);
                $pass = hashPass($mysqli->real_escape_string($_POST['pass']));
                $email = $mysqli->real_escape_string($_POST['email']);
                $date = date("Y-m-d");
                $testLogin = $mysqli->query("SELECT id FROM users WHERE login = '".$login."';");
                if($testLogin->num_rows >= 1){
                    relocate('/u/reg', 3, 'Пользователь с логином '.$login .' уже существует!');
                    $mysqli->close();
                }else
                    $mysqli->query("INSERT INTO users VALUES (NULL, '".$login."', 0, '".$name."', '".$email."', '".$pass."', 0, '".$date."', '', 0);");
                $mysqli->close();
                $cookTime = time()+(3600);
                setcookie("login", encode($_POST['login']), $cookTime, "/");
                setcookie("status", encode('0'), $cookTime, "/");
                setcookie("photo", 0, $cookTime, "/");
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
                $user = mysqli_fetch_assoc($user1);
                $mysqli->close();
                if($user1->num_rows == 0 || !password_verify($pass, $user['pass']))
                    relocate('/', 3, 'Неверные логин или пароль или пользователя не существует!');
                else{
                    $cookTime = 0;
                    if(array_key_exists('rememb', $_POST) && $_POST['rememb'] == "yes"){
                        $cookTime = time()+(3600 * 24 * 10);
                    }else{
                        $cookTime = time()+(3600);
                    }
                    setcookie("login", encode($user['login']), $cookTime, "/");
                    setcookie("status", encode($user['status']), $cookTime, "/");
                    setcookie("photo", $user['photo'], $cookTime, "/");
                    relocate('/u');
                }
            }
        }else{
            relocate('/');
        }
    }

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

    public function updatePhotoAction(){
        $uploaddir = '/files/img/avatar/';
        $fileType = $_FILES["avatar"]["type"];
        if (!empty($_FILES)) {
        if ($_FILES["avatar"]["size"] == 0 || $fileType != "image/png" || $fileType != "image/jpeg") {
            relocate('/u', 3, 'Неправильный формат!');
        }
        else if ($_FILES["avatar"]["size"] > 2000000) {
            $uploadOk = 0;
            relocate('/u', 3, 'Слишком большой файл!');
        }



            $_FILES['avatar']['name'] = decode($_COOKIE['login']);
            debug($_FILES['avatar']['type']);
            krik("AAAAAAAAAAAAAAAAAAAAAA");
        }else
            relocate('/u');
    }

    // public function deletePhotoAction(){
    //     $uploaddir = '/files/img/avatar/';
    //     if ($_COOKIE['login']) {
    //         $mysqli = openmysqli();
    //         $mysqli->query("UPDATE users SET photo = 0 WHERE login = '".decode($_COOKIE['login'])."';");
    //         $mysqli->close();
    //         relocate('/u', 2, 'Аватар удалён!');
    //     }else
    //         relocate('/u');
    // }
    
    // Выход из аккаунта
    public function exitAction(){
        if(array_key_exists('login', $_COOKIE)){
            setcookie('login', '', time(), '/');
            setcookie('status', '', time(), '/');
            setcookie('photo', '', time(), '/');
            relocate('/');
        }else
            relocate('/', 3, 'Вы не в аккаунте, чтоб из него выходить!');
    }

    // Всё о пользователе
    public function SelectAllAboutUser($login){
        $mysqli = openmysqli();
        $login = $mysqli->real_escape_string($login);
        $user = mysqli_fetch_assoc($mysqli->query("SELECT * FROM users WHERE login = '".$login."';"));
        if(!$user && $login == decode($_COOKIE['login']))
            $this->exitAction();
        $mysqli->close();
        return $user;
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