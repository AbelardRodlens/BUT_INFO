<?php 
require_once("./Models/Model.php");
require_once("Controller.php");

class Controller_demande extends Controller {
   
    
    public function action_demande() {
        if(isset($_SESSION["user"])){

        $m = Model::getModel();
		$data = [];
        $this->render("demande", $data);
        } else{
            $this->render("error", []);
        }
    }



    public function action_Default() {
        $this->action_demande();
    }

    public function action_forma() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['nbHeures'], $_POST['annee'], $_POST['semestre'], $_POST['departement'], $_POST['formation'], $_POST['discipline'])) {

                $nbHeures = $_POST['nbHeures'];
                $annee = $_POST['annee'];
                $semestre = $_POST['semestre'];
                $departement = $_POST['departement'];
                $formation = $_POST['formation'];
                $discipline = $_POST['discipline'];

                $m = Model::getModel();
                $m->insererBesoin($annee, $semestre, $formation, $discipline, $departement, $nbHeures);

                if ($success) {
                    echo "Demande insérée avec succès!";
                } else {
                    echo "Erreur lors de l'insertion de la demande.";
                }
            } else {
                echo "Tous les champs du formulaire sont nécessaires.";
            }
        }
    }
}
?>