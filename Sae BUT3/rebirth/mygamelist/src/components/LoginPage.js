import React, { useState } from "react";
import { Link, redirect } from "react-router-dom";
import "./auth.css";
import { useEffect } from "react";

function LoginPage() {

  const [userEmail, setUserEmail] = useState("");
  const [userPass, setUserPass] = useState("");
  const [errorMessage, setErrorMessage] = useState(null);

  useEffect(() => {
    const accessToken = localStorage.getItem("accessToken")

    const headers = {}

    if (accessToken) {
      headers["Authorization"] = `Bearer ${accessToken}`;
    }

    const checkAuthentification = async () => {
      const response = await fetch("http://localhost:5001/login", {
        method: "GET",
        credentials: "include",
        headers:headers
      });
  
      const data = await response.json();

      if (data.newAccessToken) {
        localStorage.setItem('accessToken',data.newAccessToken);
      }

      if (accessToken && data.removeAccessToken) {
        localStorage.removeItem('accessToken');
      } 

      if (data.redirectUrl) {
        // Rediriger immédiatement si l'utilisateur est connecté
        window.location.href = data.redirectUrl;
      }
    };
  
    // Vérifier l'authentification dès le chargement de la page
    checkAuthentification();
  },[])

  const handleLogin = async (e) => {
    e.preventDefault();

    const response = await fetch("http://localhost:5001/login_process",{
      method:"POST",
      headers: {
        "Content-Type": "application/json",
      },
      credentials: "include",
      body:JSON.stringify({
        user_email: userEmail,
        user_pass: userPass,
      }),
    });

    const data = await response.json();

    if (response.ok){
      // Stocker le token dans le localStorage
      localStorage.setItem("accessToken",data.accessToken);

      // Rediriger l'user après la réussite de la connexion
      window.location.href = "/";
     
    } else {
      setErrorMessage(data.message || "Erreur lors de la connexion");
    }
  }



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
        <form onSubmit={handleLogin}>
          <input type="email" placeholder="Adresse email" value={userEmail} onChange={(e) => setUserEmail(e.target.value)} />
          <input type="password" placeholder="Mot de passe"  value={userPass} onChange={(e) => setUserPass(e.target.value)} />
          {errorMessage && <p style ={{ color:"red"}}>{errorMessage}</p>}
          <button type="submit">Se connecter</button>
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
