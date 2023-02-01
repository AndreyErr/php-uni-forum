<?php

// ФАЙЛ С ПРЕДУСТАНОВЛЕННЫМИ НАСТРОЙКАМИ
// Левый столбец (ключи) не менять

return[
    
    // Основное

    'UNBAN_LOGIN' => 'Admin', // Логин главного админа, которому невозможно изменить статус админа и заблокировать
    'STANDART_TITLE' => 'IT Forum', // Название вкладки, если не задано иное
    'STATUS_UNBAN' => 2, // Статус пользователей, которых нельзя забанить (чаще всего админы) - только 1 число
    
    // Файлы

    'mimeTypeCheck' => true, // Проверка по mime-типу (нужна для долее безопасной работы с пользовательскими файлами)
    //Например, не дас ворд документ представить как pdf и т.п. (т.к. проверяет сигнатуру файла)

    'fileData' => [
        'avatar' => [
            'folder' => $_SERVER['DOCUMENT_ROOT'].'/files/img/avatar/',
            // Следующие 2 строчки должны иметь одинаковое кол-во значений! Иначе проверка "mimeTypeCheck" может не пройти!
            'extensions' => array('png', 'jpeg', 'jpg'), // тип (Для проверки типа ".something")
            'mimeExtensions' => array('png', 'jpeg', 'jpg'), // mime-тип (Для проверки meme-типа (сигнатуры). Список: https://ru.wikipedia.org/wiki/%D0%A1%D0%BF%D0%B8%D1%81%D0%BE%D0%BA_MIME-%D1%82%D0%B8%D0%BF%D0%BE%D0%B2)
            'maxSize' => 2097152, // В байтах / 2мб
        ],

        'forumMessage' => [
            // 'folder' => $_SERVER['DOCUMENT_ROOT'].'',
            // 'extensions' => array("jpeg","jpg","png", "plain", "pdf", "octet-stream", "vnd.openxmlformats-officedocument.wordprocessingml.document"),
            // 'maxSize' => 2097152,
        ],
    ],
];