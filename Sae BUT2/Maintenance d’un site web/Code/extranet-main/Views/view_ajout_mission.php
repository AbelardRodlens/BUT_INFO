<!-- Forumulaire permettant de créer une nouvelle mission -->

<?php
require 'view_begin.php';
require 'view_header.php';
?>
    <div class="main-container">
        <div class="ajt miss container">
            <h1>Ajout Mission</h1>
            <form action="?controller=<?php $_GET['controller'] ?>>&action=ajout_mission" method="post">

            <div class="info-miss">
                <h2>Informations mission</h2>
                <input type="text" placeholder="Nom de la mission" name='mission' class="input-case">
                <input type="text" placeholder="Société" id='sté' name='client' class="input-case">
                <input type="text" placeholder="Composante" name='composante' id='cpt' class="input-case">
                <input type="date" placeholder="Date de début" name="date-mission" class="input-case">
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
