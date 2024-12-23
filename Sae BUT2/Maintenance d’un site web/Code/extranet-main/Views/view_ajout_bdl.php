<!-- Formulaire permettant d'ajouter un bon de livraison -->
<?php
require 'view_begin.php';
require 'view_header.php';
?>
    <div class="main-container">
        <div class="ajt-bdl container">
            <h1>Ajout d'un Bon de livraison</h1>
            <form action="?controller=<?php echo $_GET['controller'] ?>&action=ajout_bdl" method="post">
                <h2>Informations</h2>
                <div class="form-names">
                    <input type="text" placeholder="Mission" name="mission" id='mail-1' class="input-case">
                    <input type="year" placeholder="Année" name="annee" class="input-case">
                    <input type="month" placeholder="Mois" name="mois" class="input-case">
                </div>

                <input type="text" placeholder="Composante" name="composante" id='mail-1' class="input-case">
                <div class="buttons" id="create">
                    <button type="submit">Créer</button>
                </div>
            </form>
        </div>
    </div>
<?php
require 'view_end.php';
?>
