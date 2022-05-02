<?php
    session_start();

    require './../pages/fonctions_communes.php';

    $nom = valid_donnees($_POST["nom"]);
    $prenom = valid_donnees($_POST["prenom"]);
    $email = valid_donnees($_POST["email"]);
    $message = valid_donnees($_POST["message"]);

    if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($message) && strlen($nom) <= 40 && 
        strlen($prenom) <= 40 && strlen($email) <= 255 && preg_match("/^[A-Za-z '-]+$/", $nom) && 
        preg_match("/^[A-Za-z '-]+$/", $prenom) && filter_var($email, FILTER_VALIDATE_EMAIL) &&
        strlen($message) >= 2  && strlen($message) <= 500) {

        try{
            /* Connexion à une base de données en PDO */
            $configs = include('config.php');
            $servername = $configs['servername'];
            $username = $configs['username'];
            $password = $configs['password'];

            $dte_message = date("Y/m/d");

            //On établit la connexion
            $conn = new PDO("mysql:host=$servername;dbname=jadoo;charset=UTF8", $username, $password);
            //On définit le mode d'erreur de PDO sur Exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            try{
                
                //On insère les données reçues
                $sth = $conn->prepare("
                        INSERT INTO messages(Nom, Prenom, Email, Message, Date_msg)
                        VALUES(:nom, :prenom, :email, :message, :date_message)");
                $sth->bindParam(':nom', $nom);    
                $sth->bindParam(':prenom', $prenom);
                $sth->bindParam(':email', $email);
                $sth->bindParam(':message', $message);
                $sth->bindParam(':date_message', $dte_message);
                $sth->execute();
                    
                /*Fermeture de la connexion à la base de données*/
                $sth = null;
                $conn = null;

                //On renvoie l'utilisateur vers la page de remerciement
                header("Location:form-merci.php");

            }
            /*On capture les exceptions si une exception est lancée et on affiche
            *les informations relatives à celle-ci*/
            catch(PDOException $e){
                write_error_log("./../error_log/error_log_formulaire.txt","Impossible d'injecter les données.", $e);
                echo 'Une erreur est survenue, merci de réessayer ultérieurement.';
                /*Fermeture de la connexion à la base de données*/
                $sth = null;
                $conn = null;
            }

        }
        catch(PDOException $e){
            // erreur de connexion à la bdd
            //echo "Erreur : " . $e->getMessage();
            write_error_log("./../error_log/error_log_formulaire.txt","Impossible de se connecter à la base de données.", $e);
            echo 'Une erreur est survenue, merci de réessayer ultérieurement.';
        }

    } else {
        //si des champs ne sont pas valides, on renvoit sur la page de formulaire
        header("Location:../index.php");
    }

?>
