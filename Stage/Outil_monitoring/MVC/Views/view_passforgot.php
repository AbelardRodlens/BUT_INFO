<?php require "view_begin_html.php" ?>
    <title>Réinitialisation</title>
  
</head>
<body>
    <div id="page_login_body">

        
        <div id="login">
            <h1 id="mdp_oublié">Mot de passe Oublié</h1>

            <p id="infos">Veuillez saisir le mail associé à votre compte,<br/> afin que nous puissions vous envoyez un code <br/>de réinitialisation.</p>

            <form action="index.php?controller=passforgot&action=passforgot" method="post">
                <input type="text" name="adress" id="adress" placeholder="Email">
                <input type="submit" name="submit" id="submit" value="Continuer">

            </form>
        </div>

    </div>

<?php require "view_end_html.php" ?>