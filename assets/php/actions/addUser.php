<?php
    // namespace App\classes;
    require_once '../classes/Client.php';
    require_once '../classes/DataBase.php';
    
    $client = new Client();
    $client->setNom($_POST['nom']);
    $client->setEmail($_POST['email']);
    $client->setMotDePassHash($_POST['password']);
    $client->setCIN($_POST['cin']);
    $client->setTelephone($_POST['telephone']);
    $client->setAdresse($_POST['adresse']);
    $client->setVille($_POST['ville']);
    try{ 
        $pdo = DataBase::getPDO();
    }catch(Exception){
        echo "Connexion à échoué.";
    }
    Client::inscription($pdo, $client);
    unset($pdo);
    
    header('location:../pages/authentification.php');
?>