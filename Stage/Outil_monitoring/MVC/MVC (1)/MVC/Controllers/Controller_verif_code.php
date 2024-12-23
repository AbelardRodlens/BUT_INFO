<?php

class Controller_verif_code extends Controller{

    public function action_verif_code(){
        
        if(isset($_POST["submit"]) && ($_POST["code"] == $_SESSION["code"])){
            unset($_SESSION['code']);
           $this->render("resetpass",[]);
           


        }else {
            echo "Code erronée";
            
            
        }
        

    }


    public function action_default(){
        if(isset($_SESSION["code"])){
            $this->render("verif_code",[]);
            
            
            

        } else{
            $this->render("error404",[]);
            
        
        }
    
        
    }



    
}

?>