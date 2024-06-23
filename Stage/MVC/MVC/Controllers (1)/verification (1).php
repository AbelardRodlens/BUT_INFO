<?php


function verification()
{
    $m = Model::getModel();
    $usertoken = $m->getUserToken($_COOKIE['user']);
    if ((isset($usertoken) && ($usertoken['token'] != "") && isset($_COOKIE['token']) && isset($_COOKIE['user']) && ($usertoken['token'] == $_COOKIE['token']))) {
        //ssi necéssaire
        if ($_COOKIE['token'] != $usertoken['token'] || !isset($_COOKIE['expire']) || $_COOKIE['expire'] < time()) {
            setcookie("user", $_COOKIE['user'], time() + 1800, "/");
            setcookie("token", $_COOKIE['token'], time() + 1800, "/");
            setcookie("expire", time() + 1800, 0, "/"); // Un nouveau cookie pour contrôler l'expiration
        }
    } else {
        header('Location:index.php');
        exit;
    }
}
