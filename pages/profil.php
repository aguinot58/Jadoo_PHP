<?php

    session_start();

    if (!isset($_SESSION['Identifiant'])){

        header("Location:./../pages/connexion.php");
    
    } else {

        $identifiant = $_SESSION['user'];

    }

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="./../css/fonts.css">
        <link rel="stylesheet" href="./../css/profil.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title>Jadoo : un voyage culinaire gourmet et gourmand</title>
        <link rel="shortcut icon" type="image/ico" href="./../img/favicon.ico">
    </head>

    <body>
        <main>
            <header>
                <div class="logo">
                    <a href="index.php"><img title="Jadoo, un voyage culinaire gourmet et gourmand" src="./../img/logo_jadoo_1.svg" alt="Logo jadoo" height="50px"></a><!--
                    --><a href="index.php"><img title="Jadoo, un voyage culinaire gourmet et gourmand" src="./../img/logo_jadoo_2.svg" alt="Jadoo" height="35px"></a>
                </div>
                <?php
                    if ($_SESSION['logged'] == 'oui') {
    
                        echo '<nav>
                                    <ul>
                                        <li class="menu-bouton"><a href="./../index.php#section-2">Les nouveautés</a></li>
                                        <li class="menu-bouton"><a href="./../index.php#section-3">Découvrir</a></li>
                                        <li class="menu-bouton"><a href="./../index.php#section-4">Commander</a></li>
                                        <li class="menu-bouton"><a href="./../index.php#section-5">Contactez-nous</a></li>';
                        if ($_SESSION['admin'] == 'oui') {
                            echo '<li class="menu-bouton"><a href="./../pages/profil.php">Mon Compte</a></li>';
                            echo '<li class="menu-bouton"><a href="./../pages/back_office.php">Administration</a></li>';
                            echo '<li class="menu-bouton"><a href="./../pages/logout.php" id="deconnexion">Déconnexion</a></li>';
                        } else {
                            echo '<li class="menu-bouton"><a href="./../pages/profil.php">Mon Compte</a></li>';
                            echo '<li class="menu-bouton"><a href="./../pages/logout.php" id="deconnexion">Déconnexion</a></li>';
                        }
                        echo                '<li class="menu-bouton burger">
                                            <img title="Menu" src="./../img/burger_icon.svg" alt="Icone menu">
                                        </li>
                                    </ul>
                                </nav>';            

                    } else {
                        echo '<nav>
                                    <ul>
                                        <li class="menu-bouton"><a href="./../index.php#section-2">Les nouveautés</a></li>
                                        <li class="menu-bouton"><a href="./../index.php#section-3">Découvrir</a></li>
                                        <li class="menu-bouton"><a href="./../index.php#section-4">Commander</a></li>
                                        <li class="menu-bouton"><a href="./../index.php#section-5">Contactez-nous</a></li>
                                        <li class="menu-bouton"><a href="./../pages/inscription.php">Inscription</a></li>
                                        <li class="menu-bouton"><a href="./../pages/connexion.php">Connexion</a></li>
                                        <li class="menu-bouton burger">
                                            <img title="Menu" src="./../img/burger_icon.svg" alt="Icone menu">
                                        </li>
                                    </ul>
                                </nav>';
                    }
                ?>
            </header>

            <section id="section-5">

                    <h3>Informations personnelles</h3>

                <article class="info-principales">

                    <?php

                        /* Connexion à une base de données en PDO */
                        $configs = include('./../pages/config.php');
                        $servername = $configs['servername'];
                        $username = $configs['username'];
                        $password = $configs['password'];
                        //On établit la connexion
                        try{
                            $conn = new PDO("mysql:host=$servername;dbname=jadoo;charset=UTF8", $username, $password);
                            //On définit le mode d'erreur de PDO sur Exception
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            try{

                                //Sélectionne les valeurs dans les colonnes pour chaque entrée de la table
                                $sth = $conn->prepare("SELECT Id, Nom, Prenom, Dte_naissance FROM utilisateurs where Identifiant = '$identifiant'");
                                $sth->execute();
                                //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
                                $users = $sth->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($users as $user) {

                                    $tb_dte = explode("-", $user['Dte_naissance']);
                                    $dteNaissance = $tb_dte[2].'/'.$tb_dte[1].'/'.$tb_dte[0];
                                    $id_utilisateur = $user['Id'];
                                    $nom = $user['Nom'];
                                    $prenom = $user['Prenom'];

                                };

                                echo    '<div class="deux-champs-inline">
                                            <div class="contact-champ">
                                                <label class="titre">Identifiant : </label>
                                                <label class="valeur">'.$identifiant.'</label>
                                            </div>
                                            <div class="contact-champ">
                                                <label class="titre">Date de naissance : </label>
                                                <label class="valeur">'.$dteNaissance.'</label>
                                            </div>
                                        </div>

                                        <div class="deux-champs-inline">
                                            <div class="contact-champ">
                                                <label class="titre">Nom : </label>
                                                <label class="valeur">'.$nom.'</label>
                                            </div>
                                            <div class="contact-champ">
                                                <label class="titre">Prénom : </label>
                                                <label class="valeur">'.$prenom.'</label>
                                            </div>
                                        </div>';
                            }
                            catch(PDOException $e){
    
                                date_default_timezone_set('Europe/Paris');
                                setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
                                $format1 = '%A %d %B %Y %H:%M:%S';
                                $date1 = strftime($format1);
                                $fichier = fopen('./../log/error_log_profile.txt', 'c+b');
                                fseek($fichier, filesize('./../log/error_log_profile.txt'));
                                fwrite($fichier, "\n\n" .$date1. " - Erreur import infos principales utilisateur. Erreur : " .$e);
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
                        $fichier = fopen('./../log/error_log_profile.txt', 'c+b');
                        fseek($fichier, filesize('./../log/error_log_profile.txt'));
                        fwrite($fichier, "\n\n" .$date1. " - Impossible de se connecter à la base de données. Erreur : " .$e);
                        fclose($fichier);

                        echo    '<article class="connexion-bdd-hs">

                                    <p>Une erreur est survenue lors de la connexion à la base de données.<br><br>
                                        Merci de rafraichir la page, et si le problème persiste, de réessayer ultérieurement.   </p>

                                </article>';

                        }
                    ?>

                </article>

                <article id="affichage-info-user" class="affichage-fixe">

                    <?php

                        //On établit la connexion
                        try{
                            $conn = new PDO("mysql:host=$servername;dbname=jadoo;charset=UTF8", $username, $password);
                            //On définit le mode d'erreur de PDO sur Exception
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            try{

                                //Sélectionne les valeurs dans les colonnes pour chaque entrée de la table
                                $sth = $conn->prepare("SELECT Tel, Mail, Adresse_1, Adresse_2, Cde_postal, Ville, Mobile FROM contacts where Id_utilisateur = '$id_utilisateur'");
                                $sth->execute();
                                //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
                                $contacts = $sth->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($contacts as $contact) {

                                    $mail = $contact['Mail'];
                                    $tel = $contact['Tel'];
                                    $mobile = $contact['Mobile'];
                                    $adr_1 = $contact['Adresse_1'];
                                    $adr_2 = $contact['Adresse_2'];
                                    $cp = $contact['Cde_postal'];
                                    $ville = $contact['Ville'];

                                };

                                /*Fermeture de la connexion à la base de données*/
                                $sth = null;
                                $conn = null;

                                echo    '<div class="deux-champs-inline">
                                            <div class="contact-champ">
                                                <label class="titre">Mot de passe : </label>
                                                <label class="valeur">************</label>
                                            </div>
                                            <div class="contact-champ">
                                                <label class="titre">Email : </label>
                                                <label class="valeur">'.$mail.'</label>
                                            </div>
                                        </div>

                                        <div class="deux-champs-inline">
                                            <div class="contact-champ">
                                                <label class="titre">Tel. fixe : </label>
                                                <label class="valeur">'.$tel.'</label>
                                            </div>
                                            <div class="contact-champ">
                                                <label class="titre">Tel. mobile : </label>
                                                <label class="valeur">'.$mobile.'</label>
                                            </div>
                                        </div>

                                        <div class="deux-champs-inline"> 
                                            <div class="contact-champ">
                                                <label class="titre">Adresse : </label>
                                                <label class="valeur">'.$adr_1.'</label>
                                            </div>
                                            <div class="contact-champ">
                                                <label class="titre">Complément Adresse : </label>
                                                <label class="valeur">'.$adr_2.'</label>
                                            </div>
                                        </div>

                                        <div class="deux-champs-inline">
                                            <div class="contact-champ">
                                                <label class="titre">Code postal : </label>
                                                <label class="valeur">'.$cp.'</label>
                                            </div>
                                            <div class="contact-champ">
                                                <label class="titre">Ville : </label>
                                                <label class="valeur">'.$ville.'</label>
                                            </div>
                                        </div>

                                        <div class="bouton-user">
                                            <button class="bouton bleu formulaire-boutton-envoyer" onclick="modif_user()">
                                                <img src="./../img/bouton_formulaire_coche.svg" alt="Icon coche">
                                                <span>Modifier</span>
                                            </button>

                                            <button class="bouton suppression formulaire-boutton-envoyer" onclick="suppr_user()">
                                                <img src="./../img/bouton_formulaire_coche.svg" alt="Icon coche">
                                                <span>Supprimer</span>
                                            </button>
                                        </div>';
                                
                            }
                            catch(PDOException $e){
    
                                date_default_timezone_set('Europe/Paris');
                                setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
                                $format1 = '%A %d %B %Y %H:%M:%S';
                                $date1 = strftime($format1);
                                $fichier = fopen('./../log/error_log_profile.txt', 'c+b');
                                fseek($fichier, filesize('./../log/error_log_profile.txt'));
                                fwrite($fichier, "\n\n" .$date1. " - Erreur import infos modifiables utilisateur partie affichage. Erreur : " .$e);
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
                        $fichier = fopen('./../log/error_log_profile.txt', 'c+b');
                        fseek($fichier, filesize('./../log/error_log_profile.txt'));
                        fwrite($fichier, "\n\n" .$date1. " - Impossible de se connecter à la base de données - infos modifiables utilisateur partie affichage. Erreur : " .$e);
                        fclose($fichier);

                        echo    '<article class="connexion-bdd-hs">

                                    <p>Une erreur est survenue lors de la connexion à la base de données.<br><br>
                                        Merci de rafraichir la page, et si le problème persiste, de réessayer ultérieurement.   </p>

                                </article>';

                        }
                    ?>

                </article>

                <article id="modification-info-user" class="affichage-fixe">

                    <form method="POST" onsubmit="return valider_modification()" action="./../pages/maj_user.php">

                    <?php

                            echo '<div class="formulaire-deux-champs-inline">
                                    <div class="formulaire-contact-champ">
                                        <label for="mdp">Mot de passe</label>
                                        <input id="mdp" name="mdp" type="password" pattern="^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d][A-Za-z\d!@#$%^&*()_+]{7,19}$" 
                                            maxlength="40" placeholder="Mot de passe" 
                                            title="Doit contenir au moins 1 majuscule, 1 chiffre et un caractère spécial - 8 caractères minimum">
                                    </div>
                                    <div class="formulaire-contact-champ">
                                        <label for="conf_mdp">Confirmer le mot de passe</label>
                                        <input id="conf_mdp" name="conf_mdp" type="password" pattern="^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d][A-Za-z\d!@#$%^&*()_+]{7,19}$" 
                                                maxlength="40" placeholder="Confirmer le mot de passe" 
                                                title="Doit cotenir au moins 1 majuscule, 1 chiffre et un caractère spécial - 8 caractères minimum">
                                    </div>
                                </div>
                                <div class="formulaire-contact-champ">
                                    <label for="mail">Adresse e-mail<span class="rouge">*</span></label>
                                    <input id="mail" name="email" type="mail" pattern="^[a-zA-Z0-9.!#$%&\'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" 
                                            maxlength="255" placeholder="monAdresseMail@gmail.com" value="'.$mail.'" required="">
                                </div>
                                <div class="formulaire-deux-champs-inline">
                                    <div class="formulaire-contact-champ">
                                        <label for="tel">Téléphone fixe</label>
                                        <input id="tel" name="tel" type="text" pattern="[0-9]{10}" maxlength="10" value="'.$tel.'" placeholder="Téléphone fixe" title="Format 0000000000">
                                    </div><!--
                                    --><div class="formulaire-contact-champ">
                                        <label for="mobile">Téléphone mobile</label>
                                        <input id="mobile" name="mobile" type="text" pattern="[0-9]{10}" maxlength="10" value="'.$mobile.'" placeholder="Téléphone mobile" title="Format 0000000000">
                                    </div>
                                </div>
                                <div class="formulaire-contact-champ">
                                    <label for="adresse_1">Adresse<span class="rouge">*</span></label>
                                    <input id="adresse_1" name="adresse_1" type="text" pattern="^[A-Za-z0-9àâäéèêëïîôöùûüÿç \'-]+$" minlength="2" maxlength="50" 
                                            placeholder="Adresse" value="'.$adr_1.'" 
                                            title="Ne peut contenir que des espaces, apostrophes ou tirets en plus des lettres / chiffres" required="">
                                </div>
                                <div class="formulaire-contact-champ">
                                    <label for="adresse_2">Complément d\'adresse</label>
                                    <input id="adresse_2" name="adresse_2" type="text" pattern="^[A-Za-z0-9àâäéèêëïîôöùûüÿç \'-]+$" minlength="2" maxlength="50" 
                                            placeholder="Complément d\'adresse" value="'.$adr_2.'" 
                                            title="Ne peut contenir que des espaces, apostrophes ou tirets en plus des lettres / chiffres">
                                </div>
                                <div class="formulaire-deux-champs-inline">
                                    <div class="formulaire-contact-champ">
                                        <label for="code_postal">Code postal<span class="rouge">*</span></label>
                                        <input id="code_postal" name="code_postal" type="text" pattern="[0-9]{5}" maxlength="5" placeholder="code_postal" 
                                                title="Format 00000" value="'.$cp.'" required="">
                                    </div><!--
                                    --><div class="formulaire-contact-champ">
                                        <label for="ville">Ville<span class="rouge">*</span></label>
                                        <input id="ville" name="ville" type="text" pattern="^[A-Za-zàâäéèêëïîôöùûüÿç \'-]+$" maxlength="50" placeholder="ville" 
                                                title="Ne peut contenir que des espaces, apostrophes ou tirets en plus des lettres" value="'.$ville.'" required="">
                                    </div>
                                </div>

                                <p><span class="rouge">*</span> Champs obligatoires. <br><br> Veuillez saisir au moins un numéro de téléphone au choix.</p>
                                
                                <div class="bouton-user">
                                    <button class="bouton bleu formulaire-boutton-envoyer" onclick="maj_user()">
                                        <img src="./../img/bouton_formulaire_coche.svg" alt="Icon coche">
                                        <span>Mettre à jour</span>
                                    </button>
                                </div>';
                    ?>

                </article>

            </section>

            <footer>
                <div class="conteneur-elements">
                    <section id="footer-logo" class="footer-part">
                        <div class="logo complet">
                        <a href="index.php"><img title="Jadoo, un voyage culinaire gourmet et gourmand" src="./../img/logo_jadoo_1.svg" alt="Logo jadoo" height="50px"></a><!--
                    --><a href="index.php"><img title="Jadoo, un voyage culinaire gourmet et gourmand" src="./../img/logo_jadoo_2.svg" alt="Jadoo" height="35px"></a>
                        </div>
                        <p class="texte-couleur-gris-bleu">Un voyage gastronomique entre<br>le Japon et la France</p>
                    </section><!--
                    --><section id="footer-plan" class="footer-part">
                        <div class="plan-restaurant">
                            <p class="texte-poppins-bold plan-title">Restaurant</p>
                            <p class="texte-couleur-gris-bleu"><a href="./../index.php#section-2">Nouveautés</a></p>
                            <p class="texte-couleur-gris-bleu"><a href="./../index.php#section-3">Découvrir</a></p>
                            <p class="texte-couleur-gris-bleu"><a href="./../index.php#section-4">Commander</a></p>
                        </div>
                        <div class="plan-contact">
                            <p class="texte-poppins-bold plan-title">Contact</p>
                            <p class="texte-couleur-gris-bleu"><a href="./../index.php#section-5">Prendre RDV</a></p>
                        </div>
                    </section><!--
                    --><section id="footer-uberEats" class="footer-part">
                        <img class="logo-ubereat" title="UberEats" src="./../img/logo_uberEats_2.svg" alt="Logo UberEats">
                        <p class="texte-couleur-gris-bleu">Téléchargez UberEats</p>
                        <button class="app-download-button bouton">
                            <img src="./../img/logo_google_play.svg" alt="Logo Google Play"><!--
                            --><span>GOOGLE PLAY</span>
                        </button>
                        <button class="app-download-button bouton">
                            <img src="./../img/logo_apple.svg" alt="Logo Apple"><!--
                            --><span>APPLE STORE</span>
                        </button>
                    </section>
                </div>
                <p class="copyright texte-couleur-gris-bleu">Tous droits réservés @jadoo.com</p>
            </footer>
        </main>
        <script src="./../js/profil.js"></script>
    </body>
</html>