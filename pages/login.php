<?php
    session_start();

    require './../pages/fonctions_communes.php';

    $identifiant = valid_donnees($_POST["login"]);
    $mdp = valid_donnees($_POST["password"]);

    if (empty($identifiant)) {

        $_SESSION['Identifiant'] = 'renseigne';
        header("Location:connexion.php");

    } elseif (empty($mdp)) {

        $_SESSION['mdp'] = 'renseigne';
        header("Location:connexion.php");

    } else {

        $_SESSION['Identifiant'] = 'renseigne';
        $_SESSION['mdp'] = 'renseigne';
        $_SESSION['user']= $identifiant;

        require ('./../pages/conn_bdd.php');    
    
        $pwd_peppered = hash_hmac("sha256", $mdp, $pepper);

        try{
                    
            //On extrait le mdp correspondant à l'identifiant
            $sth = $conn->prepare("SELECT Pwd FROM utilisateurs where Identifiant = '$identifiant'");
            $sth->execute();
            $mdp_hashed = $sth->fetchColumn();
    
            if (password_verify($pwd_peppered, $mdp_hashed)) {
                $_SESSION['logged'] = 'oui';
    
                // on extrait la valeur de la colonne Admin pour vérifier si l'utilisateur peut accéder au back-office
                $sth = $conn->prepare("SELECT Admin FROM utilisateurs where Identifiant = '$identifiant'");
                $sth->execute();
                $administration = $sth->fetchColumn();
    
                if ($administration==1){
                    $_SESSION['admin'] = 'oui';
                } else {
                    $_SESSION['admin'] = 'non';
                }
    
                /*Fermeture de la connexion à la base de données*/
                $sth = null;
                $conn = null;
    
                header("Location:../index.php");
    
            } else {
    
                $_SESSION['logged'] = 'non';
    
                /*Fermeture de la connexion à la base de données*/
                $sth = null;
                $conn = null;
    
                header("Location:connexion.php");
    
            }
    
        }
        catch(PDOException $e){
            //echo 'Impossible de traiter les données. Erreur : '.$e->getMessage();
            write_error_log("./../log/error_log_login.txt","Echec extraction mdp login.", $e);
            echo 'Une erreur est survenue, merci de réessayer ultérieurement.';
    
            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;
        }
    }
?>