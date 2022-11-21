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
                
                <h1>Formulaire bien envoyé !</h1>

                <p>Merci de nous avoir contacté, Jadoo s'engage à vous répondre dans les 48h.</p>

            </section>

            <?php
                /* imporation du footer */
                include $lien.'pages/footer.php'
            ?>

        </main>
    </body>
</html>