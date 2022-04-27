<?php
    session_start();

    if (!isset($_SESSION['Identifiant'])){
        $_SESSION['Identifiant'] = 'vide';
    }
    if (!isset($_SESSION['mdp'])){
        $_SESSION['mdp'] = 'vide';
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="./../css/fonts.css">
        <link rel="stylesheet" href="./../css/connexion.css">
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
                    <a href="../index.php"><img title="Jadoo, un voyage culinaire gourmet et gourmand" src="./../img/logo_jadoo_1.svg" alt="Logo jadoo" height="50px"></a><!--
                    --><a href="../index.php"><img title="Jadoo, un voyage culinaire gourmet et gourmand" src="./../img/logo_jadoo_2.svg" alt="Jadoo" height="35px"></a>
                </div>
                <nav>
                    <ul>
                        <li class="menu-bouton"><a href="#section-2">Les nouveautés</a></li>
                        <li class="menu-bouton"><a href="#section-3">Découvrir</a></li>
                        <li class="menu-bouton"><a href="#section-4">Commander</a></li>
                        <li class="menu-bouton"><a href="#section-5">Contactez-nous</a></li>
                        <li class="menu-bouton connexion"><a href="connexion.php">Connexion</a></li>
                        <li class="menu-bouton burger">
                            <img title="Menu" src="./../img/img/burger_icon.svg" alt="Icone menu">
                        </li>
                    </ul>
                </nav>
            </header>

            <section id="section-1">
                
                <article class="conteneur-form-login">
                    <form class="form-connexion" method="POST" action="login.php">
                        <label>Login</label>
                        <input type="text" id="login" name="login" maxlength="25" placeholder="Identifiant" required=""/>
                        <label>Password</label>
                        <input type="password" id="password" name="password" placeholder="Mot de passe" required=""/>
                        <button class="btn-valide-form-connexion" value="Submit"><img src="./../img/bouton_formulaire_coche.svg" alt="Icon coche"></button>
                    </form>
                </article>
                
            </section>

            <footer>
                <div class="conteneur-elements">
                    <section id="footer-logo" class="footer-part">
                        <div class="logo complet">
                        <a href="../index.php"><img title="Jadoo, un voyage culinaire gourmet et gourmand" src="./../img/logo_jadoo_1.svg" alt="Logo jadoo" height="50px"></a><!--
                    --><a href="../index.php"><img title="Jadoo, un voyage culinaire gourmet et gourmand" src="./../img/logo_jadoo_2.svg" alt="Jadoo" height="35px"></a>
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