<?php
session_start();

require_once('controller/adminController.php');
$adminController = new AdminController;

$adminController->viewHead();
$adminController->viewCategories();
$adminController->viewFlashShow();

if (!isset($_GET['view'])) {
    //echo 'Выполняется отображение addAdmin';
    $adminController->viewAddAdmin();
}

if (isset($_GET['view']) && method_exists($adminController, 'view' . $_GET['view'])) {
    call_user_func([$adminController, 'view' . $_GET['view']]);
}

$adminController->viewScripts();

if (isset($_POST['action']) && method_exists($adminController, 'action' . $_POST['action'])) {
    call_user_func([$adminController, 'action' . $_POST['action']], $_POST);
}

if (isset($_GET['action'])) {
    //выход из админки
    if ($_GET['action'] === 'logOut') {
        $adminController->actionLogOut();
    };
}