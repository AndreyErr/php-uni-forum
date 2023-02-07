<?php

// ФАЙЛ С ПРЕДУСТАНОВЛЕННЫМИ НАСТРОЙКАМИ
// Левый столбец (ключи) не менять

return[
    
    // Основное

    'UNBAN_LOGIN' => 'Admin', // Логин главного админа, которому невозможно изменить статус админа и заблокировать
    'STANDART_TITLE' => 'IT Forum', // Название вкладки, если не задано иное
    'STATUS_UNBAN' => 2, // Статус пользователей, которых нельзя забанить (чаще всего админы) - только 1 число
    'EMAIL' => 'aaa@aaa.aaa', // Email для связи с администрацией
    
    // Файлы

    // Возможность проверки по mime-типу (нужна для долее безопасной работы с пользовательскими файлами)
    // Например, не даст ворд документ представить как pdf и т.п. (т.к. проверяет сигнатуру файла)
    // Рекомендуется включать везде (по умочанию включено)
    'mimeTypeCheck' => true,
    'FILE_SERVER' => $_SERVER['DOCUMENT_ROOT'], // Сервер, куда грузятся изображения (по умолчанию там же, где и приложение)

    'fileData' => [
        'avatar' => [
            //'mimeTypeCheck' => false, // Проверка по mime-типуб возможность её отключения именно для этой загрузки (если включена возможность)
            'folder' => '/files/img/avatar/', // Папка хранения изображений на сервере
            // Следующие 2 строчки должны иметь одинаковое кол-во значений! Иначе проверка "mimeTypeCheck" может не пройти!
            'extensions' => array('png', 'jpeg', 'jpg'), // тип (Для проверки типа ".something")
            'mimeExtensions' => array('png', 'jpeg', 'jpg'), // mime-тип (Для проверки meme-типа (сигнатуры). Список: https://ru.wikipedia.org/wiki/%D0%A1%D0%BF%D0%B8%D1%81%D0%BE%D0%BA_MIME-%D1%82%D0%B8%D0%BF%D0%BE%D0%B2)
            'maxSize' => 2097152, // В байтах / 2мб
            'maxFilesCount' => 1, // Сколько разрешено загружать файлов одновременно
        ],

        'messageFiles' => [
            'folder' => '/files/forum/',
            'extensions' => array("jpeg","jpg","png", "plain", "pdf", "octet-stream", "word"),
            'mimeExtensions' => array("jpeg","jpg","png", "plain", "pdf", "octet-stream", "vnd.openxmlformats-officedocument.wordprocessingml.document"),
            'maxSize' => 2097152,
            'maxFilesCount' => 5,
        ],
    ],
];