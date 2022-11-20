<?php

require_once 'lib/formCheck.php'; // Проверка форм

class userM{
    
    // Регистрация пользователя
    public function regAction(){
        if (!empty($_POST)) {
            if(!passCheck($_POST['pass']) || $_POST['pass'] != $_POST['pass2'] || !nameCheck($_POST['name']) || !loginCheck($_POST['login']) || !emailCheck($_POST['email']))
                relocate('/reg', 3, 'Ошибка регистрации: неправильный формат некоторых полей!');
            else{
                $mysqli = openmysqli();
                $name = mb_convert_case($mysqli->real_escape_string($_POST['name']), MB_CASE_TITLE, "UTF-8");
                $login = $mysqli->real_escape_string($_POST['login']);
                $pass = hashPass($mysqli->real_escape_string($_POST['pass']));
                $email = $mysqli->real_escape_string($_POST['email']);
                $date = date("Y-m-d");
                $testLogin = $mysqli->query("SELECT id FROM users WHERE login = '".$login."';");
                if($testLogin->num_rows >= 1)
                    relocate('/reg', 3, 'Пользователь с логином '.$login .' уже существует!');
                else
                    $mysqli->query("INSERT INTO users VALUES (NULL, '".$login."', 0, '".$name."', '".$email."', '".$pass."', 0, '".$date."', '', 0);");
                $mysqli->close();
                $cookTime = time()+(3600);
                setcookie("login", encode($_POST['login']), $cookTime, "/");
                setcookie("status", encode('0'), $cookTime, "/");
                setcookie("photo", encode('0'), $cookTime, "/");
                relocate('/u', 2, 'Добро пожаловать на форум, '.$name);
            }
        }else
            relocate('/reg', 3, 'Ошибка регистрации: поля пусты!');
    }

    // Авторизация пользователя
    public function authorizeAction(){
        if (!empty($_POST)) {
            if(!passCheck($_POST['pass']) || !loginCheck($_POST['login']))
                relocate('/', 3, 'Неверные логин или пароль!');
            else{
                $mysqli = openmysqli();
                $login = $mysqli->real_escape_string($_POST['login']);
                $pass = $mysqli->real_escape_string($_POST['pass']);
                $user = mysqli_fetch_assoc($mysqli->query("SELECT * FROM users WHERE login = '".$login."';"));
                $mysqli->close();
                if(!$user['id'] || !password_verify($pass, $user['pass']))
                    relocate('/', 3, 'Неверные логин или пароль!');
                else{
                    $cookTime = 0;
                    if(array_key_exists('rememb', $_POST) && $_POST['rememb'] == "yes"){
                        $cookTime = time()+(3600 * 24 * 10);
                    }else{
                        $cookTime = time()+(3600);
                    }
                    setcookie("login", encode($user['login']), $cookTime, "/");
                    setcookie("status", encode($user['status']), $cookTime, "/");
                    setcookie("photo", encode($user['photo']), $cookTime, "/");
                    relocate('/u');
                }
            }
        }else{
            relocate('/', 3, 'Ошибка авторизации: поля пусты!');
        }
    }
    
    // Выход из аккаунта
    public function exitAction(){
        if(array_key_exists('login', $_COOKIE)){
            setcookie('login', '', time(), '/');
            setcookie('status', '', time(), '/');
            setcookie('photo', '', time(), '/');
            relocate('/', 1, 'Вы вышли из аккаунта');
        }else
            relocate('/', 3, 'Вы не в аккаунте, чтоб из него выходить!');
    }
}