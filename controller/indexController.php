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
    public $function;
    public $action;
    public $theme;

    public function __construct()
    {
        $this->questions = new Question();
        $this->function = new Functions();
        $this->action = new Actions();
        $this->user = new User();
        $this->content = new Content();
        $this->theme = new Theme();
    }

    public function viewFlashShow()
    {
        $show = new IndexController();
        include_once 'view/flashShow.php';
        $this->function->flashShow();
    }

    //отображает форму для задавания вопроса через index.php
    public function viewAddQuestion()
    {
        $theme = $this->theme->select();
        $array = $this->content->select();
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
        $function = $this->function;
        $array = $this->content->select();
        $controller = new IndexController();
        include('view/Categories.php');
    }

    //отображает вопросы в index.php
    public function viewContent()
    {
        $array = $this->content->select();
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

        $this->questions->add($name, $email, $theme, $question);
        $this->function->redirect();
    }

    public function actionLogin($params)
    {
        $login = $params['login'];
        $password = $params['password'];
        $link = 'index.php?view=LoginForm';

        if ($this->action->authIsLogin()) {
            $this->function->redirect();
        }
        if (!isset($login) ||
            !isset($password) ||
            trim($login) === '' ||
            trim($password) === '') {
            $this->function->flashError("Все поля должны быть заполнены!");
            return;
        }

        $res = $this->action->login($login, $password);

        if (count($res) === 0) {
            $this->function->flashError("Неверно введен логин и/или пароль!");
            return;
        }
        $_SESSION['login'] = $login;
        $this->function->redirect('admin.php');
    }

    //проверка на авторизацию
    public function isLogin()
    {
        return $this->action->authIsLogin();
    }
}