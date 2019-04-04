<?php

require_once('app/Functions.php');
require_once('app/DataBases.php');

require_once('model/Actions.php');
require_once('model/Content.php');
require_once('model/Question.php');
require_once('model/Theme.php');
require_once('model/User.php');

class IndexController
{
    public $questions;
    public $user;
    public $content;
    public $action;
    public $theme;

    public function __construct()
    {
        //$this->questions = new Question();
        //$this->action = new Actions();
        //$this->user = new User();
        //$this->content = new Content();
        //$this->theme = new Theme();
    }

    public function viewFlashShow()
    {
        $show = new IndexController();
        include_once 'view/flashShow.php';
        Functions::flashShow();
    }

    //отображает форму для задавания вопроса через index.php
    public function viewAddQuestion()
    {
        $theme = new Theme();
        $content = new Content();
        $theme = $theme->select();
        $array = $content->select();
        include('view/addQuestion.php');
    }

    //отображает башку в index.php
    public function viewHead()
    {
        include('view/Head.php');
    }

    //отображает категории в index.php
    public function viewCategories()
    {
        $theme = new Theme();
        $content = new Content();
        $function = new Functions();
        $controller = new IndexController();
        $theme = $theme->select(['status' => 1]);
        $cont = $content->select();
        $array = $content->formContentArray($theme, $cont);

        include('view/Categories.php');
    }

    //отображает вопросы в index.php
    public function viewContent()
    {
        $theme = new Theme();
        $content = new Content();
        $theme = $theme->select(['status' => 1]);
        $cont = $content->select();
        $array = $content->formContentArray($theme, $cont);
        include('view/Content.php');
    }

    //отображает скрипты в index.php
    public function viewScripts()
    {
        include('view/Scripts.php');
    }

    //отображает форму в форме авторизации
    public function viewLoginForm()
    {
        include('view/LoginForm.php');
    }

    public function actionAddQuestion($params)
    {
        $name = $params['name'];
        $email = $params['email'];
        $theme = $params['theme'];
        $question = $params['question'];
        $questions = new Question();

        if (
            !isset($name) ||
            !isset($email) ||
            !isset($theme) ||
            !isset($question) ||
            trim($name) === '' ||
            trim($email) === '' ||
            trim($question) === '' ||
            (int)$theme === 0
        ) {
            Functions::flashError("Некорректно переданы параметры, проверьте чтобы все поля были заполнены!");
        }

        $res = $questions->add($name, $email, $theme, $question);

        if ((int)$res === 0) {
            Functions::flashError("К сожалению ваш вопрос не был доставлен!");
        }
        Functions::flashOk('Вопрос успешно отправлен!');
        Functions::redirect();
    }

    public function actionLogin($params)
    {
        $login = $params['login'];
        $password = $params['password'];
        $link = 'index.php?view=LoginForm';
        $action = new Actions();

        if ($action->authIsLogin()) {
            Functions::redirect();
        }
        if (!isset($login) ||
            !isset($password) ||
            trim($login) === '' ||
            trim($password) === '') {
            Functions::flashError("Все поля должны быть заполнены!");
            return;
        }

        $res = $action->login($login, $password);

        if (count($res) === 0) {
            Functions::flashError("Неверно введен логин и/или пароль!");
            return;
        }
        $_SESSION['login'] = $login;
        Functions::redirect('admin.php');
    }

    //проверка на авторизацию
    public function isLogin()
    {
        $action = new Actions();
        return $action->authIsLogin();
    }
}