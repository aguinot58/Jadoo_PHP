<?php

    session_start();

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

    if (!isset($_SESSION['img_plat_modif'])){
        $_SESSION['img_plat_modif'] = 'non';
    }

    require $lien.'pages/fonctions.php';
    require $lien.'pages/conn_bdd.php';

    $id_plat = $_POST["id_plat"];
    $nom_plat = str_replace("'"," ",valid_donnees($_POST["nom_plat2"]));
    $desc_plat = str_replace("'"," ",valid_donnees($_POST["desc_plat2"]));
    $cat_plat = valid_donnees($_POST["cat_plat2"]);
    $visibilite_plat = valid_donnees($_POST["visibilite_plat2"]);

    if ($visibilite_plat==1){
        $visibilite_pt = 1;
    } else {
        $visibilite_pt = 0;
    }

    $img_plat = valid_donnees($_POST["img_plat3"]);
    $_SESSION['img_plat_modif'] = 'non';
    $format_img = true;

    if ($img_plat==""){
        $img_plat = valid_donnees($_FILES['img_plat2']['name']);
        $_SESSION['img_plat_modif'] = 'oui';
        if(($_FILES['img_plat2']['type']=="image/png" || $_FILES['img_plat2']['type']="image/jpg" || $_FILES['img_plat2']['type']="image/jpeg")){
            $format_img = true;
        }else{
            $format_img = false;
        }
    }

    if (!empty($nom_plat) && !empty($desc_plat) && !empty($img_plat) && $format_img == true && !empty($cat_plat) && 
    strlen($nom_plat) <= 40 && strlen($desc_plat) <= 255 && !empty($id_plat)) {

        try{

            //On met à jour les données reçues dans la table jeux
            $sth = $conn->prepare('UPDATE plats set Nom=:nom_plat, Description=:desc_plat, Image=:img_plat, Id_Categorie=:cat_plat, 
                                       Visible=:visibilite_plat WHERE Id = :id_plat');
            $sth->bindParam(':nom_plat', $nom_plat);    
            $sth->bindParam(':desc_plat', $desc_plat);
            $sth->bindParam(':img_plat', $img_plat); 
            $sth->bindParam(':cat_plat', $cat_plat); 
            $sth->bindParam(':visibilite_plat', $visibilite_pt); 
            $sth->bindParam(':id_plat', $id_plat); 
            $sth->execute();

            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;

            if ($_SESSION['img_platt_modif'] == 'oui') {

                // chemin complet de la jaquette choisie par l'utilisateur
                $file = $_FILES['img_plat2']['tmp_name'];

                // dossier de sauvegarde de l'image après traitement
                $folder_save = "./../img/";

                switch($cat_plat){
                    case 2:
                        modifier_image($file, $_FILES['img_plat2']['name'], $folder_save, 150, 150);
                        break;
                    case 1:
                        modifier_image($file, $_FILES['img_plat2']['name'], $folder_save, 320, 320);
                        break;
                }

            }

            $_SESSION['modif_plat'] = true;

            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;

            //On renvoie l'utilisateur vers la page d'administration des jeux
            header("Location:./../pages/back_plat.php");

        }
        catch(PDOException $e){

            //echo 'Impossible de traiter les données. Erreur : '.$e->getMessage();
            write_error_log("./../log/error_log_update_plat.txt","Impossible de mettre à jour les données.", $e);
            echo 'Une erreur est survenue, mise à jour des données annulée.';

            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;
        }

    } else {

        echo $id_plat.'<br>';
        echo $nom_plat.'<br>';
        echo $desc_plat.'<br>';
        echo $cat_plat.'<br>';
        echo $visibilite_pt.'<br>';
        echo $img_plat.'<br>';
        echo $format_img.'<br>';
        echo "Merci de vérifier les informations saisies";
    
    }
?>