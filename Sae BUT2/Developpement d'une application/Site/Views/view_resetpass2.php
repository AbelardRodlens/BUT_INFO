<?php require "view_begin_html.php";?>
<style>
body {
    display:flex;
    height:100vh;
    background-color:white;
    justify-content:center;
    align-items:center;
    

   
  }

#resetpass-div{
    display:flex;
    justify-content:center;
    align-items:center;
    width:50vh;
    height:70vh;
    
    box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
   
}


.pass-input{
    height:5vh;
    width:40vh;

}

#resetpass-submit{
    margin-top:2vh;
    height:6vh;
    width:41vh;
    color:white;
    background-color:#293658;
    
}

#resetpass-form{
    margin-top:8vh;
    margin-left:4.3vh;
    
}

#logo-uspn{
    position:absolute;
    
    max-height:10vh;
    margin-bottom:50vh;
}

#resetpass-div p{
    position:absolute;
    color:#6c757c;
    

}

#msg-entrer-email{
    margin-bottom:22vh;
    margin-left:2vh;
    font-size:2.1vh;
}

#pass{
    margin-top:8vh;

    
}

#confirm-pass{
    margin-top:2vh;
    
    
}



</style>
    <title>Historique</title>
<body>


  <div id="resetpass-div">
    <img src="Content/img/logo-spn0.png" id="logo-uspn">
    <p id="msg-entrer-email">Entrer l'email associé à votre compte et <br/> nous vous enverrons un lien pour réinitialiser votre <br/> mot de passe.</p>
    <form action="http://localhost/php./outsiders_login5/index.php?controller=resetpass2&action=resetpass2&token=$token" method="post" id="resetpass-form">

        <input type="password" placeholder="Mot de passe" id="pass" class="pass-input" name="pass">
        <input type="password" placeholder="Confirmer Mot de passe" id="confirm-pass" class="pass-input" name="confirm-pass"><br/>
        <input type="submit" name="submit" value="Continuer" id="resetpass-submit">

    </form>
  </div>

<?php require "view_end_html.php"?>