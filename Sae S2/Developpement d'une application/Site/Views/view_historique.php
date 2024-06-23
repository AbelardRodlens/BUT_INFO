<?php require "view_begin_html.php";?>
<style>
body {
    background-color:#293658;
   
  }

#log-container{
    display:flex;
    height:100vh;
    justify-content:center;
    align-items: center;
    
   
  }

  #log-container #log {
    height:90vh;
    width:125vh;
    background-color:white;
    overflow:auto;
    
    
    
    
   
  }

  #tableau{
    border-collapse:collapse;
    min-width: 123.22vh;
    max-width:auto;
    
    

    
    
   

  }

  thead tr{
    background-color:#92846E;
    color:#1e2537;
    text-align:left;

  }

  th, td{
    
    padding: 1vh 5vh;
  }

  tbody tr, td, th{
    border:solid 0.3vh #ddd;
  }

  td{
    
  }

  tr{
    font-size:3vh;
    
  }

  tbody tr:nth-child(even){
    background-color:#f3f3f3;
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
    margin-left: 88.3%;
    margin-top: 0.2%;
    
  }

</style>
    <title>Historique</title>
<body>
<div id="navbar">
        <a href="index.php?controller=home">
          <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" height=100 width=100>
          <path d="M37.5834 11.8334L15.125 29.3334C11.375 32.2501 8.33337 38.4584 8.33337 43.1668V74.0418C8.33337 83.7084 16.2084 91.6251 25.875 91.6251H74.125C83.7917 91.6251 91.6667 83.7084 91.6667 74.0834V43.7501C91.6667 38.7084 88.2917 32.2501 84.1667 29.3751L58.4167 11.3334C52.5834 7.25011 43.2084 7.45844 37.5834 11.8334Z" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M50 74.9584V62.4584" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>

        <a href="index.php?controller=graphique">       
        <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M76.3333 50C87.1667 50 91.6667 45.8333 87.6667 32.1666C84.9583 22.9583 77.0417 15.0416 67.8333 12.3333C54.1667 8.33331 50 12.8333 50 23.6666V35.6666C50 45.8333 54.1667 50 62.5 50H76.3333Z" stroke="white"stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M83.3335 61.25C79.4585 80.5417 60.9585 94.5417 39.9168 91.125C24.1251 88.5834 11.4168 75.875 8.83345 60.0834C5.45845 39.125 19.3751 20.625 38.5835 16.7084" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
      </a>

      <a href="">
               
            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-history">
            <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
            <path d="M3 3v5h5"/>
            <path d="M12 7v5l4 2"/>
          </svg>
            </a>

            <a href="">
                
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-clock"><path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h5"/><path d="M17.5 17.5 16 16.25V14"/><path d="M22 16a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z"/></svg>
            </a>

            <a href="index.php?controller=enseignant">
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-search">
                    <circle cx="10" cy="7" r="4"/>
                    <path d="M10.3 15H7a4 4 0 0 0-4 4v2"/>
                    <circle cx="17" cy="17" r="3"/>
                    <path d="m21 21-1.9-1.9"/>
                </svg>
            </a>

        <a href="#">
        <img src="Content/img/icons8-power-button-64" id="logout"/>
        </a>
        <form id="form-logout" action="index.php?action=logout" method="post" style="display: none;">
          <input type="hidden" id="input-logout" name="logout" value="">
        </form>

    </div>


<div id="log-container">
    <div id="log">
         <?php
        echo "<table id='tableau'>";
            
        echo "<thead>
                <th>id</th>
                <th>action</th>
                <th>date</th>
             </thead>

            <tbody>
                <tr>";
        
        foreach($data as $key => $value){
            echo "<tr>";
            echo "<td>".$data[$key]["id_personne"]."</td>";
            echo "<td>".$data[$key]["action"]."</td>";
            echo "<td>".$data[$key]["date"]."</td>";
            echo "</tr>";

                    }
               


        echo "</tbody>
        </table>";
        ?>

    </div>
</div>
<?php require "view_end_html.php"?>
