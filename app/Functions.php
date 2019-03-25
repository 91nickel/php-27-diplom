<?php
ob_start();

class Functions
{
    function redirect($url = '/')
    {
        unset($_GET);
        unset($_POST);
        if ($url === null) $url = '/';
        header("Location: {$url}");
        exit();
    }

    public function flashShow()
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
    public function flashOk($message, $link = '/')
    {
        $_SESSION['success'] = $message;
        unset($_SESSION[$message]);
        $this->redirect($link);
    }

    /*Вывод ошибки */
    public function flashError($message, $link = '/')
    {
        $_SESSION['error'] = $message;
        unset($_SESSION[$message]);
        $this->redirect($link);
    }
}