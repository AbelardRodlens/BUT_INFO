const User = require('./models/User');
const bcrypt = require('bcrypt');
const mongoose = require('mongoose');

const dbName = "gameLibrary";
const mongoURI = `mongodb://localhost:27017/${dbName}`;

// Connexion à MongoDB et exécution
mongoose
  .connect(mongoURI, { useNewUrlParser: true, useUnifiedTopology: true })
  .then(async () => {
    console.log("✅ Connecté à MongoDB");
    console.log("📦 Génération des utilisateurs...");
    
    // Exécuter la génération des utilisateurs
    await genUser();

    console.log("✅ Tous les utilisateurs ont été générés !");
    
    // Fermer la connexion après la génération
    await mongoose.connection.close();
    console.log("🔒 Connexion MongoDB fermée.");
    process.exit(0); // Terminer le processus
  })
  .catch((error) => {
    console.error("❌ Erreur de connexion MongoDB :", error);
    process.exit(1); // Terminer le processus en cas d'erreur
  });

const genUser = async () => {
  try {
    for (let i = 0; i < 10; i++) {
      const username = `user_${Math.random().toString(36).substring(7)}`;
      const hashedPassword = await bcrypt.hash(username, 10);

      const user = {
        user_id: i + 1, 
        username,
        pass: hashedPassword,
        email: `${username}@gmail.com`,
        tokens: [], // Explicite même si valeur par défaut dans le schéma
        game_list: [], // Explicite même si valeur par défaut dans le schéma
        profile_picture: undefined,
      };

      await User.create(user); 
      console.log(`${username} créé`);
    }
  } catch (e) {
    console.error("❌ Une erreur s'est produite :", e.message);
  }
};
