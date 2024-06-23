<?php require "view_begin_html.php" ?>
<title>Authentification</title>
<style>

body {
  width: 100%;
  height: 100%;
  background-image: url("Content/img/Background.jpg");
  background-size: cover;
  height:100vh;
  background-repeat: no-repeat;
  text-align: center;
  justify-content: center;
  overflow: hidden; /* Pour éviter le défilement horizontal */
}

div{
  height:100%;
}

#Login {
  max-width: 100%;
  max-height: 100%;
  display: flex;
  justify-content: center; /* Centrage horizontal */
}

.fond-uspn {
  width: 45vw; /* Utilisation de vw pour la largeur */
  max-height: 80vh;
  padding: 15vh;
  padding-left: 0;
  height: auto;
  margin: 0;

}

#login-rectangle {
  margin-left:-15vh;
  margin-top: 15vh;
  background-color: #ECF0FF;
  border-radius: 0px 20px 20px 0px;
  max-width:80vw; /* Utilisation de vw pour la largeur */
  height:70vh;
  width:25vw;
}


.logo-uspn {
  margin-top: 10%;
  max-height: 20%;
  max-width: auto;
}

form {
  display: flex;
  flex-direction: column;
}

input {
  padding: 3%;
  text-align: center;
  margin-right: 10%;
  margin-left: 10%;
  margin-top: 8%;
  border: white 0px;
  border-radius: 20px;
  font-family: 'Inria Sans', sans-serif;
  font-size: 90%;
}

button {
  background-color: #3B446D;
  margin-bottom: 0;
  border-radius: 25px;
  padding: 2%;
  margin-left: 30%;
  margin-right: 30%;
  color: aliceblue;
  font-size: 100%;
  font-family: 'Itim', cursive;
}

a {
  text-decoration: none;
  margin: 3%;
  text-align: end;
  color: black;
  margin-right: 10%;
  font-family: 'Inter', sans-serif;
  font-size: 80%

}

@media (max-width: 950px) {
 
  #login-rectangle {
  margin-left:0;
  background-color: #ECF0FF;
  border-radius: 0px 20px 20px 0px;
  height:70vh;
  width:70vw;
}
.fond-uspn {
  width: 75vw; /* Utilisation de vw pour la largeur */
  max-height: 80vh;
  padding: 15vh;
  padding-right:0;
  padding-left: 0;
  height: auto;
  margin: 0;

}
  input {
      padding: 9px;
      text-align: center;
      margin-right: 10%;
      margin-left: 10%;
      margin-top: 2%;
      border: white 0px;
      border-radius: 20px;
      font-family: 'Inria Sans', sans-serif;
      font-size: 80%;
  }
  
  button {
      background-color: #293357;
      margin-bottom: 7%;
      border: 0;
      border-radius: 25px;
      padding: 2%;
      margin-left: 25%;
      margin-right: 25%;
      color: aliceblue;
      font-size: 90%;
      font-family: 'Itim', cursive;
  }
  
  a {
      text-decoration: none;
      margin: 2%;
      text-align: end;
      color: black;
      margin-right: 10%;
  
  }
}


@media (max-width: 490px) {
  #Login {
      max-width: 100%;
      max-height: 100%;
      display: flex;
      justify-content: center; /* Centrage horizontal */
  }
  .fond-uspn{
      padding: 0;
      width: 0;
      height: 0;
  }
  #login-rectangle{
      transform: scale(1.15);
      border-radius:20px 20px 20px 20px;
  }
  input {
      padding: 15px;
      text-align: center;
      margin-right: 10%;
      margin-left: 10%;
      margin-top: 7%;
      border: white 0px;
      border-radius: 20px;
      font-family: 'Inria Sans', sans-serif;
      font-size: 70%;
  }
  
  button {
      background-color: #293357;
      margin-bottom: 7%;
      border: 0;
      border-radius: 25px;
      padding: 5%;
      margin-left: 25%;
      margin-right: 25%;
      color: aliceblue;
      font-size: 70%;
      font-family: 'Itim', cursive;
  }
  
  a {
      text-decoration: none;
      margin: 2%;
      text-align: end;
      color: black;
      margin-right: 10%;
  
  }

}
@media screen and (orientation: landscape) and (max-width: 1024px) {

  button {
  background-color: #3B446D;
  margin-bottom: 0;
  height:100%;
}
    
}
</style>
<div id="Login">
        <img src="Content/img/image-spn0.png" class="fond-uspn">
        <div id="login-rectangle"><img src="Content/img/logo-spn0.png" class="logo-uspn">
            <form action="index.php?controller=login&action=login1" method="post">
                
                <input type="text" id="username" name="username"  placeholder="Nom d'utilisateur">
                <br>
                <input type="password" id="password" name="password" placeholder="Mot de passe">
                <a href="index.php?controller=resetpass">Mot de passe oublié ?</a>

                <br>
                
                <button type="submit" name="submit">CONNEXION</button>
            </form>
        </div>
    </div>

<?php require "view_end_html.php"?>
