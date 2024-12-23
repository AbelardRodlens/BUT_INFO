<!-- Vue qui s'affiche lorsqu'une personne a plusieurs rôle, elle peut choisir -->
    <div class="popup">
        <h1>Il se trouve que vous ayez plusieurs rôles !</h1>
        <div class="select-button">
                <?php foreach ($data['response']['roles'] as $role) : ?>
                    <button type="submit" class="button-primary" onclick="window.location='?controller=<?= $role ?>&action=default'"><?= $role ?></button>
                <?php endforeach; ?>
        </div>
    </div>
