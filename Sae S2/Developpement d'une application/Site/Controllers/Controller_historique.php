<?php
// ce conroller n'est pas encore utilisé 
class Controller_historique extends Controller
{

        public function action_historique() {
            if(isset($_SESSION["user"])){
             $m = Model::getModel();

            $tab=$m->getLog();
            
            
            $this->render("historique", $tab);
            }else{
                $this->render("error", []);
                
            } 
    }


        



        public function action_default()
    {
        $this->action_historique();
    }

    }