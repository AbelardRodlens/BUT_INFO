<!-- Vue permettant de voir les informations de la société -->
<?php
require 'view_begin.php';
require 'view_header.php';
?>
<div class="main-container">
<div class="container">
        <form action="?controller=<?= $_GET['controller'] ?>&action=maj_infos_client&id=<?= $_GET['id'] ?>"
              method="post">
            <div class="infos-composante">
                <h1>Informations Société</h1>
                <div class="form-infos-composante">
                    <input type="text" placeholder="<?= $infos['nom_client'] ?>" name='client' id='cpt'
                           class="input-case">
                    <input type="tel" placeholder="<?= $infos['telephone_client'] ?>" id='sté' name='telephone-client' class="input-case">
                    <div class="buttons" id="create">
                    <button type="submit">Enregistrer</button>
                    </div>
                </div>

            </div>
        </form>

        <div class="infos-container">
            <div class="infos-colonne">
                <div class="titre">
                <h2>Interlocuteurs</h2>
                <a href="?controller=<?= $_GET['controller'] ?>&action=ajout_interlocuteur_form&id-client=<?= $_GET['id'] ?>">
                <i class="fa fa-solid fa-user-plus"></i>
                </a>
                </div>
                
                <?php foreach ($interlocuteurs as $i): ?>
                    <a href="?controller=<?= $_GET['controller'] ?>&action=infos_personne&id=<?= $i['id_personne'] ?>" class="block">
                        <h3><?= $i['nom'] . ' ' . $i['prenom'] ?></h3>
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="infos-colonne">
                <div class="titre">
                    <h2>Composantes</h2>
                    <a href="?controller=<?= $_GET['controller'] ?>&action=ajout_composante_form"><i
                            class="fa fa-solid fa-user-plus"></i>
                    </a>
                </div>
                
                <?php if (!str_contains('commercial', $_GET['controller'])): ?>
                <?php else: ?>
                    <a href="" class="ajout"></a>
                <?php endif; ?>
                <?php foreach ($composantes as $c): ?>
                    <a href='?controller=<?= $_GET['controller'] ?>&action=infos_composante&id=<?= $c['id_composante'] ?>'
                       class="block">
                        <h3><?= $c['nom_composante'] ?></h3>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php
require 'view_end.php';
?>
