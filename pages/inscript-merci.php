<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="./../css/fonts.css">
        <link rel="stylesheet" href="./../css/style.css">
        <link rel="stylesheet" href="./../css/style_rep_formulaire.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title>Jadoo : un voyage culinaire gourmet et gourment</title>
        <link rel="shortcut icon" type="image/ico" href="./../img/favicon.ico">
    </head>

    <body>
        <main>
            <header>
                <div class="logo">
                    <a href="./../index.php"><img title="Jadoo, un voyage culinaire gourmet et gourmand" src="./../img/logo_jadoo_1.svg" alt="Logo jadoo" height="50px"></a><!--
                    --><a href="./../index.php"><img title="Jadoo, un voyage culinaire gourmet et gourmand" src="./../img/logo_jadoo_2.svg" alt="Jadoo" height="35px"></a>
                </div>
                <nav>
                    <ul>
                        <li class="menu-bouton"><a href="./../index.php#section-2">Les nouveautés</a></li>
                        <li class="menu-bouton"><a href="./../index.php#section-3">Découvrir</a></li>
                        <li class="menu-bouton"><a href="./../index.php#section-4">Commander</a></li>
                        <li class="menu-bouton"><a href="./../index.php#section-5">Contactez-nous</a></li>
                        <li class="menu-bouton connexion"><a href="connexion.php">Connexion</a></li>
                        <li class="menu-bouton burger">
                            <img title="Menu" src="./../img/burger_icon.svg" alt="Icone menu">
                        </li>
                    </ul>
                </nav>
            </header>

            <section id="section-1">
                
                <h1>Merci de votre inscription !</h1>

                <p>Veuillez vous connecter en utilisant l'identifiant renseigné.</p>

            </section>

            <footer>
                <div class="conteneur-elements">
                    <section id="footer-logo" class="footer-part">
                        <div class="logo complet">
                            <a href="./../index.php"><img title="Jadoo, un voyage culinaire gourmet et gourmand" src="./../img/logo_jadoo_1.svg" alt="Logo jadoo" height="50px"></a><!--
                            --><a href="./../index.php"><img title="Jadoo, un voyage culinaire gourmet et gourmand" src="./../img/logo_jadoo_2.svg" alt="Jadoo" height="35px"></a>
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
    </body>
</html>