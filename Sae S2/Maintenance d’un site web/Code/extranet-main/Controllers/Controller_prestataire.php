<?php
    
class Controller_prestataire extends Controller
{
    /**
     * @inheritDoc
     */
    public function action_default()
    {
        $this->action_liste_client();
       
    }

    /**
     * Renvoie le tableau de bord du prestataire avec les variables adéquates
     * @return void
     */
    public function action_dashboard()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['role'])) {
            unset($_SESSION['role']);
        }
        $_SESSION['role'] = 'prestataire';

        if (isset($_SESSION['id'])) {
            $bd = Model::getModel();
            $bdlLink = '?controller=prestataire&action=afficher_bdl';
            $headerDashboard = ['Nom mission','Date de création','Nom','Status', 'BDL'];
            $data = ['menu' => $this->action_get_navbar() , 'bdlLink' => $bdlLink, 'header' => $headerDashboard, 'dashboard' => $bd->getDashboardPrestataire($_SESSION['id'],$_GET['id'])];
            return $this->render('prestataire_missions', $data);
        } else {
            echo 'Une erreur est survenue lors du chargement du tableau de bord';
        }
    }

    /**
     * Renvoie la vue qui montre les informations de l'utilisateur connecté
     * @return void
     */
    public function action_infos()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->render('infos', ['menu' => $this->action_get_navbar()]);
    }

    /**
     * Action qui retourne les éléments du menu pour le prestataire
     * @return array[]
     */
    public function action_get_navbar()
    {
        return [
            ['link' => '?controller=prestataire', 'name' => 'Bons de livraison', 'icon' => '<i class="fa-solid fa-truck"></i>']];
    }


    /**
     * Ajoute dans la base de données la date à laquelle le prestataire est absent
     * @return void
     */
    public function action_prestataire_creer_absences()
    {
        $bd = Model::getModel();
        if (isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['Date']) && isset($_POST['motif'])) {
            $bd->addAbsenceForPrestataire($_POST['prenom'], $_POST['nom'], $_POST['email'], $_POST['Date'], $_POST['motif']);
        } else {
            $this->action_error("données incomplètes");
        }
    }

    /**
     * Renvoie la vue qui lui permet de remplir son bon de livraion avec le bon type
     * @return void
     */
    public function action_afficher_bdl()
    {
        $bd = Model::getModel();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_GET['id'])) {
            $typeBdl = $bd->getBdlTypeAndMonth($_GET['id']);
            $activites=$bd->getActiviteBdl($_GET['id']);
            $typeBdl['type_bdl'] = mb_convert_encoding($typeBdl['type_bdl'], 'ISO-8859-1', 'UTF-8'); // Convertie la chaine en ISO-8859-1 **
            if ($typeBdl['type_bdl'] == 'Heure') {
                $infosBdl = $bd->getAllNbHeureActivite($_GET['id']);
            } elseif ($typeBdl['type_bdl'] == 'Journée') {
                $infosBdl = $bd->getAllJourActivite($_GET['id']);
            } elseif ($typeBdl['type_bdl'] == 'Demi-journée') {
                $infosBdl = $bd->getAllDemiJourActivite($_GET['id']);
            }
            
            $data = ['menu' => $this->action_get_navbar(), 'bdl' => $typeBdl, 'infosBdl' => $infosBdl, 'activite' => $activites];
            $this->render("activite", $data);
        } else {
            echo 'Une erreur est survenue lors du chargement de ce bon de livraison';
        }
    }


    /**
     * Vérifie d'avoir les informations nécessaire pour renvoyer la vue liste avec les bonnes variables pour afficher la liste des bons de livraisons du prestataire en fonction de la mission
     * @return void
     */
    public function action_mission_bdl()
    {
        $bd = Model::getModel();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_GET['id'])) {
            $buttonLink = '?controller=prestataire&action=ajout_bdl_form';
            $cardLink = '?controller=prestataire&action=afficher_bdl';
            $data = ['title' => 'Bons de livraison', 'buttonLink' => $buttonLink, 'cardLink' => $cardLink, 'menu' => $this->action_get_navbar(), 'person' => $bd->getBdlsOfPrestataireByIdMission($_GET['id'], $_SESSION['id'])];
            $this->render('liste', $data);
        }
    }

    /**
     * Renvoie la liste des bons de livraison du prestataire connecté
     * @return void
     */
    public function action_liste_bdl()
    {
        $bd = Model::getModel();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['id'])) {
            $cardLink = '?controller=prestataire&action=afficher_bdl';
            $buttonLink = '?controller=prestataire&action=ajout_bdl_form';
            $data = ['title' => 'Mes Bons de livraison', 'buttonLink' => $buttonLink, 'cardLink' => $cardLink, 'menu' => $this->action_get_navbar(), "person" => $bd->getAllBdlPrestataire($_SESSION['id'])];
            $this->render("liste", $data);
        }
    }

    /**
     * Vérifie d'avoir les informations nécessaires pour créer un bon de livraison
     * @return void
     */
    public function action_prestataire_creer_bdl()
    {
        $bd = Model::getModel();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['id']) && isset($_POST['mission'])) {
            $bd->addBdlForPrestataire($_SESSION['id'], e($_POST['mission']));
        } else {
            echo 'Une erreur est survenue lors de la création du bon de livraison';
        }
    }

    /**
     * Récupère le tableau renvoyé par le JavaScript et rempli les lignes du bon de livraison en fonction de son type
     * @return void
     */
    public function action_completer_bdl()
    {
        $bd = Model::getModel();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Récupérer les données depuis la requête POST
        $data = json_decode(file_get_contents("php://input"), true);

        // Vérifier si les données sont présentes
        if ($data && is_array($data)) {
            // Parcourir chaque ligne du tableau
            foreach ($data as $row) {
                // Vérifier si l'activite existe avant de l'ajouter, sinon la modifier
                if ($bd->checkActiviteExiste($_GET['id'], $row[0])) {
                    $id_activite = $bd->getIdActivite($row[0], $_GET['id']);
                    if ($row[1] && $_GET['type'] == 'Heure') {
                        $bd->setNbHeure($id_activite, (int)$row[1]);
                    } elseif ($row[1] >= 0 && $row[1] <= 1 && $_GET['type'] == 'Journée') {
                        $bd->setJourneeJour($id_activite, (int)$row[1]);
                    } elseif ($row[1] >= 0 && $row[1] <= 2 && $_GET['type'] == 'Demi-journée') {
                        $bd->setDemiJournee($id_activite, (int)$row[1]);
                    }
                    if ($row[2]) {
                        $bd->setCommentaireActivite($id_activite, $row[2]);
                    }
                } elseif ($row[1]) {
                    if ($row[1] && $_GET['type'] == 'Heure') {
                        $bd->addNbHeureActivite($row[2], $_GET['id'], $_SESSION['id'], $row[0], (int)$row[1]);
                    } elseif ($row[1] >= 0 && $row[1] <= 1 && $_GET['type'] == 'Journée') {
                        $bd->addJourneeJour($row[2], $_GET['id'], $_SESSION['id'], $row[0], (int)$row[1]);
                    } elseif ($row[1] >= 0 && $row[1] <= 2 && $_GET['type'] == 'Demi-journée') {
                        $bd->addDemiJournee($row[2], $_GET['id'], $_SESSION['id'], $row[0], (int)$row[1]);
                    }
                }
            }
        }
        $this->render('dashboard');
    }

    /**
     * Renvoie le formulaire pour ajouter un bon de livraison
     * @return void
     */
    public function action_ajout_bdl_form()
    {
        
        $data = ['menu' => []];
        $this->render('ajout_bdl', $data);
    }

    /**
     * Vérifie d'avoir les informations nécessaire pour ajouter un bon de livraison à une mission
     * @return void
     */
    public function action_ajout_bdl()
    {
        
        $bd = Model::getModel();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if ($_POST['mission'] && $_POST['mois'] && $_POST['composante']) {
            $bd->addBdlInMission(e($_POST['mission']),e($_POST['composante']),e($_POST['mois']), $_SESSION['id']);
        }
        $this->action_ajout_bdl_form();
    }

    public function action_maj_infos() 	{     	maj_infos_personne(); 
         	
    }

    /**
     * Renvoie la liste des clients du prestataire connecté
     * @return void
     */
    public function action_liste_client()
    {
        $bd = Model::getModel();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['role'])) {
            unset($_SESSION['role']);
        }

        $_SESSION['role'] = 'prestataire';
        
        if (isset($_SESSION['id'])) {
            $cardLink = '?controller=prestataire&action=composantes';
            $buttonLink = '?controller=prestataire&action=ajout_bdl_form';
            $data = ['title' => 'Mes Clients', 'buttonLink' => $buttonLink, 'cardLink' => $cardLink,'menu' => $this->action_get_navbar(), "person" => $bd->getAllClientPrestataire($_SESSION['id'])];
            $this->render("liste", $data);
        }
        
    }

    public function action_composantes()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['id'])) {
            $bd = Model::getModel();
            
            $title = 'Composantes ';
            $cardLink = '?controller=prestataire&action=dashboard';
            $data = ['title' => $title, 'composante' => $bd->getComponentsWithPrestataireMission($_SESSION['id'],$_GET['id']), 'cardLink' => $cardLink, 'menu' => $this->action_get_navbar()];
            $this->render("liste", $data);
        }
    }

    /// Barre Recherche ///

    public function action_reshearchClients()
    {   
        $bd = Model::getModel();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $controller = isset($_GET['controller']) ? $_GET['controller'] : '';
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $chaine = file_get_contents("php://input"); // Récupération de la chaine encodé au format JSON.
            $chaine = json_decode($chaine,true); // Décodage de la chaine JSON en tableau associatif.
            $clients=$bd->shearchIntoClientPrestataire($_SESSION['id'],$chaine['msg'],$chaine['msg']);
            echo json_encode($clients);
            
            

        }
    }

    public function action_reshearchComposantes()
    {   
        $bd = Model::getModel();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $controller = isset($_GET['controller']) ? $_GET['controller'] : '';
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $donnee = file_get_contents("php://input"); // Récupération de la chaine encodé au format JSON.
            $donnee = json_decode($donnee,true); // Décodage de la donnee JSON en tableau associatif.
            $chaine=$donnee['msg'];
            $id_client=$donnee['id'];
            $composantes=$bd->shearchIntoComponentsPrestataire($_SESSION['id'], $id_client,$chaine,$chaine);
            echo json_encode($composantes);
            
            

        }
    }


}
