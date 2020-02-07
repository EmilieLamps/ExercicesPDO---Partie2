//    Fonction pour la fenetre de confirmation
    function deleteButton(id){
        if (confirm('Souhaitez vous supprimer ce patient ?')){
            window.location.href="liste-patients.php?deleteButton="+id;
        }
    }



