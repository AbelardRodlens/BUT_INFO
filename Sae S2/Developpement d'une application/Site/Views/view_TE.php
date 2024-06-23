<?php require "view_begin_html.php"?>
<title>Taux d'encadrement</title>
<style>
    body {
        background-image: url("Content/img/Background.jpg");
        background-size: cover;
        height: 100vh;
        background-repeat: no-repeat;
        width: auto;
        overflow: hidden;
        margin: 20px;
        padding: 0;
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

  <style>
    body {
        background-image: url("Content/img/Background.jpg");
        background-size: cover;
        height: 100vh;
        background-repeat: no-repeat;
        width: auto;
        overflow: hidden;
        margin: 20px;
        padding: 0;
        font-family: 'Arial', sans-serif;
        color: #333;
    }

    h1 {
        text-align: center;
        color: #fff;
    }

    form {
        max-width: 400px;
        margin: 20px auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 8px;
    }

    select {
        width: 100%;
        padding: 8px;
        margin-bottom: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #4caf50;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    h2 {
        text-align: center;
        margin-top: 20px;
        color: #fff;
        font-size: 24px;
    }

    p {
        text-align: center;
        font-size: 24px;
        color: #4caf50;
        font-weight: bold;
        margin: 10px 0;
    }

    a {
        display: block;
        text-align: center;
        margin-top: 20px;
        color: #4caf50;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline;
    }
</style>


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
    
<h1>Calcul du Taux d'Encadrement pour une Discipline</h1>
<?php if (!isset($tauxEncadrement)) : ?>
    <form method="post" action="?controller=TE&action=calculerTE">
        <label for="id_discipline">Sélectionnez une discipline :</label>
        <select name="id_discipline" id="id_discipline">
            <?php foreach ($disciplines as $value): ?>
                <option value="<?php echo $value['id_discipline']; ?>"><?php echo $value['libelledisc']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <input type="submit" value="Calculer le Taux d'Encadrement">
    </form>
<?php else : ?>
    <h2>Résultat du Taux d'Encadrement</h2>
    <?php if ($tauxEncadrement >= 0) : ?>
        <p>Le taux d'encadrement est de <?php echo round($tauxEncadrement * 100, 2); ?>%.</p>
    <?php else : ?>
        <p>Erreur lors du calcul du taux d'encadrement.</p>
    <?php endif; ?>
    <a href="?controller=TE&action=TE">Retour à la page de calcul du Taux d'Encadrement</a>
<?php endif; ?>

<?php require "view_end_html.php"; ?>
