<<?php require "view_begin_html.php";
//var_dump($Discipline);
//var_dump($CatÃ©gorie); ?>
    <title>Page Enseignant</title>
    <style>body {
    box-sizing: border-box;
    background-image: url("Content/img/Background.jpg");
    background-size: cover;
    background-attachment: fixed;
    z-index: 1;
}

.profil {
    background: #ECF0FF;
    border-radius: 100px;
    width: 90px;
    height: 90px;
    z-index: -1;
    margin-left: 85%;
    margin-top: 20px;
    display: inline-block;
    margin-top: 0.2%;
}

.home_icon {
    height:90%;
    padding-left:1%;
}

#navbar{
    width:95%;
    height:10%;
    border-radius:5vh;
    background-color: #92846E;
    margin-left:2.5%;
      }



.add {
    width: 543px;
    height: 89px;
    background: #ECF0FF;
    border-radius: 20px;
    display: flex;
    align-items: center;    
    justify-content: center;
    cursor: pointer;
}

.add_icon {
    background: none;
}

.p {
    background: none;
    font-family: Georgia;
    font-weight: Regular;
    font-size: 36px;
    margin-left: 30px;
}

.overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Fond semi-transparent avec flou */
    backdrop-filter: blur(15px); /* Flou du fond */
    justify-content: center;
    align-items: center;
}

.contenuAdd {
    background: #fff;
    width: 70%;
    height:70%;
    border-radius: 10px;
    text-align: center;
    font-family: Georgia;
    font-weight: Regular;
}

.contenuAdd input::placeholder {
    text-align: center;
    font-family: Georgia;
    font-weight: Regular;
    color: grey;
    font-size: 36px;
    
}

input{
    border-radius: 10px;
    background-color: #293357;
    height: 74px;
    width: 500px;
    border: none;
    font-family: Georgia;
    font-weight: Regular;
    color: black;
    font-size: 36px;
    margin-bottom: 10px;
}
.checkbox{
    font-size:10%;
}
#nom, #prenom, #motDePasse {
    color: #B3A790;
}

#mail {
    border-radius: 10px;
    height: 74px;
    width: 500px;
    border: none;
    font-family: Georgia;
    font-weight: Regular;
    font-size: 36px;
    width: 1049px;
    color: #B3A790;
}

.bouton_envoyer {
    left: 50%;
}

#ajouterAdd {
    font-family: Georgia;
    font-weight: Regular;
    color: #293357;
    background-color: #FFF;
    border: solid #293357;
    border-radius: 10px;
    font-size: 36px;
    cursor: pointer;
    margin-top: 8px;
}

#fermerAdd {
    font-family: Georgia;
    font-weight: Regular;
    color: #293357;
    background-color: #FFF;
    border: solid #293357;
    border-radius: 10px;
    font-size: 36px;
    cursor: pointer;
    margin-top: 8px;
}


.gerer {
    display: flex;
    justify-content: center;
    margin-top: 40px;
}

.search input {
    width: 543px;
    height: 89px;
    background-color: #ECF0FF;
    border-radius: 20px;
    font-family: Georgia;
    font-weight: Regular;
    font-size: 36px;
    border: none;
    margin-left: 20%;
}

.search input::placeholder {
    text-align: center;
}

.case td {
    font-family: Georgia;
    font-weight: Regular;
    font-size: 25px;
    height: 90px;
    white-space: nowrap;
}

.tableau {
    margin: 80px auto;
    border-radius: 20px;
    background-color: #ECF0FF;
    padding-left: 75px;
    padding-right: 5%;
}

.nom {
    min-width: 250px;
    text-align: left;
}

.prenom {
    min-width: 250px;
    text-align: left;
}

.mail {
    min-width: 550px;
    text-align: left;
}

.role {
    min-width: 250px;
    text-align: left;
    padding-right: 50%;
}

.svg_line1 {
    min-width: 75px;
    max-width: auto;
}

.svg_line2 {
    min-width: 10px;
    max-width: auto;
}

