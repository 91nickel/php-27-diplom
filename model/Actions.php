<?php

class Actions
{
    public $dataBases;

    public function __construct()
    {
        $this->dataBases = new DataBases();
    }

    public function login($login, $password)
    {
        $res = $this->dataBases->whereSelect('users', ['login' => $login, 'password' => md5($password)]);
        return $res;
    }

    public function logOut()
    {
        unset($_SESSION['login']);
        Functions::redirect('/');
    }

    function authIsLogin()
    {
        if (!isset($_SESSION['login']) || trim($_SESSION['login']) === '') {
            return false;
        }
        return true;
    }
}

?>