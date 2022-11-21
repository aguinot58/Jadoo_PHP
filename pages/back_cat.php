<?php

    session_start();

    if (!isset($_SESSION['logged'])){
        $_SESSION['logged'] = 'non';
    }

    if (!isset($_SESSION['modif_cat'])){
        $_SESSION['modif_cat'] = false;
    }

    if ($_SESSION['modif_cat']== true){
        ?>
            <script type="text/javascript">
                alert ("Catégorie de plats modifiée avec succès !");
            </script>
        <?php
        $_SESSION['modif_cat']= false;
    }

    if (!isset($_SESSION['suppr_cat'])){
        $_SESSION['suppr_cat'] = false;
    }

    if ($_SESSION['suppr_cat']== true){
        ?>
            <script type="text/javascript">
                alert ("Catégorie de plats supprimée avec succès !");
            </script>
        <?php
        $_SESSION['suppr_cat']= false;
    }

    if (!isset($_SESSION['ajout_cat'])){
        $_SESSION['ajout_cat'] = false;
    }

    if ($_SESSION['ajout_cat']== true){
        ?>
            <script type="text/javascript">
                alert ("Catégorie de plats ajoutée avec succès !");
            </script>
        <?php
        $_SESSION['ajout_cat']= false;
    }

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

?>
    
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Admin_cat_Jadoo</title>
        <link rel="shortcut icon" type="image/ico" href="./../img/favicon.ico">
    
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <!-- Font Awesome CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/fontawesome.min.css" integrity="sha512-xX2rYBFJSj86W54Fyv1de80DWBq7zYLn2z0I9bIhQG+rxIF6XVJUpdGnsNHWRa6AvP89vtFupEPDP8eZAtu9qA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>   
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
        </style>
        <link rel="stylesheet" href="./../css/back.css"/>
    
    </head>

    <body>

        <header>
            <!-- Fixed navbar -->
            <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                <div class="container">
                    <a class="navbar-brand" href="./../index.php">Jadoo</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <?PHP

                    if ($_SESSION['logged'] == 'oui') {

                        echo '<div class="collapse navbar-collapse" id="navbarCollapse">
                            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="./../pages/back_office.php">Accueil Admin</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="./../pages/back_plat.php">Plats</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="./../pages/back_cat.php">Catégories</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="./../pages/back_msg.php">Messages</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="./../pages/logout.php">Déconnexion</a>
                                </li>
                            </ul>
                        </div>';
                    } 
                    ?>
                </div>
            </nav>
        </header>

        <main>
            <?php 

                if ($_SESSION['logged'] == 'oui') {

                    echo '<div class="container">
                        <h3 class="mt-3">Ajout d\'une catégorie de plats dans la base de données</h3>
                        <!-- Formulaire d\'ajout de catégorie de plats dans la bdd -->
                        <form class="form-ajout" method="post" enctype="multipart/form-data" onsubmit="return valider_cat()" action="./../pages/ajout_cat.php">
                            <div class="row mt-4 mb-3">
                                <div class="col">
                                    <label for="nom_cat" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="nom_cat" name="nom_cat">
                                    <div id="emailHelp" class="form-text">40 caractères maximum.</div>
                                </div>
                            </div>
                            <!-- Bouton d\'ajout -->
                            <div class="row d-flex justify-content-center mt-5 mb-3">
                                <div class="col-2">
                                    <button type="submit" class="btn btn-primary">Ajouter</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Trait de séparation -->
                    <div class="container">
                        <div class="divider py-1 bg-dark"></div>
                    </div>

                    <!-- liste des catégories de plats -->
                    <div class="container mb-5 table-responsive">
                        <h3 class="mt-3 mb-4">Liste des catégories</h3>';

                        require $lien.'pages/conn_bdd.php';

                            try{

                                $sth = $conn->prepare("SELECT COUNT(Id_Categorie) FROM categories");
                                $sth->execute();
                                //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
                                $nb_cats_tot = $sth->fetchColumn();

                                $page = (!empty($_GET['page']) ? $_GET['page'] : 1);
                                $limite = 10;
                                $debut = ($page - 1) * $limite;
                                $nombreDePages = ceil($nb_cats_tot / $limite);

                                $sth = $conn->prepare("SELECT * FROM categories LIMIT :limite OFFSET :debut");
                                $sth->bindValue('limite', $limite, PDO::PARAM_INT);
                                $sth->bindValue('debut', $debut, PDO::PARAM_INT); 
                                $sth->execute();
                                //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
                                $categories = $sth->fetchAll(PDO::FETCH_ASSOC);

                                $total_pages = ceil($nb_cats_tot/10);

                                echo '<table class="table table-striped" id="tableau_projets">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center text-nowrap">Id <img class="fleches" src="'.$lien.'img/up-and-down-arrows.png" alt="flèches de tri"></th>
                                                <th scope="col" class="text-center text-nowrap">Nom <img class="fleches" src="'.$lien.'img/up-and-down-arrows.png" alt="flèches de tri"></th>
                                                <th scope="col" class="text-center text-nowrap">Outils</th>
                                            </tr>
                                        </thead>
                                        <tbody id="pg-results">
                                        </tbody>
                                    </table>
                                    <div class="">
                                        <div class="pagination d-flex justify-content-center"></div>
                                    </div>';

                                /*Fermeture de la connexion à la base de données*/
                                $sth = null;
                                $conn = null;
                            }
                            catch(PDOException $e){
                                
                                date_default_timezone_set('Europe/Paris');
                                setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
                                $format1 = '%A %d %B %Y %H:%M:%S';
                                $date1 = strftime($format1);
                                $fichier = fopen('./../log/error_log_back_catt.txt', 'c+b');
                                fseek($fichier, filesize('./../log/error_log_back_cat.txt'));
                                fwrite($fichier, "\n\n" .$date1. " - Erreur import liste catégories. Erreur : " .$e);
                                fclose($fichier);

                                /*Fermeture de la connexion à la base de données*/
                                $sth = null;
                                $conn = null;    
                            }

            echo '</div>';
            } else {

                echo '<div class="container">
                        <h3 class="mt-5 mb-5">Merci de vous connecter à votre compte.</h3>
                    </div>';

            }
        ?>    
        </main>

        <footer class="footer mt-auto py-3 bg-dark">
            <span class="text-muted d-flex justify-content-center"><p>Tous droits réservés @jadoo.com</p></span>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="//rawgit.com/botmonster/jquery-bootpag/master/lib/jquery.bootpag.min.js" type="text/javascript"></script>
        <script src="./../js/back_cat.js"></script> 

        <script type="text/javascript">
            $(document).ready(function() {
                $("#pg-results").load("fetch_data_cat.php");
                $(".pagination").bootpag({
                    total: <?php echo $total_pages; ?>,
                    page: 1,
                    maxVisible: 5,
                    wrapClass: 'pagination',
                    activeClass: 'active',
                    disabledClass: 'disabled',
                }).on("page", function(e, page_num){
                    e.preventDefault();
                    /*$("#results").prepend('<div class="loading-indication"><img src="ajax-loader.gif" /> Loading...</div>');*/
                    $("#pg-results").load("fetch_data_cat.php", {"page": page_num});
                });
            });
        </script>
        <script src="./../js/tri_tableau.js"></script> 
    </body>
    
</html>




<div class="modal fade modal-lg" id="Modif_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modification d'un plat</h5>
      </div>
      <div class="modal-body" id="affichage_modal">
            <!-- affichage des données depuis le fetch en js -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
    </div>
    </div>
  </div>
</div>


