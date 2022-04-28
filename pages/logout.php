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

    if (isset($_SESSION['admin'])){
        unset($_SESSION['admin']);
    }

    if (isset($_SESSION['user'])){
        unset($_SESSION['user']);
    }

    session_destroy();

    header("Location:../index.php");
?>