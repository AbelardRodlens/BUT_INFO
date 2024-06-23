<?php require "view_begin_html.php";?>
<style>body {
    background-image: url("Content/img/Background.jpg");
    background-size: cover;
    height:100vh;
    background-repeat: no-repeat;
    width: auto;
    font-family: Arial, sans-serif;
    overflow: hidden;
    margin: 20px;
    padding: 0;
  }

  #profile-container {
    width: 900px;
    margin: 50px auto;
    padding: 20px;
    border-radius: 10px;
  }

  #avatar-container {
    text-align: center;
    position: relative;
  }

  #avatar {
    width: 20%;
    height: 20%;
    border-radius: 50%;
  }


  #info-blocks {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
  }

  .info-block {
    font-size: 20px;
    margin-right: 150px;
    margin-left: -100px;
    margin-top: 70px;
    height: 350px;
    width: 375px;
    background-color: #ecf0ff;
    padding: 20px;
    border-radius: 10px;
  }

  .info-title {
    font-family: initial;
    font-size: 30px;
    font-weight: bold;
    
  }

  .info-field svg {
    position: absolute;
    height: 29px;
    width: 29px;
    
  }
  .info-field {
    
    background-color: #fff;
    padding: 15px;
    border-radius: 10px;
    margin-top: 30px;
    
  }
 
  input {
    border: none;
    outline: none
    }

  #password-block {
    font-size: 20px;
    margin-right: -100px;
    margin-top: 70px;
    height: 350px;
    width: 375px;
    background-color: #ecf0ff;
    padding: 20px;
    border-radius: 10px;
  }

  #password-title {
    font-family: initial;
    font-size: 30px;
    font-weight: bold;
    
  }

  form input.password-field {
    text-align: center;
    background-color: #fff;
    padding: 10px;
    border-radius: 10px;
    margin-top: 50px;
    width:90%;
    height:10%;
    
  }
  
  form{
    height:80%
  }
  #navbar{
    
      width:95%;
      height:10%;
      border-radius:5vh;
      background-color:rgba(59, 70, 108, 1);
      margin-left:2.5%;
        }
  
  #navbar svg{

    height:90%;
    margin-left:1%;
    
    


  }

  #navbar #logout{
    position:absolute;
    height:8%;
    margin-left: 83.3%;
    margin-top:0.4%;
    
  }

  @media screen and (max-width: 480px) {
    body {
      background-image: url("Content/img/Background.jpg");
      background-size: cover;
      height: 135vh;
      background-repeat: no-repeat;
      width: auto;
      font-family: Arial, sans-serif;
      margin: 20px;
      padding: 0;
      overflow:auto;
  }
  
  #profile-container {
      width: 90%; /* Utiliser un pourcentage pour s'adapter à la largeur de l'écran */
      max-width: 900px; /* Définir une largeur maximale pour éviter que le contenu ne devienne trop large */
      margin: 10px auto;
      margin-top: 150px;
      padding: 20px;
      border-radius: 10px;
  }
  
  
  #avatar {
      width: 75%; /* Utiliser 100% pour que l'image soit toujours de la largeur du conteneur */
      height: auto; /* Permettre à la hauteur de s'ajuster automatiquement en conservant les proportions */
      margin-top: -150px; /* Ajuster la marge pour un meilleur positionnement */
      border-radius: 50%;
      margin-bottom: 10px;
  }
  
  #edit-avatar {
      margin-top: 10px; /* Ajuster la marge pour un meilleur positionnement */
      font-family: 'initial';
      font-size: 5vw; /* Utiliser vw (viewport width) pour une taille de police relative à la largeur de l'écran */
      position: absolute;
      top: 80%;
      right: 0;
      left: 0;
      color: #fff;
      padding: 1% 2%; /* Utiliser des pourcentages pour le rembourrage */
      border-radius: 5px;
      cursor: pointer;
  }
  
  #info-blocks {
      flex-direction: column; /* Changer la direction pour une disposition verticale sur des écrans plus petits */
      margin-top: 20px;
  }
  
  .info-block {
      font-size: 3vw; /* Utiliser vw pour une taille de police relative à la largeur de l'écran */
      margin-right: 0; /* Réinitialiser la marge droite */
      margin-left: 0; /* Réinitialiser la marge gauche */
      margin-top: 5%; /* Ajuster la marge pour un meilleur positionnement */
      height: auto; /* Ajuster la hauteur automatiquement */
      width: 90%; /* Utiliser un pourcentage pour s'adapter à la largeur de l'écran */
  }
  
  .info-title {
      font-size: 6vw; /* Utiliser vw pour une taille de police relative à la largeur de l'écran */
      font-weight: bold;
  }
  
  .info-field svg {
      height: 5vw; /* Utiliser vw pour la taille relative à la largeur de l'écran */
      width: 5vw; /* Utiliser vw pour la taille relative à la largeur de l'écran */
  }
  
  .info-field {
      margin-top: 3%; /* Ajuster la marge pour un meilleur positionnement */
  }
  
  #password-block {
      font-size: 3vw; /* Utiliser vw pour une taille de police relative à la largeur de l'écran */
      margin-right: 0; /* Réinitialiser la marge droite */
      margin-top: 5%; /* Ajuster la marge pour un meilleur positionnement */
      height: auto; /* Ajuster la hauteur automatiquement */
      width: 90%; /* Utiliser un pourcentage pour s'adapter à la largeur de l'écran */
  }
  
  #password-title {
      font-size: 3.5vh;/* Utiliser vw pour une taille de police relative à la largeur de l'écran */
      font-weight: bold;
  }
  
  .password-field {
      margin-top: 5%; /* Ajuster la marge pour un meilleur positionnement */
      
      
  }

  
  }</style>
    <title>Votre Profil</title>
