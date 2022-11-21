<?php

    session_start();

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

    require $lien.'pages/fonctions.php';
    require $lien.'pages/conn_bdd.php';

    $nom_cat = str_replace("'"," ",valid_donnees($_POST["nom_cat"]));
    
    if (!empty($nom_cat)) {

        try{

            //On insère une partie des données reçues dans la table jeux
            $sth = $conn->prepare("INSERT INTO categories (Categorie) VALUES (:nom_cat)");
            $sth->bindParam(':nom_cat', $nom_cat);    
            $sth->execute();
            
            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;

            $_SESSION['ajout_cat'] = true;

            //On renvoie l'utilisateur vers la page d'administration des jeux
            header("Location:./../pages/back_cat.php");

        }
        catch(PDOException $e){

            //echo 'Impossible de traiter les données. Erreur : '.$e->getMessage();
            write_error_log("./../log/error_log_ajout_cat.txt","Impossible d'injecter les données.", $e);
            echo 'Une erreur est survenue, injection des données annulée.';

            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;
        }

    } else {
        echo "Merci de vérifier les informations saisies";
    }

?>

