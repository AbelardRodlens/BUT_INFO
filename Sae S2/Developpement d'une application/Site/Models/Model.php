<?php

class Model
{
    /**
     * Attribut contenant l'instance PDO
     */
    private $bd;

    /**
     * Attribut statique qui contiendra l'unique instance de Model
     */
    private static $instance = null;

    /**
     * Constructeur : effectue la connexion à la base de données.
     */
    private function __construct()
    {
        require_once "credentials.php";
        try{
        include "credentials.php";
        $this->bd = new PDO($dsn, $login, $mdp);
        $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->bd->query("SET nameS 'utf8'");
    }
    catch (PDOException $e) {
        echo 'Connexion échouée : ' . $e->getMessage();
        }
    }


    /**
     * Méthode permettant de récupérer un modèle car le constructeur est privé (Implémentation du Design Pattern Singleton)
     */
    public static function getModel()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    public function getUser($username, $password) {
        $query = "SELECT * FROM personne WHERE email = :username AND motdepasse = :password";
        $stmt = $this->bd->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ? $user : false;
    }

    public function getEnseignant($id){
        $requete="SELECT id_enseignant FROM enseignant WHERE id_enseignant = :id ";
        $requete=$this->bd->prepare($requete);
        $requete->bindValue(':id',$id);
        $requete->execute();
        $teacher=$requete->fetch(PDO::FETCH_ASSOC);

        if($teacher != null){
            $_SESSION['user-role']='enseignant';
        }

        return $teacher;
    }

    public function getDirecteur($id){
        $requete="SELECT id_directeur FROM directeur WHERE id_directeur=:id";
        $requete=$this->bd->prepare($requete);
        $requete->bindValue(':id',$id);
        $requete->execute();
        $directeur=$requete->fetch(PDO::FETCH_ASSOC);

        if($directeur != null){
            $_SESSION['user-role']='directeur';
            
        }
        
        return $directeur;



    }

    public function getChefDep($id){
        $requete="SELECT id_chefdep FROM equipedirection WHERE id_chefdep=:id";
        $requete=$this->bd->prepare($requete);
        $requete->bindValue(':id',$id);
        $requete->execute();
        $chefdep=$requete->fetch(PDO::FETCH_ASSOC);

        if($chefdep != null){
            $_SESSION['user-role']='chef-departement';
            
        }
        
        return $chefdep;

    }

    
    public function getInfos($username) {
        $requete = $this->bd->prepare('SELECT nom, prenom, email FROM personne WHERE email = :username');
        $requete->bindValue(':username', $username);
        $requete->execute();
        $student = $requete->fetch(PDO::FETCH_ASSOC); // Utilisation de fetch() pour obtenir les données
    
        return $student; // Retourne les données de l'utilisateur
    }
    public function getProfil($username) {
        $requete = $this->bd->prepare('SELECT nom, prenom, email FROM personne WHERE email = :username');
        $requete->bindValue(':username', $username);
        $requete->execute();
        $student = $requete->fetchAll(PDO::FETCH_ASSOC); // Utilisation de fetch() pour obtenir les données
    
        return $student; // Retourne les données de l'utilisateur
    }

    public function updatePass($id, $newPass){
        
        $requete2 = $this->bd->prepare('UPDATE personne SET motDePasse=:newPass WHERE id_personne= :id');
        $requete2->bindValue(':id', $id);
        $requete2->bindValue(':newPass', $newPass);
        $requete2->execute();

        $msg="Modification de mot de passe";

        return $msg;

    }

    public function getAllUser(){
    $req =$this->bd->prepare('SELECT * FROM personne');
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);

}

