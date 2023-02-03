<?php
use system\model;

class view{
    // Рендер нужного вида 
    public function rander($path, $data = [], $addonLayout = '', $name = ''){ // Путь к виду, данные, доп вид (не обяз)
        if($name == '')
            $name = $this->specialDataGet('STANDART_TITLE'); // Стандартный заголовок
        extract($data);
        $path = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$path.'.php';
        if (file_exists($path)){
            ob_start();
            require $path;
            $content = ob_get_clean();
            $content = $this->randLayouts($content, $data, $addonLayout, $name);
            echo $content;
        }else
            echo $this->viewError('Не найдено представление', $path);
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
        }
        echo $this->viewError('Не найден лейаут', 'headerFooter');
    }

    // Рендер доп лейаутов
    private function randAddonLayouts($content, $data, $addonLayout){
        $path = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$addonLayout.'.php';
        if (file_exists($path)){
            ob_start();
            require $path;
            return ob_get_clean();
        }
        echo $this->viewError('Не найден дополнительный лейаут', $addonLayout);
    }

    // Подключение файла с базовыми настройками
    protected static function specialDataGet($get = ""){
        return model::specialDataGet($get);
    }

    // Подгрузка частей для визуализации
    public static function useViewTmp($module, $nameViewTmp){
        if ($module != 'default') // default распологается в главной папке представлений
            $path = $_SERVER['DOCUMENT_ROOT'] . '/modules/' . $module . '/views/tmp/' . $nameViewTmp . '.php';
        else
            $path = $_SERVER['DOCUMENT_ROOT'] . '/modules/views/tmp/' . $nameViewTmp . '.php';
        if (file_exists($path))
            return require $path;
        echo self::viewError('Не найдена часть представления', $module.' / '.$nameViewTmp);
    }

    // Показ сообщений если есть сессия с ним
    private function messageShow() {
        if (array_key_exists('message', $_SESSION) && array_key_exists(0, $_SESSION['message'])){
            switch ($_SESSION['message'][0]) {
                case 2: // Удача
                    $bg = "success";
                    $tupeMessage = 1;
                    break;
                case 3: // Ошибка
                    $bg = "danger";
                    $tupeMessage = 1;
                    break;
                case -1: // Критическая ошибка настройки сайта
                    $tupeMessage = 2;
                    break;
                default: // Информация
                    $bg = "primary";
                    $tupeMessage = 1;
                    break;
            }
            if($tupeMessage == 1)
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
            else {
                $_SESSION['message'][1] = explode('|',$_SESSION['message'][1]);
                $message = self::viewError($_SESSION['message'][1][0], $_SESSION['message'][1][1]);
            }
            $_SESSION['message'] = array();
        }else{
            $message = '';
        }
        return $message;
    }

    // Показ ошибки
    private static function viewError($text){
        $text = '<div class="alert alert-danger" style="z-index: 9999; margin: 10vh 5vh;" role="alert">
                    <h4 class="alert-heading"><i class="fa-solid fa-triangle-exclamation"></i> КРИТИЧЕСКАЯ ОШИБКА!</h4>
                    <hr>
                    <p class="mb-0">'.ucfirst($text).'</p>
                    <hr>
                    <p class="mb-0">Если вы видите это сообщение, то обратитесь к администрации по почте <b>'.self::specialDataGet('EMAIL').'</b>, желательно, приложив скрин данной ошибки!</p>
                 </div>';
        return $text;
    }
}