import React, { useEffect, useState } from "react";
import "./GameDetails.css";
import Commentaire from "./Commentaires.js";
import fetchWrapper from "../fetchWrapper.js";
import { jwtDecode } from "jwt-decode";

function GameDetails({ game, onBack, added: initiallyAdded }) {
  const [artwork, setArtwork] = useState(null);
  const [video, setVideo] = useState(null);
  const [added, setAdded] = useState(initiallyAdded);

  const accessToken = localStorage.getItem('accessToken');
  let accesTokenData;
  if (accessToken) {
    accesTokenData = jwtDecode(accessToken);
  }
  const user_id = accesTokenData?.user_id;


   useEffect(() => {
     const checkIfGameInFavorites = async () => {
      try {
      
        const response = await fetchWrapper("http://localhost:5001/gamelist/", "GET", true, { user_id } );
    
        if (response.ok) {
          const responseBody = await response?.json();
          const currentFavorites = responseBody?.data;
          const isGameInFavorites = currentFavorites.some((fav) => fav.game_id === game.game_id);
          setAdded(isGameInFavorites);
        }
    
      } catch (e) {
          console.error("An error has occured: ",e.message);
      }
  
     }
  
     checkIfGameInFavorites();
    }, [game]);

    const handleAddToFavorites = async () => {
      const data = { 
        user_id,
        game_id: game.game_id 
      };
    
      try {
        const response = await fetchWrapper("http://localhost:5001/gamelist/add_game", "POST", true, data);
    
        if (response.ok) {
          console.log("Jeu ajouté.");
          setAdded(true); // Mise à jour immédiate de l'état
        } else {
          throw new Error("Problem encountered during list update");
        }
      } catch (e) {
        console.error("An error has occurred: ", e.message);
      }
    };

     const handleRemoveFavorites = async () => {
        if (!user_id) {
          console.error("L'identifiant utilisateur n'est pas défini.");
          return;
        }
    
        const data = {
          user_id,
          game_id: game.game_id
        };
    
        try {
          const response = await fetchWrapper(
            "http://localhost:5001/gamelist/del_game",
            "POST",
            true,
            data
          );
    
          if (response.ok) {

            setAdded(false);
            
          } else {
            console.error(
              `Erreur lors de la suppression du favori: ${response.statusText}`
            );
          }
        } catch (e) {
          console.error("Une erreur est survenue :", e.message);
        }
      };
    

  useEffect(() => {
    if (game.artworks && game.artworks.length > 0) {
      setArtwork(game.artworks[0]?.original);
    }

    if (game.videos && game.videos.length > 0) {
      const videoUrl = game.videos[0];
      const videoId = videoUrl.split("v=")[1]?.split("&")[0];
      setVideo(videoId);
    }
  }, [game]);

  const renderDataBlock = (title, content) => (
    <div className="data-block">
      <strong>{title}:</strong>
      <span>{content || "Pas d'information"}</span>
    </div>
  );

  const renderDataArray = (title, items) => (
    <div className="data-block">
      <strong>{title}:</strong>
      <div className="data-list">
        {items.length > 0 ? (
          items.map((item, index) => (
            <span key={index} className="data-item">{item}</span>
          ))
        ) : (
          <span>Pas d'information</span>
        )}
      </div>
    </div>
  );

  return (
    <div className="game-details">
      <button className="back-button" onClick={onBack}>
        Retour
      </button>

      <div className="artwork-container">
        {artwork ? (
          <img
            src={artwork}
            alt="Artwork du jeu"
            className="game-artwork"
          />
        ) : (
          <p>Aucun artwork disponible</p>
        )}
      </div>

      <div className="game-cover-container">
        <img
          src={game.cover?.original || ""}
          alt={game.title || "Couverture indisponible"}
          className="game-cover"
        />
        <button
          className={`add-button ${added ? 'added' : ''}`}
          onClick={added ? handleRemoveFavorites : handleAddToFavorites}
          
        >
          {added ? 'Ajouté' : (
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="30px"
              height="30px"
              viewBox="0 0 24 24"
              className="icon"
            >
              <path
                d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z"
                strokeWidth="1.5"
                fill="none"
              ></path>
              <path d="M8 12H16" strokeWidth="1.5" fill="none" stroke="white"></path>
              <path d="M12 16V8" strokeWidth="1.5" fill="none" stroke="white"></path>
            </svg>
          )}
        </button>
      </div>

      <h2 className="game-title">{game.title || "Titre indisponible"}</h2>

      <div className="game-meta">
        {renderDataBlock("Description", game.description?.fr || game.description || "Pas d'information")}
        {renderDataArray("Genres", game.genres?.fr || game.genres || [])}
        {renderDataArray("Plateformes", game.platforms || [])}
        {renderDataArray("Développeurs", game.developers || [])}
        {renderDataArray("Éditeurs", game.publishers || [])}
        {renderDataArray("Modes de jeu", game.game_modes?.fr || game.game_modes || [])}
        {renderDataArray("Perspectives du joueur", game.player_perspectives?.fr || game.player_perspectives || [])}
        {renderDataArray("Thèmes", game.themes?.fr || game.themes || [])}
        {renderDataBlock("Date de sortie", game.release_date || "Pas d'information")}
        {renderDataArray("Franchise", game.franchises || ["Pas d'information"])}
        {renderDataArray("DLC", game.dlcs?.length > 0 ? game.dlcs : ["Pas de DLC"])}
        {renderDataArray("Moteur de jeu", game.game_engines || ["Pas d'information"])}

        {video ? (
          <div className="data-block">
            <strong>Vidéo:</strong>
            <iframe
              src={`https://www.youtube.com/embed/${video}`}
              title="Video trailer"
              allow="autoplay; encrypted-media"
              allowFullScreen
              className="video-iframe"
            />
          </div>
        ) : (
          <div className="data-block">
            <strong>Vidéo:</strong> Non disponible
          </div>
        )}
      </div>

      <div className="comments-section">
        <Commentaire />
      </div>
    </div>
  );
}

export default GameDetails;
