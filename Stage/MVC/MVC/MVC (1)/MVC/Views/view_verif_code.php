<?php require "view_begin_html.php" ?>
    <title>Réinitialisation</title>
  
</head>
<body>
    <div id="page_login_body">

        
        <div id="login">
            <h1 id="Connexion">Mot de passe Oublié</h1>

            <p id="infos">Veuillez saisir le code qui vous a été envoyé par mail.</p>

            <form action="index.php?controller=verif_code&action=verif_code" method="post">
                <input type="text" name="code" id="code" placeholder="Code">
                <input type="submit" name="submit" id="submit" value="Continuer">

            </form>
        </div>

    </div>
</body>
</html>
<?php require "view_end_html.php" ?>