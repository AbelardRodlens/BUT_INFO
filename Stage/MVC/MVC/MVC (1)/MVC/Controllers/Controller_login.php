<?php

class Controller_login extends Controller
{

    public function action_login()
    {

        if (isset($_POST["submit"])) {
            $m = Model::getModel();
            $passhash = hash('sha256', $_POST["pass"]);
            $user = $m->getUser($_POST["username"], $passhash);

            if ($user != false) {
                $token = bin2hex(random_bytes(32));

                // Mise à jour du token utilisateur dans la base de données
                $m->updateUserToken($token, $user['user_id']);

                // Création des cookies pour l'utilisateur et le token
                setcookie("user", $user['user_id'], time() + 1800, "/");
                setcookie("token", $token, time() + 1800, "/");

                // Redirection vers la page d'accueil avec un paramètre unique pour éviter le cache
                header('Location:index.php?controller=home&nocache=' . uniqid());
                exit;
            } else {
                echo "Mot de passe ou nom d'utilisateur incorrect.";
            }
        }
    }

    public function action_default()
    {
        $this->render("login", []);
    }
}
