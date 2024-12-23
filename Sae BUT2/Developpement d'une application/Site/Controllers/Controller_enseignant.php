<?php

class Controller_enseignant extends Controller {

    public function action_supprimer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_personne = isset($_POST['id_personne']) ? $_POST['id_personne'] : null;
            if ($id_personne !== null) {
                $model = Model::getModel();
                $model->supprimerPersonne($id_personne);
                $model->stockAction($_SESSION["user"], $model->supprimerPersonne($id_personne), date("Y-m-d H:i:s"));
                $this->action_default();

            }
        }
    }

    public function action_search() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $m = Model::getModel();
            $prenom = isset($_POST['search']) ? $_POST['search'] : null;
            //var_dump($prenom);
    
            // Assurez-vous que $prenom contient la valeur avant de l'utiliser
                $Personnes = $m->search($prenom);

            // N'oubliez pas de passer les données à la vue
            $this->action_enseignant($Personnes);
        }
    }
    
    public function action_enseignant($Personnes) {
        if(isset($_SESSION["user"])){
        $m = Model::getModel();
        $users = $m->getAllUser();
        
        // Boucle qui utilise la fonction getrole du modele.php pour trouver le rôle des personnes
        foreach ($users as &$user) {
            $user['role'] = $m->getRole($user['id_personne']);
        }
        
        $data = [
            "Discipline" => $m->getDiscipline(),
            "Catégorie" => $m->getCategorie(),
            "user" => $users,
            "Personnes" => $Personnes, // Correction ici pour passer correctement les données
        ];
        $this->render("enseignant", $data);
    }else{
        $this->render("error", []);
    }}

    public function action_default() {
        
        $Personnes = null;
        $this->action_enseignant($Personnes);
    }

    public function action_ren() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérez les données du formulaire
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['mail'];
            $motdepasse = $_POST['motdepasse'];
            $disciplines = $_POST["discipline"];
            $categorie = $_POST['Catégorie'];

            // Appeler la fonction du modèle ou effectuer le traitement nécessaire
            $model = Model::getModel();
            $id_personne = $model->insertpersonne($nom, $prenom, $email, $motdepasse);
            $model->stockAction($_SESSION["user"], $model->insertEnseignant($id_personne, $disciplines, $categorie), date("Y-m-d H:i:s"));
            
            if ($id_personne) {
                header("Location: index.php?controller=enseignant");
            } else {
                // Gérer le cas où l'insertion a échoué
                echo "Erreur : L'insertion a échoué.";
            }
        } else {
            // Gérer le cas où le formulaire n'a pas été soumis
            echo "Erreur : Le formulaire n'a pas été soumis.";
        }
    }
}


    /*public function action_modifier() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['mail'];
            $motdepasse = $_POST['motdepasse'];
            $disciplines = $_POST["discipline"];
            $categorie = $_POST['Catégorie'];
    
            // Appeler la fonction du modèle ou effectuer le traitement nécessaire
            $model = Model::getModel();
            $id_personne = $model->modifierPersonne($nom, $prenom, $email, $motdepasse);
            $model->modifierEnseignant($id_personne, $disciplines, $categorie);
    
            if ($id_personne) {
                header("Location: index.php?controller=enseignant");
            } else {
                // Gérer le cas où l'insertion a échoué
                echo "Erreur : L'insertion a échoué.";
            }
        } else {
            // Gérer le cas où le formulaire n'a pas été soumis
            echo "Erreur : Le formulaire n'a pas été soumis.";
        }
    }*/
?>
