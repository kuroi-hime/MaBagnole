<?php
    require_once '../classes/Utilisateur.php';
    require_once '../classes/DataBase.php';
    
    try{ 
        $pdo = DataBase::getPDO();
        $currentUser = Utilisateur::connexion($pdo, $_POST['email'], $_POST['password']);
        
        session_start();
        $_SESSION['id'] = $currentUser->getId();
        $_SESSION['name'] = $currentUser->getNom();
        if(isset($_SESSION['email']))
            unset($_SESSION['email']);
        if($currentUser->getRole()=='client')
            header('location:../pages/accueil.php');
        else
            header('location:../pages/dashbordAdmin.php');
    }catch(Exception $e){
        if($e->getMessage()=='Mot de passe incorrect.'){
            session_start();
            $_SESSION['email'] = $_POST['email'];
            header('location:../pages/authentification.php?error=Mot+de+passe+incorrect.');
        }
        elseif($e->getMessage()=='utilisateur introuvable.')
            header('location:../pages/authentification.php?error=Ce+compte+est+introuvable.');
        else
            echo $e->getMessage();
    }finally{
        unset($pdo);
    }
?>