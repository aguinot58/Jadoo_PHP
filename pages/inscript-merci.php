<?php
    session_start();

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
        <link rel="stylesheet" href="./../css/fonts.css">
        <link rel="stylesheet" href="./../css/header_footer.css">
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
            <?php
                /* importation header */
                include $lien.'pages/header.php'
            ?>

            <section id="section-1">
                
                <h1>Merci de votre inscription !</h1>

                <p>Veuillez vous connecter en utilisant l'identifiant renseigné.</p>

            </section>

            <?php
                /* imporation du footer */
                include $lien.'pages/footer.php'
            ?>

        </main>
    </body>
</html>