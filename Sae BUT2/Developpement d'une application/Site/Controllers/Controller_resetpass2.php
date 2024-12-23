<?php
// ce conroller n'est pas encore utilisé 
class Controller_resetpass2 extends Controller
{

        public function action_resetpass2() {
           
            
            
            session_start();
            
            
            $tokenSession = $_SESSION['reset_token'];
            $tokenUrl = $_GET['token'];
        
            
            if(isset($_SESSION['reset_token']) ){ // Problème j'arrive pas à faire cette condition && $tokenSession == $tokenUrl, je n'arrive pas à récupéré la valeur du token de l'url
                if (isset($_POST["submit"])){
                    if(preg_match("/^.*(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]+$/",$_POST["pass"]) == TRUE){
                        if($_POST["pass"] != $_POST["confirm-pass"]){
                            $data = [];
                            $this->render("error", $data);
        
                        }
                        $m = Model::getModel();
                        $m->updatePassByMail($_SESSION["email"],$_POST["pass"]);
                        $data = [];
                        session_destroy();
                        session_unset();

                        
                        $this->render("login",  []);
                    }else {
                        $data =[];
                        $this->render("error", $data);
            
            
                    }
                } 


             $m = Model::getModel();
            // Rendu de la vue en transmettant les données de nom et prénom
             $this->render("resetpass2",  []); // Passer directement les informations à la vue
            }else{
                $this->render("login", []);
                
            } 
    }

        


        



        public function action_default()
    {
        $this->action_resetpass2();
    }

    }