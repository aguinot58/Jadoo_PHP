<?php
    session_start();

    if (!isset($_SESSION['logged'])){
        $_SESSION['logged'] = 'non';
    }

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="./css/fonts.css">
        <link rel="stylesheet" href="./css/header_footer.css">
        <link rel="stylesheet" href="./css/style.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title>Jadoo : un voyage culinaire gourmet et gourmand</title>
        <link rel="shortcut icon" type="image/ico" href="./img/favicon.ico">
    </head>

    <body>
        <?php
            if(isset($_COOKIE["Suppression"])) {

                echo '<script>alert("Profile supprimé avec succès. Vous avez été déconnecté.");</script>';
                setcookie("Suppression", "", time() -3600, "/");

            }
        ?>
        <main>
            <?php
                /* importation header */
                include $lien.'pages/header.php'
            ?>
            <section id="section-1">
                <noscript>
                    <article class="sans-script">Le javascript est désactivé !<br>Vous risquez de rencontrer des dysfonctionnements sur le site.<br><br>
                            Pour une navigation optimale, activez le javascript et rechargez la page.
                    </article>
                </noscript>
                <article>
                    <h3 class="texte-couleur-saumon">UN VOYAGE CULINAIRE GOURMET ET GOURMAND.</h3>
                    <h1 class="souligne-texte-rose">Bienvenue<br>au restaurant<br>Jadoo</h1>
                    <h5 class="texte-couleur-gris-1">Jadoo vous accueille
                                dans son ambiance zen et épurée, idéale pour découvrir ou redécouvrir la
                                cuisine gastronomique du Chef Junichi IIDA.</h5>
                    <button class="bouton jaune">Découvrir la carte</button>

                </article>
            </section>
            <section id="section-2">
                <div class="conteneur-titres">
                    <h4>Découvrez</h4>
                    <h2>Les nouveautés Jadoo</h2>
                </div>
                <div id="conteneur-nouveautes" class="conteneur-elements">
                    <div class="conteneur-carte conteneur-carte-ligne">
                        <?php

                            /* Connexion à une base de données en PDO */
                            $configs = include('./pages/config.php');
                            $servername = $configs['servername'];
                            $username = $configs['username'];
                            $password = $configs['password'];
                            //On établit la connexion
                            try{
                                $conn = new PDO("mysql:host=$servername;dbname=jadoo;charset=UTF8", $username, $password);
                                //On définit le mode d'erreur de PDO sur Exception
                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                try{

                                    $tb_tirage_pc = array();

                                    // Selection de tous les Id de plats chauds
                                    $sth = $conn->prepare("SELECT Id FROM plats where Id_Categorie = '1'");
                                    $sth->execute();
                                    $tb_Id_pc = $sth->fetchAll(PDO::FETCH_ASSOC);

                                    for ($i=0; $i<3; $i++){

                                        // tirage d'un numéro aléatoire entre 0 et le nombre max de plats chauds -1 
                                        // puisque notre tableau part d'un indice 0
                                        $nb_tirage_pc = rand(0, (count($tb_Id_pc))-1);

                                        // on récupère la valeur de l'Id correspondant à l'indice tiré aléatoirement
                                        $tb_Id_valeur_pc = $tb_Id_pc[$nb_tirage_pc]['Id'];

                                        // on ajoute la valeur à notre tableau de tirage
                                        array_push($tb_tirage_pc, $tb_Id_valeur_pc);

                                        // on supprime l'indice utilisé du tableau des Id des plats chauds
                                        unset($tb_Id_pc[$nb_tirage_pc]);

                                        // on remet à jour les indices de notre tableau de plats chauds pour qu'il n'y ait pas
                                        // des indices manquants, ce qui provoquerait une possible erreur lors d'un tirage suivant
                                        // si on tire à nouveau le même chiffre qu'un indice supprimé.
                                        $tb_Id_pc = array_values($tb_Id_pc);

                                    }

                                    foreach ($tb_tirage_pc as $valeur) {

                                        //Sélectionne les valeurs dans les colonnes pour chaque entrée de la table
                                        $sth = $conn->prepare("SELECT Nom, Description, Image FROM plats where Id = '$valeur'");
                                        $sth->execute();
                                        //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
                                        $plats = $sth->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($plats as $plat) {

                                            echo    '<article class="carte">
                                                    <figure>
                                                        <img title="' .$plat['Nom']. '" src="./img/' .$plat['Image']. '" alt="Image ' .$plat['Nom']. '">
                                                        <figcaption>' .$plat['Description']. '</figcaption>
                                                    </figure>
                                                </article>';
                                                    
                                        };

                                    };


                                    // Version de base sans tirage aléatoire affichant les 3 derniers plats chauds
                                    /*
                                    //Sélectionne les valeurs dans les colonnes pour chaque entrée de la table
                                    $sth = $conn->prepare("SELECT Nom, Description, Image FROM plats INNER JOIN categories ON plats.Id_Categorie = categories.Id_Categorie where categories.Categorie = 'plats_chauds' order by Id DESC LIMIT 3");
                                    $sth->execute();
                                    //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
                                    $plats = $sth->fetchAll(PDO::FETCH_ASSOC);
        
                                    foreach ($plats as $plat) {
        
                                        echo    '<article class="carte">
                                                    <figure>
                                                        <img title="' .$plat['Nom']. '" src="./img/' .$plat['Image']. '" alt="Image ' .$plat['Nom']. '">
                                                        <figcaption>' .$plat['Description']. '</figcaption>
                                                    </figure>
                                                </article>';
                                                
                                    };*/

                                    //Fermeture de la connexion à la base de données
                                    $sth = null;
                                    $conn = null;
        
                                }
                                catch(PDOException $e){
        
                                    date_default_timezone_set('Europe/Paris');
                                    setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
                                    $format1 = '%A %d %B %Y %H:%M:%S';
                                    $date1 = strftime($format1);
                                    $fichier = fopen('./../log/error_log_index.txt', 'c+b');
                                    fseek($fichier, filesize('./../log/error_log_index.txt'));
                                    fwrite($fichier, "\n\n" .$date1. " - Erreur import plats chauds. Erreur : " .$e);
                                    fclose($fichier);

                                    /*Fermeture de la connexion à la base de données*/
                                    $sth = null;
                                    $conn = null;
                                    
                                }

                            }
                            /*On capture les exceptions et si une exception est lancée, on écrit dans un fichier log
                            *les informations relatives à celle-ci*/
                            catch(PDOException $e){
                            //echo "Erreur : " . $e->getMessage();
                            date_default_timezone_set('Europe/Paris');
                            setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
                            $format1 = '%A %d %B %Y %H:%M:%S';
                            $date1 = strftime($format1);
                            $fichier = fopen('./../log/error_log_index.txt', 'c+b');
                            fseek($fichier, filesize('./../log/error_log_index.txt'));
                            fwrite($fichier, "\n\n" .$date1. " - Impossible de se connecter à la base de données. Erreur : " .$e);
                            fclose($fichier);

                            echo    '<article class="connexion-bdd-hs">

                                        <p>Une erreur est survenue lors de la connexion à la base de données.<br><br>
                                            Merci de rafraichir la page, et si le problème persiste, de réessayer ultérieurement.   </p>

                                    </article>';

                            }

                        ?>
                    </div>
                </div>
                <div id="conteneur-maki" class="conteneur-elements">
                    <div class="conteneur-carte conteneur-carte-ligne">

                        <?php

                            /* Connexion à une base de données en PDO */
                            $configs = include('./pages/config.php');
                            $servername = $configs['servername'];
                            $username = $configs['username'];
                            $password = $configs['password'];
                            //On établit la connexion
                            try{
                                $conn = new PDO("mysql:host=$servername;dbname=jadoo;charset=UTF8", $username, $password);
                                //On définit le mode d'erreur de PDO sur Exception
                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
                                
                                try{

                                    $tb_tirage = array();

                                    // Selection de tous les Id de makis
                                    $sth = $conn->prepare("SELECT Id FROM plats where Id_Categorie = '2'");
                                    $sth->execute();
                                    $tb_Id = $sth->fetchAll(PDO::FETCH_ASSOC);

                                    for ($i=0; $i<4; $i++){

                                        // tirage d'un numéro aléatoire entre 0 et le nombre max de makis -1 
                                        // puisque notre tableau part d'un indice 0
                                        $nb_tirage = rand(0, (count($tb_Id))-1);

                                        // on récupère la valeur de l'Id correspondant à l'indice tiré aléatoirement
                                        $tb_Id_valeur = $tb_Id[$nb_tirage]['Id'];

                                        // on ajoute la valeur à notre tableau de tirage
                                        array_push($tb_tirage, $tb_Id_valeur);

                                        // on supprime l'indice utilisé du tableau des Id des makis
                                        unset($tb_Id[$nb_tirage]);

                                        // on remet à jour les indices de notre tableau de makis pour qu'il n'y ait pas
                                        // des indices manquants, ce qui provoquerait une possible erreur lors d'un tirage suivant
                                        // si on tire à nouveau le même chiffre qu'un indice supprimé.
                                        $tb_Id = array_values($tb_Id);

                                    }

                                    foreach ($tb_tirage as $valeur) {

                                        //Sélectionne les valeurs dans les colonnes pour chaque entrée de la table
                                        $sth = $conn->prepare("SELECT Nom, Description, Image FROM plats where Id = '$valeur'");
                                        $sth->execute();
                                        //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
                                        $plats = $sth->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($plats as $plat) {

                                            echo    '<article class="carte">
                                                        <figure>
                                                            <img title="' .$plat['Nom']. '" src="./img/' .$plat['Image']. '" alt="Image '.$plat['Nom']. '">
                                                            <figcaption>
                                                                <p class="texte-couleur-bleu texte-poppins-bold">' .utf8_encode($plat['Nom']). '</p>
                                                                <p>' .$plat['Description']. '</p>
                                                            </figcaption>
                                                        </figure>
                                                    </article>';
        
                                        };

                                    };

                                    // Version de base sans tirage aléatoire pour sélectionner les 4 derniers makis.
                                    /*
                                    //Sélectionne les valeurs dans les colonnes pour chaque entrée de la table
                                    $sth = $conn->prepare("SELECT Nom, Description, Image FROM plats INNER JOIN categories ON plats.Id_Categorie = categories.Id_Categorie where categories.Categorie = 'makis' order by Id DESC LIMIT 4");
                                    $sth->execute();
                                    //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
                                    $plats = $sth->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($plats as $plat) {

                                        echo    '<article class="carte">
                                                    <figure>
                                                        <img title="' .$plat['Nom']. '" src="./img/' .$plat['Image']. '" alt="Image '.$plat['Nom']. '">
                                                        <figcaption>
                                                            <p class="texte-couleur-bleu texte-poppins-bold">' .$plat['Nom']. '</p>
                                                            <p>' .$plat['Description']. '</p>
                                                        </figcaption>
                                                    </figure>
                                                </article>';

                                    };*/

                                    //Fermeture de la connexion à la base de données
                                    $sth = null;
                                    $conn = null;

                                }
                                catch(PDOException $e){

                                    date_default_timezone_set('Europe/Paris');
                                    setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
                                    $format1 = '%A %d %B %Y %H:%M:%S';
                                    $date1 = strftime($format1);
                                    $fichier = fopen('./../log/error_log_index.txt', 'c+b');
                                    fseek($fichier, filesize('./../log/error_log_index.txt'));
                                    fwrite($fichier, "\n\n" .$date1. " - Erreur import makis. Erreur : " .$e);
                                    fclose($fichier);
                                    
                                }

                            }
                            /*On capture les exceptions et si une exception est lancée, on écrit dans un fichier log
                            *les informations relatives à celle-ci*/
                            catch(PDOException $e){
                            //echo "Erreur : " . $e->getMessage();
                            date_default_timezone_set('Europe/Paris');
                            setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
                            $format1 = '%A %d %B %Y %H:%M:%S';
                            $date1 = strftime($format1);
                            $fichier = fopen('./../log/error_log_index.txt', 'c+b');
                            fseek($fichier, filesize('./../log/error_log_index.txt'));
                            fwrite($fichier, "\n\n" .$date1. " - Impossible de se connecter à la base de données. Erreur : " .$e);
                            fclose($fichier);

                            echo    '<article class="connexion-bdd-hs">

                                        <p>Une erreur est survenue lors de la connexion à la base de données.<br><br>
                                            Merci de rafraichir la page, et si le problème persiste, de réessayer ultérieurement.   </p>

                                    </article>';

                            }

                        ?>
                    </div>
                </div>
                <button class="bouton jaune">Découvrir la carte</button>
            </section>
            <section id="section-3">
                <div class="conteneur-video">
                    <img src="./img/visu_video.jpg" alt="Image Prévisualisation vidéo">
                    <div class="video-lecture-bouton">
                        <img title="Lire la vidéo" src="./img/button_play.svg" alt="Bouton lecture">
                    </div>
                </div>
                <article>
                    <h1 class="souligne-texte-rose">Un voyage<br>gastronomique entre le Japon et la France...</h1>
                    <h5>Passé par des maisons étoilées en France, le
                        cuisinier japonais s'est forgé une solide expérience dans l'Hexagone :
                        aujourd'hui franc-comtois d'adoption, il maîtrise aujourd'hui les
                        mélanges de cultures et de saveurs chaque jour au sein de
                        son restaurant gastronomique.</h5>
                </article>
                <div class="conteneur-illustrations conteneur-carte-ligne">
                    <figure class="mobile-illustration">
                        <img src="./img/illustration_chef.jpg" alt="Image chef">
                    </figure><!--
                    -->
                    <figure>
                        <img src="./img/wrapper_illustration_1.jpg" alt="Image plat maki">
                    </figure><!--
                    --><figure>
                        <img src="./img/wrapper_illustration_2.jpg" alt="Image salle de restauration">
                    </figure>
                </div>
            </section>
            <section id="section-4">
                <article>
                    <h4>RAPIDE ET PRATIQUE</h4>
                    <h2><span class="texte-couleur-saumon">Commandez</span> sur le site Jadoo</h2>
                    <div class="conteneur-elements">
                        <div class="conteneur-arguments">
                            <a class="argument" href="#" target="_blank">
                                <figure>
                                    <img title="UberEats" src="./img/logo_uberEats.png" alt="Logo UberEats"><!--
                                    --><figcaption>
                                        <p class="texte-couleur-sombre texte-poppins-bold">UberEats</p>
                                        <p class="texte-couleur-gris-3">Commandez tous vos plats depuis UberEats</p>
                                    </figcaption>
                                </figure>
                            </a>
                            <a class="argument" href="#" target="_blank">
                                <figure>
                                    <img title="Jadoo" src="./img/logo_jadoo_1.svg" alt="Logo Jadoo"><!--
                                    --><figcaption>
                                        <p class="texte-couleur-sombre texte-poppins-bold">Jadoo.fr</p>
                                        <p class="texte-couleur-gris-3">Ou commandez en ligne sur le site officiel de Jadoo</p>
                                    </figcaption>
                                </figure>
                            </a>
                            <figure class="argument">
                                <img title="Livraison rapide" src="./img/logo_transport.png" alt="Logo livreur"><!--
                                --><figcaption>
                                    <p class="texte-couleur-sombre texte-poppins-bold">Livraison ultra rapide</p>
                                    <p class="texte-couleur-gris-3">Soyez livré en 20 minutes maximum</p>
                                </figcaption>
                            </figure>
                        </div>
                        <button class="bouton jaune">Découvrir la carte</button>
                    </div>
                </article>
            </section>
            <section id="section-5">
                <h4>PRENDRE RENDEZ-VOUS</h4>
                <div class="conteneur-form">
                    <div class="form-gauche">
                        <h4 class="texte-couleur-noir">Formulaire de contact</h4>
                        <h5 class="texte-couleur-gris-2">Remplissez le formulaire ci-dessous<br>pour nous contacter</h5>
                        <form method="POST" onsubmit="return valider()" action="./pages/formulaire.php">
                            <div class="formulaire-deux-champs-inline">
                                <div class="formulaire-contact-champ">
                                    <label for="nom">Nom</label>
                                    <input id="nom" name="nom" type="text" pattern="^[A-Za-z '-]+$" maxlength="40" placeholder="Nom" required="">
                                </div><!--
                                --><div class="formulaire-contact-champ">
                                    <label for="prenom">Prénom</label>
                                    <input id="prenom" name="prenom" type="text" pattern="^[A-Za-z '-]+$" maxlength="40" placeholder="Prénom" required="">
                                </div>
                            </div>
                            <div class="formulaire-contact-champ">
                                <label for="mail">Adresse e-mail</label>
                                <input id="mail" name="email" type="mail" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" maxlength="255" placeholder="monAdresseMail@gmail.com" required="">
                            </div>
                            <div class="formulaire-contact-champ">
                                <label for="message">Message</label>
                                <input id="message" name="message" type="text" minlength="2" maxlength="500" placeholder="Votre message/demande de réservation" required="">
                            </div>
                            <button class="bouton bleu formulaire-boutton-envoyer" value="Submit">
                                <img src="./img/bouton_formulaire_coche.svg" alt="Icon coche">
                                <span>Envoyer</span>
                            </button>
                        </form>
                    </div><!--
                    --><div class="form-droite"></div>
                </div>
            </section>
            <?php
                /* imporation du footer */
                include $lien.'pages/footer.php'
            ?>
        </main>
        <script src="./js/verif.js"></script>

    </body>
</html>
