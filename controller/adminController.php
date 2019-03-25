<?php

require_once('model/Actions.php');
require_once('model/Content.php');
require_once('model/Question.php');
require_once('model/Theme.php');
require_once('model/User.php');

require_once('app/Functions.php');
require_once('app/DataBases.php');

class AdminController
{
    public $action;
    public $questions;
    public $user;
    public $content;
    public $function;
    public $theme;

    public function __construct()
    {
        $this->action = new Actions();
        $this->questions = new Question();
        $this->function = new Functions();
        $this->user = new User();
        $this->content = new Content();
        $this->theme = new Theme();
    }

    //отображает уведомление
    public function viewFlashShow()
    {
        $show = new AdminController();
        include_once 'view/flashShow.php';
        $this->function->flashShow();
    }

    //отображает башку
    public function viewHead()
    {
        include('view/admin/head.php');
    }

    //отображает блок категорий
    public function viewCategories()
    {
        include('view/admin/categories.php');
    }

    //отображает блок добавления администратора
    public function viewAddAdmin()
    {
        include('view/admin/addAdmin.php');
    }

    //отображает блок редактирования администратора
    public function viewEditAdmin()
    {
        //echo 'Сработал контроллер editAdmin';
        $users = $this->user->select();
        include('view/admin/editAdmin.php');
    }

    //отображает блок добавления темы
    public function viewAddTheme()
    {
        include('view/admin/addTheme.php');
    }

    //отображает блок контент
    public function viewContent()
    {
        $theme = $this->theme->select();
        $array = $this->content->select();
        //$array = $this->content->themeQuestions($theme, $array);

        $counter = $this->contentCounter();
        include('view/admin/content.php');
        $this->viewAddContent();
        $this->viewMoveContent();
        $this->viewEditContent();
    }

    //отображает блок вопросов
    public function viewQuestions()
    {
        $theme = $this->theme->select();
        $quest = $this->questions->select();
        $quest = $this->questions->formThemeArray($quest, $theme);
        include('view/admin/questions.php');
        $this->viewAnswerQuestion();
        $this->viewAnswerQuestionPublish();
        $this->viewEditQuestion();
    }

    //отображает закрывающие теги секции 1
    public function viewCloseSection1()
    {
        include('view/admin/closeSection1.php');
    }

    //отображает блок ИНФО
    public function viewContentInfo()
    {
        $info = $this->content->getInfo();
        include('view/admin/contentInfo.php');
    }

    // отображает форму добавления вопрос-ответа через админку
    public function viewAddContent()
    {
        include('view/admin/addContent.php');
    }

    //отображает форму редактирования вопрос-ответа через админку
    public function viewEditContent()
    {
        include('view/admin/editContent.php');
    }

    //отображает форму перемещения вопрос-ответа в другую тему
    public function viewMoveContent()
    {
        $array = $this->content->select();
        include('view/admin/moveContent.php');
    }

    //отображает форму редактирования неопубликованного вопроса
    public function viewEditQuestion()
    {
        include('view/admin/editQuestion.php');
    }

    //отображает форму ответа на вопрос без публикации
    public function viewAnswerQuestion()
    {
        $array = $this->content->select();
        include('view/admin/answerQuestion.php');
    }

    //отображает форму ответа на вопрос и публикации
    public function viewAnswerQuestionPublish()
    {
        $array = $this->content->select();
        include('view/admin/answerQuestionPublish.php');
    }

    //отображает скрипты в admin.php
    public function viewScripts()
    {
        include('view/admin/scripts.php');
    }

    //добавляет администратора
    public function actionAddAdmin($params)
    {
        $login = $params['login'];
        $password = $params['password'];
        $link = 'admin.php';

        if (!isset($login) || !isset($password) || trim($login) === '' || trim($password) === '') {
            $this->function->flashError("Все поля должны быть заполнены!", $link);
        }
        $res = $this->user->select(['login' => $login]);
        if (count($res) > 0) {
            $this->function->flashError('Администратор с таким именем уже существует', $link);
        }

        $res = $this->user->add($login, $password);

        if ((int)$res === 0) {
            $this->function->flashError("К сожалению администратор не был добавлен!", $link);
        }

        $this->function->flashOk('Новый администратор успешно добавлен!', $link);
    }

    // меняет данные администратора
    public function actionUpdateAdmin($params)
    {
        $id = $params['id'];
        $password = $params['password'];
        $link = 'admin.php';

        if (!isset($id) ||
            !isset($password) ||
            (int)$id === 0 ||
            trim($password) === '') {

            $this->function->flashError("Все поля должны быть заполнены!", $link);
        }

        $res = $this->user->select(['id' => $id]);
        if (count($res) === 0) {
            $this->function->flashError("Администратора с таким идентификатором не существует!", $link);
        }

        $res = $this->user->edit($id, $password);
        if (!$res) {
            $this->function->flashError("К сожалению не удалось изменить пароль у администратора!", $link);
        }

        $this->function->flashOk('Пароль администратора успешно изменен!', $link);
    }

