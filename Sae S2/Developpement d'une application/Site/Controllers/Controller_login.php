<?php 
require_once("./Models/Model.php");
require_once("Controller.php");

class Controller_Login extends Controller {
   
    
    public function action_Login() {
        $m = Model::getModel();
		$data = [];
        $this->render("login", $data);}

    protected function log_user($id, $role, $nom, $prenom,$email){
        $_SESSION["user"]=$id;
        $_SESSION["user-role"]=$role;
        $_SESSION["user-nom"]=$nom;
        $_SESSION["user-prenom"]=$prenom;
        $_SESSION["user-email"]=$email;
            session_write_close();
    
        }

        

      public function action_Login1() {
        
      
    if (isset($_POST['submit'])) {
        $username = $_POST['username']; // Utilisez 'id' pour récupérer le username
        $password = $_POST['password'];

        // Débogage : affiche les données reçues du formulaire
        
        
        $m = Model::getModel();
        $user = $m->getUser($username, $password);
        
    

        // Débogage : affiche le résultat de la vérification de l'utilisateur
       

        if ($user) {
            //echo "Connexion réussie !";
            if($verif=$m->getDirecteur($user['id_personne']) != null)
         {
            $role="directeur";
        } elseif($verif=$m->getChefDep($user['id_personne']) != null){
            $role="chef-departement";

        }
        
          elseif($verif=$m->getEnseignant($user['id_personne']) != null){
            $role="enseignant";

        }  else {$role="secretaire";}


        
        $this->log_user($user['id_personne'], $role, $user['nom'], $user['prenom'],$user['email']);
            $data = [];
            $this->render("home", $user); 
            
        } else {
            echo "Identifiants invalides !";
            

        }
    }
}
    public function action_logout(){
        if(isset($_POST["logout"])){

            $_SESSION = array();

            session_destroy();
            session_unset();

            header("Location: index.php");
            exit();

            $this->render("index",[]);


    }
    


}


    public function action_Default() {
        $this->action_Login();
    }
}
?>
