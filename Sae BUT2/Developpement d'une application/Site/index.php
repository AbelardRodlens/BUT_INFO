<?php

require_once "Models/Model.php";
require_once "Controllers/Controller.php";
$controllers = ["login","home","profil","enseignant","graphique","historique","resetpass","resetpass2","TE","demande"];
$controller_default = "login";
if (isset($_GET['controller']) and in_array($_GET['controller'], $controllers)) {
    $nom_controller = $_GET['controller'];
} else {
    $nom_controller = $controller_default;
}
$nom_classe = 'Controller_' . $nom_controller;
$nom_fichier = 'Controllers/' . $nom_classe . '.php';
if (is_readable($nom_fichier)) {
    require_once $nom_fichier;
    new $nom_classe();
} else {
    die("Error 404: not found!");
}
?>