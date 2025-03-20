import React from "react";
import { Link } from "react-router-dom";
import { useState, useEffect, useCallback } from "react";
import "./auth.css";
import fetchWrapper from "../fetchWrapper.js";

function LoginPage() {

  const [emailValue, setEmailValue] = useState("");
  const [passValue, setPasslValue] = useState("");
  const [errorMessage, setErrorMessage] = useState("");
  

  useEffect(() => {
    const checkAuthentication = async () => {
      const response = await fetchWrapper("http://localhost:5001/auth/status", "GET", true);
      
      const data = await response?.json();
      

      if (data?.redirectUrl && data?.newAccessToken){
        // Mettre à jour accesToken
        localStorage.setItem('accesToken', data?.newAccessToken);
        // Rediriger immédiatement si l'utilisateur est connecté
        window.location.href = data.redirectUrl;
      } 

      else if (data?.isConnected){
        window.location.href = "/";
      }

    };
  
    // Vérifier l'authentification dès le chargement de la page
    checkAuthentication();
  },[])

  
  

  const submitHandler = useCallback(async (e) => {
    e.preventDefault();

    const data = {
      user_email: emailValue,
      user_pass: passValue,
    };

    try {
      const response = await fetchWrapper("http://localhost:5001/auth/login_process", "POST", false, data);

      const responseBody = await response?.json();

      if (!response.ok) {
        throw new Error(responseBody?.message || "An error has occurred.");
      }

      const accessToken = responseBody?.data;
      localStorage.setItem("accessToken", accessToken);

      setErrorMessage(""); // Réinitialise l'erreur

      console.log("Connexion réussie");
      window.location.href = "/";
    } catch (e) {
      if (e.message.includes("The account is not activated")){
        setErrorMessage("Your account is not activated. Please complete the registration.");

      } else {
        setErrorMessage(e.message);
      }
    
    }
  }, [emailValue, passValue]); // Redéfini uniquement si ces valeurs changent

  
  const checkRegistrationFinalization = useCallback( async () => {
    try {
      const queryParams = new URLSearchParams(window.location.search);
      const registrationToken = queryParams.get('token');

      if (registrationToken) {
        const response = await fetchWrapper("http://localhost:5001/user/registration_finalization", "POST", false, {registrationToken});

        if (response.ok) {
          localStorage.removeItem('registrationProcessus');
          console.log("Inscription finalisée.");

          queryParams.delete('token');
          // const newUrl = `${window.location.pathname}?${queryParams.toString()}`;
          const newUrl = '/login';
          window.history.replaceState(null, '', newUrl);
        }
      }
    } catch (e) {
      console.error("An error has occured: ", e.message);
    }
  }, []);

  checkRegistrationFinalization();
  return (
    <div className="auth-page">
      {/* Section gauche avec le texte d'accueil */}
      <div className="welcome-section">
  <h1>Bienvenue sur <Link to="/" className="gameverse-link"> GameVerse</Link></h1>
  <p>
    Découvrez, suivez et organisez votre collection de jeux en toute simplicité.
    <br />
    <em>Le jeu n'est pas seulement un divertissement, c'est une aventure où chaque choix façonne notre destin, comme un capitaine qui guide son navire à travers l'océan de possibilités.</em>
  </p>
</div>


      {/* Section droite avec le formulaire */}
      <div className="login-section">
        <h2>Connexion</h2>
        <form onSubmit={submitHandler}>
        <div class="input-group">
        <input type="email" id="email" class="input"  required  onChange={(e) => {setEmailValue(e.target.value)}}/>
        <label for="email" class="user-label">Email</label>
      </div>
      <div class="input-group">
        <input type="password" id="password" class="input" required  onChange={(e) => {setPasslValue(e.target.value)}}/>
        <label for="password" class="user-label">Mot de passe</label>
      </div>
          <button type="submit">Se connecter</button>
          { errorMessage && (<p className="error-message" style={{color: "red"}}>{errorMessage}</p>)}
        </form>
        <p>
          Pas encore inscrit ? <Link to="/register">Créez un compte</Link>
        </p>
        <p>
          Mot de passe oublié ? <Link to="/change-password">Changez-le ici</Link>
        </p>
        <p className="terms">
          En cliquant sur "Se connecter", vous acceptez nos{" "}
          <Link to="/terms">Conditions d'utilisation</Link> et notre{" "}
          <Link to="/privacy">Politique de confidentialité</Link>.
        </p>
      </div>
    </div>
  );
}

export default LoginPage;
