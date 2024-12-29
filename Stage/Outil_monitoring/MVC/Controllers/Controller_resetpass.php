<?php

class Controller_resetpass extends Controller{

    public function action_resetpass(){
        if((isset($_SESSION['adress'])) && (isset($_POST['newpass'])) && (isset($_POST['confirm_pass']))){
            if($_POST['confirm_pass'] >=7){

                if((preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).*$/", $_POST['confirm_pass']))){

                    if($_POST['newpass']  == $_POST['confirm_pass']){
                        $m=Model::getModel();
                        $user=$m->getUserByAdress($_SESSION['adress']);
                        $userid=$user['user_id'];

                        $verif=$m->checkIfPassAlreadyUse($userid,$_POST['newpass']);

                        if($verif == null){
                            $passhash=hash('sha256', $_POST['newpass']);
                            $m->UpdatePassByAdress($_SESSION['adress'],$passhash);
                            $m->putIntoPassLogs($userid,$passhash);
                            unset($_SESSION['adress']);
                            $this->render("login",[]);

                        } else{echo "Merci de saisir un mot de passe que vous n'avez jamais utilisé";}
                        
                        



                    } else{echo "Les mots de passe diffèrent";}

                } else{echo "Le mot de passe doit contenir au minimum 1 majuscule, 1 chiffre et 1 caratère spéciaux";}

            } else{echo "Le mot de passe doit faire au minimum 7 caractères";}
            
        }
        

       
        

    }


    public function action_default(){
        if(isset($_POST["code"])){
            $this->render('resetpass',[]);

        }else {
            $this->render('error404', []);

        }
       
    
        
    }



    
}

?>