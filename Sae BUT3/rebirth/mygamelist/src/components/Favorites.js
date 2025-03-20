import React, { useState, useEffect } from "react";
import { useNavigate, Link } from "react-router-dom";
import "./Favorites.css";
import GameDetails from "./GameDetails.js";
import fetchWrapper from "../fetchWrapper.js";
import { jwtDecode } from "jwt-decode";

const Favorites = () => {
  const [favorites, setFavorites] = useState([]);
  const [selectedGame, setSelectedGame] = useState(null);
  const navigate = useNavigate();

  // Décodage du token pour récupérer l'utilisateur connecté
  const accessToken = localStorage.getItem("accessToken");
  let accesTokenData = null;
  if (accessToken) {
    try {
      accesTokenData = jwtDecode(accessToken);
    } catch (e) {
      console.error("Erreur de décodage du token:", e.message);
    }
  }
  const user_id = accesTokenData?.user_id;

  
  // Récupérer les favoris depuis l'API
  useEffect(() => {
    const fetchFavorites = async () => {
      if (!user_id) {
        console.error("L'identifiant utilisateur n'est pas défini.");
        return;
      }

      try {
        const response = await fetchWrapper(
          "http://localhost:5001/gamelist/",
          "GET",
          true,
          { user_id } // Passer le user_id en paramètre
        );

        if (response.ok) {
          const responseBody = await response.json();
          setFavorites(responseBody?.data || []);
          if (responseBody?.newAccessToken) {
            localStorage.setItem("accessToken", responseBody?.newAccessToken);
          }
        } else {
          console.error(
            `Erreur lors de la récupération des favoris: ${response.statusText}`
          );
        }
      } catch (e) {
        console.error("Une erreur est survenue :", e.message);
      }
    };

    fetchFavorites();
  }, [user_id]);

  

  // Suppression d'un favori
  const handleRemoveFavorite = async (gameId) => {
    if (!user_id) {
      console.error("L'identifiant utilisateur n'est pas défini.");
      return;
    }

    const data = {
      user_id,
      game_id: gameId,
    };

    try {
      const response = await fetchWrapper(
        "http://localhost:5001/gamelist/del_game",
        "POST",
        true,
        data
      );

      if (response.ok) {
        const requestForData = await fetchWrapper(
          "http://localhost:5001/gamelist/",
          "GET",
          true,
          {user_id}
        );

        if(requestForData.ok) {
          const requestBody = await requestForData?.json();
          setFavorites(requestBody?.data || []); // Mettre à jour la liste locale
          if (requestBody.data?.newAccessToken) {
            localStorage.setItem("accessToken", requestBody.data?.newAccessToken);
          }
        }
        
      } else {
        console.error(
          `Erreur lors de la suppression du favori: ${response.statusText}`
        );
      }
    } catch (e) {
      console.error("Une erreur est survenue :", e.message);
    }
  };

  // Sélection d'un jeu pour afficher ses détails
  const handleGameSelect = async (game) => {
    // setSelectedGame(game);
    try {
      // Fetch game details using the game_id from the backend
      const response = await fetchWrapper(
        `http://localhost:5001/game/${game.game_id}`,
        "GET",
        true
      );
  
      if (response.ok) {
        const detailedGame = await response.json();
        setSelectedGame(detailedGame); // Set the detailed game in state
      } else {
        console.error(
          `Erreur lors de la récupération des détails du jeu: ${response.statusText}`
        );
      }
    } catch (e) {
      console.error("Une erreur est survenue :", e.message);
    }
    window.scrollTo(0, 0);
  };

  // Retour à la liste des favoris
  const handleBack = () => {
    setSelectedGame(null);
  };

  // Rendu des détails d'un jeu si sélectionné
  if (selectedGame) {
    console.log(selectedGame)
    return <GameDetails game={selectedGame} onBack={handleBack} added />;
  }
  

  // Rendu principal
  return (
    <div className="favorites">
      <button className="back-button" onClick={() => navigate(-1)}>
        Retour
      </button>
      <h2 className="favorites-title">Vos jeux favoris</h2>
      {favorites.length === 0 ? (
        <div className="no-favorites">
          <p>Vous n'avez pas de jeu en favoris.</p>
          <Link to="/">Cherchez vos jeux préférés</Link>
        </div>
      ) : (
        <div className="favorites-grid">
          {favorites.map((game, index) => (
            <div
              key={game.id || index}
              className="favorite-item"
              onClick={() => handleGameSelect(game)}
            >
              <img
                src={game.cover?.original || "/images/default-cover.png"}
                alt={game.title}
                className="favorite-cover"
              />
              <p className="favorite-title">{game.title}</p>
              <button
                onClick={(e) => {
                  e.stopPropagation(); // Empêche l'ouverture des détails
                  handleRemoveFavorite(game.game_id);
                }}
                className="remove-button"
              >
                x
              </button>
            </div>
          ))}
        </div>
      )}
    </div>
  );
};

export default Favorites;
