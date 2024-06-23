
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// ce conroller n'est pas encore utilisé 
class Controller_resetpass extends Controller
{

    public function action_resetpass(){
        $m = Model::getModel();
        $this->render("resetpass", []);
    }




        public function action_resetpass1() {
            
            
            if(isset($_POST["submit"])){
             $m = Model::getModel();
             $verif=$m->getPassByEmail($_POST["email"]);
             if($verif ==true){
                require 'vendor/autoload.php';
    
                
               
                $envoyer="non";
                if (isset( $_POST["email"]) && $envoyer=="non"){
                
                $mail = new PHPMailer(true);
                
                try {
                    $token = bin2hex(random_bytes(32));
                    // Paramètres du serveur SMTP (Gmail)
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'rycou123@gmail.com';
                    $mail->Password = 'wpdh jyer jtah odmt';
                    $mail->SMTPSecure = 'tls'; // ssl ou tls
                    $mail->Port = 587;
                
                    // Paramètres du message
                    $mail->setFrom("rycou123@gmail.com", "Sorbonne Paris Nord");
                    $mail->addAddress($_POST['email'] , $_POST["email"]);
                    $mail->Subject = "Sorbonne Paris Nord Changement De Mot De Passe" ;
                    $mail->Body = "Bonjour, voici le lien pour changer votre mot de passe:"."http://localhost/php./outsiders_login5/index.php?controller=resetpass2&token=$token";   
                
                    // Ajoute l'en-tête Return-Path
                    $mail->addCustomHeader('Return-Path: rycou123@gmail.com');
                
                    // Envoi de l'e-mail
                    $mail->send();
                    $a1="e-mail a été envoyé avec succès.";
                    echo $a1;
                    $envoyer="oui";
                    session_start();
                    $_SESSION['reset_token'] = $token;
                    $_SESSION['email']=$_POST['email'];

                    header("Location: index.php");
                    
                    
                    
            
                } catch (Exception $e) {
                    echo 'Erreur lors de l\'envoi de l\'e-mail : ', $mail->ErrorInfo;
                } 

             $this->render("login", $token);
                };
             

            
            
            
             
        }else {
            $this->render("error", []);
        }
    }
    }


        



        public function action_default()
    {
        $this->action_resetpass();
    }

    }