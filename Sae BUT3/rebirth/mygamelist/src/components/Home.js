import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom"; // Importation de Link
import "./Home.css";
import SearchBar from "./SearchBar.js";
import Carousel from "./Carousel.js";
import GameDetails from "./GameDetails.js";

// Fonction pour récupérer les jeux par genre depuis l'API
const fetchTopRatedGamesByGenre = async (genre) => {
  try {
    const response = await fetch(`http://localhost:5001/top_rated_games_by_genre?genre=${genre}`);
    const data = await response.json();
    return data;
  } catch (error) {
    console.error("Erreur lors de la récupération des jeux par genre :", error);
    return [];
  }
};

function Home() {
  const [isSearching, setIsSearching] = useState(false); // Indique si la recherche est active
  const [selectedGame, setSelectedGame] = useState(null); // Contient le jeu sélectionné
  const [gamesByGenre, setGamesByGenre] = useState({
    Platform: [],
    Adventure: [],
    "Role-playing (RPG)": [],
  });

  // Charger les jeux par genre lors du montage du composant
  useEffect(() => {
    const loadGamesByGenre = async () => {
      const platformGames = await fetchTopRatedGamesByGenre("Platform");
      const adventureGames = await fetchTopRatedGamesByGenre("Adventure");
      const rpgGames = await fetchTopRatedGamesByGenre("Role-playing (RPG)");

      setGamesByGenre({
        Platform: platformGames,
        Adventure: adventureGames,
        "Role-playing (RPG)": rpgGames,
      });
    };

    loadGamesByGenre();
  }, []);

  // Active la recherche
  const handleSearchClick = () => {
    setIsSearching(true);
    setSelectedGame(null); // Réinitialise le jeu sélectionné
  };

  // Gestion de la sélection d'un jeu
  const handleGameSelect = (game) => {
    setSelectedGame(game);
    window.scrollTo(0, 0); // Remonter en haut de la page
  };

  // Retourne à la recherche ou à la page d'accueil
  const handleBack = () => {
    if (selectedGame) {
      setSelectedGame(null);
    } else {
      setIsSearching(false);
    }
  };

  // Vue : Affichage des détails du jeu sélectionné
  if (selectedGame) {
    return <GameDetails game={selectedGame} onBack={handleBack} />;
  }

  // Vue : Recherche active
  if (isSearching) {
    return (
      <div className="search-only">
        <div className="search-header">
          <button className="back-button" onClick={handleBack}>
            Retour
          </button>
          <SearchBar images={Object.values(gamesByGenre).flat()} onGameSelect={handleGameSelect} />
        </div>
      </div>
    );
  }

  // Vue : Accueil avec les carrousels
  return (
    <div className="home">
      <header className="header">
        <div className="logo">
          <span className="logo-text">GameVerse</span>
          <img src="/images/logo.png" alt="Logo" className="logo-img" />
        </div>
        <nav className="nav-icons">
          <button onClick={handleSearchClick} className="search-logo-button">
            <img src="/images/search.svg" alt="Logo de recherche" className="search-logo" />
          </button>
          <Link to="/favorites"> {/* Utilisation de Link */}
            <i className="icon-favorite">
              <img src="/images/favorite.svg" alt="favorite" />
            </i>
          </Link>
          <Link to="/login"> {/* Utilisation de Link */}
            <i className="icon-login">
              <img src="/images/profile.svg" alt="login" />
            </i>
          </Link>
        </nav>
      </header>

      <div className="cover-section">
        <img
          src="/images/affiche3.jpg"
          alt="Découvrez les jeux"
          className="cover-image"
        />
        <div className="cover-text">
          <h1 className="main-title">
            Découvrez les Meilleurs Jeux Vidéo<br />
            <span className="secondary-title">
              Trouvez. Explorez et Favorisez vos Nouveautés !
            </span>
          </h1>
          <p className="sub-title">
            Explorez des milliers de jeux vidéos dans toutes les catégories. Trouvez
            ce qui vous correspond le mieux grâce à notre moteur de recherche
            intuitif.<br /> Découvrez les jeux les mieux notés dans chaque catégorie et
            consultez les classements les plus populaires pour ne jamais manquer les
            incontournables.
          </p>
        </div>
      </div>

      <section className="trending">
        <h2>Les jeux les plus appréciés</h2>
        <div className="carousel-container">
          {["Platform", "Adventure", "Role-playing (RPG)"].map((genre, index) => {
            const topGames = gamesByGenre[genre];

            return (
              <div key={index} className="genre-section">
                <h3 className="genre-title">{genre}</h3>
                {topGames.length > 0 ? (
                  <Carousel images={topGames} onGameSelect={handleGameSelect} />
                ) : (
                  <p className="no-games">Aucun jeu trouvé pour ce genre.</p>
                )}
              </div>
            );
          })}
        </div>
      </section>

      <footer className="footer">
        <div className="footer-content">
          <div className="footer-logo">
            <img src="/images/logo.png" alt="Logo" className="footer-logo-img" />
          </div>
          <div className="footer-links">
            <ul>
              <li><Link to="./about">À propos</Link></li> {/* Utilisation de Link */}
              <li><Link to="./terms">Conditions d'utilisation</Link></li> {/* Utilisation de Link */}
              <li><Link to="./privacy">Politique de confidentialité</Link></li> {/* Utilisation de Link */}
            </ul>
          </div>
          <div className="footer-socials">
            <a href="https://facebook.com" target="_blank" className="social-icon">Facebook</a>
            <a href="https://twitter.com" target="_blank" className="social-icon">Twitter</a>
            <a href="https://instagram.com" target="_blank" className="social-icon">Instagram</a>
          </div>
        </div>
        <div className="footer-bottom">
          <p>&copy; 2024 GameVerse. Tous droits réservés.</p>
        </div>
      </footer>
    </div>
  );
}

export default Home;
