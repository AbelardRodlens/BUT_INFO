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
        var canvas = document.getElementById('CA_chart');
        var ctx = canvas.getContext('2d');

        // Créer le graphique
        // if(Chart.getChart('CA_chart') == null){
        //     var myChart = new Chart(ctx, {
        //         type: 'bar',
        //         data: data,
        //         options: options
        //     });
        // }
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


buttons_settings[0].addEventListener("click", function(){
        PagesPara[0].style.visibility="visible"; // Remplace la valeur "visible" de la propriété visibility de la page par "hidden".
        blur.style.visibility="visible"; //Affiche le flou.

        CA_inputs_radio.forEach((input_radio, index)=>{ //Réaffiche l'input à la la réouverture de la page paramètre si un input radio a été sélectionné.
            if(input_radio.checked){ //Vérifie si un input radio est selectionnée.
                CA_inputs_dates[index].style.visibility='visible'; // Affiche l'input_date relié à l'input_radio en question.
                
            }

        })
    })

buttons_settings[1].addEventListener("click", function(){
    PagesPara[1].style.visibility="visible"; // Remplace la valeur "visible" de la propriété visibility de la page par "hidden".
        blur.style.visibility="visible"; //Affiche le flou.
    MP_inputs_radio.forEach((input_radio, index)=>{ //Réaffiche l'input à la la réouverture ...
            if(input_radio.checked){ //Vérifie ...
                MP_inputs_dates[index].style.visibility='visible'; // Affiche l'input_date ...
                
            }

        })
    })


// Page paramètre boutton fermer
let cross=document.querySelectorAll(".cross");  //Met dans la variable cross une Nodelist comportant des éléments de classe "cross".
let CA_inputs_dates=document.querySelectorAll(".CA-inputs-periode");
let MP_inputs_dates=document.querySelectorAll(".MP-inputs-periode");
cross.forEach((cross,index)=>{
    if(index==0){
        
        cross.addEventListener("click", function(){
            CA_inputs_dates.forEach((input_date)=>{
                input_date.style.visibility="hidden";
            })
            PagesPara[0].style.visibility ="hidden";// Remplace la valeur "visible" de la propriété visibility de la page par "hidden".
            blur.style.visibility="hidden"; //Cache le flou.
        
        })
    } else{
        
        cross.addEventListener("click", function(){
            MP_inputs_dates.forEach((input_date)=>{
                input_date.style.visibility="hidden";
            })
            PagesPara[1].style.visibility ="hidden";// Remplace la valeur "visible" de la propriété visibility de la page par "hidden".
            blur.style.visibility="hidden"; //Cache le flou.
        
        })    
    }
})

// Page paramètre afficher input-date selon input radio selectionné.

let CA_inputs_radio=document.querySelectorAll(".CA-radio");
let MP_inputs_radio=document.querySelectorAll(".MP-radio");
let input_space_para=document.querySelectorAll(".exemple");

PagesPara.forEach((Page,index)=>{
    if(index==0){
        CA_inputs_radio.forEach((input_radio,index)=>{
            input_radio.addEventListener("click",function(){
                CA_inputs_dates.forEach((input_date)=>{
                    if(input_date.style.visibility=="visible"){
                        input_date.style.visibility="hidden";
                    }
                })
                CA_inputs_dates[index].style.visibility="visible";

            })
        })
    } 
    else{
        
        MP_inputs_radio.forEach((input_radio,index)=>{
            input_radio.addEventListener("click",function(){
                MP_inputs_dates.forEach((input_date)=>{
                    if(input_date.style.visibility=="visible"){
                        input_date.style.visibility="hidden";
                    }
                })
                MP_inputs_dates[index].style.visibility="visible";
                console.log(MP_inputs_dates);
            })
        })
    }
})

//Page paramètre envoyer form
let CA_form=document.getElementById("CA-Parametre-form");
let MP_form=document.getElementById("MP-Parametre-form");

CA_form.addEventListener("submit",function(event){
    event.preventDefault(); // Annule le comportement par défaut du formulaire.
    
    CA_inputs_dates.forEach((input)=>{                         
        if(input.style.visibility=='visible'){  //Si l'input est visible (c'est à dire sélectionné) ,mais qu'il n'est pas remplie on affiche l'alerte.
            if(input.value == null || input.value ==''){
            alert('Veuillez remplir tout les champs !!!');

        } else{ //Dans le cas contraire on valide le formulaire.
            caValiderFormulaire();
        }

        }
        
    })
    var nb_checked=0;
    CA_inputs_radio.forEach((input_radio)=>{
        if(input_radio.checked){
            nb_checked+=1;

        }
    })
    if(nb_checked < 1){
        alert("Aucune période n'a été sélectionné.");
    }
    
    

});


