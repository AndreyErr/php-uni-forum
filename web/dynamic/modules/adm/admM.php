<?php

use system\model;

require_once 'lib/formCheck.php'; // Проверка форм

class admM extends model{
    
    // Получаем всех пользователей и статусы банов
    public function selectFromUsers(){
        $mysqli = openmysqli();
        $users = $mysqli->query("
        (SELECT * FROM users LEFT OUTER JOIN banSite ON banSite.loginUser = users.login)
        UNION
        (SELECT * FROM users RIGHT OUTER JOIN banSite ON banSite.loginUser = users.login);
        ");
        $mysqli->close();
        return $users;
    }

    // Подсчёт пользователей
    public function selectCountUsers(){
        $mysqli = openmysqli();
        $count = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(user_id) FROM users"));
        return $count;
    }

    // Блокировка пользователя на сайте
    public function banAction($login){
        $mysqli = openmysqli();
        $login = $mysqli->real_escape_string($login);
        $user1 = $mysqli->query("SELECT * FROM users WHERE login = '".$login."';");
        $userBanAlready = $mysqli->query("SELECT * FROM banSite WHERE loginUser = '".$login."';");
        $user = mysqli_fetch_assoc($user1);
        if($user1->num_rows == 0 || $userBanAlready->num_rows > 0 || $user['status'] == 2){
            $mysqli->close();
            relocate('/adm/users', 3, 'Ошибка бана!');
        }
        $date = date("Y-m-d");
        $mysqli->query("INSERT INTO banSite VALUES (NULL, '".$login."', '".$date."');");
        $mysqli->close();
        relocate('/adm/users', 2, 'Пользователь заблокирован!');
    }

    // Разблокировка пользователя на сайте
    public function unbanAction($login){
        $mysqli = openmysqli();
        $login = $mysqli->real_escape_string($login);
        $user1 = $mysqli->query("SELECT * FROM users WHERE login = '".$login."';");
        $userBanAlready = $mysqli->query("SELECT * FROM banSite WHERE loginUser = '".$login."';");
        $user = mysqli_fetch_assoc($user1);
        if($user1->num_rows == 0 || $userBanAlready->num_rows == 0){
            $mysqli->close();
            relocate('/adm/users', 3, 'Ошибка разбана!');
        }
        $date = date("Y-m-d");
        $mysqli->query("DELETE FROM banSite WHERE loginUser = '".$login."';");
        $mysqli->close();
        relocate('/adm/users', 2, 'Пользователь разблокирован!');
    }

    // Изменение статуса пользователя
    public function changeStatusAction(){
        if (!empty($_POST)) {
            $specdata = model::specialDataConnect(); // Для получения логина главного админа
            if(!$_POST['login'] || $_POST['stat'] < 0 || $_POST['stat'] > 3 || $_POST['login'] == $specdata['UNBAN_LOGIN'])
                relocate('/adm', 3, 'Что-то не так!');
            else{
                $mysqli = openmysqli();
                $login = $mysqli->real_escape_string($_POST['login']);
                $user1 = $mysqli->query("SELECT * FROM users WHERE login = '".$login."';");
                if($user1->num_rows == 0){
                    $mysqli->close();  
                    relocate('/', 3, 'Такого логина не существует!');
                }else{
                    $mysqli->query("UPDATE users SET status = '".$_POST['stat']."' WHERE login = '".$login."';");
                    $mysqli->close();
                    relocate('/adm', 2, 'Статус пользователя изменён!');
                }
            }
        }else
            relocate('/');
    }
}