public function search($prenom){
    $req = $this->bd->prepare('SELECT * FROM personne WHERE prenom = :prenom');
    $req->bindParam(':prenom', $prenom);
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

public function getRole($id_personne) {
    $m = Model::getModel();

    if ($m->getDirecteur($id_personne) != null) {
        return "directeur";
    } elseif ($m->getChefDep($id_personne) != null) {
        return "chef-departement";
    } elseif ($m->getEnseignant($id_personne) != null) {
        return "enseignant";
    } elseif ($m->getSecretaire($id_personne) != null) {
        return "secretaire";
    } else {
        return "role inconnu";
    }
}


    public function getAllEnseignant()
    {
        $req = $this->bd->prepare('SELECT * FROM personne JOIN enseignant ON id_personne=id_enseignant');
        $req->execute();

        return $req->fetchall();
    }



    public function getDiscipline()
    {
        $req = $this->bd->prepare('SELECT * FROM discipline');
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategorie()
    {
        $req = $this->bd->prepare('SELECT * FROM categorie');
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertPersonne($nom, $prenom, $email, $motDePasse) {
        $queryPersonne = "INSERT INTO personne (nom, prenom, email, motDePasse) VALUES (:nom, :prenom, :email, :motdepasse)";
        $stmtPersonne = $this->bd->prepare($queryPersonne);
        $stmtPersonne->bindParam(':nom', $nom);
        $stmtPersonne->bindParam(':prenom', $prenom);
        $stmtPersonne->bindParam(':email', $email);
        $stmtPersonne->bindParam(':motdepasse', $motdepasse);
        $stmtPersonne->execute();
         // Retournez l'ID de la personne nouvellement insérée
         $idPersonne = $this->bd->lastInsertId();
        return $idPersonne;}
        public function insertEnseignant($id_personne,$discipline,$categorie){
            $stmtEnseignant = $this->bd->prepare('INSERT INTO enseignant (id_enseignant, id_discipline, id_categorie, aa) VALUES (:id_enseignant, :id_discipline, :id_categorie, :AA)');
            $stmtEnseignant->bindParam(':id_enseignant', $id_personne);
            $stmtEnseignant->bindParam(':id_discipline', $discipline);
            $stmtEnseignant->bindParam(':id_categorie', $categorie);
            $stmtEnseignant->bindValue(':AA', '2024'); // À modifier en fonction de votre application
            $stmtEnseignant->execute();
            $msg="Ajout de l'Enseignant:".$id_personne;

            return $msg;
            
            
    
        }
        public function getSecretaire($id){
                $requete="SELECT id_personne FROM secretaire WHERE id_personne=:id";
                $requete=$this->bd->prepare($requete);
                $requete->bindValue(':id',$id);
                $requete->execute();
                $secretaire=$requete->fetch(PDO::FETCH_ASSOC);
    
                if($secretaire != null){
                    $_SESSION['user-role']='secretaire';
    
                }
    
                return $secretaire;
    
            }
            public function supprimerPersonne($id_personne){
                $req1 =$this->bd->prepare("DELETE FROM equipedirection WHERE id_chefdep = :id");
                $req2 = $this->bd->prepare("DELETE FROM enseignant WHERE id_enseignant = :id");
                $req3 = $this->bd->prepare("DELETE FROM personne WHERE id_personne = :id");
            
                $req1->bindValue(':id', $id_personne);
                $req2->bindValue(':id', $id_personne);
                $req3->bindValue(':id', $id_personne);
            
                $req1->execute();
                $req2->execute();
                $req3->execute();

                $msg="Suppression de l'utilisateur:".$id_personne;

                return $msg;
            }
                public function getTeacherCountByCategory() {
                    $requete = $this->bd->prepare('SELECT categorie.siglecat, COUNT(enseignant.id_enseignant) AS nb_enseignant FROM enseignant JOIN categorie ON categorie.id_categorie = enseignant.id_enseignant GROUP BY categorie.siglecat;');
                    $requete->execute();
                    return $requete->fetchAll(PDO::FETCH_ASSOC);
        
                }

                public function countEnseignantByCategorie(){
                    $requete = $this->bd->prepare('SELECT categorie.libellecat, COUNT(enseignant.id_enseignant) AS nb_enseignant FROM enseignant JOIN categorie ON categorie.id_categorie = enseignant.id_categorie GROUP BY categorie.libellecat;');
                    $requete->execute();
                    
                    return $requete->fetchAll(PDO::FETCH_ASSOC);
        
                }
        
        
                public function countEnseignantByDep(){
                    $requete = $this->bd->prepare('SELECT departement.libelledept, COUNT(enseignant.id_enseignant) AS nb_enseignant FROM assigner JOIN departement ON assigner.id_departement = departement.id_departement JOIN enseignant ON assigner.id_personne = enseignant.id_enseignant GROUP BY departement.libelledept;');
                    $requete->execute();
                    
                    return $requete->fetchAll(PDO::FETCH_ASSOC);
        
                }
        
                public function countEnseignantByDiscipline(){
                    $requete = $this->bd->prepare('SELECT discipline.libelledisc, COUNT(enseignant.id_enseignant) AS nb_enseignant FROM enseignant JOIN discipline ON enseignant.id_discipline = discipline.id_discipline  GROUP BY discipline.libelledisc;');
                    $requete->execute();
                    
                    return $requete->fetchAll(PDO::FETCH_ASSOC);
        
                }
        
                public function getPassByEmail($email){
                    $requete=$this->bd->prepare("SELECT motdepasse FROM personne WHERE email=:email");
                    $requete->bindValue(":email",$email);
                    $requete->execute();
        
                    return $requete->fetch(PDO::FETCH_ASSOC);
                }

                       
        
                public function updatePassByMail($email,$pass){
                    $requete=$this->bd->prepare('UPDATE personne SET motdepasse=:pass WHERE email=:email');
                    $requete->bindValue(":email",$email);
                    $requete->bindValue(":pass",$pass);
                    $requete->execute();
        
                }

                public function stockAction($user, $action, $date){
                    $requete = $this->bd->prepare('INSERT INTO historique(id_personne, action, date) VALUES (:user, :action,:date)');
                    $requete->bindValue(':user', $user);
                    $requete->bindValue(':action', $action);
                    $requete->bindValue(':date', $date);
                    $requete->execute();
                            
                
                    }
                
                public function getLog(){
                    $requete = $this->bd->prepare('SELECT * FROM historique');
                    $requete->execute();
                    
        
                    return  $requete->fetchAll(PDO::FETCH_ASSOC);
        
                }
                public function calculerTauxEncadrementParDiscipline($idDiscipline) {
                    $totalBesoinHeure = $this->getTotalBesoinHeureParDiscipline($idDiscipline);
                    $heureDisponibleSemestre = 41 * 5; // 41 heures par semaine pendant 5 semaines
                
                    // Vérifier si $totalBesoinHeure est numérique et différent de zéro avant le calcul
                    if (is_numeric($totalBesoinHeure) && $totalBesoinHeure != 0) {
                        $tauxEncadrement = $totalBesoinHeure / $heureDisponibleSemestre;
                        return $tauxEncadrement;
                    } else {
                        // Gérer le cas où $totalBesoinHeure n'est pas numérique ou égal à 0
                        return -1; // Valeur d'erreur (ou une autre valeur appropriée)
                    }
                }
                
                public function getTotalBesoinHeureParDiscipline($idDiscipline) {
                    $query = "SELECT SUM(besoin_heure) AS total_besoin_heure FROM Besoin WHERE id_discipline = :idDiscipline";
                    $stmt = $this->bd->prepare($query);
                    $stmt->bindParam(':idDiscipline', $idDiscipline);
                    $stmt->execute();
                
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    return $result ? (float)$result['total_besoin_heure'] : 0; // Convertir en float et retourner 0 si aucune valeur trouvée
                }
                
    }