<body>
    
    
    <div id="navbar">
        <a href=index.php?controller=home>
          <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M37.5834 11.8334L15.125 29.3334C11.375 32.2501 8.33337 38.4584 8.33337 43.1668V74.0418C8.33337 83.7084 16.2084 91.6251 25.875 91.6251H74.125C83.7917 91.6251 91.6667 83.7084 91.6667 74.0834V43.7501C91.6667 38.7084 88.2917 32.2501 84.1667 29.3751L58.4167 11.3334C52.5834 7.25011 43.2084 7.45844 37.5834 11.8334Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M50 74.9584V62.4584" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>

        <a href="#">
        <img src="Content/img/icons8-power-button-64" id="logout"/>
        </a>
        <form id="form-logout" action="index.php?action=logout" method="post" style="display: none;">
          <input type="hidden" id="input-logout" name="logout" value="">
        </form>

    </div>

  <div id="profile-container">
    <div id="avatar-container">
      <img id="avatar" src="Content/img/avatar.png">
    </div>

    <div id="info-blocks">
      <div class="info-block">
        <div class="info-title">Mes informations<hr></div>
        <div class="info-field"><svg width="67" height="65" viewBox="0 0 67 65" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M33.9466 29.4396C33.6675 29.4125 33.3325 29.4125 33.0254 29.4396C26.3812 29.2229 21.105 23.9417 21.105 17.4417C21.105 10.8063 26.6325 5.41669 33.5 5.41669C40.3396 5.41669 45.895 10.8063 45.895 17.4417C45.8671 23.9417 40.5908 29.2229 33.9466 29.4396Z" stroke="#292D32" stroke-opacity="0.6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M19.9883 39.4333C13.2324 43.8208 13.2324 50.9708 19.9883 55.3312C27.6653 60.3146 40.2558 60.3146 47.9328 55.3312C54.6887 50.9437 54.6887 43.7937 47.9328 39.4333C40.2837 34.4771 27.6933 34.4771 19.9883 39.4333Z" stroke="#292D32" stroke-opacity="0.6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nom : <?php echo htmlspecialchars($_SESSION["user-nom"]); ?>
          </div>
        <div class="info-field"><svg width="67" height="65" viewBox="0 0 67 65" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M33.9466 29.4396C33.6675 29.4125 33.3325 29.4125 33.0254 29.4396C26.3812 29.2229 21.105 23.9417 21.105 17.4417C21.105 10.8063 26.6325 5.41669 33.5 5.41669C40.3396 5.41669 45.895 10.8063 45.895 17.4417C45.8671 23.9417 40.5908 29.2229 33.9466 29.4396Z" stroke="#292D32" stroke-opacity="0.6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M19.9883 39.4333C13.2324 43.8208 13.2324 50.9708 19.9883 55.3312C27.6653 60.3146 40.2558 60.3146 47.9328 55.3312C54.6887 50.9437 54.6887 43.7937 47.9328 39.4333C40.2837 34.4771 27.6933 34.4771 19.9883 39.4333Z" stroke="#292D32" stroke-opacity="0.6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prénom : <?php echo htmlspecialchars($_SESSION["user-prenom"]); ?>
        </div>
        <div class="info-field"><svg width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M20.5416 24.7708H8.45829C4.83329 24.7708 2.41663 22.9583 2.41663 18.7291V10.2708C2.41663 6.04163 4.83329 4.22913 8.45829 4.22913H20.5416C24.1666 4.22913 26.5833 6.04163 26.5833 10.2708V18.7291C26.5833 22.9583 24.1666 24.7708 20.5416 24.7708Z" stroke="#292D32" stroke-opacity="0.6" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M20.5417 10.875L16.7596 13.8958C15.515 14.8867 13.473 14.8867 12.2284 13.8958L8.45837 10.875" stroke="#292D32" stroke-opacity="0.6" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mail : <?php echo htmlspecialchars($_SESSION["user-email"]); ?>
        </div>
          
      </div>

      <div id="password-block">
        <div id="password-title">Modifier mon mot de passe<hr></div>
        <form action="index.php?controller=profil&action=updatepass" method="post">
          <input  type="password" placeholder="NOUVEAU MOT DE PASSE:" class="password-field" id="new-pass" name="new-pass">
          <input class="password-field" type="password" placeholder="CONFIRMER MOT DE PASSE:" id="confirm-pass" name="confirm-pass">
          <input type="submit" style="display: none;" name="submit"></input>
          <p>Les mots de passe diffèrent.</p>
      </form>
      </div>
    </div>
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
<?php require "view_end_html.php"?>