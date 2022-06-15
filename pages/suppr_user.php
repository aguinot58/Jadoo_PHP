<?php

    session_start();

    require './../pages/fonctions_communes.php';
    require ('./../pages/conn_bdd.php');

    $identifiant = $_SESSION['user'];

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

?>