import React from "react";
import { Link } from "react-router-dom";
import "./auth.css"; // Import du CSS

function RegisterPage() {
  return (
    <div className="auth-page">
      {/* Section gauche : texte d'accueil */}
      <div className="welcome-section">
        <h1>Bienvenue sur GameVerse</h1>
        <p>Créez un compte pour commencer à organiser votre collection de jeux.</p>
      </div>

      {/* Section droite : formulaire d'inscription */}
      <div className="login-section">
        <h2>Inscription</h2>
        <form>
          <input type="text" placeholder="Nom d'utilisateur" />
          <input type="email" placeholder="Email" />
          <input type="password" placeholder="Mot de passe" />
          <button type="submit">S'inscrire</button>
        </form>
        <p>
          Déjà inscrit ? <Link to="/login">Connectez-vous ici</Link>
        </p>
      </div>
    </div>
  );
}

export default RegisterPage;
