<?php

class Controller_TE extends Controller {
    public function action_TE() {
        if (isset($_SESSION["user"])) {
            $m = Model::getModel();
            $disciplines = $m->getDiscipline();
            $this->render("TE", array('disciplines' => $disciplines));
        }
    }

    public function action_calculerTE() {
        if (isset($_SESSION["user"])) {
            $m = Model::getModel();
    
            // Vérifier si l'identifiant de la discipline a été envoyé
            if (isset($_POST['id_discipline'])) {
                $idDiscipline = $_POST['id_discipline'];
    
                // Calculer le taux d'encadrement pour la discipline spécifiée
                $tauxEncadrement = $m->calculerTauxEncadrementParDiscipline($idDiscipline);
    
                // Afficher le résultat dans la même vue
                $disciplines = $m->getDiscipline();
                $this->render("TE", array('disciplines' => $disciplines, 'tauxEncadrement' => $tauxEncadrement));
            } else {
                $this->render("error", []);
            }
        } else {
            $this->render("error", []);
        }
    }
    

    public function action_default() {
        $this->action_TE();
    }
}
