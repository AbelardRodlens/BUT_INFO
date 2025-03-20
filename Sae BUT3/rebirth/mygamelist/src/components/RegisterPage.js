import React from "react";
import { Link } from "react-router-dom";
import { useState, useCallback } from "react";
import "./auth.css"; // Import du CSS
import fetchWrapper from "../fetchWrapper.js";

function RegisterPage() {

  const [succesMessage, setSuccesMessage] = useState("");
  const [errorMessage, setErrorMessage] = useState("");

  const registerHandler = useCallback(async (e) => {
    e.preventDefault();

    try {
     
      const form = e.target;
      const formData = new FormData(form); // Récupère les valeurs des champs du formulaire
      const data = {
        user_email: formData.get("email").trim(),
        user_username: formData.get("username").trim(),
        user_pass: formData.get("password").trim()
      };

      const response = await fetchWrapper("http://localhost:5001/auth/register", "POST", false, data);

      if (response.ok) {
        localStorage.setItem('registrationProcessus',"true");
        setSuccesMessage("Inscription réussie ! Veuillez vérifier votre e-mail pour finaliser votre inscription.");
        console.log("Processus d'inscription en cours.");
      } else {
        const errorData = await response.json();
        throw new Error(errorData.message || "Une erreur est survenue.");
      }

      form.reset();
    } catch (e) {
      if (e.message.includes('Invalid email')) {
        setErrorMessage("L'email renseigné n'est pas valide.");
      }
      else if (e.message.includes('Invalid username')) {
        setErrorMessage("Username doit contenir entre 7 et 35 caractères, ne pas commencer ou finir par \"-\", doit être composé uniquement de  lettres (a-z, A-Z), de chiffres (0-9), et de tirets (-) ps: pas en début ni fin de chaine.");
      }
      else if (e.message.includes('Invalid password')) {
        setErrorMessage("Le mot de passe doit contenir entre 8 et 128 caractères, inclure au moins une lettre minuscule (a-z), une lettre majuscule (A-Z), un chiffre (0-9), et un caractère spécial (@, $, !, %, , ?, & ou espace). Il ne doit pas contenir deux espaces consécutifs.")
      }
    }
    
  }, []);

  return (
    <div className="auth-page">
      {/* Section gauche : texte d'accueil */}
      <div className="welcome-section">
      <h1>Bienvenue sur <Link to="/" className="gameverse-link"> GameVerse</Link></h1>
        <p>Créez un compte pour commencer à organiser votre collection de jeux.</p>
      </div>

      {/* Section droite : formulaire d'inscription */}
      <div className="login-section">
        <h2>Inscription</h2>
        <form onSubmit={registerHandler}>
        <div class="input-group">
        <input type="text" name="username" id="text" class="input" required />
          <label For="text" class="user-label">Nom d'utilisateur</label> 
        </div>
        <div class="input-group">
        <input type="email" name="email" id="email" class="input" required />
        <label for="email" class="user-label">Email</label>
      </div>

          <div class="input-group">
          <input type="password" name="password" id="password" class="input" required />
          <label For="password" class="user-label">Mot de passe</label>
          </div>
          <button type="submit">S'inscrire</button>
          {succesMessage && (<p style={{ color: "green" }}>{succesMessage}</p>)}
          {errorMessage && (<p style={{ color: "red" }}>{errorMessage}</p>)}

        </form>
        <p>
          Déjà inscrit ? <Link to="/login">Connectez-vous ici</Link>
        </p>
      </div>
    </div>
  );
}

export default RegisterPage;
