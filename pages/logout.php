<?php
    session_start();

    if (isset($_SESSION['Identifiant'])){
        unset($_SESSION['Identifiant']);
    }

    if (isset($_SESSION['mdp'])){
        unset($_SESSION['mdp']);
    }

    if (isset($_SESSION['logged'])){
        unset($_SESSION['logged']);
    }

    session_destroy();

    header("Location:../index.php");
?>