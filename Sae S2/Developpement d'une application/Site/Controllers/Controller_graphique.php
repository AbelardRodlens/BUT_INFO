<?php

class Controller_graphique extends Controller {

    public function action_graphique() {
    if(isset($_SESSION["user"])){
        $m = Model::getModel();
        $tab=$m->getTeacherCountByCategory();
        $this->render("graphique", $tab); // Passer directement les informations à la vue
       }else{
           $this->render("error", []);

       } 
}


    public function action_Default() {
        $this->action_graphique();
    }
}
?>