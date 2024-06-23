<!-- Vue de l'interlocuteur où il peut voir ses missions, y consulter ses bons de livraison et faire une demande -->
<?php
require 'view_begin.php';
require 'view_header.php';
?>

<div class='main-container'>
    <div class="inter-container container">
        <h1>Mes Prestataires</h1>
        <?php require_once 'view_dashboard.php'; ?>

        <div class='form-container'>
        <h2 class="demande"> Une demande ? C'est juste ici !</h2>
        <form action="?controller=interlocuteur&action=envoyer_email" method="post">
            <input type="text" id="objet" name="objet" placeholder="Objet">

            <textarea id="message" name="message" placeholder="Votre message..."></textarea>

            <button type="submit" class="button-primary" id="bouton-envoyer">Envoyer</button>
        </form>
    </div>
    </div>
</div>

<?php
require 'view_end.php';
?>
