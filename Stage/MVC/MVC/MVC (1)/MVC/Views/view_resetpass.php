<?php require "view_begin_html.php" ?>
    <title>Réinitialisation</title>
  
</head>
<body>
    <div id="page_login_body">

        
        <div id="login">
            <h1 id="mdp_oublié">Mot de passe Oublié</h1>

            <p id="infos">Veuillez saisir le mail associé à votre compte,<br/> afin que nous puissions vous envoyez un code <br/>de réinitialisation.</p>

            <form action="index.php?controller=resetpass&action=resetpass" method="post">
                <input type="password" name="newpass" id="newpass" placeholder="Nouveau Mot de passe">
                <input type="password" name="confirm_pass" id="confirm_pass" placeholder="Confirmer Nouveau Mot De Passe">
                <input type="submit" name="submit" id="submit" value="Continuer">

            </form>
        </div>

    </div>

<?php require "view_end_html.php" ?>