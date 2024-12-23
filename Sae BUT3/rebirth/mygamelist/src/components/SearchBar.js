import React, { useState, useEffect, useRef } from "react";
import "./SearchBar.css";

function SearchBar({ images, onGameSelect }) {
  const [searchQuery, setSearchQuery] = useState(""); // Recherche par titre
  const [filteredImages, setFilteredImages] = useState([]); // Images filtrées
  const [activeFilters, setActiveFilters] = useState({
    genres: [],
    platforms: [],
    game_modes: [],
    player_perspectives: [],
    game_engines: [],
    themes: [],
    dlcs: false,
  });
  const [showFilters, setShowFilters] = useState(false); // Afficher/masquer les filtres
  const [isMobile, setIsMobile] = useState(window.innerWidth <= 768); // Détecter les écrans mobiles

  const filterRef = useRef(null); // Référence pour détecter les clics en dehors du filtre

  const imagesPerPage = 9; // Nombre d'images par page
  const [currentPage, setCurrentPage] = useState(1); // Page actuelle
  const [showMoreGenres, setShowMoreGenres] = useState(false);
  const [showMorePlatforms, setShowMorePlatforms] = useState(false);
  const [showMoreGameModes, setShowMoreGameModes] = useState(false);
  const [showMorePlayerPerspectives, setShowMorePlayerPerspectives] = useState(false);
  const [showMoreGameEngines, setShowMoreGameEngines] = useState(false);
  const [showMoreThemes, setShowMoreThemes] = useState(false);

  // Fonction fetch pour récupérer les jeux avec un titre et des filtres donnés
  const fetchGames = async (title = "", page_number = 1, filters = {}) => {
    try {
      const filterParams = new URLSearchParams({
        title,
        page_number,
        ...filters,
      }).toString();

      const response = await fetch(`http://localhost:5001/search_game?${filterParams}`);
      const data = await response.json();
      return data;
    } catch (error) {
      console.error("Erreur lors de la récupération des jeux :", error);
      return [];
    }
  };

  useEffect(() => {
    const handleResize = () => setIsMobile(window.innerWidth <= 768);
    window.addEventListener("resize", handleResize);
    return () => window.removeEventListener("resize", handleResize);
  }, []);

  useEffect(() => {
    const loadGames = async () => {
      const filters = {
        genres: activeFilters.genres.join(","),
        platforms: activeFilters.platforms.join(","),
        game_modes: activeFilters.game_modes.join(","),
        player_perspectives: activeFilters.player_perspectives.join(","),
        game_engines: activeFilters.game_engines.join(","),
        themes: activeFilters.themes.join(","),
        dlcs: activeFilters.dlcs ? "true" : "false",
      };

      try {
        const games = await fetchGames(searchQuery, currentPage, filters);
        if (Array.isArray(games)) {
          const filteredGames = games.filter((game) => {
            const matchesSearchQuery = game.title.toLowerCase().includes(searchQuery.toLowerCase());
            const matchesPlayerPerspective = activeFilters.player_perspectives.length === 0 ||
              game.player_perspectives.some((perspective) =>
                activeFilters.player_perspectives.includes(perspective)
              );
            const matchesGameEngine = activeFilters.game_engines.length === 0 ||
              game.game_engines.some((engine) =>
                activeFilters.game_engines.includes(engine)
              );
            const matchesThemes = activeFilters.themes.length === 0 ||
              game.themes.some((theme) =>
                activeFilters.themes.includes(theme)
              );

            return matchesSearchQuery && matchesPlayerPerspective && matchesGameEngine && matchesThemes;
          });
          setFilteredImages(filteredGames); // Mettre à jour les jeux filtrés dans l'état
        } else {
          setFilteredImages([]); // En cas d'erreur, vider les résultats
        }
      } catch (error) {
        console.error("Erreur lors de la récupération des jeux :", error);
        setFilteredImages([]); // En cas d'erreur, vider les résultats
      }
    };

    loadGames();
  }, [searchQuery, currentPage, activeFilters]);

  const getCurrentPageImages = () => {
    const indexOfLastImage = currentPage * imagesPerPage;
    const indexOfFirstImage = indexOfLastImage - imagesPerPage;
    return filteredImages.slice(indexOfFirstImage, indexOfLastImage);
  };

  const handlePageChange = (direction) => {
    if (direction === "next" && currentPage * imagesPerPage < filteredImages.length) {
      setCurrentPage(currentPage + 1);
    }
    if (direction === "prev" && currentPage > 1) {
      setCurrentPage(currentPage - 1);
    }
    window.scrollTo(0, 0); // Remonter en haut de la page
  };

  const handleSearch = (e) => {
    setSearchQuery(e.target.value);
    setCurrentPage(1); // Revenir à la page 1
  };

  const handleFilterChange = (key, value) => {
    setActiveFilters((prev) => {
      const updatedFilter = prev[key].includes(value)
        ? prev[key].filter((item) => item !== value)
        : [...prev[key], value];
      return { ...prev, [key]: updatedFilter };
    });
    setCurrentPage(1); // Revenir à la page 1
  };

  const handleClearFilters = () => {
    setActiveFilters({
      genres: [],
      platforms: [],
      game_modes: [],
      player_perspectives: [],
      game_engines: [],
      themes: [],
      dlcs: false,
    });
    setSearchQuery(""); // Réinitialiser la barre de recherche
  };

  const handleRankingClick = (genre) => {
    const filteredByGenre = images.filter((image) => image.genres.includes(genre));
    setFilteredImages(filteredByGenre);
    setSearchQuery(""); // Réinitialise la recherche
    setActiveFilters({
      genres: [],
      platforms: [],
      game_modes: [],
      player_perspectives: [],
      game_engines: [],
      themes: [],
      dlcs: false,
    });
  };

  const hasResults = filteredImages.length > 0 || searchQuery || Object.values(activeFilters).some((filter) => filter.length > 0);

  const showPagination = filteredImages.length >= imagesPerPage;

  const handleCloseFilter = () => {
    setShowFilters(false); // Fermer le filtre
  };

  useEffect(() => {
    const handleClickOutside = (event) => {
      if (filterRef.current && !filterRef.current.contains(event.target)) {
        setShowFilters(false); // Ferme le filtre si un clic est effectué en dehors
      }
    };

    document.addEventListener("mousedown", handleClickOutside);
    return () => document.removeEventListener("mousedown", handleClickOutside);
  }, []);

  return (
    <div className="search-page">
      
      {/* Afficher le filtre uniquement sur mobile */}
      {isMobile && (
        <button className="filter-toggle" onClick={() => setShowFilters(true)}>
          <i className="icon-">
            <img src="/images/filter.svg" alt="filter" />
          </i>
        </button>
      )}

      {/* Bloc filtre qui s'affiche toujours en version PC */}
      <div className={`filter-block ${isMobile && (showFilters ? "show" : "hidden")}`} ref={filterRef}>
        <button className="close-filter" onClick={handleCloseFilter}>
          &times;
        </button>
        <h3>Filtres</h3>
        <div className="filter-section">
          <h4>Genres</h4>
          <div className="filter-options">
            {Array.from(new Set(images.flatMap((img) => img.genres || [])))
              .slice(0, showMoreGenres ? Infinity : 4)
              .map((genre) => (
                <label key={genre}>
                  <input
                    type="checkbox"
                    checked={activeFilters.genres.includes(genre)}
                    onChange={() => handleFilterChange("genres", genre)}
                  />
                  {genre}
                </label>
              ))}
          </div>
          {images.flatMap((img) => img.genres || []).length > 10 && (
            <button className="see-more" onClick={() => setShowMoreGenres((prev) => !prev)}>
              {showMoreGenres ? "Voir moins" : "Voir plus"}
            </button>
          )}
        </div>

        <div className="filter-section">
          <h4>Plateformes</h4>
          <div className="filter-options">
            {Array.from(new Set(images.flatMap((img) => img.platforms || [])))
              .slice(0, showMorePlatforms ? Infinity : 4)
              .map((platform) => (
                <label key={platform}>
                  <input
                    type="checkbox"
                    checked={activeFilters.platforms.includes(platform)}
                    onChange={() => handleFilterChange("platforms", platform)}
                  />
                  {platform}
                </label>
              ))}
          </div>
          {images.flatMap((img) => img.platforms || []).length > 10 && (
            <button className="see-more" onClick={() => setShowMorePlatforms((prev) => !prev)}>
              {showMorePlatforms ? "Voir moins" : "Voir plus"}
            </button>
          )}
        </div>

        <div className="filter-section">
          <h4>Modes de jeu</h4>
          <div className="filter-options">
            {Array.from(new Set(images.flatMap((img) => img.game_modes || [])))
              .slice(0, showMoreGameModes ? Infinity : 4)
              .map((mode) => (
                <label key={mode}>
                  <input
                    type="checkbox"
                    checked={activeFilters.game_modes.includes(mode)}
                    onChange={() => handleFilterChange("game_modes", mode)}
                  />
                  {mode}
                </label>
              ))}
          </div>
        </div>

        <div className="filter-section">
          <h4>Perspectives du joueur</h4>
          <div className="filter-options">
            {Array.from(new Set(images.flatMap((img) => img.player_perspectives || [])))
              .slice(0, showMorePlayerPerspectives ? Infinity : 4)
              .map((perspective) => (
                <label key={perspective}>
                  <input
                    type="checkbox"
                    checked={activeFilters.player_perspectives.includes(perspective)}
                    onChange={() => handleFilterChange("player_perspectives", perspective)}
                  />
                  {perspective}
                </label>
              ))}
          </div>
        </div>

        <div className="filter-section">
          <h4>Moteurs de jeu</h4>
          <div className="filter-options">
            {Array.from(new Set(images.flatMap((img) => img.game_engines || [])))
              .slice(0, showMoreGameEngines ? Infinity : 4)
              .map((engine) => (
                <label key={engine}>
                  <input
                    type="checkbox"
                    checked={activeFilters.game_engines.includes(engine)}
                    onChange={() => handleFilterChange("game_engines", engine)}
                  />
                  {engine}
                </label>
              ))}
          </div>
        </div>

        <div className="filter-section">
          <h4>Thèmes</h4>
          <div className="filter-options">
            {Array.from(new Set(images.flatMap((img) => img.themes || [])))
              .slice(0, showMoreThemes ? Infinity : 4)
              .map((theme) => (
                <label key={theme}>
                  <input
                    type="checkbox"
                    checked={activeFilters.themes.includes(theme)}
                    onChange={() => handleFilterChange("themes", theme)}
                  />
                  {theme}
                </label>
              ))}
          </div>
          {images.flatMap((img) => img.themes || []).length > 10 && (
            <button className="see-more" onClick={() => setShowMoreThemes((prev) => !prev)}>
              {showMoreThemes ? "Voir moins" : "Voir plus"}
            </button>
          )}
        </div>

        <div className="filter-section">
          <h4>DLCs</h4>
          <label>
            <input
              type="checkbox"
              checked={activeFilters.dlcs}
              onChange={() => handleFilterChange("dlcs", !activeFilters.dlcs)}
            />
            Inclure les DLCs
          </label>
        </div>
        <button className="apply-filters-button" onClick={handleClearFilters}>
          Réinitialiser les filtres
        </button>
      </div>

      <div className="results-container">
        <div className="search-bar">
          <input
            type="text"
            placeholder="Rechercher des jeux..."
            value={searchQuery}
            onChange={handleSearch}
          />
        </div>
        {hasResults ? (
          <div className="search-results">
            {getCurrentPageImages().map((image) => (
              <div
                key={image.title}
                className="search-result-item"
                onClick={() => onGameSelect(image)}
              >
                <img
                  src={image.cover.original}
                  alt={image.title}
                  className="game-image"
                />
              </div>
            ))}
          </div>
        ) : (
          <div className="no-results">Aucun résultat trouvé.</div>
        )}

        {/* Pagination */}
        {showPagination && (
          <div className="pagination">
            <button
              className="pagination-button"
              onClick={() => handlePageChange("prev")}
              disabled={currentPage === 1}
            >
              Précédent
            </button>
            <span>Page {currentPage}</span>
            <button
              className="pagination-button"
              onClick={() => handlePageChange("next")}
              disabled={currentPage * imagesPerPage >= filteredImages.length}
            >
              Suivant
            </button>
          </div>
        )}
      </div>

      <div className="ranking-block">
        <h3>Classement</h3>
        {["Role-playing (RPG)", "Action", "Adventure", "Sports", "Simulation"].map((genre) => (
          <li key={genre} onClick={() => handleRankingClick(genre)}>{genre}</li>
        ))}
      </div>
    </div>
  );
}

export default SearchBar;
