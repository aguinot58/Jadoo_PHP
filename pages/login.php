<?php
    session_start();

    $identifiant = valid_donnees($_POST["login"]);
    $mdp = valid_donnees($_POST["password"]);

    function valid_donnees($donnees){
        $donnees = trim($donnees);
        $donnees = stripslashes($donnees);
        $donnees = htmlspecialchars($donnees);
        return $donnees;
    }

    if (empty($identifiant)) {

        $_SESSION['Identifiant'] = 'renseigne';
        header("Location:connexion.php");

    } elseif (empty($mdp)) {

        $_SESSION['mdp'] = 'renseigne';
        header("Location:connexion.php");

    } else {

        $_SESSION['Identifiant'] = 'renseigne';
        $_SESSION['mdp'] = 'renseigne';
        $_SESSION['user']= $identifiant;
        
        try{

            /* Connexion à une base de données en PDO */
            $configs = include('config.php');
            $servername = $configs['servername'];
            $username = $configs['username'];
            $password = $configs['password'];
    
            $pepper = $configs['pepper'];
            $pwd_peppered = hash_hmac("sha256", $mdp, $pepper);
    
            //On établit la connexion
            $conn = new PDO("mysql:host=$servername;dbname=jadoo", $username, $password);
            //On définit le mode d'erreur de PDO sur Exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            try{
                    
                //On extrait le mdp correspondant à l'identifiant
                $sth = $conn->prepare("SELECT Pwd FROM utilisateurs where Identifiant = '$identifiant'");
                $sth->execute();
                $mdp_hashed = $sth->fetchColumn();
    
                if (password_verify($pwd_peppered, $mdp_hashed)) {
                    $_SESSION['logged'] = 'oui';
    
                    // on extrait la valeur de la colonne Admin pour vérifier si l'utilisateur peut accéder au back-office
                    $sth = $conn->prepare("SELECT Admin FROM utilisateurs where Identifiant = '$identifiant'");
                    $sth->execute();
                    $administration = $sth->fetchColumn();
    
                    if ($administration==1){
    
                        $_SESSION['admin'] = 'oui';
    
                    } else {
    
                        $_SESSION['admin'] = 'non';
    
                    }
    
                    /*Fermeture de la connexion à la base de données*/
                    $sth = null;
                    $conn = null;
    
                    header("Location:../index.php");
    
                } else {
    
                    $_SESSION['logged'] = 'non';
    
                    /*Fermeture de la connexion à la base de données*/
                    $sth = null;
                    $conn = null;
    
                    header("Location:connexion.php");
    
                }
    
            }
            /*On capture les exceptions si une exception est lancée et on affiche
            *les informations relatives à celle-ci*/
            catch(PDOException $e){
                //echo 'Impossible de traiter les données. Erreur : '.$e->getMessage();
                date_default_timezone_set('Europe/Paris');
                setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
                $format1 = '%A %d %B %Y %H:%M:%S';
                $date1 = strftime($format1);
                $fichier = fopen('./../log/error_log_login.txt', 'c+b');
                fseek($fichier, filesize('./../log/error_log_login.txt'));
                fwrite($fichier, "\n\n" .$date1. " - Echec extraction mdp login. Erreur : " .$e);
                fclose($fichier);
                echo 'Une erreur est survenue, merci de réessayer ultérieurement.';
    
                /*Fermeture de la connexion à la base de données*/
                $sth = null;
                $conn = null;
            }
    
        }
        catch(PDOException $e){
    
            // erreur de connexion à la bdd
            //echo "Erreur : " . $e->getMessage();
            date_default_timezone_set('Europe/Paris');
            setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
            $format1 = '%A %d %B %Y %H:%M:%S';
            $date1 = strftime($format1);
            $fichier = fopen('./../log/error_log_connexion.txt', 'c+b');
            fseek($fichier, filesize('./../log/error_log_connexion.txt'));
            fwrite($fichier, "\n\n" .$date1. " - Impossible de se connecter à la base de données. Erreur : " .$e);
            fclose($fichier);
            echo 'Une erreur est survenue, merci de réessayer ultérieurement.';
    
        }

    }

?>