<?php
// ПОКА НЕ ИСП
// class mainV{
//     public function rander($path, $data = []){
//         extract($data);
//         $path = $_SERVER['DOCUMENT_ROOT'].'/main/views/'.$path.'.php';
//         if (file_exists($path)){
//             ob_start();
//             require $path;
//             $content = ob_get_clean();
//             echo $content;
//         }
//         debug($data);
//     }
// }