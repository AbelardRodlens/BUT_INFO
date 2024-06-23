<?php
require_once 'Controller.php';
require_once __DIR__ . '/../Models/Model.php';

class Controller_userlist extends Controller{

    public function action_userlist(){ //Probablement inutile, à vérifier !!!!
        $m=Model::getModel();
        $users=$m->getAllUser();
        

        /*foreach($users as $key=>$value){
            $var=$users[$key]["username"];
            echo "<p>".$users[$key]["username"]."    ".$users[$key]["adresse"]."     ".$users[$key]["admin"]."<input type='submit' class='voirplus' name=".$var." value=''>"."</p>";
            
        }
        $this->render("userlist",$users);*/

        

    }

    public function action_modifyuser(){

        if (isset($_POST["oldusername"]) && isset($_POST["newusername"])){
            var_dump($_POST["oldusername"]);
            var_dump($_POST["newusername"]);
            $m=Model::getModel();
            $m->updateUserUsername($_POST["oldusername"], $_POST["newusername"]);
            $this->render("userlist",[]);
        } else{ $this->render("error404", []);}
        

    }



    public function action_default(){
        // if(isset($_SESSION["role"]) && ($_SESSION["role"]=="admin")){
        //     $this->render("userlist",[]);
        // } else { 
        //     header("location:index.php");
        //     exit;
        // }

        $this->render("userlist",[]);
       
    }



    
}



if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['oldadress']) && isset($_POST["oldusername"]) && isset($_POST["newusername"]) && $_POST["newusername"] !== "" ) {
    // Récupérez les données du formulaire
    $m=Model::getModel();
    $newusername = $_POST["newusername"];
    $oldusername = $m->getUserByAdress($_POST['oldadress']);
    $oldusername=$oldusername['username'];
    // Appel la fonction permettant de modifier l'username de l'utilisateur
    
    $m->updateUserUsername($oldusername, $newusername);

    echo "Username changé";
}


if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["oldadress"]) && isset($_POST["newadress"]) && $_POST["newadress"] != ""  ) {
    // Récupérez les données du formulaire
    $newadress = $_POST["newadress"];

    // Appel la fonction permettant de modifier l'adresse de l'utilisateur
    $m=Model::getModel();
    $user= $m->getUserByAdress($_POST["oldadress"]);
    $oldadress=$user['adresse'];

    $m->updateUserAdress($oldadress, $newadress);
    // Vous pouvez envoyer une réponse JSON au client si nécessaire
    
    echo "Adresse". $oldadress ."modifié par ".$newadress;
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["oldadress"]) && isset($_POST["newadress"]) && isset($_POST["oldusername"]) && isset($_POST["newusername"]) && $_POST["newadress"] != "" && $_POST["newusername"] !="") {
    // Récupérez les données du formulaire
    $newadress = $_POST["newadress"];
    $newusername=$_POST["newusername"];

    // Appel la fonction permettant de modifier l'adresse de l'utilisateur
    $m=Model::getModel();
    $user= $m->getUserByAdress($_POST["oldadress"]);
    $oldadress=$user['adresse'];
    $oldusername=$user['username'];
    $m->updateUserAdress($oldadress, $newadress);
    $m->updateUserUsername($oldusername, $_POST["newusername"]);
    // Vous pouvez envoyer une réponse JSON au client si nécessaire
    
    echo "Adresse". $oldadress ."modifié par ".$newadress. " et ".$oldusername." en ".$newusername;
}




if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["asktab"]) ) {

    $m=Model::getModel();
    $users=$m->getAllUser();

     echo json_encode($users);

    
}



if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["updateUser"]) ) {

    $m=Model::getModel();
    $userlist=$m->getAllUser();

     echo json_encode($userlist);

    
}

if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["getUsers"])){
    $m=Model::getModel();
    $userlist=$m->getAllUser();

     echo json_encode($userlist);
}


if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['userid'])) {

    $m=Model::getModel();
    $m->delUser($_POST['userid']);
    echo "Utilisateur ".$_POST['userid']." Supprimé";

    
}





?>