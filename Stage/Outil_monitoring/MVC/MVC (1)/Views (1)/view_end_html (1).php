<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

    
    var urlParams = new URLSearchParams(window.location.search);

    if (urlParams.has('controller') && urlParams.get('controller') === 'userlist'){
    ActualiserListUsers();
    setInterval(ActualiserListUsers, 60000);//60000ms

  



    document.getElementById('modify_user_form').addEventListener('submit', function(event) {
    // Empêche le rechargement de la page par défaut
    event.preventDefault();

    // Appel la fonction validerFormulaire lorsque l'action submit est détecté.
    validerFormulaire(ActualiserListUsers); // Appel la fonction ActualiserListUsers quelques ms après pour être sur d'actualiser la liste après modification.
    
    var userinfos = document.getElementById('userinfos');
    userinfos.style.visibility= 'hidden';
        
    
    
    
    });
            
    function validerFormulaire(callback) {
        console.log("dans validerFormulaire");

        var xhr = new XMLHttpRequest();
        xhr.open('POST', './Controllers/Controller_userlist.php', true);
        
            
        var newusername = document.getElementById('newusername-userlist').value.trim();
        var oldusername = document.getElementById('oldusername-userlist').value.trim();
        var newadress = document.getElementById('newadress-userlist').value.trim();
        var oldadress = document.getElementById('oldadress-userlist').value.trim();

        var formData = ''; // Initialisation ici

        if ((newusername === '') && (newadress === '')) {
            alert('Veuillez remplir au moins un champ.');
            return false;
        } else if (newusername === '' && newadress !== '') {
            formData = '&newadress=' + encodeURIComponent(newadress) + '&oldadress=' + encodeURIComponent(oldadress);
            newusername = oldusername;
        } else if (newadress === '' && newusername !== '') {
            formData = 'newusername=' + encodeURIComponent(newusername) + '&oldusername=' + encodeURIComponent(oldusername) + '&oldadress=' + encodeURIComponent(oldadress);
            newadress = oldadress;
        } else {
            formData = 'newusername=' + encodeURIComponent(newusername) + '&oldusername=' + encodeURIComponent(oldusername) + '&newadress=' + encodeURIComponent(newadress) + '&oldadress=' + encodeURIComponent(oldadress);
        }

        
        

        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(formData);


        setTimeout(callback,0500);
        
        let newusername_userlist = document.getElementById('newusername-userlist');
        let newadress_userlist = document.getElementById('newadress-userlist');

        newusername_userlist.value="";
        newadress_userlist.value="";
    

        
}



    function ActualiserListUsers() { // Actualise la liste des utilisateur
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./Controllers/Controller_userlist.php", true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var users = JSON.parse(this.response);
            var userRows = document.querySelectorAll('.user_row');

            users.forEach(function(user) {
                var existingRow = Array.from(userRows).find(function(row) {
                    return row.querySelector('.voirplus').name === user.user_id;
                });

                if (!existingRow) { // Si l'utilisateur est présent dans la bd, mais pas dans la liste alors il l'ajoute à celui-ci.
                    var div = document.createElement("div");
                    div.classList.add('user_row');

                    var para = document.createElement("p");
                    para.textContent = "username= " + user.username + " address= " + user.adresse;
                    div.appendChild(para);

                    var input = document.createElement("input");
                    input.type = "submit";
                    input.classList.add('voirplus');
                    input.name = user.user_id;
                    input.value = "modifier";
                    div.appendChild(input);

                    var input_del = document.createElement("input");
                    input_del.type = "submit";
                    input_del.classList.add('del');
                    input_del.value = "supprimer";
                    input_del.name = user.user_id;
                    div.appendChild(input_del);

                    

                    document.body.appendChild(div);

                    // Ajoute un gestionnaire d'événements pour ce nouveau bouton voirplus
                    input.addEventListener("click", function() {
                        var userinfos = document.getElementById('userinfos');
                        let newusername_userlist = document.getElementById('newusername-userlist');
                        let newadress_userlist = document.getElementById('newadress-userlist');

                        newusername_userlist.value="";
                        newadress_userlist.value="";

                    
                        newusername_userlist.placeholder = user.username;
                        newadress_userlist.placeholder = user.adresse;

                        var oldusername = document.getElementById('oldusername-userlist');
                        oldusername.value = user.username;

                        var oldadress = document.getElementById('oldadress-userlist');
                        oldadress.value = user.adresse;

                        userinfos.style.visibility = 'visible';
                        
                    });

                    // Ajoute un gestionnaire d'événements pour button supprimer
                    inputs=Array.from(document.querySelectorAll(".del"));
                    console.log(inputs);

                    inputs.forEach((val, key) =>{
                        inputs[key].addEventListener("click", function(){
                            
                            
                            xhr= new XMLHttpRequest();
                            xhr.open('POST', './Controllers/Controller_userlist.php', true);
                            xhr.onreadystatechange=function(){
                                if(xhr.readyState ==4 && xhr.status==200){
                                        inputs[key].parentNode.remove();
                                        

                                }
                                
                            }

                            let userid=this.name;

                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            
                            xhr.send("userid="+userid);

                        
                        })
                        
                    });

                } else { // Si il existe il met seulement à jour les valeurs username et adresse.
                    var userPara = existingRow.querySelector("p");
                    userPara.textContent = "username= " + user.username + " address= " + user.adresse;
                }
            });

            userRows.forEach(function(row) {// Verifie que chaque lignes de la liste correspondent à un utilisateur, sinon il supprime celui-ci.
                var userId = row.querySelector('.voirplus').name;
                var existingUser = users.find(function(user) {
                    return user.user_id === userId;
                });

                if (!existingUser) {
                    row.remove();
                }
            });
        }
    };

    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send('getUsers=2');
}

