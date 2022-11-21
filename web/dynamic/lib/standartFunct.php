<?php

// Файл с дополнительными функциями, используемыми на всём сайте

// Кастомный редирект
function relocate($page, $status = -1, $message = ''){
    if($status != -1)
        $_SESSION['message'] = [$status, $message];
    header('Location: '.$page);
}