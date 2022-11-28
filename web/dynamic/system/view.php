<?php

class view{
    // Рендер нужного вида 
    public function rander($path, $data = [], $addonLayout = '', $name = 'IT Forum'){ // Путь к виду, данные, доп вид (не обяз)
        extract($data);
        $path = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$path.'.php';
        if (file_exists($path)){
            ob_start();
            require $path;
            $content = ob_get_clean();
            $content = $this->randLayouts($content, $data, $addonLayout, $name);
            echo $content;
        }else
            header('Location: /err/error.html');
        exit;
    }

    // Рендер доп контента (шипки и подвала)
    private function randLayouts($content, $data, $addonLayout, $name){
        $path = $_SERVER['DOCUMENT_ROOT'].'/modules/views/headerFooter.php';
        if ($addonLayout != '')
            $content = $this->randAddonLayouts($content, $data, $addonLayout);
        if (file_exists($path)){
            $message = $this->messageShow();
            ob_start();
            require $path;
            return ob_get_clean();
        }else
            header('Location: /err/error.html');
    }

    // Рендер доп лейаутов
    private function randAddonLayouts($content, $data, $addonLayout){
        $path = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$addonLayout.'.php';
        if (file_exists($path)){
            ob_start();
            require $path;
            return ob_get_clean();
        }else
            header('Location: /err/error.html');
    }

    // Показ сообщений если есть сессия с ним
    private function messageShow() {
        if (array_key_exists('message', $_SESSION) && array_key_exists(0, $_SESSION['message'])){
            switch ($_SESSION['message'][0]) {
                case 2: // Удача
                    $bg = "success";
                    break;
                case 3: // Ошибка
                    $bg = "danger";
                    break;
                default: // Информация
                    $bg = "primary";
            }
            $message = '
            <div aria-live="polite" aria-atomic="true" class="toast-container position-fixed bottom-0 end-0 p-3">
                <div class="toast align-items-center text-bg-'.$bg.' border-0 fade show role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                      <div class="toast-body">'.$_SESSION['message'][1].'</div>
                      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            ';
            $_SESSION['message'] = array();
        }else{
            $message = '';
        }
        return $message;
    }
}