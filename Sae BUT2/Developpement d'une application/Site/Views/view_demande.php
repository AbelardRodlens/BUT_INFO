<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande d'Heures d'Enseignement</title>
    <style>
    
    body {
      background: url('./Content/img/Background.jpg') no-repeat center center fixed; 
        background-size: cover;
        height:100vh;
        background-repeat: no-repeat;
        width: auto;
        font-family: Arial, sans-serif;
        overflow: hidden;
        margin: 20px;
        padding: 0;
      }

      div {
      width: 90%; /* Utiliser un pourcentage pour s'adapter à la largeur de l'écran */
      max-width: 60vh;
      height: 75vh; /* Définir une largeur maximale pour éviter que le contenu ne devienne trop large */
      margin: 10px auto;
      margin-top: 150px;
      padding: 20px;
      border-radius: 10px;
      background-color: #1e2337;
  }

    .block2 {
      
      width: 90%; /* Utiliser un pourcentage pour s'adapter à la largeur de l'écran */
      max-width: 60vh;
      height: 35vh; /* Définir une largeur maximale pour éviter que le contenu ne devienne trop large */
      margin: 10px auto;
      border-radius: 10px;
      background-color: #ECF0FF;
    }

    .block3 {
      width: 90%; /* Utiliser un pourcentage pour s'adapter à la largeur de l'écran */
      max-width: 60vh;
      height: 10vh; /* Définir une largeur maximale pour éviter que le contenu ne devienne trop large */
      margin: 10px auto;
      
      border-radius: 10px;
      background-color: #ECF0FF;
    }

      h1 {
        font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        background-color: #ECF0FF;
        border-radius:10px;
        color: #b3a790;
        padding:2vh;
        text-align: center;
        justify-content: center;
        
      }

      label {
        
        font-family:'Trebuchet MS';
        padding:0.5vh;
        font-size: 2.7vh;
        
        
      }

      button {
        font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        color:#000000;
        background-color: #b3a790;
        border-radius: 10px;
        margin-top: 2vh;
        padding:1.5vh;
        border:none;
        font-size: 2.5vh;
        margin-left: 15vh;
        
      }

      input {
        background-color: #b3a790;
        border:none;
        border-radius: 5px;
        padding: 0.7vh;
        outline:#000000;
        color:#000000;
      }

      select {
        background-color: #b3a790;
        border-radius: 5px;
        border:none;
        color:#000000;
        font-size: 2vh;
      }

    </style>
</head>
<body>



<div class="Formulaire">
    <h1>Demande d'Heures d'Enseignement</h1>
    <form action="index.php?controller=demande&action=forma" method="post">
    <div class="block2">
      
    <label for="nbHeures">Nombre d'heures :</label>
    <input type="texte" id="nbHeures" name="nbHeures" required min="0" pattern="[0-9]+">
<br>
<br>
    <label for="annee">Année :</label>
    <select id="annee" name="annee">
        <!-- Options pour les années -->
        <option value="2024">2024</option>
        <option value="2025">2025</option>
        <!-- Ajoutez d'autres années au besoin -->
    </select>

    <br>
    <br>
    <label for="semestre">Semestre :</label>
    <select id="semestre" name="semestre">
        <option value="1">Semestre 1</option>
        <option value="2">Semestre 2</option>
    </select>

    <br>
    <br>
    <label for="departement">Département :</label>
<select id="departement" name="departement">
    <option value="21">INFO</option>
    <option value="9">SD</option>
    <option value="10">RT</option>
    <option value="11">GEII</option>
    <option value="12">GEA</option>
    <option value="13">CJ</option>


    </select>

    <br>
    <br>

    <label for="formation">Formation :</label>
    <select id="formation" name="formation">
        <option value="31">BUT</option>
       
    </select>
    <br>
    <br>
    <label for="discipline">Discipline :</label>
<select id="discipline" name="discipline">
    <option value="1">Informatique</option>
    <option value="2">Mathématiques</option>
    <option value="3">Physique</option>
    <option value="4">INFO-PROG</option>
    <option value="5">INFO-INDUSTRIEL</option>
    <option value="6">INFO-RESEAU</option>
    <option value="7">INFO-BUREAUTIQUE</option>
    <option value="8">ECOGESTION</option>
    <option value="9">ELECTRONIQUE</option>
    <option value="10">DROIT</option>
    <option value="11">ANGLAIS</option>
    <option value="12">COMMUNICATION</option>
    <option value="13">ESPAGNOL</option>
</select>

    </div>
    <div class="block3">
    <button type="submit">Envoyer la demande</button></div>
</form>
</div>
</body>
</html>
