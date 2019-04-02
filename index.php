<?php
session_start();

require_once('controller/IndexController.php');
$indexController = new IndexController;

$indexController->viewHead();
$indexController->viewFlashShow();
$indexController->viewCategories();

if (!isset($_GET['view'])) {
    $indexController->viewContent();
}

if (isset($_GET['view']) && method_exists($indexController, 'view' . $_GET['view'])) {

    call_user_func([$indexController, 'view' . $_GET['view']]);
}

$indexController->viewAddQuestion();
$indexController->viewScripts();

if (isset($_POST['action']) && method_exists($indexController, 'action' . $_POST['action'])) {
    call_user_func([$indexController, 'action' . $_POST['action']], $_POST);
}
