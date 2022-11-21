/* fichier javascript en mode strict */
"use strict"; 


    function Suppr_msg(event){

        let type_element= event.target.id;
    
        let id_bouton = "";
    
        if (type_element == ""){
            id_bouton = event.target.name;
        } else {
            id_bouton = event.target.id;
        }
    
        let tb_split_id = id_bouton.split("_");
        let id_msg = tb_split_id[1];
        let donnees = {"id_msg": id_msg};
    
        fetch_post('./suppr_msg.php', donnees).then(function(response) {
    
            if(response=='suppression reussie'){
    
                alert("Suppresion réussie");
                window.location.href = "back_msg.php";
    
    
            } else if (response=='erreur suppression message') {
    
                alert('Echec de la suppression du message - annulation');
    
            } else if (response=='echec connexion bdd') {
    
                alert('Echec de la connexion à la base de données - annulation');
    
            }
    
        });
    
    }




    $(document).on("click", ".open_modal", function () {
        var myId = $(this).data('id');
        let donnees = {"id_msg": myId};

        fetch_post('./modal_affichage_msg.php', donnees).then(function(response) {

            document.getElementById('affichage_modal').innerHTML = response;

            var myModal = new bootstrap.Modal(document.getElementById("Consult_Msg_Modal"));
            myModal.show();

        });

    });




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
