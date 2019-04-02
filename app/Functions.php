<?php
ob_start();

class Functions
{
    public static function redirect($url = '/')
    {
        unset($_GET);
        unset($_POST);
        if ($url === null) $url = '/';
        header("Location: {$url}");
        exit();
    }

    public static function flashShow()
    {
        $session = '';
        if (isset($_SESSION['success'])) {
            $session = $_SESSION['success'];
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            $session = $_SESSION['error'];
            unset($_SESSION['error']);
        }
        echo $session;
    }

    /*Вывод успешного завершения */
    public static function flashOk($message, $link = '/')
    {
        $_SESSION['success'] = $message;
        unset($_SESSION[$message]);
        Functions::redirect($link);
    }

    /*Вывод ошибки */
    public static function flashError($message, $link = '/')
    {
        $_SESSION['error'] = $message;
        unset($_SESSION[$message]);
        Functions::redirect($link);
    }
}