document.getElementById("croix").addEventListener("click", function(){
    if(userinfos.style.visibility == 'visible'){
        userinfos.style.visibility = 'hidden';

    }
    
})


}


//      *   *  Page Stats  *   *


 // Récupérer le contexte du canvas



 var xhr = new XMLHttpRequest();
xhr.open('POST', './Controllers/Controller_stats.php', true);
xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
        var montant = JSON.parse(this.responseText);
        console.log(montant[0].Montant_total);

        // Définir les données pour le graphique
        var data = {
            labels: [ montant[0][0].department_name,  montant[1][0].department_name,  montant[2][0].department_name, 'Avril', 'Mai'],
            datasets: [{
                label: 'Ventes mensuelles',
                backgroundColor: 'blue',
                borderColor: 'black',
                data: [montant[0][0].Montant_total, montant[1][0].Montant_total, montant[2][0].Montant_total, 65, 80]
            }]
        };

        // Configurer les options du graphique
        var options = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
            
        };

        // Récupérer le canvas
        var canvas = document.getElementById('myChart');
        var ctx = canvas.getContext('2d');

        // Créer le graphique
        if(Chart.getChart('myChart') == null){
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: options
            });
        }
    }
};

xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.send('getMontant');

  

/*Home Script */

let inputs=document.querySelectorAll(".inputs-menu");

inputs.forEach((input)=>{
    input.addEventListener("mouseenter", function(){
        this.style.backgroundColor="#f1f1f1";
    })

    input.addEventListener("mouseleave", function(){
        this.style.backgroundColor="#FFFFFF";
    })

});

//Page paramètre afficher
let blur=document.querySelector(".blur");
let buttons_settings=document.querySelectorAll(".infos-settings"); //Met dans la variable buttons_settings une Nodelist comportant des éléments de classe "infos-settings".
let PagesPara=document.querySelectorAll(".Page-Parametres"); // Pareil pour les éléments de classe "Page-Parametres".

buttons_settings.forEach((button, index) =>{
    button.addEventListener("click", function(){
        PagesPara[index].style.visibility="visible"; // Remplace la valeur "visible" de la propriété visibility de la page par "hidden".
        blur.style.visibility="visible"; //Affiche le flou.
    })
})



// Page paramètre boutton fermer
let cross=document.querySelectorAll(".cross");  //Met dans la variable cross une Nodelist comportant des éléments de classe "cross".
let inputs_dates=document.querySelectorAll(".inputs-periode");
cross.forEach((cross,index)=>{
    cross.addEventListener("click", function(){
        inputs_dates.forEach((input_date)=>{
            input_date.style.visibility="hidden";
        })
        PagesPara[index].style.visibility ="hidden";// Remplace la valeur "visible" de la propriété visibility de la page par "hidden".
        blur.style.visibility="hidden"; //Cache le flou.
        
    })
})

// Page paramètre afficher input-date selon input radio selectionné.

let inputs_radio=document.querySelectorAll(".CA-radio");
let input_space_para=document.querySelectorAll(".exemple");


inputs_radio.forEach((input_radio,index)=>{
    input_radio.addEventListener("click",function(){
        inputs_dates.forEach((input_date)=>{
            if(input_date.style.visibility=="visible"){
                input_date.style.visibility="hidden";
            }
        })
        inputs_dates[index].style.visibility="visible";

    })
})
//Page paramètre envoyer form
let CA_form=document.getElementById("CA-Parametre-form");

CA_form.addEventListener("submit",function(event){
    event.preventDefault();
    caValiderFormulaire();

});

