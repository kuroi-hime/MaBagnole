<?php
    require_once '../classes/DataBase.php';
    require_once '../classes/Client.php';
    require_once '../classes/Admin.php';

    $pdo = DataBase::getPDO();
    $currentClient = Client::getById($_POST['id_user'], $pdo);
    $currentClient->statut ? Admin::bloquerClient($pdo, $_POST['id_user']):Admin::debloquerClient($pdo, $_POST['id_user']);

    header('location:../pages/dashbordAdmin.php?tab=clients');
?>