<?php

// Массивы доступов (цифры - статусы пользователей из файла настроек status.php)
// Знак Х помечает страницы, где проверка по отсутствию доступа, в остальных случаях проверка на присутствие доступа

return[
    'modules' => [ // Доступ к модулям (полное название, например, не f, а forum)
        'adm' => array(1, 2), // Админ панель
    ],

    'actions' => [ // Доступ к действиям

        // С аккаунтом (user / u)
        'reg' => array(0, 1, 2), // Х Страница регистрации и сама регистрация
        'login' => array(0, 1, 2), // Х Вход
        'сhInProfile' => array(0, 1, 2), // Изменения профиля (имя, пароль, аватарка, почта)
        'deleteAkk' => array(0, 1, 2), // Удаление аккаунта

        // С админ панелью (adm)
        'adm' => array(1, 2), // Админ панель (кнпка к ней)
        'ban' => array(1, 2), // Бан и разбан пользователей 
        'changeStatus' => array(2), // Изменение пользователей 

        // С форумом (forum / f)
        'unit' => array(1, 2), // Темы (создание, изменение, удаление)
        'topic' => array(0, 1, 2), // Темы (создание, изменение, удаление) + сообщения
        'controlTopic' => array(1, 2), // Темы (статусы, способные так же контролировать топик(помимо самого создателя топика) - изменять и удалять) + сообщения
    ],
];