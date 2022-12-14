<?php

use system\model;

require_once 'lib/formCheck.php'; // Проверка форм

class admM extends model{
    
    // Получаем всех пользователей и статусы банов
    public function selectFromUsers(){
        $mysqli = openmysqli();
        $users = $mysqli->query("
        (SELECT * FROM users LEFT OUTER JOIN usersBanOnSite ON usersBanOnSite.loginUser = users.login)
        UNION
        (SELECT * FROM users RIGHT OUTER JOIN usersBanOnSite ON usersBanOnSite.loginUser = users.login);
        ");
        $mysqli->close();
        return $users;
    }

    // Подсчёт пользователей
    public function selectCountUsers(){
        $mysqli = openmysqli();
        $count = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(userId) FROM users"));
        return $count;
    }

    // Блокировка пользователя на сайте
    public function banAction($login){
        if(chAccess("ban")){
            $mysqli = openmysqli();
            $login = $mysqli->real_escape_string($login);
            $user1 = $mysqli->query("SELECT * FROM users WHERE login = '".$login."';");
            $userBanAlready = $mysqli->query("SELECT * FROM usersBanOnSite WHERE loginUser = '".$login."';");
            $user = mysqli_fetch_assoc($user1);
            if($user1->num_rows == 0 || $userBanAlready->num_rows > 0 || $user['status'] == model::specialDataGet('STATUS_UNBAN') || $user['login'] == model::specialDataGet('UNBAN_LOGIN')){
                $mysqli->close();
                parent::relocate('/adm/users', 3, 'Ошибка бана!');
            }
            $mysqli->query("INSERT INTO usersBanOnSite VALUES (NULL, '".$login."');");
            $mysqli->close();
            parent::relocate('/adm/users', 2, 'Пользователь заблокирован!');
        }else
            parent::relocate('/');
    }

    // Разблокировка пользователя на сайте
    public function unbanAction($login){
        if(chAccess("ban")){
            $mysqli = openmysqli();
            $login = $mysqli->real_escape_string($login);
            $user1 = $mysqli->query("SELECT * FROM users WHERE login = '".$login."';");
            $userBanAlready = $mysqli->query("SELECT * FROM usersBanOnSite WHERE loginUser = '".$login."';");
            if($user1->num_rows == 0 || $userBanAlready->num_rows == 0){
                $mysqli->close();
                parent::relocate('/adm/users', 3, 'Ошибка разбана!');
            }
            $mysqli->query("DELETE FROM usersBanOnSite WHERE loginUser = '".$login."';");
            $mysqli->close();
            parent::relocate('/adm/users', 2, 'Пользователь разблокирован!');
        }else
            parent::relocate('/');
    }

    // Изменение статуса пользователя
    public function changeStatusAction(){
        if (!empty($_POST) && chAccess("changeStatus")) {
            if(!$_POST['login'] || $_POST['stat'] < 0 || $_POST['stat'] > 3 || $_POST['login'] == model::specialDataGet('UNBAN_LOGIN'))
                parent::relocate('/adm', 3, 'Что-то не так!');
            else{
                $mysqli = openmysqli();
                $login = $mysqli->real_escape_string($_POST['login']);
                $user1 = $mysqli->query("SELECT * FROM users WHERE login = '".$login."';");
                if($user1->num_rows == 0){
                    $mysqli->close();  
                    parent::relocate('/adm', 3, 'Такого логина не существует!');
                }else{
                    $mysqli->query("UPDATE users SET status = ".$_POST['stat']." WHERE login = '".$login."';");
                    $mysqli->close();
                    parent::relocate('/adm', 2, 'Статус пользователя изменён!');
                }
            }
        }else
            parent::relocate('/');
    }
}