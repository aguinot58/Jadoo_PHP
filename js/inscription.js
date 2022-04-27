/* fichier javascript en mode strict */
"use strict"; 

function valider(){

    /* validation formulaire index.php */
    let masqueIdentifiant = /^[A-Z]{1}[A-Za-z0-9]{6,39}$/;
    let masqueMdp = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d][A-Za-z\d!@#$%^&*()_+]{7,19}$/;
    let masqueNPV = /^[A-Za-zàâäéèêëïîôöùûüÿç '-]{2,50}+$/;
    let masqueAdresse = /^[A-Za-z0-9àâäéèêëïîôöùûüÿç '-]{2,50}+$/;
    let masqueEmail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    let masqueTel = /[0-9]{10}/;
    let masqueCP = /[0-9]{5}/;
    let masqueDteNaissance = /^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/;

    let identifiantValide = document.getElementById('identifiant').value.match(masqueIdentifiant);
    let mdpValide = document.getElementById('mdp').value.match(masqueMdp);
    let nomFamilleValide = document.getElementById('nom').value.match(masqueNPV);
    let prenomValide = document.getElementById('prenom').value.match(masqueNPV);
    let emailValide = document.getElementById('mail').value.match(masqueEmail);
    let adresseValide = document.getElementById('adresse_1').value.match(masqueAdresse);
    let cptAdresseValide = document.getElementById('adresse_2').value.match(masqueAdresse);
    let villeValide = document.getElementById('ville').value.match(masqueNPV);
    let telFixeValide = document.getElementById('tel').value.match(masqueTel);
    let telMobileValide = document.getElementById('mobile').value.match(masqueTel);
    let codePostalValide = document.getElementById('code_postal').value.match(masqueCP);
    let dteNaissanceValide = document.getElementById('dte_naissance').value.match(masqueDteNaissance);

    if (document.getElementById('tel').value == "" && document.getElementById('mobile').value == "") {

        alert("Merci de saisir au moins un numéro de téléphone.");
        return false;

    }

    if (document.getElementById('mdp').value != document.getElementById('conf_mdp').value) {

        alert("Les deux mot de passe saisis ne sont pas identiques.");
        return false;

    }

    if (emailValide == null) {

        alert("Votre adresse email ne semble pas valide.");
        return false;

    }

    if (codePostalValide == null) {

        alert("Merci de saisir un code postal de 5 chiffres.");
        return false;

    }

    if (document.getElementById('tel').value != "" && telFixeValide == null) {

        alert("Votre numéro de téléphone fixe ne doit contenir que 10 chiffres.");
        return false;

    }

    if (document.getElementById('mobile').value != "" && telMobileValide == null) {

        alert("Votre numéro de téléphone mobile ne doit contenir que 10 chiffres.");
        return false;

    }

    if (nomFamilleValide == null) {

        alert("Votre nom de famille doit faire moins de 40 caractères et ne peut comporter que les caractères suivant en plus de lettres : - ' ou espace");
        return false;

    } 
    
    if (prenomValide == null) {

        alert("Votre prénom doit faire moins de 50 caractères et ne peut comporter que les caractères suivant en plus de lettres : - ' ou espace");
        return false;

    }

    if (adresseValide == null) {

        alert("Votre adresse doit faire moins de 50 caractères et ne peut comporter que les caractères suivant en plus de lettres : - ' ou espace");
        return false;

    }

    if (cptAdresseValide == null) {

        alert("Votre complément d'adresse doit faire moins de 50 caractères et ne peut comporter que les caractères suivant en plus de lettres : - ' ou espace");
        return false;

    }

    if (villeValide == null) {

        alert("Votre ville doit faire moins de 50 caractères et ne peut comporter que les caractères suivant en plus de lettres : - ' ou espace");
        return false;

    }

    if (identifiantValide == null) {

        alert("Votre identifiant doit commencer par une lettre, ne peut contenir que des lettres ou chiffres et doit faire entre 6 et 30 caractères");
        return false;

    }

    if (mdpValide == null) {

        alert("Votre mot de passe doit contenir au moins 1 majuscule, 1 chiffre, 1 caractère spécial et doit faire entre 8 et 20 caractères");
        return false;

    }

    if (dteNaissanceValide == null) {

        alert("Votre date de naissance doit être au format jj/mm/aaaa");
        return false;

    }

    return true;

}

