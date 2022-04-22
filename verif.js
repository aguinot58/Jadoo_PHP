/* fichier javascript en mode strict */
"use strict"; 

function valider(){

    let masqueNom = /^[A-Za-z '-]{2,40}$/;
    let masquePrenom = /^[A-Za-z '-]{2,40}$/;
    let masqueEmail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    let nomFamilleValide = document.getElementById('nom').value.match(masqueNom);
    let prenomValide = document.getElementById('prenom').value.match(masquePrenom);
    let emailValide = document.getElementById('mail').value.match(masqueEmail);
    let texteMessage = document.getElementById('message').value

    if (document.getElementById('nom').value == "") {

        alert("Merci de saisir votre nom de famille");
        return false;

    } else if (document.getElementById('prenom').value == "") {

        alert("Merci de saisir votre prénom");
        return false;

    } else if (document.getElementById('mail').value == "") {

        alert("Merci de saisir votre adresse e-mail");
        return false;

    } else if (document.getElementById('message').value == "") {

        alert("Merci de saisir votre message");
        return false;

    } else if (nomFamilleValide == null) {

        alert("Votre nom de famille doit faire moins de 40 caractères et ne peut comporter que les caractères suivant en plus de lettres : - ' ");
        return false;

    } else if (prenomValide == null) {

        alert("Votre prénom doit faire moins de 40 caractères et ne peut comporter que les caractères suivant en plus de lettres : - ' ");
        return false;

    } else if (emailValide == null) {

        alert("Votre adresse email ne semble pas valide");
        return false;

    } else if (texteMessage.includes('<') && texteMessage.includes('>')) {

        alert("Votre message contient le signe < et le signe >, ceci pouvant présenter un risque potentiel, votre message a été effacé.");
        document.getElementById('message').value = "";
        return false;

    } else {

        return true;

    }

}