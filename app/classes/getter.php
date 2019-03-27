<?php
class Getter {
    // переменная ссылка
    public $url;

    // функция для получения кода страницы
    function get_web_page() {

        $url = $this->url;

        $ch = curl_init( $url );
      
        // настройки
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // возвращает веб-страницу
        curl_setopt($ch, CURLOPT_HEADER, 0);           // не возвращает заголовки
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);   // переходит по редиректам
        curl_setopt($ch, CURLOPT_ENCODING, "");    // обрабатывает все кодировки
        curl_setopt($ch, CURLOPT_USERAGENT, "booyah!");
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); // таймаут соединения
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);        // таймаут ответа
      
        // формируем массив ответа
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );
      
        // формируем массив ответа
        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        // ответ
        return $header;
      }
}