    //удаляет администратора
    public function actionDeleteAdmin($params)
    {
        $id = $params['id'];
        $link = 'admin.php?view=EditAdmin';

        if (!isset($id) || (int)$id === 0) {
            $this->function->flashError("Все поля должны быть заполнены", $link);
        }

        $res = $this->user->select(['id' => $id]);

        if (count($res) === 0) {
            $this->function->flashError("Администратора с таким идентификатором не существует!", $link);
        }

        $res = $this->user->delete($id);

        $this->function->flashOk('Администратор успешно удален!', $link);
    }

    //Добавляет тему в блоке добавления темы
    public function actionAddTheme($params)
    {
        $name = $params['name'];
        $link = 'admin.php?view=AddTheme';

        if (!isset($name) || trim($name) === '') {
            $this->function->flashError("Все поля должны быть заполнены!", $link);
        }

        $res = $this->theme->add($name);
        if ((int)$res === 0) {
            $this->function->flashError("К сожалению тема не была добавлена!", $link);
        }

        $this->function->flashOk('Тема успешно добавлена!', $link);
    }

    // удаляет тему в блоке контент
    public function actionDeleteTheme($params)
    {
        $id = $params['id'];
        $link = 'admin.php?view=Content';

        if (!isset($id) || (int)$id === 0) {
            $this->function->flashError("Не существуют основные параметры", $link);
        }

        $res = $this->theme->select(['id' => $id]);
        if (count($res) === 0) {
            $this->function->flashError("Темы с таким идентификатором нет в системе!", $link);
        }

        $this->theme->delete($id);
        $this->function->flashOk('Тема успешно удалена!', $link);
    }

    // Добавляет вопрос в блок контент
    public function actionAddContent($params)
    {
        $idTheme = $params['id_theme'];
        $question = $params['question'];
        $answer = $params['answer'];
        $link = 'admin.php?view=Content';

        if (!isset($idTheme) ||
            !isset($question) ||
            !isset($answer) ||
            (int)$idTheme === 0 ||
            trim($question) === '' ||
            trim($answer) === '') {
            $this->function->flashError("Не существуют основные параметры!", $link);
        }

        $res = $this->content->add($idTheme, $question, $answer);
        if ((int)$res === 0) {
            $this->function->flashError("К сожалению тема не была добавлена!", $link);
        }

        $this->function->flashOk('Тема успешно добавлена!', $link);
    }

    // Редактирует вопрос в блоке контент
    public function actionEditContent($params)
    {
        $idTheme = $params['id_theme'];
        $name = $params['name'];
        $question = $params['question'];
        $answer = $params['answer'];
        $link = 'admin.php?view=Content';

        if (!isset($idTheme) ||
            !isset($question) ||
            !isset($answer) ||
            !isset($name) ||
            (int)$idTheme === 0 ||
            trim($question) === '' ||
            trim($answer) === '' ||
            trim($name) === '') {
            $this->function->flashError("Не существуют основные параметры!", $link);
        }

        $res = $this->content->select('content', ['id' => $idTheme]);
        if (count($res) === 0) {
            $this->function->flashError("Темы с таким идентификатором не сущесвует!", $link);
        }

        $res = $this->content->edit($idTheme, $name, $question, $answer);
        if (!$res) {
            $this->function->flashError("Не удалось изменить вопрос!", $link);
        }

        $this->function->flashOk('Вопрос  отредактирован!', $link);
    }

    // Перемещает вопрос в блоке контент
    public function actionMoveContent($params)
    {
        $idTheme = $params['id_theme'];
        $theme = $params['theme'];
        $link = 'admin.php?view=Content';

        if (!isset($idTheme) ||
            !isset($theme) ||
            (int)$idTheme === 0 ||
            (int)$theme === 0) {
            $this->function->flashError("Не существуют основные параметры!", $link);
        }

        $res = $this->theme->select(['id' => $theme]);
        if (count($res) === 0) {
            $this->function->flashError("Темы с таким идентификатором не сущесвует!", $link);
        }

        $res = $this->content->move($idTheme, $theme);
        if (!$res) {
            $this->function->flashError("Не удалось переместить вопрос!", $link);
        }

        $this->function->flashOk('Вопрос перемещен!', $link);
    }

    //удаляет вопрос в блоке контент
    public function actionDeleteContent($params)
    {
        $id = $params['id'];
        $link = 'admin.php?view=Content';

        if (!isset($id) || (int)$id === 0) {
            $this->function->flashError("Не существуют основные параметры!", $link);
        }

        $res = $this->content->select(['id' => $id]);
        if (count($res) === 0) {
            $this->function->flashError("Вопросы с таким идентификатором нет в системе!", $link);
        }

        $res = $this->content->delete($id);
        $this->function->flashOk('Вопрос успешно удален!', $link);
    }

