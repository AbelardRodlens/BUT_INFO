<!-- Vue permettant de voir les informations de son compte et de les changer si nécessaire -->
<?php
require 'view_begin.php';
require 'view_header.php';
?>
    <div class="main-container">
        <div class="container">
            <h1>Mon compte</h1>
            <div class="moncompte">
                <div class="row">
                <p class="title">Prenom</p>
                <p class="value"><?= $_SESSION['prenom'] ?></p>
                </div>
                <div class="row">
                <p class="title">Nom</p>
                <p class="value"><?= $_SESSION['nom'] ?></p>
                </div>
                <div class="row">
                <p class="title">E-mail</p>
                <p class="value" style="text-transform:lowercase"><?= $_SESSION['email'] ?></p>
                </div>
                <div class="row">
                <p class="title">Role</p>
                <p class="value"><?= $_SESSION['role'] ?></p>
                </div>
                <div class="row">
                <form action="?controller=<?= $_GET['controller'] ?>&action=maj_infos" method="post">
                    <p class="title">Mot de passe</p>
                    <div class="mdp">
                    <input type="text" placeholder='Changer de mot de passe' name='mdp' id='sté' class="input-case">
                    <div class="buttons" id="create">
                            <button type="submit"><i class="fa-solid fa-pen"></i></button>
                        </div>
                    </div>
                    
                    </form>
                </div>
            </div>
            
            
        </div>
    </div>
<?php
require 'view_end.php';
?><?php
