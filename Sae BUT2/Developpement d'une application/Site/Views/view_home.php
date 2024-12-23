<?php require "view_begin_html.php" ?>
    <title>Bienvenue</title>
    <style>
      body {
    background: url('./Content/img/Background.jpg') no-repeat center center fixed; 
    
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    position: relative;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}
.container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 60px; /* Augmenter l'espace entre les divs */
    width: 100%;
    margin: auto;
}
.box {
    background-color: #293356;
    color: #b3a790;
    padding: 20px;
    text-align:top; 
    height: 150px;
    display: flex;
    justify-content: center;
    font-family: Georgia;
    font-weight: Regular;
    font-size: 3vh;
    text-align:center;
    box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
    border-radius: 15px; /* Arrondir les coins */
    border: solid 0.5px white;
    overflow: hidden;
    position: relative;
    transition: transform 0.6s ease, background-color 0.8s ease;
    z-index: 1; 
    }
    

    .box:hover::before {
            width: 100%;
        }

        .box::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background-color: #496789; /* Couleur de fond au survol - remplacez par la couleur désirée */
            transition: width 0.8s ease;
            z-index:-1;
        }

        .box:hover {
            background-color: #496789; /* Nouvelle couleur de fond au survol - remplacez par la couleur désirée */
            transform: scale(1.1);
        }




h1{
    text-align:center;
    padding:1vh;
    margin-left:35vh;
    margin-right:35vh;
    margin-bottom:15vh;
    font-family: Georgia;
    font-weight: Regular;
    background-color:#B3A790;
    font-size:4vh;
    border-radius:15px;
    border: solid 3px white;
}

    .box svg {
        
        position: absolute;
        top: 60%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 70px; 
        height: 70px; 
        stroke: #b3a790;
    }
    
    .deco{
        position: fixed;
  top: 10px; /* Ajustez la valeur en fonction de la marge souhaitée depuis le haut */
  right: 10px; /* Ajustez la valeur en fonction de la marge souhaitée depuis la droite */ /* Couleur de fond du bouton */ /* Couleur du texte du bouton */
  border: none; /* Supprimez la bordure du bouton si nécessaire */
  padding: 10px 20px; /* Ajustez la valeur du rembourrage selon vos besoins */
  cursor: pointer;
  border-radius: 5px; 
    }

</style>
</head>

<body>
<a href="#" class="deco">
        <img src="Content/img/icons8-power-button-64" id="logout"/>
        </a>
        <form id="form-logout" action="index.php?action=logout" method="post" style="display: none;">
          <input type="hidden" id="input-logout" name="logout" value="">
        </form>
    <div class="centered">
        <h1>Bienvenue <?php echo htmlspecialchars($_SESSION["user-nom"]) . ' ' . htmlspecialchars($_SESSION["user-prenom"]); ?></h1>

        <div class="container">
            <a href="index.php?controller=enseignant" class="box">
                GESTION DES ENSEIGNANTS
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-search">
                    <circle cx="10" cy="7" r="4"/>
                    <path d="M10.3 15H7a4 4 0 0 0-4 4v2"/>
                    <circle cx="17" cy="17" r="3"/>
                    <path d="m21 21-1.9-1.9"/>
                </svg>
            </a>
            <!-- Ajoutez des liens similaires pour les autres boîtes -->
            <a href="index.php?controller=demande&action=demande" class="box">
                DEMANDE D'HEURES
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-clock"><path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h5"/><path d="M17.5 17.5 16 16.25V14"/><path d="M22 16a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z"/></svg>
            </a>


            <a href="index.php?controller=historique&action=historique" class="box">
                HISTORIQUE
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-history"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M12 7v5l4 2"/></svg>
            </a>

            <a href="index.php?controller=graphique" class="box">
                GRAPHIQUE
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M18.32 12.0001C20.92 12.0001 22 11.0001 21.04 7.72006C20.39 5.51006 18.49 3.61006 16.28 2.96006C13 2.00006 12 3.08006 12 5.68006V8.56006C12 11.0001 13 12.0001 15 12.0001H18.32Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M19.9999 14.7C19.0699 19.33 14.6299 22.69 9.57993 21.87C5.78993 21.26 2.73993 18.21 2.11993 14.42C1.30993 9.39001 4.64993 4.95001 9.25993 4.01001"  stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
</a>

            <a href="index.php?controller=profil&action=profil" class="box">
                PROFIL
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M19.21 15.74L15.67 19.2801C15.53 19.4201 15.4 19.68 15.37 19.87L15.18 21.22C15.11 21.71 15.45 22.05 15.94 21.98L17.29 21.79C17.48 21.76 17.75 21.63 17.88 21.49L21.42 17.95C22.03 17.34 22.32 16.63 21.42 15.73C20.53 14.84 19.82 15.13 19.21 15.74Z"  stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M18.7 16.25C19 17.33 19.84 18.17 20.92 18.47" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M3.40997 22C3.40997 18.13 7.26 15 12 15C13.04 15 14.04 15.15 14.97 15.43" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>

</a>

<a href="index.php?controller=TE&action=TE" class="box">
                TAUX D'ENCADREMENT
                <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="512" height="512"><path d="M23,22H3a1,1,0,0,1-1-1V1A1,1,0,0,0,0,1V21a3,3,0,0,0,3,3H23a1,1,0,0,0,0-2Z"/><path d="M15,20a1,1,0,0,0,1-1V12a1,1,0,0,0-2,0v7A1,1,0,0,0,15,20Z"/><path d="M7,20a1,1,0,0,0,1-1V12a1,1,0,0,0-2,0v7A1,1,0,0,0,7,20Z"/><path d="M19,20a1,1,0,0,0,1-1V7a1,1,0,0,0-2,0V19A1,1,0,0,0,19,20Z"/><path d="M11,20a1,1,0,0,0,1-1V7a1,1,0,0,0-2,0V19A1,1,0,0,0,11,20Z"/></svg>
</a>

        
    </div>
    <script>

  input=document.getElementById("logout");

  input.addEventListener("click",function (){
       
      var valeur="logout";

       document.getElementById("input-logout").value = valeur;

       // Soumettre le formulaire
       document.getElementById("form-logout").submit();
   } );

  


</script>
    <?php require "view_end_html.php" ?>