<?php

    function write_error_log ($nom_fichier, $message, $e){

        //echo 'Impossible de traiter les données. Erreur : '.$e->getMessage();
        date_default_timezone_set('Europe/Paris');
        setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
        $format1 = '%A %d %B %Y %H:%M:%S';
        $date1 = strftime($format1);
        $fichier = fopen($nom_fichier, 'c+b');
        fseek($fichier, filesize($nom_fichier));
        fwrite($fichier, "\n\n" .$date1. " - " .$message. " - Erreur : " .$e);
        fclose($fichier);

    }

    function valid_donnees($donnees){
        $donnees = trim($donnees);
        $donnees = stripslashes($donnees);
        $donnees = htmlspecialchars($donnees);
        return $donnees;
    }

?>