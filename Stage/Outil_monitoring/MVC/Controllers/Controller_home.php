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



if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["Dep"]) && isset($_POST["Date"])) {
    $m = Model::getModel();
    $tab=[];
    $i =0;
    $a=$i;
    while($i<12){
        if($i < 10){
            $a='0'.strval($i);
            $tab[$i]=$m->getTurnoverByDepByMonthAndYear($_POST["Dep"], $_POST["Date"], $a);
            
        } else{
            $tab[$i]=$m->getTurnoverByDepByMonthAndYear($_POST["Dep"], $_POST["Date"], $i);
        }
        $i+=1;
    }

    // Convertir le tableau en JSON et l'afficher
    echo json_encode($tab);
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["Dep"]) && isset($_POST["Year"]) && isset($_POST["Month"])) {
    $m = Model::getModel();

    $semaines=decouperMois($_POST["Year"], $_POST["Month"]);
    $i=0;
    $tab=[];
    while($i<count($semaines)){
        
        $tab[]=$m->getTurnoverByWeek($_POST["Dep"], $_POST["Year"], $_POST["Month"],$semaines[$i][0],$semaines[$i][1]);
        $i++;
    }


    // Convertir le tableau en JSON et l'afficher
    echo json_encode(array($tab,$semaines));
    
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["Dep"]) && isset($_POST["WeekDate"])) {
    $m = Model::getModel();

    $date=explode("/",$_POST["WeekDate"]);
    $jours=weekToDay(intval($date[0]),intval($date[1]), intval($date[2]));
    $i=0;
    $tab=[];
    while($i<count($jours)){
        
        $tab[]=$m->getTurnoverByDepByDate($_POST["Dep"], $jours[$i]);
        $i++;
    }


    // Convertir le tableau en JSON et l'afficher
    echo json_encode(array($tab,$jours));
}



if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["getDeps"])) {
    $m = Model::getModel();
    $tab_sites = $m->getALLDep('gtvx');

    // Convertir le tableau en JSON et l'afficher
    echo json_encode($tab_sites);
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["getChartsData"])) {
    $m = Model::getModel();

    $AllDepCAForCurYear=[];
    $dep=$m->getALLDep('gtvx');
    forEach($dep as $value ){
        $AllDepCAForCurYear[]=$m->getTurnoverByDepByYear($value['department_name'],2023,'gtvx');
        
    
    }

    $AllDepPmStat=[];
    forEach($dep as $value){
        $AllDepPmStat[]=$m->getPaymentMethodStatByDepAndYear($value['department_name'],date("Y"),'gtvx');
    }

    




    $NotRentRooms = $m->countNotRentRooms();
    $RentRooms = $m->countRentRooms();
    
    $NRR_ratio=($NotRentRooms['nb_not_rent_rooms']/$RentRooms['nb_rent_rooms']) * 100;
    $RR_ratio= 100-$NRR_ratio;
    $NRR_ratio=round($NRR_ratio);
    $RR_ratio= round($RR_ratio);


    $Sub_ratio=$m->countSubscription('gtvx');
    $CA_Site=$m->getSiteTurnover('gtvx');
    $Site_MP_Stat=$m->countPaymentMethod('gtvx');

    // Convertir le tableau en JSON et l'afficher
    echo json_encode(array([$NRR_ratio,$RR_ratio],$Sub_ratio,$AllDepCAForCurYear, $AllDepPmStat,$CA_Site,$Site_MP_Stat));
}


if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["mpDep"]) && isset($_POST["mpDate"])) {
    $m = Model::getModel();
    
    if($_POST["mpDep"]=="Tout"){
        $PM_date=$m->getAllPaymentMethodStatByYear($_POST["mpDate"],'gtvx');

    } else{
        $PM_date=$m->getPaymentMethodStatByDepAndYear($_POST["mpDep"],$_POST["mpDate"],'gtvx');
    }

    // Convertir le tableau en JSON et l'afficher
    echo json_encode($PM_date);
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["mpDep"]) && isset($_POST["mpYear"]) && isset($_POST["mpMonth"])) {
    $m = Model::getModel();

    $pm_Month=$m->getPaymentMethodStatByMonthAndYear($_POST["mpDep"],$_POST["mpYear"],$_POST["mpMonth"],'gtvx');
    
    // Convertir le tableau en JSON et l'afficher
    echo json_encode($pm_Month);
    
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["mpDep"]) && isset($_POST["mpWeekDate"])) {
    $m = Model::getModel();

    $date=explode("/",$_POST["mpWeekDate"]);
    $jours=weekToDay(intval($date[0]),intval($date[1]), intval($date[2]));
    $week_start=$jours[0];
    $week_end=$jours[count($jours)-1];

    $mp_weekdate=$m->getPaymentMethodStatByWeek($_POST["mpDep"],$week_start,$week_end,'gtvx');
    

    // Convertir le tableau en JSON et l'afficher
    echo json_encode(array($week_start,$mp_weekdate));
}
