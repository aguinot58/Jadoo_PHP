<?php

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
        $page = "index.php";
    } else {
        $lien = "./../";
        $page = "./../index.php";
    }

    echo '<header>
                <div class="logo">
                    <a href="'.$page.'"><img title="Jadoo, un voyage culinaire gourmet et gourmand" src="'.$lien.'img/logo_jadoo_1.svg" alt="Logo jadoo" height="50px"></a><!--
                    --><a href="'.$page.'"><img title="Jadoo, un voyage culinaire gourmet et gourmand" src="'.$lien.'img/logo_jadoo_2.svg" alt="Jadoo" height="35px"></a>
                </div>';
                
    if ($_SESSION['logged'] == 'oui') {

        echo '<nav>
                <div id="barre-nav">
                    <ul>
                        <li class="menu-bouton"><a href="'.$page.'#section-2">Les nouveautés</a></li>
                        <li class="menu-bouton"><a href="'.$page.'#section-3">Découvrir</a></li>
                        <li class="menu-bouton"><a href="'.$page.'#section-4">Commander</a></li>
                        <li class="menu-bouton"><a href="'.$page.'#section-5">Contactez-nous</a></li>';
                if ($_SESSION['admin'] == 'oui') {
                    echo '<li class="menu-bouton"><a href="'.$lien.'pages/profil.php">Mon Compte</a></li>
                          <li class="menu-bouton"><a href="'.$lien.'pages/back_office.php">Administration</a></li>
                          <li class="menu-bouton"><a href="'.$lien.'pages/logout.php" id="deconnexion">Déconnexion</a></li>';
                } else {
                    echo '<li class="menu-bouton"><a href="'.$lien.'pages/profil.php">Mon Compte</a></li>
                          <li class="menu-bouton"><a href="'.$lien.'pages/logout.php" id="deconnexion">Déconnexion</a></li>';
                }
        echo       '</ul>
                </div>
                <div id="menuToggle">
                    <input type="checkbox"/>
                    <span></span>
                    <span></span>
                    <span></span>
                    <ul id="menu">
                        <li class="menu-bouton"><a href="'.$page.'#section-2">Les nouveautés</a></li>
                        <li class="menu-bouton"><a href="'.$page.'#section-3">Découvrir</a></li>
                        <li class="menu-bouton"><a href="'.$page.'#section-4">Commander</a></li>
                        <li class="menu-bouton"><a href="'.$page.'#section-5">Contactez-nous</a></li>
                        <li></li>';
                if ($_SESSION['admin'] == 'oui') {
                    echo '<li class="menu-bouton"><a href="'.$lien.'pages/profil.php">Mon Compte</a></li>
                          <li class="menu-bouton"><a href="'.$lien.'pages/back_office.php">Administration</a></li>
                          <li class="menu-bouton"><a href="'.$lien.'pages/logout.php" id="deconnexion">Déconnexion</a></li>';
                } else {
                    echo '<li class="menu-bouton"><a href="'.$lien.'pages/profil.php">Mon Compte</a></li>
                          <li class="menu-bouton"><a href="'.$lien.'pages/logout.php" id="deconnexion">Déconnexion</a></li>';
                }
            echo    '</ul>
                </div>
            </nav>';            

    } else {

        echo '<nav>
                <div id="barre-nav">
                    <ul>
                        <li class="menu-bouton"><a href="'.$page.'#section-2">Les nouveautés</a></li>
                        <li class="menu-bouton"><a href="'.$page.'#section-3">Découvrir</a></li>
                        <li class="menu-bouton"><a href="'.$page.'#section-4">Commander</a></li>
                        <li class="menu-bouton"><a href="'.$page.'#section-5">Contactez-nous</a></li>
                        <li class="menu-bouton"><a href="'.$lien.'pages/inscription.php">Inscription</a></li>
                        <li class="menu-bouton"><a href="'.$lien.'pages/connexion.php">Connexion</a></li>
                    </ul>
                </div>
                <div id="menuToggle">
                    <input type="checkbox"/>
                    <span></span>
                    <span></span>
                    <span></span>
                    <ul id="menu">
                        <li class="menu-bouton"><a href="'.$page.'#section-2">Les nouveautés</a></li>
                        <li class="menu-bouton"><a href="'.$page.'#section-3">Découvrir</a></li>
                        <li class="menu-bouton"><a href="'.$page.'#section-4">Commander</a></li>
                        <li class="menu-bouton"><a href="'.$page.'#section-5">Contactez-nous</a></li>
                        <li></li>
                        <li class="menu-bouton"><a href="'.$lien.'pages/inscription.php">Inscription</a></li>
                        <li class="menu-bouton"><a href="'.$lien.'pages/connexion.php">Connexion</a></li>
                    </ul>
                </div>
            </nav>';
    }
    echo '</header>';
?>