    //изменяет статус публикации в блоке контент
    public function actionChangeStatusContent($params)
    {
        $id = $params['id'];
        $status = $params['status'];
        $link = 'admin.php?view=Content';

        if (!isset($id) || !isset($status) || (int)$id === 0) {
            $this->function->flashError("Не существуют основные параметры!", $link);
        }

        $res = $this->content->select(['id' => $id]);
        if (count($res) === 0) {
            $this->function->flashError("Вопроса с таким идентификатором нет в системе!", $link);
        }

        $res = $this->content->changeStatus($id, $status);
        if (!$res) {
            $this->function->flashError("Статус не изменен!", $link);
        }

        $this->function->flashOk('Статус изменен!', $link);
    }

    //редактирует вопрос в блоке вопросов
    public function actionEditQuestion($params)
    {
        $id = $params['id'];
        $question = $params['question'];
        $link = 'admin.php?view=Questions';

        if ((int)$id === 0 || trim($question) === '') {
            $this->function->flashError("Все поля должны быть заполнены!", $link);
        }
        $res = $this->questions->select('question', ['id' => $id]);

        if (count($res) === 0) {
            $this->function->flashError("Вопроса с таким идентификатором не сущесвует!", $link);
        }

        $res = $this->questions->edit($id, $question);
        if (!$res) {
            $this->function->flashError("Не удалось изменить вопрос!", $link);
        }

        $this->function->flashOk('Вопрос  отредактирован!', $link);
    }

    public function actionAnswerQuestionPublish($params)
    {
        $question = $params['question'];
        $id = $params['id'];
        $name = $params['name'];
        $email = $params['email'];
        $idTheme = $params['id_theme'];
        $answer = $params['answer'];
        $link = 'admin.php?view=Questions';

        if (!isset($idTheme) ||
            !isset($id) ||
            !isset($answer) ||
            !isset($question) ||
            !isset($name) ||
            !isset($email) ||
            (int)$idTheme === 0 ||
            (int)$id === 0 ||
            trim($question) === '' ||
            trim($answer) === '' ||
            trim($name) === '' ||
            trim($email) === '') {

            $this->function->flashError("Не существуют основные параметры!", $link);
        }

        $res = $this->questions->answerPublish($question, $id, $name, $email, $idTheme, $answer);
        if ((int)$res === 0) {
            $this->function->flashError("К сожалению вопрос  не был добавлен!", $link);
        }

        $this->function->flashOk('Вопрос успешно добавлен!', $link);
    }

    public function actionAnswerQuestion($params)
    {
        $question = $params['question'];
        $id = $params['id'];
        $name = $params['name'];
        $email = $params['email'];
        $idTheme = $params['id_theme'];
        $answer = $params['answer'];
        $link = 'admin.php?view=Questions';

        if (!isset($idTheme) ||
            !isset($id) ||
            !isset($answer) ||
            !isset($question) ||
            !isset($name) ||
            !isset($email) ||
            (int)$idTheme === 0 ||
            (int)$id === 0 ||
            trim($question) === '' ||
            trim($answer) === '' ||
            trim($name) === '' ||
            trim($email) === '') {
            $this->function->flashError("Не существуют основные параметры!", $link);
        }

        $res = $this->questions->answer($question, $id, $name, $email, $idTheme, $answer);

        if ((int)$res === 0) {
            $this->function->flashError("К сожалению вопрос  не был добавлен!", $link);
        }

        $this->function->flashOk('Вопрос успешно добавлен!', $link);
    }

    public function actionDeleteQuestion($params)
    {
        $id = $params['id'];
        $link = 'admin.php?view=Questions';

        if (!isset($id) || (int)$id === 0) {
            $this->function->flashError("Не существуют основные параметры!", $link);
        }

        $res = $this->questions->select('question', ['id' => $id]);
        if (count($res) === 0) {
            $this->function->flashError("Такого вопроса, нет!", $link);
        }

        $res = $this->questions->delete($id);
        $this->function->flashOk('Вопрос успешно удален!', $link);
    }

    //получает массив информации для счетчиков в блоке контента
    public function contentCounter()
    {
        return $this->content->getCounter();
    }

    public function actionLogin($params)
    {
        $login = $params['login'];
        $password = $params['password'];

        $this->action->login($login, $password);
    }

    //выход из админки
    public function actionLogOut()
    {
        unset($_SESSION['login']);
        $this->action->logOut();
    }

    //проверка на авторизацию
    public function isLogin()
    {
        return $this->action->authIsLogin();
    }
}