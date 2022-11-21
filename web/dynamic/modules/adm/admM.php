<?php

use system\model;

require_once 'lib/formCheck.php'; // Проверка форм

class admM extends model{
    
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

    public function selectCountUsers(){
        $mysqli = openmysqli();
        $count = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(id) FROM users"));
        return $count;
    }

    public function banAction($login){
        $mysqli = openmysqli();
        $login = $mysqli->real_escape_string($login);
        $user1 = $mysqli->query("SELECT * FROM users WHERE login = '".$login."';");
        $userBanAlready = $mysqli->query("SELECT * FROM banSite WHERE loginUser = '".$login."';");
        $user = mysqli_fetch_assoc($user1);
        if($user1->num_rows == 0 || $userBanAlready->num_rows > 0){
            $mysqli->close();
            relocate('/adm/users', 3, 'Ошибка бана!');
        }
        $date = date("Y-m-d");
        $mysqli->query("INSERT INTO banSite VALUES (NULL, '".$login."', '".$date."');");
        $mysqli->close();
        relocate('/adm/users', 2, 'Пользователь заблокирован!');
    }

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
}