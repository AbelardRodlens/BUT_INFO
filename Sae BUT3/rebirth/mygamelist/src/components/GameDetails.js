import React, { useEffect, useState } from "react";
import "./GameDetails.css";

function GameDetails({ game, onBack }) {
  const [artwork, setArtwork] = useState(null);
  const [video, setVideo] = useState(null);

  useEffect(() => {
    if (game.artworks && Array.isArray(game.artworks)) {
      const firstArtwork = game.artworks.find((artwork) => artwork.original);
      setArtwork(firstArtwork ? firstArtwork.original : null);
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
      <span>{content}</span>
    </div>
  );

  const renderDataArray = (title, items) => (
    <div className="data-block">
      <strong>{title}:</strong>
      <div className="data-list">
        {items.map((item, index) => (
          <span key={index} className="data-item">{item}</span>
        ))}
      </div>
    </div>
  );

  return (
    <div className="game-details">
      <button className="back-button" onClick={onBack}>
        Retour
      </button>

      <div className="artwork-container">
        {artwork && <img src={artwork} alt="Artwork du jeu" className="game-artwork" />}
      </div>

      <div className="game-cover-container">
        <img src={game.cover?.original} alt={game.title} className="game-cover" />
      </div>

      <h2 className="game-title">{game.title || "Titre indisponible"}</h2>

      <div className="game-meta">
      {game.description && (
  <div className="data-block description">
    <strong>Description:</strong>
    <span>{game.description}</span>
  </div>
)}

        {game.genres && game.genres.length > 0 && renderDataArray("Genres", game.genres)}
        {game.platforms && game.platforms.length > 0 && renderDataArray("Plateformes", game.platforms)}
        {game.developers && game.developers.length > 0 && renderDataArray("Développeurs", game.developers)}
        {game.publishers && game.publishers.length > 0 && renderDataArray("Éditeurs", game.publishers)}
        {game.game_modes && game.game_modes.length > 0 && renderDataArray("Modes de jeu", game.game_modes)}
        {game.player_perspectives && game.player_perspectives.length > 0 && renderDataArray("Perspectives du joueur", game.player_perspectives)}
        {game.themes && game.themes.length > 0 && renderDataArray("Thèmes", game.themes)}
        {game.release_date && renderDataBlock("Date de sortie", game.release_date)}
        {game.franchises && game.franchises.length > 0 && renderDataArray("Franchise", game.franchises)}
        {game.dlcs && game.dlcs.length > 0 && renderDataArray("DLC", game.dlcs)}
        {game.game_engines && renderDataBlock("Moteur de jeu", game.game_engines)}
       
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
    </div>
  );
}

export default GameDetails;