function caValiderFormulaire() {
            console.log("dans validerFormulaire");

            var xhr = new XMLHttpRequest();
            xhr.open('POST', './Controllers/Controller_home.php', true);

            xhr.onreadystatechange=function(){
                if(xhr.readyState==4 && xhr.status==200){

                    montant=JSON.parse(this.responseText);

                    var montant = JSON.parse(this.responseText);
                    console.log(montant[0].Montant_total);

                    graphique=Chart.getChart('myChart');
                    if(graphique){
                        graphique.destroy();
                        
                        
                    }
                    // Définir les données pour le graphique
                    var data = {
                        labels: [ 'Janvier',  'Février',  'Mars', 'Avril', 'Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
                        datasets: [{
                            label: "Chiffre d'affaires",
                            backgroundColor: 'red',
                            borderColor: 'black',
                            data: [montant[0].Montant_total, montant[1].Montant_total, montant[2].Montant_total, montant[3].Montant_total, montant[4].Montant_total,montant[5].Montant_total,montant[6].Montant_total,montant[7].Montant_total,montant[8].Montant_total,montant[9].Montant_total,montant[10].Montant_total,montant[11].Montant_total]
                        }]
                    };

                    // Configurer les options du graphique
                    var options = {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                ticks: {
                                    font: {
                                        size: 17,
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true
                            }
                        },
                        
                        plugins: {
                            tooltip: {
                                titleFont: {
                                    size: 20
                                },
                                bodyFont: {
                                    size: 15
                                }
                                
                            }
                        }
                        
                    };


                    // Récupérer le canvas
                    var canvas = document.getElementById('myChart');
                    ctx=canvas.getContext('2d');
                    
                    
                    
                    // Créer le graphique
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: data,
                        options: options
                    });
                    
                    
                }

            }
        

        
        let select_input_value=document.getElementById("CA-Select-Site").value;
        // let radio_inputs=document.querySelectorAll(".CA-radio");
        
        var caformData=''; // Initialisation ici
        inputs_dates.forEach((input)=>{
            if(input.style.visibility=="visible"){
                if(input.name=="year"){
                    caformData="Site="+encodeURIComponent(select_input_value)+"&Date="+encodeURIComponent(input.value);
                } 
                else if(input.name=="month"){
                    caformData="Site="+encodeURIComponent(select_input_value)+"&Year="+encodeURIComponent(input.valueAsDate.getFullYear())+"&Month="+encodeURIComponent(input.valueAsDate.getMonth() + 1);
                    
                }
                else if(input.name=="week"){
                    caformData="Site="+encodeURIComponent(select_input_value)+"&Week="+encodeURIComponent(input.value);
                } 
                else{caformData="Site="+encodeURIComponent(select_input_value)+"&Day="+encodeURIComponent(input.value);}
            
            }
            console.log(input.value);
        });


        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(caformData);
 
}
    


    //Button extend4
    let buttons_extend=document.querySelectorAll(".extend-input");
    let extend_graphs_zones=document.querySelectorAll('.extend-graph');
    let zone_transparente=document.querySelector('.zone-transparente');
    let canvas_zone=document.querySelectorAll('.graph');
    let div_home=document.getElementById("home-body");
    let parent=document.querySelectorAll(".graph-space");
    buttons_extend.forEach((button,index)=>{
        button.addEventListener('click',function(){

            if(extend_graphs_zones[index].style.visibility =="hidden"){
                // console.log(extend_graphs_zones[index]);
                // extend_graphs_zones[index].style.visibility="visible";
                // zone_transparente.style.visibility="visible";
                parent[index].removeChild(canvas_zone[index]);
                // canvas_zone[index].style.width=60+'%';
                // canvas_zone[index].style.height=50+'%';
                // canvas_zone[index].style.position='absolute';
                canvas_zone[index].classList.add('extend-graph');
                div_home.appendChild(canvas_zone[index]);
                canvas_zone[index].style.visibility="visible";
                zone_transparente.style.visibility="visible";
            }
            else{
                extend_graphs_zones[index].style.visibility="hidden";
                zone_transparente.style.visibility="hidden";
                
            }
        })
    })

    // Input select selon user
    var xhr = new XMLHttpRequest();
    xhr.open('POST','./Controllers/Controller_home.php',true);
    xhr.onreadystatechange= function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            $tab=JSON.parse(this.responseText);
            let inputs_select=document.querySelectorAll("select[name='Site']");
            inputs_select.forEach((input_select,index)=>{
                $tab.forEach((Ligne)=>{
                    let option=document.createElement('option');
                    option.value=Ligne.department_name;
                    option.textContent=Ligne.department_name;
                    input_select.appendChild(option);
                        
                    
                });

            })
        

        }
    }
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('getSites');
    


</script>
</body>
</html>