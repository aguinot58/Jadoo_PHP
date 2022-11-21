<?php

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
        $page = "index.php";
    } else {
        $lien = "./../";
        $page = "./../index.php";
    }

    echo '<footer>
            <div class="conteneur-elements">
                <section id="footer-logo" class="footer-part">
                    <div class="logo complet">
                    <a href="'.$page.'"><img title="Jadoo, un voyage culinaire gourmet et gourmand" src="'.$lien.'img/logo_jadoo_1.svg" alt="Logo jadoo" height="50px"></a><!--
                --><a href="'.$page.'"><img title="Jadoo, un voyage culinaire gourmet et gourmand" src="'.$lien.'img/logo_jadoo_2.svg" alt="Jadoo" height="35px"></a>
                    </div>
                    <p class="texte-couleur-gris-bleu">Un voyage gastronomique entre<br>le Japon et la France</p>
                </section><!--
                --><section id="footer-plan" class="footer-part">
                    <div class="plan-restaurant">
                        <p class="texte-poppins-bold plan-title">Restaurant</p>
                        <p class="texte-couleur-gris-bleu"><a href="'.$page.'#section-2">Nouveautés</a></p>
                        <p class="texte-couleur-gris-bleu"><a href="'.$page.'#section-3">Découvrir</a></p>
                        <p class="texte-couleur-gris-bleu"><a href="'.$page.'#section-4">Commander</a></p>
                    </div>
                    <div class="plan-contact">
                        <p class="texte-poppins-bold plan-title">Contact</p>
                        <p class="texte-couleur-gris-bleu"><a href="'.$page.'#section-5">Prendre RDV</a></p>
                    </div>
                </section><!--
                --><section id="footer-uberEats" class="footer-part">
                    <img class="logo-ubereat" title="UberEats" src="'.$lien.'img/logo_uberEats_2.svg" alt="Logo UberEats">
                    <p class="texte-couleur-gris-bleu">Téléchargez UberEats</p>
                    <button class="app-download-button bouton">
                        <img src="'.$lien.'img/logo_google_play.svg" alt="Logo Google Play"><!--
                        --><span>GOOGLE PLAY</span>
                    </button>
                    <button class="app-download-button bouton">
                        <img src="'.$lien.'img/logo_apple.svg" alt="Logo Apple"><!--
                        --><span>APPLE STORE</span>
                    </button>
                </section>
            </div>
            <p class="copyright texte-couleur-gris-bleu">Tous droits réservés @jadoo.com</p>
        </footer>';

?>