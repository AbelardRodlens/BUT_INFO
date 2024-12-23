<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Controller_passforgot extends Controller{

    public function action_passforgot(){
        if(isset($_POST["submit"])){
            echo"submit";
            $m=Model::getModel();
            $user=$m->getUserByAdress($_POST["adress"]);
            if($user == true){

                $mail = new PHPMailer(true);
                
                try {
                    $code=random_int(100000,999999);
                    if(session_status() == PHP_SESSION_NONE){
                        session_start();
                    }
                    
                    $_SESSION["code"]=$code;
                    $_SESSION["adress"]=$_POST["adress"];
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
                    $mail->addAddress($_POST['adress'] , $user['username']);
                    $mail->Subject = "AVI... Changement De Mot De Passe" ;
                    $mail->Body = "Bonjour, voici votre code:".$code;   
                
                    // Ajoute l'en-tête Return-Path
                    $mail->addCustomHeader('Return-Path: rycou123@gmail.com');
                
                    // Envoi de l'e-mail
                    $mail->send();
                    echo "e-mail a été envoyé avec succès.";
                    extract([$code]); // utilité à vérifier
                    header('Location:index.php?controller=verif_code&action=default');
                    exit;
                    

    
                } catch (Exception $e) {
                    echo 'Erreur lors de l\'envoi de l\'e-mail : ', $mail->ErrorInfo;
                } 

            
                }

            }else {
                
                $this->render("login", []);
            }

            
        }
        

       
        

    public function action_default(){
        $this->render("passforgot",[]);
    
       
    }


    
    }


    



    


?>