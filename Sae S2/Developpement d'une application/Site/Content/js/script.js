document.addEventListener("DOMContentLoaded", function () {
    const afficherMiniPageButton = document.getElementById("afficherAdd");
    const fermerMiniPageButton = document.getElementById("ajouterAdd");
    const fermerAddMiniPageButton = document.getElementById("fermerAdd");
    const miniPage = document.getElementById("addPage");

    afficherMiniPageButton.addEventListener("click", function () {
        miniPage.style.display = "flex";
    });

    fermerMiniPageButton.addEventListener("click", function () {
        miniPage.style.display = "none";
    });

    fermerAddMiniPageButton.addEventListener("click", function () {
        miniPage.style.display = "none";
    });
});


function appuyerSurEntree(event) {
    // Vérifier si la touche appuyée est "Entrée"
    if (event.key === "Enter") {
      // Empêcher le comportement par défaut du formulaire (s'il y en a un)
      event.preventDefault();

      // Appeler la fonction d'action post
      actionPost();
    }
  }

  function actionPost() {
    // Récupérer la valeur du champ de saisie
    var searchValue = document.getElementById("searchInput").value;
  
    // Créer un nouvel objet XMLHttpRequest
    var xhr = new XMLHttpRequest();
  
    // Définir la fonction de rappel pour gérer la réponse
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          // Traitement de la réponse ici (par exemple, mise à jour de l'affichage)
          var searchResults = document.getElementById("searchResults");
          searchResults.innerHTML = xhr.responseText;
        } else {
          console.error('Erreur lors de la requête AJAX');
        }
      }
    };
  
    // Construire l'URL du script PHP de traitement de la requête
    var url = "votre_script.php";
  
    // Ouvrir la requête avec la méthode POST
    xhr.open("POST", url, true);
  
    // Définir l'en-tête de la requête pour spécifier le type de contenu
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  
    // Construire les données à envoyer
    var params = "search=" + encodeURIComponent(searchValue);
  
    // Envoyer la requête avec les données
    xhr.send(params);
  }
  