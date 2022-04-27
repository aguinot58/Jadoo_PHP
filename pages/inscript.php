<?php

    session_start();

    function valid_donnees($donnees){
        $donnees = trim($donnees);
        $donnees = stripslashes($donnees);
        $donnees = htmlspecialchars($donnees);
        return $donnees;
    }

    function validateDate($date, $format = 'dd/mm/yyyy') {

        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    
    }

    $identifiant = valid_donnees($_POST["identifiant"]);
    $mdp = valid_donnees($_POST["mdp"]);
    $conf_mdp = valid_donnees($_POST["conf_mdp"]);
    $nom = valid_donnees($_POST["nom"]);
    $prenom = valid_donnees($_POST["prenom"]);
    $email = valid_donnees($_POST["email"]);
    $dteNaissance = valid_donnees($_POST["dte_naissance"]);
    $adresse = valid_donnees($_POST["adresse_1"]);
    $cptAdresse = valid_donnees($_POST["adresse_2"]);
    $tel = valid_donnees($_POST["tel"]);
    $mobile = valid_donnees($_POST["mobile"]);
    $codeP = valid_donnees($_POST["code_postal"]);
    $ville = valid_donnees($_POST["ville"]);

    if ((!empty($tel) || !empty($mobile)) && !empty($nom) && !empty($prenom) && !empty($identifiant) && 
        !empty($mdp) && !empty($conf_mdp) && !empty($email) && !empty($dteNaissance) && !empty($adresse) &&
        !empty($codeP) && !empty($ville) && ($mdp === $conf_mdp) && preg_match("/^[A-Za-zàâäéèêëïîôöùûüÿç '-]{2,50}+$/", $nom) &&
        preg_match("/^[A-Za-zàâäéèêëïîôöùûüÿç '-]{2,50}+$/", $prenom) && preg_match("/^[A-Za-zàâäéèêëïîôöùûüÿç '-]{2,50}+$/", $ville) &&
        preg_match("/^[A-Z]{1}[A-Za-z0-9]{6,39}$/", $identifiant) && preg_match("/^[A-Za-z0-9àâäéèêëïîôöùûüÿç '-]{2,50}+$/", $adresse) &&
        preg_match("/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d][A-Za-z\d!@#$%^&*()_+]{7,19}$/", $mdp) &&
        preg_match("/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d][A-Za-z\d!@#$%^&*()_+]{7,19}$/", $conf_mdp) &&
        preg_match("/[0-9]{5}/", $codeP) && 
        preg_match("/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/", $dteNaissance)) {

            if ((!empty($tel) && preg_match("/[0-9]{10}/", $tel)==false) || (!empty($mobile) && preg_match("/[0-9]{10}/", $mobile)==false)) {

                echo 'pb téléphone';

            } else {

                if (!empty($cptAdresse) && preg_match("/^[A-Za-z0-9àâäéèêëïîôöùûüÿç '-]{2,50}+$/", $cptAdresse)==false) {

                    echo 'pb cpt adresse';

                } else {

                    try{

                        /* Connexion à une base de données en PDO */
                        $configs = include('config.php');
                        $servername = $configs['servername'];
                        $username = $configs['username'];
                        $password = $configs['password'];
                        // On établit la connexion
                        $conn = new PDO("mysql:host=$servername;dbname=jadoo;charset=UTF8", $username, $password);
                        // On définit le mode d'erreur de PDO sur Exception
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        try{

                            $tb_dte = explode("/", $dteNaissance);
                            $dteNaissance = $tb_dte[2].'/'.$tb_dte[1].'/'.$tb_dte[0];

                            $pepper = $configs['pepper'];
                            $pwd_peppered = hash_hmac("sha256", $mdp, $pepper);
                            $pwd_hashed = password_hash($pwd_peppered, PASSWORD_ARGON2ID);

                            // Démarre une transaction, désactivation de l'auto-commit */
                            $conn->beginTransaction();

                            //On insère une partie des données reçues dans la table utilisateur
                            $sth = $conn->prepare("INSERT INTO utilisateurs(Identifiant, Nom, Prenom, Dte_Naissance, Pwd, Admin) VALUES(:identifiant, :nom, :prenom, :dte_naissance, :pwd, 0)");
                            $sth->bindParam(':identifiant', $identifiant); 
                            $sth->bindParam(':nom', $nom);    
                            $sth->bindParam(':prenom', $prenom);
                            $sth->bindParam(':dte_naissance', $dteNaissance);
                            $sth->bindParam(':pwd', $pwd_hashed);
                            $sth->execute();


                            // on récupère l'id créée pour l'utilisateur afin de pouvoir réinjecter les informations de contact
                            $sth = $conn->prepare("SELECT Id FROM utilisateurs where Identifiant = '$identifiant'");
                            $sth->execute();
                            $id_utilisateur = $sth->fetchColumn();

                            if (empty($cptAdresse)){

                                $cptAdresse = "";

                            }

                            if (empty($tel)){

                                $tel = "";

                            }

                            if (empty($mobile)){

                                $mobile = "";

                            }

                            $sth = $conn->prepare("INSERT INTO contacts(Id_utilisateur, Tel, Mail, Adresse_1, Adresse_2, Cde_postal, Ville, Mobile) 
                                    VALUES(:id_utilisateur, :tel, :mail, :adr_1, :adr_2, :cde_postal, :ville, :mobile)");
                            $sth->bindParam(':id_utilisateur', $id_utilisateur);
                            $sth->bindParam(':tel', $tel); 
                            $sth->bindParam(':mail', $email);
                            $sth->bindParam(':adr_1', $adresse);
                            $sth->bindParam(':adr_2', $cptAdresse);
                            $sth->bindParam(':cde_postal', $codeP);
                            $sth->bindParam(':ville', $ville);
                            $sth->bindParam(':mobile', $mobile);
                            $sth->execute();

                            // commit de la transaction
                            $conn->commit();
            
                            /*Fermeture de la connexion à la base de données*/
                            $sth = null;
                            $conn = null;

                            //On renvoie l'utilisateur vers la page de remerciement
                            header("Location:inscript-merci.php");

                        }
                        catch(PDOException $e){

                            // rollback de la transaction
                            $conn->rollBack();

                            //echo 'Impossible de traiter les données. Erreur : '.$e->getMessage();
                            date_default_timezone_set('Europe/Paris');
                            setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
                            $format1 = '%A %d %B %Y %H:%M:%S';
                            $date1 = strftime($format1);
                            $fichier = fopen('error_log_inscription.txt', 'c+b');
                            fseek($fichier, filesize('error_log_inscription.txt'));
                            fwrite($fichier, "\n\n" .$date1. " - Impossible d'injecter les données. Erreur : " .$e);
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
                        $fichier = fopen('error_log_inscription.txt', 'c+b');
                        fseek($fichier, filesize('error_log_inscription.txt'));
                        fwrite($fichier, "\n\n" .$date1. " - Impossible de se connecter à la base de données. Erreur : " .$e);
                        fclose($fichier);
                        echo 'Une erreur est survenue, merci de réessayer ultérieurement.';

                    }

                }

            }

    } else {

        echo 'pb de données';

    }

?>