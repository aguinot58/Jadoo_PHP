<?php
    /* Connexion à une base de données en PDO */
    $servername = 'localhost';
    $username = 'root';
    $password = '240282';
    //On établit la connexion
    try{
        $conn = new PDO("mysql:host=$servername;dbname=jadoo", $username, $password);
        //On définit le mode d'erreur de PDO sur Exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    /*On capture les exceptions si une exception est lancée et on affiche
    *les informations relatives à celle-ci*/
    catch(PDOException $e){
    //echo "Erreur : " . $e->getMessage();
    date_default_timezone_set('Europe/Paris');
    setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
    $format1 = '%A %d %B %Y %H:%M:%S';
    $date1 = strftime($format1);
    $fichier = fopen('error_log_index.txt', 'c+b');
    fseek($fichier, filesize('error_log_index.txt'));
    fwrite($fichier, "\n\n" .$date1. " - Impossible de se connecter à la base de données. Erreur : " .$e);
    fclose($fichier);
    }
    /* fin procédure de connexion à la BDD */
?>

<!DOCTYPE html>
<html lang="fr"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="fonts.css">
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Jadoo : un voyage culinaire gourmet et gourmand</title>
    <link rel="shortcut icon" type="image/ico" href="./img/favicon.ico">
</head>

<body>
    <main>
        <header>
            <div class="logo">
                <a href="index.php"><img title="Jadoo, un voyage culinaire gourmet et gourmand" src="./img/logo_jadoo_1.svg" alt="Logo jadoo" height="50px"></a><!--
                --><a href="index.php"><img title="Jadoo, un voyage culinaire gourmet et gourmand" src="./img/logo_jadoo_2.svg" alt="Jadoo" height="35px"></a>
            </div>
            <nav>
                <ul>
                    <li class="menu-bouton"><a href="#section-2">Les nouveautés</a></li>
                    <li class="menu-bouton"><a href="#section-3">Découvrir</a></li>
                    <li class="menu-bouton"><a href="#section-4">Commander</a></li>
                    <li class="menu-bouton"><a href="#section-5">Contactez-nous</a></li>
                    <li class="menu-bouton burger">
                        <img title="Menu" src="./img/burger_icon.svg" alt="Icone menu">
                    </li>
                </ul>
            </nav>
        </header>
        <section id="section-1">
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

                        try{

                            /*Sélectionne les valeurs dans les colonnes pour chaque entrée de la table*/
                            $sth = $conn->prepare("SELECT Nom, Description, Image FROM plats INNER JOIN categories ON plats.Id_Categorie = categories.Id_Categorie where categories.Categorie = 'plats_chauds' order by Id DESC LIMIT 3");
                            $sth->execute();
                            /*Retourne un tableau associatif pour chaque entrée de notre table
                            *avec le nom des colonnes sélectionnées en clefs*/
                            $plats = $sth->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($plats as $plat) {

                                echo    '<article class="carte">
                                            <figure>
                                                <img title="' .utf8_encode($plat['Nom']). '" src="./img/' .$plat['Image']. '" alt="Image ' .utf8_encode($plat['Nom']). '">
                                                <figcaption>' .utf8_encode($plat['Description']). '</figcaption>
                                            </figure>
                                        </article>';
                                        
                            };

                        }
                        catch(PDOException $e){

                            date_default_timezone_set('Europe/Paris');
                            setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
                            $format1 = '%A %d %B %Y %H:%M:%S';
                            $date1 = strftime($format1);
                            $fichier = fopen('error_log_index.txt', 'c+b');
                            fseek($fichier, filesize('error_log_index.txt'));
                            fwrite($fichier, "\n\n" .$date1. " - Erreur import plats chauds. Erreur : " .$e);
                            fclose($fichier);
                            
                        }
                    ?>
                </div>
            </div>
            <div id="conteneur-maki" class="conteneur-elements">
                <div class="conteneur-carte conteneur-carte-ligne">

                <?php

                        try{

                            /*Sélectionne les valeurs dans les colonnes pour chaque entrée de la table*/
                            $sth = $conn->prepare("SELECT Nom, Description, Image FROM plats INNER JOIN categories ON plats.Id_Categorie = categories.Id_Categorie where categories.Categorie = 'makis' order by Id DESC LIMIT 4");
                            $sth->execute();
                            /*Retourne un tableau associatif pour chaque entrée de notre table
                            *avec le nom des colonnes sélectionnées en clefs*/
                            $plats = $sth->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($plats as $plat) {

                                echo    '<article class="carte">
                                            <figure>
                                                <img title="' .utf8_encode($plat['Nom']). '" src="./img/' .$plat['Image']. '" alt="Image '.utf8_encode($plat['Nom']). '">
                                                <figcaption>
                                                    <p class="texte-couleur-bleu texte-poppins-bold">' .utf8_encode($plat['Nom']). '</p>
                                                    <p>' .utf8_encode($plat['Description']). '</p>
                                                </figcaption>
                                            </figure>
                                        </article>';

                            };

                        }
                        catch(PDOException $e){

                            date_default_timezone_set('Europe/Paris');
                            setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
                            $format1 = '%A %d %B %Y %H:%M:%S';
                            $date1 = strftime($format1);
                            $fichier = fopen('error_log_index.txt', 'c+b');
                            fseek($fichier, filesize('error_log_index.txt'));
                            fwrite($fichier, "\n\n" .$date1. " - Erreur import makis. Erreur : " .$e);
                            fclose($fichier);
                            
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
            <h2>Contactez-nous<br>pour réserver au restaurant</h2>
            <div class="conteneur-form">
                <div class="form-gauche">
                    <h4 class="texte-couleur-noir">Formulaire de contact</h4>
                    <h5 class="texte-couleur-gris-2">Remplissez le formulaire ci-dessous<br>pour nous contacter</h5>
                    <form method="POST" onsubmit="return valider()" action="formulaire.php">
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
        <footer>
            <div class="conteneur-elements">
                <section id="footer-logo" class="footer-part">
                    <div class="logo complet">
                    <a href="index.php"><img title="Jadoo, un voyage culinaire gourmet et gourmand" src="./img/logo_jadoo_1.svg" alt="Logo jadoo" height="50px"></a><!--
                --><a href="index.php"><img title="Jadoo, un voyage culinaire gourmet et gourmand" src="./img/logo_jadoo_2.svg" alt="Jadoo" height="35px"></a>
                    </div>
                    <p class="texte-couleur-gris-bleu">Un voyage gastronomique entre<br>le Japon et la France</p>
                </section><!--
                --><section id="footer-plan" class="footer-part">
                    <div class="plan-restaurant">
                        <p class="texte-poppins-bold plan-title">Restaurant</p>
                        <p class="texte-couleur-gris-bleu"><a href="#section-2">Nouveautés</a></p>
                        <p class="texte-couleur-gris-bleu"><a href="#section-3">Découvrir</a></p>
                        <p class="texte-couleur-gris-bleu"><a href="#section-4">Commander</a></p>
                    </div>
                    <div class="plan-contact">
                        <p class="texte-poppins-bold plan-title">Contact</p>
                        <p class="texte-couleur-gris-bleu"><a href="#section-5">Prendre RDV</a></p>
                    </div>
                </section><!--
                --><section id="footer-uberEats" class="footer-part">
                    <img class="logo-ubereat" title="UberEats" src="./img/logo_uberEats_2.svg" alt="Logo UberEats">
                    <p class="texte-couleur-gris-bleu">Téléchargez UberEats</p>
                    <button class="app-download-button bouton">
                        <img src="./img/logo_google_play.svg" alt="Logo Google Play"><!--
                        --><span>GOOGLE PLAY</span>
                    </button>
                    <button class="app-download-button bouton">
                        <img src="./img/logo_apple.svg" alt="Logo Apple"><!--
                        --><span>APPLE STORE</span>
                    </button>
                </section>
            </div>
            <p class="copyright texte-couleur-gris-bleu">Tous droits réservés @jadoo.com</p>
        </footer>
    </main>
    <script src="verif.js"></script>

</body>
</html>

<?php
    /*Fermeture de la connexion à la base de données*/
    $conn = null;
?>