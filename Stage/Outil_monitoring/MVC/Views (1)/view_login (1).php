<?php require "view_begin_html.php" ?>
    <title>Login</title>
  
</head>
<body>
    <div id="page_login_body">

        
        <div id="login">
            <h1 id="Logo-Login" class="Logo">Avistel</h1>
            <h2 id="Connexion">Connexion</h2>
            <form method="post" action="index.php?action=login">
                <input type="text" name="username" id="username" placeholder="Username">
                <input type="password" name="pass" id="pass" placeholder="Pass">
                <input type="submit" name="submit" id="submit" value="Se connecter">

            </form>
            <a href ="index.php?controller=passforgot"><p id="pass_forgot">Mot de passe oublié ?</p></a>
        </div>

    </div>

<?php require "view_end_html.php" ?>