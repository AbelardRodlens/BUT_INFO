import React from "react";
import { Link } from "react-router-dom";
import "./auth.css"; // Import du CSS

function ChangePasswordPage() {
  return (
    <div className="auth-page">
      {/* Section gauche : texte d'accueil */}
      <div className="welcome-section">
        <h1>Bienvenue sur GameVerse</h1>
        <p>Vous avez oublié votre mot de passe ? Réinitialisez-le ci-dessous.</p>
      </div>

      {/* Section droite : formulaire de changement de mot de passe */}
      <div className="login-section">
        <h2>Changer le mot de passe</h2>
        <form>
          <input type="email" placeholder="Email" />
          <input type="password" placeholder="Nouveau mot de passe" />
          <button type="submit">Changer le mot de passe</button>
        </form>
        <p>
          Retour à la <Link to="/login">page de connexion</Link>
        </p>
      </div>
    </div>
  );
}

export default ChangePasswordPage;
