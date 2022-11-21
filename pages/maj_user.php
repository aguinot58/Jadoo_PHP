<?php
    session_start();

    require './../pages/fonctions_communes.php';

    $identifiant = $_SESSION['user'];
    $mdp = valid_donnees($_POST["mdp"]);
    $conf_mdp = valid_donnees($_POST["conf_mdp"]);
    $email = valid_donnees($_POST["email"]);
    $adresse = valid_donnees($_POST["adresse_1"]);
    $cptAdresse = valid_donnees($_POST["adresse_2"]);
    $tel = valid_donnees($_POST["tel"]);
    $mobile = valid_donnees($_POST["mobile"]);
    $codeP = valid_donnees($_POST["code_postal"]);
    $ville = valid_donnees($_POST["ville"]);

    require ('./../pages/conn_bdd.php'); 

        try{
            $conn->beginTransaction();

            $sth = $conn->prepare("SELECT Id FROM utilisateurs WHERE Identifiant = '$identifiant'");
            $sth->execute();
            $id_utilisateur = $sth->fetchColumn();

            if(!empty($mdp)){

                if (($mdp === $conf_mdp) && preg_match("/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d][A-Za-z\d!@#$%^&*()_+]{7,19}$/", $mdp)){

                    $pepper = $configs['pepper'];
                    $pwd_peppered = hash_hmac("sha256", $mdp, $pepper);
                    $pwd_hashed = password_hash($pwd_peppered, PASSWORD_ARGON2ID);

                    // Mise à jour du mdp dans la table utilisateur
                    $sth = $conn->prepare("UPDATE utilisateurs SET Pwd = :mdp WHERE Id = :id_utilisateur");
                    $sth->bindParam(':id_utilisateur', $id_utilisateur); 
                    $sth->bindParam(':mdp', $pwd_hashed);
                    $sth->execute();

                }
            }

            if (empty($cptAdresse)){
                $cptAdresse = "";
            }

            if (empty($tel)){
                $tel = "";
            }

            if (empty($mobile)){
                $mobile = "";
            }

            $sth = $conn->prepare("UPDATE contacts SET Tel = :tel, Mail = :mail, Adresse_1 = :adr_1, Adresse_2 = :adr_2, Cde_postal = :cde_postal, 
                    Ville = :ville, Mobile = :mobile WHERE Id_utilisateur = :id_utilisateur");
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

            //On renvoie l'utilisateur sur la page pour la rafraichir.
            header("Location:profil.php");

        }
        catch(PDOException $e){
        // rollback de la transaction
        $conn->rollBack();

        //echo 'Impossible de traiter les données. Erreur : '.$e->getMessage();
        write_error_log("./../log/error_log_maj_user.txt","Impossible de mettre à jour les données.", $e);
        echo 'Une erreur est survenue, merci de réessayer ultérieurement.';

        /*Fermeture de la connexion à la base de données*/
        $sth = null;
        $conn = null;
        }

?>