select {
    color: #B3A790;
    background-color: #293357;
    border: none;
    border-radius: 2px;
}
.modifier{
    all:initial;
    border-radius: 20px;
}
.modifier:hover{
    transition:1s;
    background-color: #9B9B9B;
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
<link href="https://fonts.googleapis.com/css?family=Itim&display=swap" rel="stylesheet" />
</head>

<body>
    <main>
    <div id="navbar">
    <a href="index.php?controller=home">
          <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" width="100" height="100">
          <path d="M37.5834 11.8334L15.125 29.3334C11.375 32.2501 8.33337 38.4584 8.33337 43.1668V74.0418C8.33337 83.7084 16.2084 91.6251 25.875 91.6251H74.125C83.7917 91.6251 91.6667 83.7084 91.6667 74.0834V43.7501C91.6667 38.7084 88.2917 32.2501 84.1667 29.3751L58.4167 11.3334C52.5834 7.25011 43.2084 7.45844 37.5834 11.8334Z" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M50 74.9584V62.4584" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>

        <a href="index.php?controller=graphique">       
        <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" width="100" height="100">
<path d="M76.3333 50C87.1667 50 91.6667 45.8333 87.6667 32.1666C84.9583 22.9583 77.0417 15.0416 67.8333 12.3333C54.1667 8.33331 50 12.8333 50 23.6666V35.6666C50 45.8333 54.1667 50 62.5 50H76.3333Z" stroke="white"stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M83.3335 61.25C79.4585 80.5417 60.9585 94.5417 39.9168 91.125C24.1251 88.5834 11.4168 75.875 8.83345 60.0834C5.45845 39.125 19.3751 20.625 38.5835 16.7084" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
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
        <section class="gerer">
            <div class="add" id="afficherAdd">
                <svg class="add_icon" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g style="mix-blend-mode:plus-darker">
                <path d="M13.3333 20H26.6667" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M20 26.6666V13.3333" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M15 36.6666H25C33.3333 36.6666 36.6667 33.3333 36.6667 25V15C36.6667 6.66665 33.3333 3.33331 25 3.33331H15C6.66668 3.33331 3.33334 6.66665 3.33334 15V25C3.33334 33.3333 6.66668 36.6666 15 36.6666Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </g>
                </svg>
                <p class="p">Ajouter un utilisateur</p>
            </div>
            <div class="overlay" id="addPage">
                <div class="contenuAdd">
                    <h2>Ajouter un utilisateur</h2>
                    <form action="index.php?controller=enseignant&action=ren" method="post">
                        Nom: <input id="nom" type="text" name="nom"><br>
                        Prénom: <input id="prenom" type="text" name="prenom"><br>
                        Email: <input id="mail" type="text" name="mail"><br>
                        Mot de passe: <input id="motDePasse" type="password" name="motdepasse"><br>
                        Discipline: <select name="discipline">
                            <?php foreach ($Discipline as $value) : ?>
                                <option value="<?= $value['id_discipline'] ?>"><?= $value['libelledisc'] ?></option>
                            <?php endforeach; ?>
                        </select><br>

                        <label for="choixCatégorie">Choix catégorie :</label>
                        <select id="choixCatégorie" name="Catégorie">
                            <?php foreach ($Catégorie as $value) : ?>
                                <option name="<?= $value['id_categorie'] ?>" value="<?= $value['id_categorie'] ?>"><?= $value['siglecat'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <br>

                        <div id="bouton_envoyer"><button type="submit" id="ajouterAdd" name="envoyer">Ajouter</button></div>
                        <div id="bouton_fermer"><button id="fermerAdd">Fermer</button></div>
                    </form>
                    
                </div>
            </div>
            <div class="search">
                <form action="index.php?controller=enseignant&action=search" method="post">
                <input type="text" id="searchInput" placeholder="Chercher enseignant(prénom)" name="search">
                </form>
            </div>
        </section>

        <section class="liste">
    <?php
    $People = $user;

    if (isset($_POST['search']) && $_POST['search'] !== '') {
        $People = $Personnes;
        if (empty($People)) {
            echo "<p>Aucun résultat trouvé pour la recherche.</p>";
        }
    }
            foreach ($People as $value) : ?>
                <?php

                $del_button = '<form action="index.php?controller=enseignant&action=supprimer" method="post"><input type="hidden" name="id_personne" value="' . $value["id_personne"] . '">
                    <button class="modifier" type="submit" value="' . $value["id_personne"] . '"><svg type="submit" class="svg_line2" width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M30.625 8.72087C25.7688 8.23962 20.8833 7.9917 16.0125 7.9917C13.125 7.9917 10.2375 8.13753 7.35 8.4292L4.375 8.72087" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12.3958 7.248L12.7166 5.33758C12.9499 3.95216 13.1249 2.91675 15.5895 2.91675H19.4103C21.8749 2.91675 22.0645 4.0105 22.2833 5.35216L22.6041 7.248" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M27.4894 13.3291L26.5415 28.0145C26.3811 30.3041 26.2498 32.0833 22.1811 32.0833H12.8186C8.74984 32.0833 8.61859 30.3041 8.45817 28.0145L7.51025 13.3291" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M15.0647 24.0625H19.9209" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M13.8542 18.2292H21.1459" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg></button></form>';
                ?>

                <table class="tableau">
                    <tr class="case">
                        <td class="nom"><?= $value["nom"] ?></td>
                        <td class="prenom"><?= $value["prenom"] ?></td>
                        <td class="mail"><?= $value["email"] ?></td>
                        <td><?= $del_button ?></td>
                    </tr>
                </table>
            <?php endforeach; ?>
        </section>
    </main>
    <script src="Content/js/script.js"></script>
</body>

</html>
