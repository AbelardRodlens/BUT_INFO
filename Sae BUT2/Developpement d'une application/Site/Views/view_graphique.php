<?php require "view_begin_html.php";?>
<title>Graphique</title>
<style>
    body {
    background-image: url("Content/img/Background.jpg");
    background-size: cover;
    height:100vh;
    background-repeat: no-repeat;
    width: auto;
    overflow: hidden;
    margin: 20px;
    padding: 0;
  }

  .chart-container{
    padding-left:15vh;
    padding-top:20vh;
    display: flex;
    justify-content: center;
    align-items: center;
    width:60%;
    height:60%;
    font-size:5vh;
    color:#ffffff;
  }
  #navbar{
    
    width:95%;
    height:10%;
    border-radius:5vh;
    background-color: #92846E;
    margin-left:2.5%;
      }

#navbar svg{

  height:90%;
  padding-left:1%;
}

#navbar #logout{
  height:90%;
  margin-left: 88.3%;
  margin-top: 0.2%;
  
}

#navbar {
    display: flex;
    width: 95%;
    height: 10%;
    border-radius: 5vh;
    background-color: #92846E;
    margin-left: 2.5%;
}
#navbar a {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: white;
    padding: 0 10px;
}

#navbar svg {
    height: 90%;
    margin-right: 22vh; /* Ajustez la marge à votre convenance */
}

  #navbar #logout{
    height:90%;
    margin-left:50%;
    margin-top: 0.2%;
    
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php

$tab=json_encode($data);

?>
 <div id="navbar">
    <a href="index.php?controller=home">
          <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" width="100" height="100">
          <path d="M37.5834 11.8334L15.125 29.3334C11.375 32.2501 8.33337 38.4584 8.33337 43.1668V74.0418C8.33337 83.7084 16.2084 91.6251 25.875 91.6251H74.125C83.7917 91.6251 91.6667 83.7084 91.6667 74.0834V43.7501C91.6667 38.7084 88.2917 32.2501 84.1667 29.3751L58.4167 11.3334C52.5834 7.25011 43.2084 7.45844 37.5834 11.8334Z" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M50 74.9584V62.4584" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>

        <a href="index.php?controller=enseignant">
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-search">
                    <circle cx="10" cy="7" r="4"/>
                    <path d="M10.3 15H7a4 4 0 0 0-4 4v2"/>
                    <circle cx="17" cy="17" r="3"/>
                    <path d="m21 21-1.9-1.9"/>
                </svg>
            </a>


      <a href="">
               
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="100" height="100"> 
            <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M3 3v5h5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 7v5l4 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
            </a>

            <a href="">
                
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-clock"><path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h5"/><path d="M17.5 17.5 16 16.25V14"/><path d="M22 16a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z"/></svg>
            </a>

            <a href="index.php?controller=profil&action=profil">
                <svg viewBox="0 0 100 100" fill="none"  xmlns="http://www.w3.org/2000/svg" width="100" height="100">
<path d="M50 49.9999C61.5059 49.9999 70.8333 40.6725 70.8333 29.1666C70.8333 17.6607 61.5059 8.33325 50 8.33325C38.4941 8.33325 29.1667 17.6607 29.1667 29.1666C29.1667 40.6725 38.4941 49.9999 50 49.9999Z" stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M80.0417 65.5834L65.2915 80.3336C64.7082 80.9169 64.1665 82.0001 64.0415 82.7918L63.2499 88.4167C62.9582 90.4583 64.3749 91.875 66.4166 91.5834L72.0415 90.7917C72.8331 90.6667 73.9583 90.1251 74.4999 89.5418L89.2498 74.7918C91.7915 72.2502 92.9998 69.2917 89.2498 65.5417C85.5415 61.8334 82.5833 63.0417 80.0417 65.5834Z" stroke="currentColor" stroke-width="5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M77.9167 67.7083C79.1667 72.2083 82.6666 75.7081 87.1666 76.9581" stroke="currentColor" stroke-width="5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M14.2082 91.6667C14.2082 75.5417 30.25 62.5 50 62.5C54.3333 62.5 58.4999 63.125 62.3749 64.2916" stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>

</a>

        <a href="#">
        <img src="Content/img/icons8-power-button-64" id="logout"/>
        </a>
        <form id="form-logout" action="index.php?action=logout" method="post" style="display: none;">
          <input type="hidden" id="input-logout" name="logout" value="">
        </form>

    </div>
<div class="chart-container">
<h1>Enseignant de l'IUT</h1>
  <canvas id="graph1" aria-labels="chart"></canvas>
</div>
<script>
    var tab = <?php echo $tab; ?>;
    var ctx = document.getElementById("graph1").getContext("2d");
    console.log(tab);

    var labels = [
        tab[0]['siglecat'],
        tab[1]['siglecat'],
        tab[2]['siglecat'],
        tab[3]['siglecat'],
        tab[4]['siglecat'],
        tab[5]['siglecat'],
        tab[6]['siglecat']
    ];

    var dataValues = [
        tab[0]['nb_enseignant'],
        tab[1]['nb_enseignant'],
        tab[2]['nb_enseignant'],
        tab[3]['nb_enseignant'],
        tab[4]['nb_enseignant'],
        tab[5]['nb_enseignant'],
        tab[6]['nb_enseignant']
    ];

    var total = dataValues.reduce((acc, val) => acc + val, 0);
    var percentages = dataValues.map(val => (val / total) * 100);

    var backgroundColors = ['red', 'green', 'blue', 'purple', 'pink', 'orange', 'yellow'];

    var data = {
        labels: labels,
        datasets: [{
            backgroundColor: backgroundColors,
            label: "Nombre d'enseignant",
            data: dataValues,
            borderWidth:2,
            hoverOffset:20
        }]
    };

    var options = {
        plugins: {
            legend: {
                position: 'bottom'
            },
            tooltip: {
                callbacks: {
                    label: function (context) {
                        var labelIndex = context.dataIndex;
                        var dataLabel = labels[labelIndex];
                        var dataValue = dataValues[labelIndex];
                        var percentage = percentages[labelIndex].toFixed(2) + "%";
                        return dataLabel + ': ' + dataValue + ' (' + percentage + ')';
                    }
                }
            }
            
        }
    };


    var config = {
        type: 'pie',
        data: data,
        options: options
    };

    var graph1 = new Chart(ctx, config);


  input=document.getElementById("logout");

  input.addEventListener("click",function (){
       
      var valeur="logout";

       document.getElementById("input-logout").value = valeur;

       // Soumettre le formulaire
       document.getElementById("form-logout").submit();
   } );

  



</script>
<?php require "view_end_html.php" ?>