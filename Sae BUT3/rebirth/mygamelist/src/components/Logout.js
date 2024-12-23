import React from "react";
import { useNavigate } from "react-router-dom";

const Logout = () => {
  const navigate = useNavigate();

  const handleLogout = async () => {
    try {
      const response = await fetch("http://localhost:5001/logout", {
        method: "POST",
        credentials: "include", // Inclure les cookies
        headers:{
            'Authorization':`Bearer ${localStorage.getItem('accessToken')}`
        }
      });

      if (response.ok) {
        console.log("Déconnexion réussie.");
        
        localStorage.removeItem('accessToken');
        navigate("/"); // Rediriger vers la page d'accueil
      } else {
        console.error("Erreur lors de la déconnexion.");
      }
    } catch (error) {
      console.error("Erreur réseau :", error);
    }
  };

  return (
    <div>
      <h1>Déconnexion</h1>
      <input
        type="button"
        value="Se déconnecter"
        onClick={handleLogout}
      />
    </div>
  );
};

export default Logout;
