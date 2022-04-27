<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="./../css/fonts.css">
        <link rel="stylesheet" href="./../css/inscription.css">
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

            <section id="section-5">
                <div class="conteneur-form">
                    <div class="form-gauche">
                        <h4 class="texte-couleur-noir">Formulaire d'inscription</h4>
                        <form method="POST" onsubmit="return valider()" action="./../pages/inscript.php">
                            <div class="formulaire-deux-champs-inline">
                                <div class="formulaire-contact-champ">
                                    <label for="identifiant">Identifiant<span class="rouge">*</span></label>
                                    <input id="identifiant" name="identifiant" type="text" pattern="^[A-Za-z]{1}[A-Za-z0-9]{5,29}$" maxlength="40" placeholder="identifiant" 
                                            title="Doit commencer par une lettre et ne peut contenir que des lettres ou des chiffres - 6 caractères minimum" required="">
                                </div><!--
                                --><div class="formulaire-contact-champ">
                                    <label for="mdp">Mot de passe<span class="rouge">*</span></label>
                                    <input id="mdp" name="mdp" type="text" pattern="^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d][A-Za-z\d!@#$%^&*()_+]{7,19}$" 
                                                maxlength="40" placeholder="Mot de passe" 
                                                title="Doit contenir au moins 1 majuscule, 1 chiffre et un caractère spécial - 8 caractères minimum" required="">
                                </div>
                            </div>
                            <div class="formulaire-deux-champs-inline">
                                <div class="formulaire-contact-champ">
                                    <label for="dte_naissance">Date de naissance<span class="rouge">*</span></label>
                                    <input id="dte_naissance" name="dte_naissance" type="text" pattern="^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[13-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$" maxlength="10" placeholder="Date de naissance" 
                                            title="Format jj/mm/aaaa" required="">
                                </div><!--
                                --><div class="formulaire-contact-champ">
                                    <label for="conf_mdp">Confirmer le mot de passe<span class="rouge">*</span></label>
                                    <input id="conf_mdp" name="conf_mdp" type="text" pattern="^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d][A-Za-z\d!@#$%^&*()_+]{7,19}$" 
                                                maxlength="40" placeholder="Confirmer le mot de passe" 
                                                title="Doit cotenir au moins 1 majuscule, 1 chiffre et un caractère spécial - 8 caractères minimum" required="">
                                </div>
                            </div>
                            <div class="formulaire-deux-champs-inline">
                                <div class="formulaire-contact-champ">
                                    <label for="nom">Nom<span class="rouge">*</span></label>
                                    <input id="nom" name="nom" type="text" pattern="^[A-Za-zàâäéèêëïîôöùûüÿç '-]+$" maxlength="50" placeholder="Nom" 
                                            title="Ne peut contenir que des espaces, apostrophes ou tirets en plus des lettres" required="">
                                </div><!--
                                --><div class="formulaire-contact-champ">
                                    <label for="prenom">Prénom<span class="rouge">*</span></label>
                                    <input id="prenom" name="prenom" type="text" pattern="^[A-Za-zàâäéèêëïîôöùûüÿç '-]+$" maxlength="50" placeholder="Prénom" 
                                            title="Ne peut contenir que des espaces, apostrophes ou tirets en plus des lettres" required="">
                                </div>
                            </div>
                            <div class="formulaire-contact-champ">
                                <label for="mail">Adresse e-mail<span class="rouge">*</span></label>
                                <input id="mail" name="email" type="mail" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" 
                                        maxlength="255" placeholder="monAdresseMail@gmail.com" required="">
                            </div>
                            <div class="formulaire-deux-champs-inline">
                                <div class="formulaire-contact-champ">
                                    <label for="tel">Téléphone fixe</label>
                                    <input id="tel" name="tel" type="text" pattern="[0-9]{10}" maxlength="10" placeholder="Téléphone fixe" title="Format 0000000000">
                                </div><!--
                                --><div class="formulaire-contact-champ">
                                    <label for="mobile">Téléphone mobile</label>
                                    <input id="mobile" name="mobile" type="text" pattern="[0-9]{10}" maxlength="10" placeholder="Téléphone mobile" title="Format 0000000000">
                                </div>
                            </div>
                            <div class="formulaire-contact-champ">
                                <label for="adresse_1">Adresse<span class="rouge">*</span></label>
                                <input id="adresse_1" name="adresse_1" type="text" pattern="^[A-Za-z0-9àâäéèêëïîôöùûüÿç '-]+$" minlength="2" maxlength="50" 
                                        placeholder="Adresse" 
                                        title="Ne peut contenir que des espaces, apostrophes ou tirets en plus des lettres / chiffres" required="">
                            </div>
                            <div class="formulaire-contact-champ">
                                <label for="adresse_2">Complément d'adresse</label>
                                <input id="adresse_2" name="adresse_2" type="text" pattern="^[A-Za-z0-9àâäéèêëïîôöùûüÿç '-]+$" minlength="2" maxlength="50" 
                                        placeholder="Complément d'adresse" 
                                        title="Ne peut contenir que des espaces, apostrophes ou tirets en plus des lettres / chiffres">
                            </div>
                            <div class="formulaire-deux-champs-inline">
                                <div class="formulaire-contact-champ">
                                    <label for="code_postal">Code postal<span class="rouge">*</span></label>
                                    <input id="code_postal" name="code_postal" type="text" pattern="[0-9]{5}" maxlength="5" placeholder="code_postal" 
                                            title="Format 00000" required="">
                                </div><!--
                                --><div class="formulaire-contact-champ">
                                    <label for="ville">Ville<span class="rouge">*</span></label>
                                    <input id="ville" name="ville" type="text" pattern="^[A-Za-zàâäéèêëïîôöùûüÿç '-]+$" maxlength="50" placeholder="ville" 
                                            title="Ne peut contenir que des espaces, apostrophes ou tirets en plus des lettres" required="">
                                </div>
                            </div>
                            <p><span class="rouge">*</span> Champs obligatoires. <br><br> Veuillez saisir au moins un numéro de téléphone au choix.</p>
                            <button class="bouton bleu formulaire-boutton-envoyer" value="Submit">
                                <img src="./../img/bouton_formulaire_coche.svg" alt="Icon coche">
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
        <script src="./../js/inscription.js"></script>
    </body>
</html>