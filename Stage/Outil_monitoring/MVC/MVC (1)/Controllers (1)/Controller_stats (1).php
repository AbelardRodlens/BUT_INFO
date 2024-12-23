<?php
require_once 'Controller.php';
require_once __DIR__ . '/../Models/Model.php';

class Controller_stats extends Controller{

    public function action_stats(){
        $m=Model::getModel();
        // $TurnoverByYear=$m->getTurnoverBySiteByYear("USR",2023); ok 
        //  $TurnoverByMonth=$m->getTurnoverBySiteByMonthAndYear("USR",2023, 12); ok
        /*$TurnoverByDay=$m->getTurnoverBySiteByDay("UGA_19", '2023'); inutile pour l'instant*/
        // $TurnoverByExploitantByYear=$m->getTurnoverByExploitantByYear(127, 2023); ok
        // $TurnoverByExploitantByMonthAndYear=$m->getTurnoverByExploitantByMonthAndYear(373, '2023',12); ok
        // $TurnoverByEploitantByDay=$m->getTurnoverByExploitantByDay(373, '2023-10-28'); ok
       /* $getNotRentRoom=$m->getAllNotRentRooms(); //ok
        $LessEfficientService=$m->getLessEfficientService();
        // $MostEfficientService=$m->getMostEfficientService();*/
    //   var_dump($TurnoverByYear);
    //    var_dump($TurnoverByMonth);
      /*  var_dump($TurnoverByDay);*/
        // var_dump($TurnoverByExploitantByYear);
        // var_dump($TurnoverByExploitantByMonthAndYear);
        // var_dump($TurnoverByEploitantByDay);
       /* var_dump($getNotRentRoom);
        var_dump($LessEfficientService);
        var_dump($MostEfficientService);*/
       // $LessEficientByClient=$m->getLessEfficientServiceByExploitant(373); ok

        var_dump($m->getLessEfficientServiceByExploitantByYear(373,2023));
        
        

    }


    public function action_default(){

        $this->render("stats",[]);
    }



    
}

if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["getMontant"])){
    $m=Model::getModel();
    $c1=$m->getTurnoverBySiteByDay("UGA_19", '2023');
    $c2=$m->getTurnoverBySiteByDay("USR", '2023');
    $c3=$m->getTurnoverBySiteByDay("NEPHRO", '2023');
    $tab = array($c1, $c2, $c3);

// Convertir le tableau en JSON et l'afficher
      echo json_encode($tab);
   
}


?>