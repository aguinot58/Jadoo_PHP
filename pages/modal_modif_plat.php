<?php

    session_start();

    if(!empty($_POST) && array_key_exists("id_plat", $_POST)){

        $id_plat = $_POST['id_plat'];

        $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

        if ($curPageName == "index.php") {
            $lien = "./";
        } else {
            $lien = "./../";
        }

        require $lien.'pages/conn_bdd.php';

            try{

                $sth = $conn->prepare("SELECT * FROM plats where Id = $id_plat");
                $sth->execute();
                //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
                $plats = $sth->fetchAll(PDO::FETCH_ASSOC);

                foreach ($plats as $plat) {

                    echo '  <form class="form-ajout" method="post" enctype="multipart/form-data" onsubmit="return valider_plat2()" action="./../pages/update_plat.php">
                                <div class="row mt-4 mb-3">
                                    <div class="col">
                                        <label for="nom_plat2" class="form-label">Nom</label>
                                        <input type="text" class="form-control" id="nom_plat2" name="nom_plat2" value="'.$plat['Nom'].'">
                                        <div id="emailHelp" class="form-text">40 caractères maximum.</div>
                                    </div>
                                    <div class="col">
                                        <label for="cat_plat2" class="form-label">Catégorie de plat</label>
                                        <select id="cat_plat2" class="form-select" name="cat_plat2" aria-label="Default select example">';

                                            try{

                                                //Sélectionne les valeurs dans les colonnes pour chaque entrée de la table
                                                $sth = $conn->prepare("SELECT distinct(Id_Categorie), Categorie FROM categories ORDER BY Id_Categorie ASC");
                                                $sth->execute();
                                                //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
                                                $categories = $sth->fetchAll(PDO::FETCH_ASSOC);

                                                // on remplit la liste de sélection de catégorie
                                                foreach ($categories as $categorie) {

                                                    if ($categorie['Id_Categorie'] == $projet['Id_Categorie']){
                                                        echo '<option selected value="'.$categorie['Id_Categorie'].'">'.$categorie['Categorie'].'</option>';
                                                    } else {
                                                        echo '<option value="'.$categorie['Id_Categorie'].'">'.$categorie['Categorie'].'</option>';
                                                    }
                                                };
                                            }
                                            catch(PDOException $e){
                                
                                                date_default_timezone_set('Europe/Paris');
                                                setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
                                                $format1 = '%A %d %B %Y %H:%M:%S';
                                                $date1 = strftime($format1);
                                                $fichier = fopen('./../log/error_log_modif_plat.txt', 'c+b');
                                                fseek($fichier, filesize('./../log/error_log_modif_plat.txt'));
                                                fwrite($fichier, "\n\n" .$date1. " - Erreur import liste des catégories de plats. Erreur : " .$e);
                                                fclose($fichier);
                            
                                                //Fermeture de la connexion à la base de données
                                                $sth = null;
                                                $conn = null;    
                                            }

                                echo    '</select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="desc_plat2" class="form-label">Description</label>
                                        <textarea type="text" class="form-control" id="desc_plat2" name="desc_plat2" rows="5">'.$plat['Description'].'</textarea>
                                        <div id="emailHelp" class="form-text">255 caractères maximum.</div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <div id="input_file" class="d-none row">
                                            <label for="img_plat2" class="form-label">Image</label>
                                            <div class="col">
                                                <input class="form-control" type="file" id="img_plat2" name="img_plat2">
                                            </div>
                                        </div>
                                        <div id="input_text" class="row">
                                            <label for="img_plat3" class="form-label">Image</label>
                                            <div class="col">
                                                <input type="text" class="form-control" id="img_plat3" name="img_plat3" value="'.$plat['Image'].'">
                                            </div>
                                            <div class="col">
                                                <button type="button" class="btn btn-primary" id="btn-modif-contenu" onclick="Modif_contenu_page()">Modifier</button>
                                            </div>
                                        </div>
                                        <div id="emailHelp" class="form-text">Pas d\'apostrophe dans le nom - remplacer les espaces par des underscores - format jpg/jpeg/png.</div>
                                    </div>
                                </div>
                                <div class="row mb-3">    
                                    <div class="col">
                                        <label for="visibilite_plat2" class="form-label">Projet visible sur site</label>
                                        <select id="visibilite_plat2" class="form-select" name="visibilite_plat2" aria-label="Default select example">';

                                            if ($plat['Visible']==1){
                                                echo    '<option selected value=1>Oui</option>
                                                        <option value=0>Non</option>';
                                            } else {
                                                echo    '<option value=1>Oui</option>
                                                        <option selected value=0>Non</option>';
                                            }

                                echo '  </select>
                                    </div>
                                </div>                         
                                <div class="col-1">
                                        <label for="id_plat" class="invisible">Id du plat</label>
                                        <input type="text" class="form-control invisible" id="id_plat" name="id_plat" value="'.$id_plat.'">
                                    </div>
                                    <div class="d-flex justify-content-center"">
                                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                                    </div>
                                </div>
                            </form>';

                            /*Fermeture de la connexion à la base de données*/
                            $sth = null;
                            $conn = null;

                            break;

                }

            }
            catch(PDOException $e){
                                
                date_default_timezone_set('Europe/Paris');
                setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
                $format1 = '%A %d %B %Y %H:%M:%S';
                $date1 = strftime($format1);
                $fichier = fopen('./../log/error_log_modif_plat.txt', 'c+b');
                fseek($fichier, filesize('./../log/error_log_modif_plat.txt'));
                fwrite($fichier, "\n\n" .$date1. " - Erreur import données plat. Erreur : " .$e);
                fclose($fichier);

                /*Fermeture de la connexion à la base de données*/
                $sth = null;
                $conn = null;    

            }

    }else{
        echo 'pb id_plat';
    }

?>