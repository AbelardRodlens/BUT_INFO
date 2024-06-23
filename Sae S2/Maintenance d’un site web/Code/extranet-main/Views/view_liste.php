<!-- Vue permettant de faire la liste d'un type de personne -->
<?php
require 'view_begin.php';
require 'view_header.php';
?>

<div class="main-container">
<div class='liste-prestataire-contrainer container'>

    <div class="element-recherche">
    <h1><?= $title ?> </h1>
        <div class="option">
            <input type="text" id="recherche" name="recherche" placeholder="Rechercher un <?= $title ?>...">
            <?php if (((str_contains($_GET['controller'], 'gestionnaire') || str_contains($_GET['controller'], 'administrateur')) && !isset($_GET['id']))
                || ((str_contains($_GET['controller'], 'prestataire') && isset($person[0]['id_bdl'])))): ?>
                <button type="submit" class="button-primary"
                        onclick="window.location='<?= $buttonLink ?>'"><i class="fa-solid fa-plus"></i>
                </button>
            <?php endif; ?>
        </div>
        
    </div>

    <div class="element-block">
    <?php if (isset($person) && is_array($person)): ?>
        <?php foreach ($person as $p): ?>
            <a href='<?= htmlspecialchars($cardLink) ?>&id=<?= isset($p['id_bdl']) ? htmlspecialchars($p['id_bdl']) : htmlspecialchars($p['id']) ?>' class="block">
                <h2>
                    <?= htmlspecialchars($p['nom'] ?? '') ?> <?= htmlspecialchars($p['prenom'] ?? '') ?>
                </h2>
                <?php if (!empty($p['nom_client'])): ?>
                    <h2><?= htmlspecialchars($p['nom_client']) ?></h2>
                <?php endif; ?>
                <?php if (!empty($p['nom_mission'])): ?>
                    <h2><?= htmlspecialchars($p['nom_mission']) ?></h2>
                <?php endif; ?>
                <h3>
                    <?php if (!empty($p['mois'])): ?>
                        <?= htmlspecialchars($p['mois']) ?>
                    <?php endif; ?>
                    <?php if (!empty($p['telephone_client'])): ?>
                        <?= htmlspecialchars($p['telephone_client']) ?>
                    <?php endif; ?>
                    <?php if (!empty($p['nom_composante'])): ?>
                        <?= htmlspecialchars($p['nom_composante']) ?>
                    <?php endif; ?>
                </h3>
            </a>
        <?php endforeach; ?>
    <?php elseif (isset($composante) && is_array($composante)): ?>
        <?php foreach ($composante as $c): ?>
            <a href='<?= htmlspecialchars($cardLink) ?>&id=<?= isset($c['id_composante']) ? htmlspecialchars($c['id_composante']) : '' ?>' class="block">
                <h2>
                    <?= htmlspecialchars($c['nom_composante'] ?? '') ?>
                </h2>
                <?php if (!empty($c['nom_client'])): ?>
                    <h2><?= htmlspecialchars($c['nom_client']) ?></h2>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</div>



</div>

<?php
require 'view_end.php';
?>
