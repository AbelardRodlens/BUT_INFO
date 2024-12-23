<!-- Vue permettant de voir la page de connection afin de se connecter et accéder au site -->
<?php
require 'view_begin.php';
?>

<div class="login-container" <?= (isset($data['response']['roles']))  ?> >

        <h1>Connectez-vous !</h1>

        <?php if (isset($data['response'])) :
                    if (isset($data['response']['roles'])):
                        require 'view_login_popup.php'; ?>
                    <?php else: ?>
                        <p class='alert'><?= $data['response'] ?></p>
                    <?php endif; ?>
                <?php endif; ?>
                
        <form action="?controller=login&action=check_pswd" method="post">
            <div class="login-form">
                <h2>Accéder au site de Perform Vision</h2>

                <input class="input-login" type="text" name="mail" placeholder="Email">
                <input class="input-login" type="password" name="password" placeholder="Mot de passe">
            </div>

            <div class="buttons">
                <button type="submit">Se connecter</button>
            </div>
        </form>

        


</div>

<?php
require 'view_end.php';
?>
