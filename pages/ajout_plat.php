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

    $nom_plat = str_replace("'"," ",valid_donnees($_POST["nom_plat"]));
    $desc_plat = str_replace("'"," ",valid_donnees($_POST["desc_plat"]));
    $img_plat = valid_donnees($_FILES['img_plat']['name']);
    $cat_plat = valid_donnees($_POST["cat_plat"]);
    $visibilite_plat = valid_donnees($_POST["visibilite_plat"]);

    if ($visibilite_plat=="oui"){
        $visibilite_pt = 1;
    } else {
        $visibilite_pt = 0;
    }
    
    if (!empty($nom_plat) && !empty($visibilite_plat) && !empty($desc_plat) && !empty($img_plat) && !empty($cat_plat) && 
        ($_FILES['img_plat']['type']=="image/png" || $_FILES['img_plat']['type']="image/jpg" || $_FILES['img_plat']['type']="image/jpeg") &&
        strlen($nom_plat) <= 40 && strlen($desc_projet) <= 255) {

        // chemin complet de la jaquette choisie par l'utilisateur
        $file = $_FILES['img_plat']['tmp_name'];

        // dossier de sauvegarde de l'image après traitement
        $folder_save = "./../img/";

        $identifiant = $_SESSION['user'];

            try{

                //On insère une partie des données reçues dans la table jeux
                $sth = $conn->prepare("INSERT INTO plats (Nom, Description, Image, Id_Categorie, Visible) VALUES
                        (:nom_plat, :desc_plat, :img_plat, :cat_plat, :visibilite_proj)");
                $sth->bindParam(':nom_plat', $nom_plat);    
                $sth->bindParam(':desc_plat', $desc_plat);
                $sth->bindParam(':img_plat', $img_plat); 
                $sth->bindParam(':cat_plat', $cat_plat); 
                $sth->bindParam(':visibilite_plat', $visibilite_pt); 
                $sth->execute();
            
                /*Fermeture de la connexion à la base de données*/
                $sth = null;
                $conn = null;

                switch($cat_plat){
                    case 2:
                        modifier_image($file, $_FILES['img_plat']['name'], $folder_save, 150, 150);
                        break;
                    case 1:
                        modifier_image($file, $_FILES['img_plat']['name'], $folder_save, 320, 320);
                        break;
                }

                $_SESSION['ajout_plat'] = true;

                //On renvoie l'utilisateur vers la page d'administration des jeux
                header("Location:./../pages/back_plat.php");

            }
            catch(PDOException $e){

                //echo 'Impossible de traiter les données. Erreur : '.$e->getMessage();
                write_error_log("./../log/error_log_ajout_plat.txt","Impossible d'injecter les données.", $e);
                echo 'Une erreur est survenue, injection des données annulée.';

                /*Fermeture de la connexion à la base de données*/
                $sth = null;
                $conn = null;
            }

    } else {
        echo "Merci de vérifier les informations saisies";
    }

?>

