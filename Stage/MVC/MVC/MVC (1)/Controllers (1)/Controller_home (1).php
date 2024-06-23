<?php
require_once 'Controller.php';
require_once __DIR__ . '/../Models/Model.php';
require_once 'verification.php';
require_once 'functions.php';

class Controller_home extends Controller
{

    public function action_home()
    {
        $this->render("home", []);
    }

    // public function action_logout(){
    //     if(isset($_POST["logout"])){
    //         session_destroy();
    //     }




    // }




    public function action_default()
    {
        verification();
        $this->render('home', []);
    }
}



// if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["getMontant"])){
//     $m=Model::getModel();
//     $c1=$m->getTurnoverBySiteByDay("UGA_19", '2023');
//     $c2=$m->getTurnoverBySiteByDay("USR", '2023');
//     $c3=$m->getTurnoverBySiteByDay("NEPHRO", '2023');
//     $tab = array($c1, $c2, $c3);

// // Convertir le tableau en JSON et l'afficher
//       echo json_encode($tab);

// }


if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["Site"]) && isset($_POST["Date"])) {
    $m = Model::getModel();
    $tab=[];
    $i =0;
    $a=$i;
    while($i<12){
        if($i < 10){
            $a='0'.strval($i);
            $tab[$i]=$m->getTurnoverBySiteByMonthAndYear($_POST["Site"], $_POST["Date"], $a);
            
        } else{
            $tab[$i]=$m->getTurnoverBySiteByMonthAndYear($_POST["Site"], $_POST["Date"], $i);
        }
        $i+=1;
    }

    // Convertir le tableau en JSON et l'afficher
    echo json_encode($tab);
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["Site"]) && isset($_POST["Year"]) && isset($_POST["Month"])) {
    $m = Model::getModel();

    $semaines=decouperMois($_POST["Year"], $_POST["Month"]);
    $i=0;
    $tab=[];
    while($i<count($semaines)){
        
        $tab[]=getTurnoverByWeek($_POST["Site"], $_POST["Year"], $_POST["Month"],$semaines[$i][0],$semaines[$i][1]);

    }


    // Convertir le tableau en JSON et l'afficher
    echo json_encode($tab);
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["getSites"])) {
    $m = Model::getModel();
    $tab_sites = $m->getAllSiteByUserid($_COOKIE["user"]);

    // Convertir le tableau en JSON et l'afficher
    echo json_encode($tab_sites);
}
