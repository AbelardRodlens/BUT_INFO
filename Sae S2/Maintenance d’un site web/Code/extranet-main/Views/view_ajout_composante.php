<!-- Formulaire permettant d'ajouter une nouvelle composante  -->
<?php
require 'view_begin.php';
require 'view_header.php';
?>
    <div class="main-container">
        <div class="ajt comp container">
            <h1>Ajout Composante</h1>
            <form action="?controller=<?php echo $_GET['controller'] ?>&action=ajout_composante" method="post">
            <div class="info-conp"> 
                <h2>Informations composante</h2>
                <div class="form-infos-composante">
                    <input type="text" placeholder="Nom composante" name='composante'  class="input-case">
                    <input type="text" placeholder="Société" name='client' class="input-case">
                </div>

                <div class="form-infos-composante">
                    <input type="text" placeholder="Nom mission" name='mission' class="input-case">
                    <input type="date" placeholder="Date de début" name="date-mission" class="input-case">
                </div>

                <h4>Adresse</h4>
                <div class="form-address">
                    <input type="number" placeholder="Numéro de voie" name="numero-voie"
                           class="input-case form-num-voie">
                    <input type="text" placeholder="Type de voie" name="type-voie" class="input-case form-type-voie">
                    <input type="text" placeholder="Nom de voie" name="nom-voie" class="input-case form-nom-voie">
                </div>

                <div class="form-address">
                    <input type="number" placeholder="Code postal" name="cp" class="input-case form-cp">
                    <input type="text" placeholder="Ville" name="ville" class="input-case form-ville">
                </div>
            </div>

            <div class="info-inter">
            <h2>Informations interlocuteur</h2>
                <div class="form-names">
                    <input type="text" placeholder="Prénom" name="prenom-interlocuteur" class="input-case">
                    <input type="text" placeholder="Nom" name="nom-interlocuteur" class="input-case">
                </div>
                <input type="email" placeholder="Adresse email" name='email-interlocuteur' class="input-case">
            </div>
                
            <div class="info-comm">
                <h2>Informations commercial</h2>
                <div class="form-names">
                    <input type="text" placeholder="Prénom" name="prenom-name" class="input-case">
                    <input type="text" placeholder="Nom" name="nom" class="input-case">
                </div>
                <input type="email" placeholder="Adresse email" name='email-commercial' class="input-case">
            </div>
                
            <div class="buttons" id="create">
                <button type="submit">Créer</button>
            </div>
            </form>
        </div>
    </div>
<?php
require 'view_end.php';
?>
