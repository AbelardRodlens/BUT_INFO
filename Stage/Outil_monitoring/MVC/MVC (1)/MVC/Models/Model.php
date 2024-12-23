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
        try {
            include "credentials.php";
            $this->bd = new PDO($dsn, $login, $mdp);
            $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->bd->query("SET nameS 'utf8'");
        } catch (PDOException $e) {
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


    public function getUser($username, $pass)
    {
        $query = "SELECT * FROM account WHERE username = :username AND pass = :pass";
        $query = $this->bd->prepare($query);
        $query->bindParam(':username', $username);
        $query->bindParam(':pass', $pass);
        $query->execute();

        $user = $query->fetch(PDO::FETCH_ASSOC);

        return $user;
    }
    public function getUserToken($user)
    {
        $query = "SELECT token FROM account WHERE user_id=:user";
        $query = $this->bd->prepare($query);
        $query->bindParam(':user', $user);
        $query->execute();

        $token = $query->fetch(PDO::FETCH_ASSOC);

        return $token;
    }

    public function updateUserToken($token, $userid)
    {
        $query = "UPDATE account SET token=:token WHERE user_id=:user";
        $query = $this->bd->prepare($query);
        $query->bindParam(':token', $token);
        $query->bindParam(':user', $userid);
        $query->execute();
    }

    public function getAllUser()
    {
        $query = "SELECT * FROM account";
        $query = $this->bd->prepare($query);
        $query->execute();

        $users = $query->fetchAll(PDO::FETCH_ASSOC);

        return $users;
    }

    public function getUserByUsername($username)
    {
        $query = "SELECT * FROM account WHERE username = :username";
        $query = $this->bd->prepare($query);
        $query->bindParam(':username', $username);
        $query->execute();

        $user = $query->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

    public function getUserRole($username)
    {
        $query = "SELECT admin FROM account WHERE username = :username";
        $query = $this->bd->prepare($query);
        $query->bindParam(':username', $username);
        $query->execute();

        $role = $query->fetch(PDO::FETCH_ASSOC);

        return $role;
    }

    public function addUser($username, $adress, $pass)
    {
        $query = "INSERT INTO account(username,pass,adresse) VALUES(:username,:pass,:adress)";
        $query = $this->bd->prepare($query);
        $query->bindParam(':username', $username);
        $query->bindParam(':pass', $pass);
        $query->bindParam(':adress', $adress);
        $query->execute();
    }

    public function delUser($userid)
    {
        $query = "DELETE FROM account WHERE user_id=:userid";
        $query = $this->bd->prepare($query);
        $query->bindParam(':userid', $userid);
        $query->execute();
    }

    public function getUserByAdress($adress)
    {
        $query = "SELECT * FROM account WHERE adresse = :adress";
        $query = $this->bd->prepare($query);
        $query->bindParam(':adress', $adress);
        $query->execute();

        $user = $query->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

    public function UpdatePassByAdress($adress, $pass)
    {
        $query = $this->bd->prepare("UPDATE account SET pass=:pass WHERE adresse=:adress");
        $query->bindValue(":pass", $pass);
        $query->bindValue(":adress", $adress);
        $query->execute();
    }

    public function putIntoPassLogs($userid, $pass)
    {
        $query = $this->bd->prepare("INSERT INTO passlogs(user_id,pass) VALUES(:userid,:pass)");
        $query->bindValue(":pass", $pass);
        $query->bindValue(":userid", $userid);
        $query->execute();
    }

    public function getOldUserPass($userid)
    {
        /**useless pour l'instant */
        $query = $this->bd->prepare("SELECT pass FROM passlogs WHERE user_id=:userid");
        $query->bindValue(":userid", $userid);
        $query->execute();

        $oldpass = $query->fetchAll(PDO::FETCH_ASSOC);

        return $oldpass;
    }

    public function checkIfPassAlreadyUse($userid, $pass)
    {
        $query = $this->bd->prepare("SELECT user_id FROM passlogs WHERE pass=:pass AND user_id=:userid");
        $query->bindValue(":pass", $pass);
        $query->bindValue(":userid", $userid);
        $query->execute();

        $pass = $query->fetch(PDO::FETCH_ASSOC);

        return $pass;
    }

    public function giveAdminRole($username)
    {
        $query = $this->bd->prepare("UPDATE account SET admin=1 WHERE username=:username");
        $query->bindValue(":username", $username);
        $query->execute();
    }

    public function updateUserUsername($oldusername, $newusername)
    {
        $query = $this->bd->prepare("UPDATE account SET username=:newusername WHERE username=:oldusername");
        $query->bindValue(":oldusername", $oldusername);
        $query->bindValue(":newusername", $newusername);
        $query->execute();

        $username = $query->fetch(PDO::FETCH_ASSOC);

        return $username;
    }

    public function updateUserAdress($oladress, $newadress)
    {
        $query = $this->bd->prepare("UPDATE account SET adresse=:newadress WHERE adresse=:oldadress");
        $query->bindValue("oldadress", $oladress);
        $query->bindValue("newadress", $newadress);
        $query->execute();
    }




    public function getTurnoverByExploitant($userid)
    {
        $query = $this->bd->prepare("SELECT SUM(montant_total) AS Chiffredaffaire FROM factures_tv WHERE id_client =:userid AND type <> 'remboursement'");
        $query->bindValue("userid", $userid);
        $query->execute();

        $chiffredaffaire = $query->fetch(PDO::FETCH_ASSOC);

        return $chiffredaffaire;
    }

    public function getAllChiffreAffaire()
    {
        $query = $this->bd->prepare("SELECT SUM(montant_total) AS Chiffredaffaire,id_client FROM factures_tv WHERE type <> 'remboursement' GROUP BY id_client");
        $query->execute();

        $Allchiffredaffaire = $query->fetchAll(PDO::FETCH_ASSOC);

        return $Allchiffredaffaire;
    }

    public function getTurnoverBySite($site)
    {
        $query = $this->bd->prepare("SELECT SUM(montant_total) AS TurnoverBySite FROM factures_tv WHERE department_name=:site AND type <> 'remboursement'");
        $query->bindValue("site", $site);
        $query->execute();

        $CA_AllTime = $query->fetch(PDO::FETCH_ASSOC);

        return $CA_AllTime;
    }

    public function getTurnoverBySiteByYear($site, $annee)
    {
        $query = $this->bd->prepare(
            "SELECT 
                SUM(
                    CASE 
                        WHEN YEAR(date_saisie) =:annee THEN montant_total
                        
                        ELSE 0
                    END
                ) AS TurnoverByYear
            FROM 
                factures_tv
            WHERE 
                department_name = :site
                AND 
                type <> 'remboursement'    
            ;"
        );

        $query->bindValue("site", $site);
        $query->bindValue("annee", $annee);
        $query->execute();

        $TurnoverByYear = $query->fetch(PDO::FETCH_ASSOC);

        return $TurnoverByYear;
    }




    public function getTurnoverBySiteByMonthAndYear($site, $annee, $mois)
    {
        $query = $this->bd->prepare(
            "SELECT 
                SUM(
                    CASE 
                        WHEN 
                            YEAR(date_saisie) = :annee AND MONTH(date_saisie) = :mois 
                        THEN 
                            montant_total
                       
                        ELSE 
                            0
                    END
                ) AS Montant_total
            FROM 
                factures_tv
            WHERE 
                department_name = :site
                AND 
                type <> 'remboursement'
               ;"
        );


        $query->bindValue("site", $site);
        $query->bindValue("annee", $annee);
        $query->bindValue("mois", $mois);
        $query->execute();

        $TurnoverByMonthAndYear = $query->fetch(PDO::FETCH_ASSOC);

        return $TurnoverByMonthAndYear;
    }

    public function getTurnoverByWeek($site, $annee, $mois,$debut_semaine,$fin_semaine)
    {
        $query = $this->bd->prepare(
            "SELECT 
                SUM(
                    CASE 
                        WHEN 
                            YEAR(date_saisie) = :annee AND MONTH(date_saisie) = :mois 
                        THEN 
                            montant_total
                       
                        ELSE 
                            0
                    END
                ) AS Montant_total
            FROM 
                factures_tv
            WHERE 
                department_name = :site
                AND 
                type <> 'remboursement'
                AND
                DATE(date_saisie) >= :debut_semaine AND DATE(date_saisie)<=:fin_semaine 

               ;"
        );


        $query->bindValue("site", $site);
        $query->bindValue("annee", $annee);
        $query->bindValue("mois", $mois);
        $query->bindValue("debut_semaine", $debut_semaine);
        $query->bindValue("fin_semaine", $fin_semaine);
        $query->execute();

        $TurnoverByWeek = $query->fetch(PDO::FETCH_ASSOC);

        return $TurnoverByWeek;
    }



    public function getTurnoverBySiteByDay($site, $annee)
    {
        $query = $this->bd->prepare(
            "SELECT 
                SUM(
                    montant_total / DATEDIFF(date_sortie, date_entree)
                ) AS Montant_total,
                department_name
            FROM 
                factures_tv
            WHERE 
                department_name = :site
                AND YEAR(date_entree) = :annee
                AND type <> 'remboursement';"
        );

        $query->bindValue("site", $site);
        $query->bindValue("annee", $annee);
        $query->execute();

        $TurnoverBySiteByDay = $query->fetchAll(PDO::FETCH_ASSOC);

        return $TurnoverBySiteByDay;
    }

    public function getTurnoverByExploitantByYear($id_exploitant, $annee)
    {
        $query = $this->bd->prepare(
            "SELECT 
                SUM(
                    CASE 
                        WHEN YEAR(date_saisie) = :annee THEN montant_total
                        
                        ELSE 0
                    END
                ) AS TurnoverByYear
            FROM 
                factures_tv
            WHERE 
                id_client = :id_exploitant
                AND 
                type <> 'remboursement'
               ;"
        );

        $query->bindValue("id_exploitant", $id_exploitant);
        $query->bindValue("annee", $annee);
        $query->execute();

        $TurnoverByYear = $query->fetch(PDO::FETCH_ASSOC);

        return $TurnoverByYear;
    }


    public function getTurnoverByExploitantByMonthAndYear($id_exploitant, $annee, $mois)
    {
        $query = $this->bd->prepare(
            "SELECT 
                SUM(
                    CASE 
                        WHEN 
                            YEAR(date_saisie) = :annee AND MONTH(date_saisie) = :mois 
                        THEN 
                            montant_total
                       
                        ELSE 
                            0
                    END
                ) AS Montant_total
            FROM 
                factures_tv
            WHERE 
                id_client = :id_exploitant
                AND
                AND type <> 'remboursement'
                ;"
        );

        $query->bindValue("id_exploitant", $id_exploitant);
        $query->bindValue("annee", $annee);
        $query->bindValue("mois", $mois);
        $query->execute();

        $turnoverByExploitantByMonthAndYear = $query->fetch(PDO::FETCH_ASSOC);

        return $turnoverByExploitantByMonthAndYear;
    }


    public function getTurnoverByExploitantByDay($id_exploitant, $date)
    {
        $query = $this->bd->prepare(
            "SELECT 
                SUM(
                    CASE 
                        WHEN YEAR(date_saisie) = YEAR(:date) AND MONTH(date_saisie)= MONTH(:date) AND  DAY(date_saisie)= DAY(:date)  THEN
                            montant_total
                        ELSE
                            0
                    END
                ) AS Montant_total
            FROM 
                factures_tv
            WHERE 
                id_client = :id_exploitant
                AND
                type <> 'remboursement'
                
                ;"
        );

        $query->bindValue("id_exploitant", $id_exploitant);
        $query->bindValue("date", $date);
        $query->execute();

        $TurnoverBySiteByDay = $query->fetch(PDO::FETCH_ASSOC);

        return $TurnoverBySiteByDay;
    }


    public function getAllNotRentRooms()
    {
        $query = $this->bd->prepare("SELECT id_chambre,nom_chambre FROM chambres WHERE active='0' ");
        $query->execute();

        $chambres = $query->fetchAll(PDO::FETCH_ASSOC);
        return $chambres;
    }

    public function getLessEfficientService()
    {
        $query = $this->bd->prepare("SELECT department_name,SUM(montant_total) AS total_department FROM factures_tv WHERE type <> 'remboursement' GROUP BY department_name ORDER BY total_department ASC LIMIT 1; ");
        $query->execute();
        $LessEfficient = $query->fetch(PDO::FETCH_ASSOC);


        return $LessEfficient;
    }



    public function getMostEfficientService()
    {
        $query = $this->bd->prepare("SELECT department_name,SUM(montant_total) AS total_department FROM factures_tv WHERE type <> 'remboursement' GROUP BY department_name ORDER BY total_department DESC LIMIT 1; ");
        $query->execute();
        $MostEfficient = $query->fetch(PDO::FETCH_ASSOC);


        return $MostEfficient;
    }


    public function getLessEfficientServiceByExploitant($id_exploitant)
    {
        $query = $this->bd->prepare("SELECT department_name,SUM(montant_total) AS total_department FROM factures_tv WHERE id_client=:id_exploitant AND type <> 'remboursement' GROUP BY department_name ORDER BY total_department ASC LIMIT 1; ");
        $query->bindValue("id_exploitant", $id_exploitant);
        $query->execute();
        $LessEfficient = $query->fetch(PDO::FETCH_ASSOC);


        return $LessEfficient;
    }

    public function getMostEfficientServiceByExploitant($id_exploitant)
    {
        $query = $this->bd->prepare("SELECT department_name,SUM(montant_total) AS total_department FROM factures_tv WHERE id_client=:id_exploitant AND type <> 'remboursement' GROUP BY department_name ORDER BY total_department DESC LIMIT 1; ");
        $query->bindValue("id_exploitant", $id_exploitant);
        $query->execute();
        $MostEfficient = $query->fetch(PDO::FETCH_ASSOC);


        return $MostEfficient;
    }

    public function getLessEfficientServiceByExploitantByDay($id_exploitant, $date)
    {
        $query = $this->bd->prepare("SELECT department_name,SUM(montant_total) AS total_department FROM factures_tv WHERE id_client=:id_exploitant AND DATE(date_saisie) =:date AND type <> 'remboursement' GROUP BY department_name ORDER BY total_department ASC LIMIT 1; ");
        $query->bindValue("id_exploitant", $id_exploitant);
        $query->bindValue("date", $date);
        $query->execute();
        $LessEfficient = $query->fetch(PDO::FETCH_ASSOC);


        return $LessEfficient;
    }

    public function getMostEfficientServiceByExploitantByDay($id_exploitant, $date)
    {
        $query = $this->bd->prepare("SELECT department_name,SUM(montant_total) AS total_department FROM factures_tv WHERE id_client=:id_exploitant AND DATE(date_saisie) =:date AND type <> 'remboursement' GROUP BY department_name ORDER BY total_department DESC LIMIT 1; ");
        $query->bindValue("id_exploitant", $id_exploitant);
        $query->bindValue("date", $date);
        $query->execute();
        $MostEfficient = $query->fetch(PDO::FETCH_ASSOC);


        return $MostEfficient;
    }

    public function getLessEfficientServiceByExploitantByMonth($id_exploitant, $annee, $mois)
    {
        $query = $this->bd->prepare("SELECT department_name,SUM(montant_total) AS total_department FROM factures_tv WHERE id_client=:id_exploitant AND YEAR(DATE(date_saisie)) =:annee AND MONTH(DATE(date_saisie))= :mois AND type <> 'remboursement' GROUP BY department_name ORDER BY total_department ASC LIMIT 1; ");
        $query->bindValue("id_exploitant", $id_exploitant);
        $query->bindValue("mois", $mois);
        $query->bindValue("annee", $annee);
        $query->execute();
        $LessEfficient = $query->fetch(PDO::FETCH_ASSOC);


        return $LessEfficient;
    }

    public function getMostEfficientServiceByExploitantByMonth($id_exploitant, $annee, $mois)
    {
        $query = $this->bd->prepare("SELECT department_name,SUM(montant_total) AS total_department FROM factures_tv WHERE id_client=:id_exploitant AND YEAR(DATE(date_saisie)) =:annee AND MONTH(DATE(date_saisie))= :mois AND type <> 'remboursement'  GROUP BY department_name ORDER BY total_department DESC LIMIT 1; ");
        $query->bindValue("id_exploitant", $id_exploitant);
        $query->bindValue("mois", $mois);
        $query->bindValue("annee", $annee);
        $query->execute();
        $MostEfficient = $query->fetch(PDO::FETCH_ASSOC);


        return $MostEfficient;
    }


    public function getLessEfficientServiceByExploitantByYear($id_exploitant, $annee)
    {
        $query = $this->bd->prepare("SELECT department_name,SUM(montant_total) AS total_department FROM factures_tv WHERE id_client=:id_exploitant AND YEAR(DATE(date_saisie)) =:annee GROUP BY department_name ORDER BY total_department ASC LIMIT 1; ");
        $query->bindValue("id_exploitant", $id_exploitant);
        $query->bindValue("annee", $annee);
        $query->execute();
        $LessEfficient = $query->fetch(PDO::FETCH_ASSOC);


        return $LessEfficient;
    }

    public function getMostEfficientServiceByExploitantByYear($id_exploitant, $annee)
    {
        $query = $this->bd->prepare("SELECT department_name,SUM(montant_total) AS total_department FROM factures_tv WHERE id_client=:id_exploitant AND YEAR(DATE(date_saisie)) =:annee GROUP BY department_name ORDER BY total_department DESC LIMIT 1; ");
        $query->bindValue("id_exploitant", $id_exploitant);
        $query->bindValue("annee", $annee);
        $query->execute();
        $MostEfficient = $query->fetch(PDO::FETCH_ASSOC);


        return $MostEfficient;
    }

    public function getAllSiteByUserid($id_user)
    {
        $query = $this->bd->prepare("SELECT DISTINCT department_name FROM factures_tv WHERE id_client=:user AND department_name <> ''; ");
        $query->bindValue("user", $id_user);
        $query->execute();
        $Sites = $query->fetchAll(PDO::FETCH_ASSOC);


        return $Sites;
    }
}
