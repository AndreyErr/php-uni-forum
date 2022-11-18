<?php

require_once 'lib/formCheck.php'; // Проверка форм
require_once 'lib/security.php'; // Безопасность некоторых данных

class userM{
    public function test(){
        return "userM page uwu";
    }
    public function regAction(){
        if (!empty($_POST)) {
            if(!passCheck($_POST['pass']) || $_POST['pass'] != $_POST['pass2'] || !nameCheck($_POST['name']) || !loginCheck($_POST['login']) || !emailCheck($_POST['email']))
                krik("РЕГИСТРАЦИЯ НЕ ПРОШЛА");
            else{
                $mysqli = openmysqli();
                $name = $mysqli->real_escape_string($_POST['name']);
                $login = $mysqli->real_escape_string($_POST['login']);
                $pass = hashPass($mysqli->real_escape_string($_POST['pass']));
                $email = $mysqli->real_escape_string($_POST['email']);
                $date = date("Y-m-d");
                $testLogin = $mysqli->query("SELECT id FROM users WHERE login = '".$login."';");
                if($testLogin->num_rows >= 1)
                    krik("Пользователь уже существует!");
                else
                    $mysqli->query("INSERT INTO users VALUES (NULL, '".$login."', 0, '".$name."', '".$email."', '".$pass."', 0, '".$date."', '', 0);");
                $mysqli->close();
                krik("РЕГИСТРАЦИЯ ПРОШЛА");
            }
        }else{
            krik("РЕГИСТРАЦИ ЯЯЯЯЯЯЯЯЯ ПУСТА");
        }
    }
    public function authorizeAction(){
        krik("АВТОРИЗАЦИ ЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯ");
    }
}