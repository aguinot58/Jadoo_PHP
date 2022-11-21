/* fichier javascript en mode strict */
"use strict"; 

function valider_plat(){

    let nom_plat = document.getElementById('nom_plat').value;
    let desc_plat = document.getElementById('desc_plat').value;
    let cat_plat = document.getElementById('cat_plat').value;
    let img_plat = document.getElementById('img_plat').value;
    let visibilite_plat = document.getElementById('visibilite_plat').value;
    let tbl_format_img = img_plat.split(".");

    if (nom_plat==""){
        alert("Merci de saisir un nom de plat");
        return false;
    } else if (desc_plat==""){
        alert("Merci de saisir la déscription du plat");
        return false;
    } else if (img_plat==""){
        alert("Merci de sélectionner l'image de présentation du plat");
        return false;
    } else if (cat_plat=="Choix"){
        alert("Merci de sélectionner la catégorie du plat");
        return false;
    }else if (tbl_format_img[1]!="jpg" && tbl_format_img[1]!="jpeg" && tbl_format_img[1]!="png"){
        alert("Merci de sélectionner une image au format jpg ou png");
        return false;
    } else if (visibilite_plat=="Choix"){
        alert("Merci de sélectionner la visibilité du plat");
        return false;   
    } else {
        return true;
    }
}

function valider_plat2(){

    let nom_plat = document.getElementById('nom_plat2').value;
    let desc_plat = document.getElementById('desc_plat2').value;
    let cat_plat = document.getElementById('cat_plat2').value;
    let visibilite_plat = document.getElementById('visibilite_plat2').value;
    let tbl_class_IF = document.getElementById('input_file').className;
    let id_comp= "";

    if ((tbl_class_IF.indexOf('d-none') > -1) == true){
        id_comp = "img_plat3";
    } else {
        id_comp = "img_plat2";
    }

    let img_plat = document.getElementById(id_comp).value;
    let tbl_format_img = img_plat.split(".");

    if (nom_plat==""){
        alert("Merci de saisir un nom de plat");
        return false;
    } else if (desc_plat==""){
        alert("Merci de saisir la déscription du plat");
        return false;
    } else if (img_plat==""){
        alert("Merci de sélectionner l'image de présentation du plat");
        return false;
    } else if (cat_plat=="Choix"){
        alert("Merci de sélectionner la catégorie de plat");
        return false;
    }else if (tbl_format_img[1]!="jpg" && tbl_format_img[1]!="jpeg" && tbl_format_img[1]!="png"){
        alert("Merci de sélectionner une image au format jpg ou png");
        return false;
    } else if (visibilite_plat=="Choix"){
        alert("Merci de sélectionner la visibilité du plat");
        return false;   
    } else {
        return true;
    }
}



function Suppr_plat(event){

    let type_element= event.target.id;

    let id_bouton = "";

    if (type_element == ""){
        id_bouton = event.target.name;
    } else {
        id_bouton = event.target.id;
    }

    let tb_split_id = id_bouton.split("_");
    let id_plat = tb_split_id[1];
    let donnees = {"id_plat": id_plat};

    fetch_post('./suppr_plat.php', donnees).then(function(response) {

        if(response=='suppression reussie'){

            alert('Plat supprimé !');
            window.location.href = "back_plat.php";


        } else if (response=='erreur suppression plat') {

            alert('Echec de la suppression du plat - annulation');

        } else if (response=='echec connexion bdd') {

            alert('Echec de la connexion à la base de données - annulation');

        } else if (response=='test if echec') {

            alert('Echec identification du plat - annulation');

        }

    });

}


$(document).on("click", ".open_modal", function () {
    var myId = $(this).data('id');
    let donnees = {"id_plat": myId};

    fetch_post('./modal_modif_plat.php', donnees).then(function(response) {

        document.getElementById('affichage_modal').innerHTML = response;

        var myModal = new bootstrap.Modal(document.getElementById("Modif_Modal"));
        myModal.show();

    });

});


function Modif_contenu_page(){

    let tbl_class_IF = document.getElementById('input_file').className;

    if ((tbl_class_IF.indexOf('d-none') > -1) == true){

        document.getElementById('input_file').setAttribute ("class", "d-flex row");
        document.getElementById('input_text').setAttribute ("class", "d-none row");
        document.getElementById('img_plat3').value = "";

    } else {

        document.getElementById('input_file').setAttribute ("class", "d-none row");
        document.getElementById('input_text').setAttribute ("class", "d-flex row");

    }

}


function data(data) {

    let text = "";

    for (var key in data) {
      text += key + "=" + data[key] + "&";
    }

    return text.trim("&");
}


function fetch_post(url, dataArray) {

    let dataObject = data(dataArray);

    return fetch(url, {
             method: "post",
             headers: {
                   "Content-Type": "application/x-www-form-urlencoded",
             },
             body: dataObject,
        })
        .then((response) => response.text())
        .catch((error) => console.error("Error:", error));

}
