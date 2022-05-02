<?php

    session_start();

    require './../pages/fonctions_communes.php';

    $identifiant = $_SESSION['user'];

    try{

        /* Connexion à une base de données en PDO */
        $configs = include('config.php');
        $servername = $configs['servername'];
        $username = $configs['username'];
        $password = $configs['password'];
        // On établit la connexion
        $conn = new PDO("mysql:host=$servername;dbname=jadoo;charset=UTF8", $username, $password);
        // On définit le mode d'erreur de PDO sur Exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try{

            $sth = $conn->prepare("SELECT Id FROM utilisateurs WHERE Identifiant = '$identifiant'");
            $sth->execute();
            $id_utilisateur = $sth->fetchColumn();


            $sth = $conn->prepare("Delete FROM utilisateurs WHERE Id = :id_utilisateur");
            $sth->bindParam(':id_utilisateur', $id_utilisateur);
            $sth->execute();

            $sth = $conn->prepare("Delete FROM contacts WHERE Id_utilisateur = :id_utilisateur");
            $sth->bindParam(':id_utilisateur', $id_utilisateur);
            $sth->execute();

            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;

            setcookie("Suppression", 1, time() + 60, "/");

            //On renvoie l'utilisateur sur la page pour la rafraichir.
            header("Location:./../pages/logout.php");

        }
        catch(PDOException $e){
            //echo 'Impossible de traiter les données. Erreur : '.$e->getMessage();
            write_error_log("./../log/error_log_suppr_user.txt","Impossible de supprimer les données.", $e);
            echo 'Une erreur est survenue, merci de réessayer ultérieurement.';
    
            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;
        }
    }
    catch(PDOException $e){
        // erreur de connexion à la bdd
        //echo "Erreur : " . $e->getMessage();
        write_error_log("./../log/error_log_suppr_user.txt","Impossible de se connecter à la base de données.", $e);
        echo 'Une erreur est survenue, merci de réessayer ultérieurement.';
    }
?>