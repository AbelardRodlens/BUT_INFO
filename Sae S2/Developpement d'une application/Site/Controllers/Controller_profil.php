<?php 
require_once("./Models/Model.php");
require_once("Controller.php");

class Controller_profil extends Controller {
   
    
    public function action_profil() {
        if(isset($_SESSION["user"])){

        $m = Model::getModel();
		$data = [];
        $this->render("profil", $data);
        } else{
            $this->render("error", []);
        }
    }

    public function action_updatepass(){
        if (isset($_POST["submit"])){
            if(preg_match("/^.*(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]+$/",$_POST["new-pass"]) == TRUE){
                if($_POST["new-pass"] != $_POST["confirm-pass"]){
                    $data = [];
                    $this->render("updatepassfail", $data);

                }
                $m = Model::getModel();
                $m->updatePass($_SESSION["user"], $_POST["new-pass"]);
                $m->stockAction($_SESSION["user"], $m->updatePass($_SESSION["user"], $_POST["new-pass"]), date("Y-m-d H:i:s"));
                $data = [];
                $this->render("profil", $data);
            }else {
                $data =[];
                $this->render("updatepassfail2", $data);
    
    
            }
        } 

    }
        
    
      


    public function action_Default() {
        $this->action_profil();
    }
}
?>
