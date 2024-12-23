    var userlist=document.getElementById('userlist');
    var buttons=document.querySelectorAll('.voirplus');
    console.log(buttons);

    var test=document.getElementById('test');

    var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Parsez la réponse JSON en un tableau JavaScript
                var users = JSON.parse(xhr.responseText);

                // Utilisez le tableau JavaScript comme nécessaire
                console.log(users);
            
            }
        };

        xhr.open("GET", "./Controllers/Controller_userlist.php", true);
        xhr.send();
    
    
    
    
    for (let i=0; i < buttons.length; i++) {
        
        buttons[i].addEventListener("click", function() {
            //var tab= <?php echo $tab;?>;
            console.log(tab[i]);
            console.log(i);
            
            
            

            var userinfos = document.getElementById('userinfos'); // Récupère dans une variable l'élément permettant de modifier les données de l'utilisateur
            let newusername_userlist=document.getElementById('newusername-userlist'); //Récupère dans une variable l'input username.
            let newadress_userlist=document.getElementById('newadress-userlist');     //Récupère dans une variable l'input adresse.

            if(userinfos.style.visibility == 'hidden'){
                newusername_userlist.placeholder=tab[i].username; // Modifie la valeur placeholder pour y afficher l'username actuel de l'utilisateur
                newadress_userlist.placeholder=tab[i].adresse; // Modifie la valeur placeholder pour y afficher l'adress actuel de l'utilisateur

                // Met la valeur l'username de l'utilisateur sur lequel on a cliquer dans l'input cacher #oldusername-userlist
                var oldusername=document.getElementById('oldusername-userlist');
                oldusername.value=tab[i].username;

                // Met la valeur l'adresse de l'utilisateur sur lequel on a cliquer dans l'input cacher #oldadress-userlist
                var oldadress=document.getElementById('oldadress-userlist');
                oldadress.value=tab[i].adresse;
                

                // Rend visible l'élément permettant de modifier les données de l'utilisateur
                userinfos.style.visibility = 'visible';
                return oldusername;

            }else {userinfos.style.visibility = 'hidden'; //Cache l'élément dans le cas où il est visible}
            
        }});
    };


    document.getElementById('modify_user_form').addEventListener('submit', function(event) {
        // Empêche le rechargement de la page par défaut
         event.preventDefault();
         // Appel la fonction validant le formulaire seulement si un changement a été fait
         validerFormulaire();


            });

            function validerFormulaire() {//fonction validant formulaire
                
               
            var newusername = document.getElementById('newusername-userlist').value.trim();//Récupère la valeur de l'input username en y effacant les espaces et indentation
            var oldusername=document.getElementById('oldusername-userlist').value.trim(); //Aucune utilité !!!!!!!

            var newadress = document.getElementById('newadress-userlist').value.trim();//Récupère la valeur de l'input adress en y effacant les espaces et indentation
            var oldadress=document.getElementById('oldadress-userlist').value.trim();//Aucune utilité !!!!!!!

            if ((newusername === '') && (newadress ==='')) { //Renvoie false si les 2 champs sont vide
                alert('Veuillez remplir au moins un champ.');
                return false; // Le formulaire n'est pas valide
            }

            else if (newusername === '') { //Si champ vide, attribue valeur par défaut
                newusername=oldusername;
            }

            else if (newadress ===''){
                newadress=oldadress;
                
            }



            // Créez une instance de XMLHttpRequest
            var xhr = new XMLHttpRequest();

            // Configurez la requête
            xhr.open('POST', './Controllers/Controller_userlist.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            var formData = 'newusername=' + encodeURIComponent(newusername) + '&oldusername=' + encodeURIComponent(oldusername) + '&newadress=' + encodeURIComponent(newadress) + '&oldadress=' + encodeURIComponent(oldadress);
            // Ajoutez d'autres champs si nécessaire

            xhr.send(formData);


            

            
        }

    
    
    




