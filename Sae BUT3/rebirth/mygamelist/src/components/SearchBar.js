import React, { useState, useEffect, useRef } from "react";
import "./SearchBar.css";
import fetchWrapper from "../fetchWrapper.js";
import { jwtDecode } from "jwt-decode";

const SearchBar = ({ images, onGameSelect }) => {
  const [searchQuery, setSearchQuery] = useState("");
  const [developerQuery, setDeveloperQuery] = useState("");
  const [publisherQuery, setPublisherQuery] = useState("");
  const [filteredImages, setFilteredImages] = useState([]);
  const [filterOptions, setFilterOptions] = useState({
    genres: [],
    platforms: [],
    game_modes: [],
    player_perspectives: [],
    game_engines: [],
    themes: [],
  });
  const [activeFilters, setActiveFilters] = useState({
    genres: [],
    platforms: [],
    game_modes: [],
    player_perspectives: [],
    game_engines: [],
    themes: [],
  });
  const [showFilters, setShowFilters] = useState(false);
  const [currentPage, setCurrentPage] = useState(1);
  const [isMobile, setIsMobile] = useState(window.innerWidth <= 768);
  const [expandedFilters, setExpandedFilters] = useState({
    genres: false,
    platforms: false,
    game_modes: false,
    player_perspectives: false,
    game_engines: false,
    themes: false,
  });
  const filterRef = useRef(null);
  const imagesPerPage = 9;
  const [autocompleteSuggestions, setAutocompleteSuggestions] = useState([]);
const [developerSuggestions, setDeveloperSuggestions] = useState([]);
const [publisherSuggestions, setPublisherSuggestions] = useState([]);
const autocompleteRef = useRef(null);  // Reference for autocomplete lists
const searchRef = useRef(null);  // Reference for search input fields
const [isSearchActive, setIsSearchActive] = useState(false);
const [isNoResults, setIsNoResults] = useState(false);


const fetchAutocomplete = async (query, type) => {
  const searchQuery = typeof query === "string" ? query.trim() : "";

  if (!searchQuery) {
    switch (type) {
      case "game":
        setAutocompleteSuggestions([]);
        break;
      case "developer":
        setDeveloperSuggestions([]);
        break;
      case "publisher":
        setPublisherSuggestions([]);
        break;
      default:
        break;
    }
    return;
  }

  try {
    const response = await fetch(
      `http://localhost:5001/autocomplete?query=${encodeURIComponent(searchQuery)}&type=${type}`
    );
    const data = await response.json();
    if (Array.isArray(data)) {
      switch (type) {
        case "game":
          setAutocompleteSuggestions(data.slice(0, 10));
          break;
        case "developer":
          setDeveloperSuggestions(data.slice(0, 10));
          break;
        case "publisher":
          setPublisherSuggestions(data.slice(0, 10));
          break;
        default:
          break;
      }
    } else {
      console.warn("Données inattendues pour l'autocomplétion :", data);
      setAutocompleteSuggestions([]);
      setDeveloperSuggestions([]);
      setPublisherSuggestions([]);
    }
  } catch (error) {
    console.error("Erreur lors de l'autocomplétion :", error);
    setAutocompleteSuggestions([]);
    setDeveloperSuggestions([]);
    setPublisherSuggestions([]);
  }
};


useEffect(() => {
  fetchAutocomplete(searchQuery, "game");
}, [searchQuery]);

useEffect(() => {
  fetchAutocomplete(developerQuery, "developer");
}, [developerQuery]);

useEffect(() => {
  fetchAutocomplete(publisherQuery, "publisher");
}, [publisherQuery]);


  // Détecte si l'écran est mobile
  const checkIsMobile = () => {
    setIsMobile(window.innerWidth <= 768);
  };

  useEffect(() => {
    window.addEventListener("resize", checkIsMobile);
    return () => {
      window.removeEventListener("resize", checkIsMobile);
    };
  }, []);

  // Fetch des options de filtres depuis l'API
  const fetchFilters = async () => {
    try {
      const response = await fetch("http://localhost:5001/filters");
      const data = await response.json();
      setFilterOptions({
        genres: data.genres || [],
        platforms: data.platforms || [],
        game_modes: data.game_modes || [],
        player_perspectives: data.player_perspectives || [],
        game_engines: data.engines || [],
        themes: data.themes || [],
      });
    } catch (error) {
      console.error("Erreur lors de la récupération des filtres :", error);
    }
  };

  // Fetch des jeux
  const fetchGames = async (title = "", developers = "", publishers = "", page_number = 1, filters = {}) => {
    try {
      const params = new URLSearchParams({
        title,
        developers,
        publishers,
        page_number,
        ...filters,
      }).toString();

      const response = await fetch(`http://localhost:5001/search_game?${params}`);
      const data = await response.json();
      console.log("Données récupérées :", data); // Debug
      return data;
    } catch (error) {
      console.error("Erreur lors de la récupération des jeux :", error);
      return [];
    }
  };

  useEffect(() => {
    fetchFilters();
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
      };
      const games = await fetchGames(searchQuery, developerQuery, publisherQuery, currentPage, filters);
      setFilteredImages(games || []);
      
      // Vérifier si la recherche est active ou s'il n'y a pas de résultats
      setIsSearchActive(!!searchQuery);
      setIsNoResults(games.length === 0);
    };
  
    loadGames();
  }, [searchQuery, developerQuery, publisherQuery, currentPage, activeFilters]);
  

  const handleSearch = (e) => {
    setSearchQuery(e.target.value);
    setCurrentPage(1);
  };

  const handleDeveloperSearch = (e) => {
    setDeveloperQuery(e.target.value);
    setCurrentPage(1);
  };

  const handlePublisherSearch = (e) => {
    setPublisherQuery(e.target.value);
    setCurrentPage(1);
  };

  const handleFilterChange = (key, value) => {
    setActiveFilters((prev) => {
      if (typeof prev[key] === "boolean") {
        return { ...prev, [key]: value };
      } else {
        const updatedFilter = prev[key].includes(value)
          ? prev[key].filter((item) => item !== value)
          : [...prev[key], value];
        return { ...prev, [key]: updatedFilter };
      }
    });
    setCurrentPage(1);
  };

  const handlePageChange = (direction) => {
    if (direction === "next") {
      setCurrentPage((prev) => prev + 1);
    } else if (direction === "prev" && currentPage > 1) {
      setCurrentPage((prev) => prev - 1);
    }
  };

  const handleClearFilters = () => {
    setActiveFilters({
      genres: [],
      platforms: [],
      game_modes: [],
      player_perspectives: [],
      game_engines: [],
      themes: [],
    });
    setSearchQuery("");
    setDeveloperQuery("");
    setPublisherQuery("");
    setCurrentPage(1);
  };

  const toggleExpandFilter = (key) => {
    setExpandedFilters((prev) => ({
      ...prev,
      [key]: !prev[key],
    }));
  };
  const renderFilterSection = (key, options) => (
    <div className="filter-section" key={key}>
      <h4>{key.charAt(0).toUpperCase() + key.slice(1)}</h4>
      <div className="filter-options">
        {options.slice(0, expandedFilters[key] ? options.length : 4).map((option) => (
          <label key={option}>
            <input
              type="checkbox"
              checked={activeFilters[key].includes(option)}
              onChange={() => handleFilterChange(key, option)}
            />
            {option}
          </label>
        ))}
      </div>
      {options.length > 4 && (
        <button className="see-more" onClick={() => toggleExpandFilter(key)}>
          {expandedFilters[key] ? "Voir moins" : "Voir plus"}
        </button>
      )}
    </div>
  );
   // Function to handle clicks outside the search inputs or autocomplete list
   const handleClickOutside = (event) => {
    if (autocompleteRef.current && !autocompleteRef.current.contains(event.target) && searchRef.current && !searchRef.current.contains(event.target)) {
      setAutocompleteSuggestions([]);
      setDeveloperSuggestions([]);
      setPublisherSuggestions([]);
    }
  };
  useEffect(() => {
    document.addEventListener("mousedown", handleClickOutside);  // Listen for clicks
    return () => {
      document.removeEventListener("mousedown", handleClickOutside);  // Clean up on component unmount
    };
  }, []);

  const [favorites, setFavorites] = useState([]);

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
            setFavorites(currentFavorites);
          }
        } catch (e) {
            console.error("An error has occured: ",e.message);
        }
    
      }
    
       checkIfGameInFavorites();
  }, []);



  const handleAddToFavorites = async (game, event) => {
    event.preventDefault(); // Empêche l'action par défaut (ex. navigation)
    event.stopPropagation(); // Empêche la propagation de l'événement aux éléments parents
  
    try {
      const data = {
        game_id: game.game_id,
        user_id
        // Ajoutez d'autres propriétés nécessaires si besoin
      };
  
      const response = await fetchWrapper(
        "http://localhost:5001/gamelist/add_game",
        "POST",
        true,
        data
      );
  
      if (response.ok) {
        const updatedFavorites = [...favorites, game];
        setFavorites(updatedFavorites);
        localStorage.setItem("favorites", JSON.stringify(updatedFavorites));
      } else {
        console.error("Erreur lors de l'ajout du jeu aux favoris");
      }
    } catch (error) {
      console.error("Erreur lors de la gestion des favoris :", error);
    }
  };

  const handleRemoveFavorites = async (game) => {
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
  
  


  const isFavorite = (gameId) => {
    return favorites.some((fav) => fav.game_id === gameId);
  };
  

  return (
    <div className="search-page">
      {isMobile && (
        <button className="filter-toggle" onClick={() => setShowFilters(true)}>
          <img src="/images/filter.svg" alt="Filter" />
        </button>
      )}

      <div
        className={`filter-block ${
          isMobile ? (showFilters ? "show" : "hidden") : "visible"
        }`}
        ref={filterRef}
      >
        {isMobile && (
          <button className="close-filter" onClick={() => setShowFilters(false)}>
            &times;
          </button>
        )}
        <h3>Filtres</h3>
        {Object.keys(filterOptions).map((key) =>
          renderFilterSection(key, filterOptions[key])
        )}
        <button className="apply-filters-button" onClick={handleClearFilters}>
          Réinitialiser les filtres
        </button>
      </div>
      
      <div className="results-container">
        <div className="search-bar">
        <div className="search-input-container" ref={searchRef}>
          <input
            type="text"
            placeholder="Rechercher des jeux..."
            value={searchQuery}
            onChange={handleSearch}
          />
          {autocompleteSuggestions.length > 0 && (
            <ul className="autocomplete-list" ref={autocompleteRef}>
              {autocompleteSuggestions.map((suggestion, index) => (
                <li key={index} onClick={() => setSearchQuery(suggestion.title)}>
                  {suggestion.title}
                </li>
              ))}
            </ul>
          )}
        </div>
        <div className="search-input-container" ref={searchRef}>
          <input
            type="text"
            placeholder="Rechercher des développeurs..."
            value={developerQuery}
            onChange={handleDeveloperSearch}
          />
          {developerSuggestions.length > 0 && (
            <ul className="autocomplete-list" ref={autocompleteRef}>
              {developerSuggestions.map((suggestion, index) => (
                <li key={index} onClick={() => setDeveloperQuery(suggestion.developers)}>
                  {suggestion.developers}
                </li>
              ))}
            </ul>
          )}
        </div>
        <div className="search-input-container" ref={searchRef}>
          <input
            type="text"
            placeholder="Rechercher des éditeurs..."
            value={publisherQuery}
            onChange={handlePublisherSearch}
          />
          {publisherSuggestions.length > 0 && (
            <ul className="autocomplete-list" ref={autocompleteRef}>
              {publisherSuggestions.map((suggestion, index) => (
                <li key={index} onClick={() => setPublisherQuery(suggestion.publishers)}>
                  {suggestion.publishers}
                </li>
              ))}
            </ul>
          )}
        </div>
        </div>


        <div className="search-results">
  {filteredImages.map((image) => (
    <div
    key={image.title}
    className="search-result-item"
    onClick={() => onGameSelect(image)} // Event for game selection
  >
    <div className="game-cover-2">
      <img
        src={image.cover.original}
        alt={image.title}
        // No onClick here for the image, to allow game selection
      />
      {/* Add to favorites button */}
      {(isSearchActive || !isNoResults) && (
        <button
          className={`add-button ${isFavorite(image.game_id) ? 'added' : ''}`}
          onClick={(e) => {
            e.stopPropagation(); // Prevent game selection when clicking on the favorite button
            isFavorite(image.game_id) ? handleRemoveFavorites(image, e) : handleAddToFavorites(image, e); // Add to favorites
          }}
          type="button"
        >
          {isFavorite(image.game_id) ? 'Ajouté' : (
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
      )}
    </div>
  </div>
  
  
  ))}
</div>


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
            disabled={!filteredImages.length || filteredImages.length < imagesPerPage}
          >
            Suivant
          </button>
        </div>
      </div>
    </div>
  );
};

export default SearchBar;
