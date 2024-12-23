const mongoose = require("mongoose");
const fs = require("fs");

// Chemin vers ton fichier JSON
const jsonFilePath = "./GamesDATA.json";

// Connexion à MongoDB
const dbName = "gameLibrary";
const mongoURI = `mongodb://localhost:27017/${dbName}`;

// Connexion et suppression de la base à chaque exécution
mongoose
  .connect(mongoURI)
  .then(async () => {
    console.log("✅ Connecté à MongoDB");
    await mongoose.connection.db.dropDatabase(); // Suppression de la base
    console.log(`🗑️  Base de données "${dbName}" supprimée et prête pour une nouvelle importation.`);
    await importData(); // Importer les données JSON
    process.exit(0); // Terminer après le traitement
  })
  .catch((error) => {
    console.error("❌ Erreur de connexion MongoDB:", error);
    process.exit(1);
  });

// Schéma pour gérer le compteur d'ID
const counterSchema = new mongoose.Schema({
  name: { type: String, required: true }, // Nom du compteur (exemple : "gameId")
  seq: { type: Number, required: true }, // Dernier ID utilisé
});

const Counter = mongoose.model("Counter", counterSchema);

// Schéma pour les jeux
const gameSchema = new mongoose.Schema({
  id: { type: Number, unique: true }, // ID incrémental
  title: { type: String, required: true },
  description: String,
  platforms: [String],
  platform_logos: [
    {
      thumb: String,
      original: String,
    },
  ],
  genres: [String],
  cover: {
    thumb: String,
    original: String,
  },
  developers: [String],
  publishers: [String],
  artworks: [
    {
      thumb: String,
      original: String,
    },
  ],
  game_modes: [String],
  player_perspectives: [String],
  themes: [String],
  franchises: [String],
  dlcs: [String],
  game_engines: [String],
  videos: [String],
  release_date: {
    type: Date,
    validate: {
      validator: function (value) {
        return value instanceof Date || value === null; // Autoriser `null` ou une date valide
      },
      message: "release_date doit être une date valide ou null.",
    },
    default: null,
  },
  total_rating: Number,
  total_rating_count: Number,
});

// Middleware : incrémenter automatiquement l'ID avant d'insérer un jeu
gameSchema.pre("save", async function (next) {
  if (this.isNew) {
    try {
      const counter = await Counter.findOneAndUpdate(
        { name: "gameId" },        // Nom du compteur
        { $inc: { seq: 1 } },      // Incrémenter `seq` de 1
        { new: true, upsert: true } // Crée un document si inexistant
      );

      this.id = counter.seq; // Assigner le prochain ID
      next();
    } catch (error) {
      next(error); // Transmettre l'erreur
    }
  } else {
    next(); // Pas de modification si ce n'est pas un nouveau document
  }
});

const Game = mongoose.model("Game", gameSchema);

// Fonction pour importer les données JSON dans MongoDB
async function importData() {
  try {
    // Lire les données du fichier JSON
    const jsonData = JSON.parse(fs.readFileSync(jsonFilePath, "utf8"));

    // Nettoyer les données : convertir les dates non valides en null
    const cleanedData = jsonData.map((game) => ({
      ...game,
      release_date: isValidDate(game.release_date) ? new Date(game.release_date) : null,
    }));

    // Gérer l'incrémentation manuelle des IDs
    let counter = await Counter.findOneAndUpdate(
      { name: "gameId" },
      { $inc: { seq: cleanedData.length } }, // Réserve une plage pour les IDs
      { new: true, upsert: true }
    );

    let currentId = counter.seq - cleanedData.length + 1;

    const dataWithIds = cleanedData.map((game) => ({
      ...game,
      id: currentId++, // Ajouter un ID incrémental
    }));

    // Insérer les données dans la collection
    await Game.insertMany(dataWithIds);
    console.log("✅ Données importées avec succès !");
  } catch (error) {
    console.error("❌ Erreur lors de l'import des données :", error);
  }
}


// Fonction utilitaire pour vérifier si une date est valide
function isValidDate(date) {
  return !isNaN(Date.parse(date));
}

// Exporter le modèle pour des utilisations ultérieures
module.exports = Game;