MP_form.addEventListener("submit",function(event){
    event.preventDefault(); // Annule le comportement par défaut du formulaire.
    
    MP_inputs_dates.forEach((input)=>{                         
        if(input.style.visibility=='visible'){  //Si l'input est visible (c'est à dire sélectionné) ,mais qu'il n'est pas remplie on affiche l'alerte.
            if(input.value == null || input.value ==''){
            alert('Veuillez remplir tout les champs !!!');

        } else{ //Dans le cas contraire on valide le formulaire.
            mpValiderFormulaire();
        }

        }
        
    })
    var nb_checked=0;
    MP_inputs_radio.forEach((input_radio)=>{
        if(input_radio.checked){
            nb_checked+=1;

        }
    })
    if(nb_checked < 1){
        alert("Aucune période n'a été sélectionné.");
    }
    
    

});

function caValiderFormulaire() {
            

            var xhr = new XMLHttpRequest();
            xhr.open('POST', './Controllers/Controller_home.php', true);

            xhr.onreadystatechange=function(){
                let input_year=document.getElementById('CA_input_year');
                let input_month=document.getElementById('CA_input_month');
                let input_week=document.getElementById('CA_input_week');
                let input_date=document.getElementById('CA_input_date');
                if(xhr.readyState==4 && xhr.status==200){

                    reponse=JSON.parse(this.responseText);
                    
                    graphique=Chart.getChart('CA_chart');
                    if(graphique){
                        graphique.destroy();
                        
                        
                    }
                    

                    if(input_year.style.visibility=="visible"){
                        // Définir les données pour le graphique
                        var data = {
                        labels: [ 'Janvier',  'Février',  'Mars', 'Avril', 'Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
                        datasets: [{
                            label: "Chiffre d'affaires "+document.getElementById('CA-Select-Dep').value+' '+input_year.value,
                            backgroundColor: 'red',
                            borderColor: 'black',
                            data: [reponse[0].Montant_total, reponse[1].Montant_total, reponse[2].Montant_total, reponse[3].Montant_total, reponse[4].Montant_total,reponse[5].Montant_total,reponse[6].Montant_total,reponse[7].Montant_total,reponse[8].Montant_total,reponse[9].Montant_total,reponse[10].Montant_total,reponse[11].Montant_total]
                        }]
                    };

                    }
                    else if(input_month.style.visibility=="visible"){
                        label_reponse=[];
                        data_reponse=[];
                        reponse[0].forEach((donnée,index)=>{
                            var date=reponse[1][index][0];
                            date=date.split('-');
                            var day=date[2];
                            var month=date[1];
                            var year=date[0];
                            data_reponse.push(donnée.Montant_total);
                            label_reponse.push('Semaine du '+day+month+year);
                            

                        })
                        var data = {
                            labels: label_reponse,
                            datasets: [{
                                label: "Chiffre d'affaires",
                                backgroundColor: 'red',
                                borderColor: 'black',
                                data: data_reponse
                            }]
                        };
                        
                        
                    }
                    else if(input_week.style.visibility=="visible"){
                        label_reponse=[];
                        data_reponse=[];
                        reponse[0].forEach((donnée,index)=>{
                            var date=new Date(reponse[1][index]);
                            var date_name='';
                            var day=date.getDay();
                            var month=date.toLocaleString('fr-FR', { month: 'long' });
                            var year=date.getFullYear();
                            
                            
                            data_reponse.push(donnée.Montant_total);
                            if(date.getDay()==1){
                                date_name='Lundi';
                            }
                            else if(date.getDay()==2){
                                date_name='Mardi';
                            }
                            else if(date.getDay()==3){
                                date_name='Mercredi';
                            }
                            else if(date.getDay()==4){
                                date_name='Jeudi';
                            }
                            else if(date.getDay()==5){
                                date_name='Vendredi';
                            }
                            label_reponse.push(date_name+'  '+day+' '+month+'   '+year);


                        })
                        var data = {
                            labels: label_reponse,
                            datasets: [{
                                label: "Chiffre d'affaires",
                                backgroundColor: 'red',
                                borderColor: 'black',
                                data: data_reponse
                            }]
                        };
                        


                    }
                    

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
                    var canvas = document.getElementById('CA_chart');
                    ctx=canvas.getContext('2d');
                    
                    
                    
                    // Créer le graphique
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: data,
                        options: options
                    });
                    
                    
                }

            }
        

        
        let select_input_value=document.getElementById("CA-Select-Dep").value;
        // let radio_inputs=document.querySelectorAll(".CA-radio");
        
        var caformData=''; // Initialisation ici
        CA_inputs_dates.forEach((input)=>{
            if(input.style.visibility=="visible"){
                if(input.name=="year"){
                    if(input.value!= null){
                        caformData="Dep="+encodeURIComponent(select_input_value)+"&Date="+encodeURIComponent(input.value);

                    }
                } 
                else if(input.name=="month"){
                    caformData="Dep="+encodeURIComponent(select_input_value)+"&Year="+encodeURIComponent(input.valueAsDate.getFullYear())+"&Month="+encodeURIComponent(input.valueAsDate.getMonth() + 1);
                    
                }
                else if(input.name=="week"){
                    let day=input.valueAsDate.getDate();
                    let month=input.valueAsDate.getMonth()+1;
                    let year=input.valueAsDate.getFullYear();

                    caformData="Dep="+encodeURIComponent(select_input_value)+"&WeekDate="+encodeURIComponent([year,month,day].join('/'));
                    

                } 
                else{caformData="Dep="+encodeURIComponent(select_input_value)+"&Day="+encodeURIComponent(input.value);}
            
            }
            

        });

        


        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(caformData);
 
    }

    function mpValiderFormulaire() {
            

            var xhr = new XMLHttpRequest();
            xhr.open('POST', './Controllers/Controller_home.php', true);

            xhr.onreadystatechange=function(){
                let input_year=document.getElementById('MP_input_year');
                let input_month=document.getElementById('MP_input_month');
                let input_week=document.getElementById('MP_input_week');
                let input_date=document.getElementById('MP_input_date');
                if(xhr.readyState==4 && xhr.status==200){

                    reponse=JSON.parse(this.responseText);
                    
                    graphique=Chart.getChart('PM_chart');
                    if(graphique){
                        graphique.destroy();
                        
                        
                    }
                    
                    
                    if(input_year.style.visibility=="visible"){
                        PM_data_datas=[]; //Juste pour voir .
                        PM_labels_datas=[];
                        reponse.forEach((objet)=>{
                            PM_data_datas.push(objet.nb_facture);
                            PM_labels_datas.push(objet.reglement);
                        })
                        // Définir les données pour le graphique
                        var PM_data = {
                        labels: PM_labels_datas,
                        datasets: [{
                            label: "Nombre de factures "+document.getElementById('CA-Select-Dep').value+' '+input_year.value,
                            backgroundColor: 'red',
                            borderColor: 'black',
                            data: PM_data_datas
                        }]
                    };

                    }
                    else if(input_month.style.visibility=="visible"){
                        label_reponse=[];
                        data_reponse=[];
                        var date=input_month.valueAsDate;
                        var month=date.getMonth()+1;
                        var year=date.getFullYear();
                        reponse.forEach((objet,index)=>{
                            data_reponse.push(objet.nb_facture);
                            label_reponse.push(objet.reglement);
                            console.log(label_reponse);
                        });
                        var PM_data = {
                            labels: label_reponse,
                            datasets: [{
                                label: "Nombre de factures "+month+"/"+year,
                                backgroundColor: 'red',
                                borderColor: 'black',
                                data: data_reponse
                            }]
                        };
                        
                        
                    }
                    
                    else if(input_week.style.visibility=="visible"){
                        label_reponse=[];
                        data_reponse=[];
                        var ws_date=new Date(reponse[0]);
                        var day=ws_date.getDay();
                        var date=ws_date.getDate();
                        var month=ws_date.toLocaleString('fr-FR', { month: 'long' });
                        var year=ws_date.getFullYear();
                        reponse[1].forEach((objet)=>{
                            
                            
                            
                            data_reponse.push(objet.nb_facture);
                            label_reponse.push(objet.reglement);


                        })
                        var PM_data = {
                            labels: label_reponse,
                            datasets: [{
                                label: "Nombres factures semaine du "+date+" "+month,
                                backgroundColor: 'red',
                                borderColor: 'black',
                                data: data_reponse
                            }]
                        };
                        


                    }
                    
                    

                    // Configurer les options du graphique
                    var PM_options = {
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
                                },

                        
                            }
                        
                        }
                    };


                    // Récupérer le canvas
                    var canvas = document.getElementById('PM_chart');
                    var ctx = canvas.getContext('2d');

                    // Créer le graphique
                    var PM_Chart = new Chart(ctx, {
                        type: 'bar',
                        data: PM_data,
                        options: PM_options
                    });
                    
                    
                }

            }
        

        
        let mp_select_input_value=document.getElementById("MP-Select-Dep").value;
        // let radio_inputs=document.querySelectorAll(".CA-radio");
        
        var caformData=''; // Initialisation ici
        MP_inputs_dates.forEach((input)=>{
            if(input.style.visibility=="visible"){
                if(input.name=="year"){
                    if(input.value!= null){
                        mpformData="mpDep="+encodeURIComponent(mp_select_input_value)+"&mpDate="+encodeURIComponent(input.value);

                    }
                } 
                else if(input.name=="month"){
                    mpformData="mpDep="+encodeURIComponent(mp_select_input_value)+"&mpYear="+encodeURIComponent(input.valueAsDate.getFullYear())+"&mpMonth="+encodeURIComponent(input.valueAsDate.getMonth() + 1);
                    
                }
                else if(input.name=="week"){
                    let day=input.valueAsDate.getDate();
                    let month=input.valueAsDate.getMonth()+1;
                    let year=input.valueAsDate.getFullYear();

                    mpformData="mpDep="+encodeURIComponent(mp_select_input_value)+"&mpWeekDate="+encodeURIComponent([year,month,day].join('/'));
                    

                } 
                else{mpformData="mpDep="+encodeURIComponent(mp_select_input_value)+"&mpDay="+encodeURIComponent(input.value);}
            
            }
            

        });

        


        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(mpformData);
 
    }
    


    //Button extend
    let buttons_extend=document.querySelectorAll(".extend-input"); // Récupère dans une variable l'élément permettant d'agrandir le graphe.
    let extend_graphs_zones=document.querySelectorAll('.extend-graph');// ...................... la zone étendue du graphe.
    let zone_transparente=document.querySelector('.zone-transparente');// ...................... la zone transparente.
    let canvas_zone=document.querySelectorAll('.graph');    // ................. la div contenant le graphe.
    let div_home=document.getElementById("home-body"); // ............le body.
    let parent_extend_graphs_zones=document.querySelectorAll(".graph-space"); // ......... la div contenant la div qui contient lui même le graphe.
    buttons_extend.forEach((button,index)=>{
        button.addEventListener('click',function(){

            if(!canvas_zone[index].classList.contains('extend-graph')){
                parent_extend_graphs_zones[index].removeChild(canvas_zone[index]);
                div_home.appendChild(canvas_zone[index]);
                canvas_zone[index].classList.add('extend-graph');
                canvas_zone[index].style.visibility="visible";
                zone_transparente.style.visibility="visible";
            }
            else{
                
                extend_graphs_zones[index].style.visibility="hidden";
                zone_transparente.style.visibility="hidden";
                
            }
        })
    })

    //Fermer graphe étendu
    zone_transparente.addEventListener('click',function(){ //Ajoute un gestionnaire d'événement sur la zone transparente.
        extend_graphs_zones.forEach((extend_graph_zone,index)=>{ 
            if(canvas_zone[index].classList.contains('extend-graph') && zone_transparente.style.visibility=="visible" ){ //Regarde si la div contenant le graphe à la classe 'extend-graph'(ce qui siginifie qu'il est étendu).
                div_home.removeChild(canvas_zone[index]);   //Enleve la div contenant le graphe des éléments enfant de la div home(équivaut à body).
                parent_extend_graphs_zones[index].appendChild(canvas_zone[index]); // Remet la div contenant le graph à sa place d'origine.
                canvas_zone[index].classList.remove('extend-graph'); //On redonne à la div ces attribruts d'origine.
                zone_transparente.style.visibility="hidden";    //Cache la zone transparente.

            }

        })
        
        

    })

    // Input select selon user
    var xhr = new XMLHttpRequest();
    xhr.open('POST','./Controllers/Controller_home.php',true);
    xhr.onreadystatechange= function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            $tab=JSON.parse(this.responseText);
            let inputs_select=document.querySelectorAll("select[name='Dep']");
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
    xhr.send('getDeps');
    
    // Charts

    var chart_xhr= new XMLHttpRequest();
    chart_xhr.open('POST','./Controllers/Controller_home.php',true);
    chart_xhr.onreadystatechange=function(){
        if(chart_xhr.readyState==4 && chart_xhr.status==200){

            var reponse=JSON.parse(this.response);

            // Paragraphe Stat
            var paragraphes=document.querySelectorAll('.stats');
            var p_chambre=paragraphes[0].textContent=reponse[0][1];
            var p_CA=paragraphes[1].textContent=reponse[4].Montant_total+" €";
            
                // CA Chart

                var CA_labels_datas=[];
                var CA_data_datas=[];
                var date=new Date();
                var year=date.getFullYear();
                reponse[2].forEach((objet)=>{
                    CA_labels_datas.push(objet.department_name);
                    CA_data_datas.push(objet.TurnoverByYear);
                })
                
                // Définir les données pour le graphique
            var data = {
                labels:CA_labels_datas,
                datasets: [{
                    label: "Chiffre d'affaires Année "+year,
                    backgroundColor: 'blue',
                    borderColor: 'black',
                    data: CA_data_datas
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
                                            size: 8,
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
                                    },

                                    // callbacks: {
                                    //     label: function(tooltipItem, data) {
                                    //         return data.labels[tooltipItem.index] + ': ' + data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] + '€';
                                            

                                    //     }

                                    // }
                                }
                            
                            }
            };
            // Récupérer le canvas
            var canvas = document.getElementById('CA_chart');
            var ctx = canvas.getContext('2d');

            // Créer le graphique
            var CA_Chart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: options
            });
        

            // RC Chart
            // Définir les données pour le graphique
            var data = {
                labels: ['Chambres non allouée', 'Chambres allouée'],
                datasets: [{
                    label: 'Nombre de chambres',
                    backgroundColor: ['rgb(255, 205, 86)', 'rgb(54, 162, 235)'],
                    data: [reponse[0][0], reponse[0][1]],
                    hoverOffset: 2
                }]
                
            };
            
            // Configurer les options du graphique
            var options = {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutoutPercentage: 5,
                    plugins:{
                        legend: {
                            labels:{
                                font:{
                                    size:15

                                }
                            },

                            display: false,
                        }
                    }
                
            };
            

            // Récupérer le canvas
            var RC_canvas = document.getElementById('RC_chart');
            var ctx = RC_canvas.getContext('2d');

            // Créer le graphique
        
            var RC_myChart = new Chart(ctx, {
                type: 'doughnut',
                data: data,
                options: options
            });


            // RA Chart
            var RA_data_datas=[];
            var RA_labels_datas=[];
            reponse[1].forEach((ligne)=>{
                RA_data_datas.push(ligne.nb_abonnée);
                RA_labels_datas.push(ligne.nom_bouquet);
                
            })

            
            // Définir les données pour le graphique
            var RA_data = {
                labels: RA_labels_datas,
                datasets: [{
                    label: 'Abonnée',
                    backgroundColor: ['rgb(239 129 182)', 'rgb(54, 162, 235)','rgb(127 205 216)','rgb(133 243 103)'],
                    data: RA_data_datas,
                    hoverOffset: 2
                }]
                
            };
            
            // Configurer les options du graphique
            var RA_options = {
                responsive: true,
                maintainAspectRatio: false,
                cutoutPercentage: 5,
                plugins:{
                    legend: {
                        labels:{
                            font:{
                                size:15

                            }
                        },
                        display: false,
                    }
                }
                
            };
            

            // Récupérer le canvas
            var RA_canvas = document.getElementById('RA_chart');
            var ctx = RA_canvas.getContext('2d');

            // Créer le graphique
        
            var RA_myChart = new Chart(ctx, {
                type: 'doughnut',
                data: RA_data,
                options: RA_options
            });

            // PM Chart

            var PM_labels_datas=[];
            var PM_data_datas=[];
            var date=new Date();
            var year=date.getFullYear();
            reponse[5].forEach((objet)=>{
                PM_labels_datas.push(objet.reglement);
                PM_data_datas.push(objet.nb_facture);
            })
            
            // Définir les données pour le graphique
        var PM_data = {
            labels: PM_labels_datas,
            datasets: [{
                label: "MP Site "+year,
                backgroundColor: 'blue',
                borderColor: 'black',
                data: PM_data_datas
            }]
        };

        // Configurer les options du graphique
        var PM_options = {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                ticks: {
                                    font: {
                                        size: 8,
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
                                },

                        
                            }
                        
                        }
        };
        // Récupérer le canvas
        var canvas = document.getElementById('PM_chart');
        var ctx = canvas.getContext('2d');

        // Créer le graphique
        var PM_Chart = new Chart(ctx, {
            type: 'bar',
            data: PM_data,
            options: PM_options
        });

        }
    }
    chart_xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    chart_xhr.send('getChartsData');
    
            
    



</script>
</body>
</html>