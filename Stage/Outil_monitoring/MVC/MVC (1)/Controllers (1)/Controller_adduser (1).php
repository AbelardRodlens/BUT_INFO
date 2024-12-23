<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Controller_adduser extends Controller{

    public function action_adduser(){
        
        if(isset($_POST['submit']) && isset($_POST["username"]) && isset($_POST["adress"]) && isset($_POST["role"]) ){
            
            $m=Model::getModel();

            $verification=$m->getUserByUsername($_POST["username"]);
            
            if($verification == null){
                $pass="Av".random_int(10000, 99999)."**";
                $m->addUser($_POST["username"],$_POST["adress"],$pass);

                if($_POST["role"] == "oui"){
                    echo "donne role";
                    $m->giveAdminRole($_POST["username"]);
                }
                $mail = new PHPMailer(true);
                    
                try {
                    
                    
                    // Paramètres du serveur SMTP (Gmail)
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'rycou123@gmail.com';
                    $mail->Password = 'wpdh jyer jtah odmt';
                    $mail->SMTPSecure = 'tls'; // ssl ou tls
                    $mail->Port = 587;
                
                    // Paramètres du message
                    $mail->setFrom("rycou123@gmail.com", "AVI...");
                    $mail->addAddress($_POST['adress'] , $_POST['username']);
                    $mail->Subject = "Vos Identifiants Avi..." ;
                    $mail->Body = "Bonjour, voici votre mot de passe Avi...:".hash('sha256', $pass);   
                
                    // Ajoute l'en-tête Return-Path
                    $mail->addCustomHeader('Return-Path: rycou123@gmail.com');
                
                    // Envoi de l'e-mail
                    $mail->send();
                    echo "e-mail a été envoyé avec succès.";
                    header('Location:index.php?controller=adduser');
                    exit;
                    


                } catch (Exception $e) {
                    echo 'Erreur lors de l\'envoi de l\'e-mail : ', $mail->ErrorInfo;
                }

                

            }else {echo "utilisateur déjà existant";
                   $this->render("adduser",[]);}
            


        } else {echo "Veuillez remplir tout les champs.";
                $this->render("adduser",[]);}
        

        
        

    }

    



    public function action_default(){
        // if(isset($_SESSION["role"]) && ($_SESSION["role"]=="admin")){
        //     $this->render("adduser",[]);
        // } else { $this->render("error404",[]);}

        $this->render("adduser",[]);
       
    }



    
}

?>