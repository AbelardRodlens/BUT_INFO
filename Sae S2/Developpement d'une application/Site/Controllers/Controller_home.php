<?php
// ce conroller n'est pas encore utilisé 
class Controller_home extends Controller
{

        public function action_home() {
            if(isset($_SESSION["user"])){
             $m = Model::getModel();
             
             
            // Rendu de la vue en transmettant les données de nom et prénom
             $this->render("home", []); // Passer directement les informations à la vue
            }else{
                $this->render("error", []);
                
            } 
    }


        



        public function action_default()
    {
        $this->action_home();
    }

    }
    
    

