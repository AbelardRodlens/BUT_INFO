# Projet Rebirth

Rebirth est une plateforme complète de gestion et d'affichage de données sur les jeux vidéo. Elle collecte, traite et visualise des données sur les jeux pour offrir une expérience web interactive et dynamique aux utilisateurs. Ce projet combine un backend robuste avec un frontend riche en fonctionnalités.

## Fonctionnalités

### Backend
- **Collecte de données** : Récupération des données via des API telles que RAWG et IGDB, garantissant des informations actualisées et détaillées.
- **Gestion de base de données** : Intégration avec MongoDB et schémas de données pour les jeux et les filtres.
- **Services API** :
  - Recherche de jeux selon différents attributs (titre, genre, développeur, etc.).
  - Récupération des jeux les mieux notés, des nouvelles sorties ou des jeux basés sur des filtres comme les thèmes ou les plateformes.
  
### Frontend
- **Design responsive** : Développé avec React pour des interactions dynamiques et conviviales.
- **Recherche et filtres** : Fonctionnalité de recherche complète avec des filtres avancés (genres, thèmes, etc.).
- **Détails des jeux** : Pages d'informations détaillées pour chaque jeu, incluant notes, descriptions et contenu multimédia.
- **Authentification** : Gestion des utilisateurs avec des fonctionnalités comme la connexion, l'inscription et les paramètres de compte.

## Structure du projet
```
Rebirth/
├── GenerateDATA1.0/      
│   ├── Aperçu : Contient des scripts et des fichiers JSON pour la collecte initiale de données via l'API RAWG.
│   └── Suit la progression à l'aide d'un fichier de suivi et stocke les données des jeux au format JSON.
├── GenerateDATA2.0/      
│   ├── Aperçu : Contient des scripts avancés pour la collecte de données, incluant le support multilingue et la traduction des données.
│   └── Inclut des outils pour nettoyer, traduire et traiter les données de jeux à partir de l'API IGDB.
├── backend/                         
│   ├── .gitignore                   # Fichier pour exclure des fichiers/dossiers du contrôle de version Git
│   ├── GamesDATA.json               # Fichier JSON contenant les données des jeux
│   ├── api.js                       # Fichier principal pour les routes API
│   ├── api_functions.js             # Fichier contenant les fonctions principales utilisées par l'API
│   ├── genUser.js                   # Script pour générer des utilisateurs fictifs
│   ├── index.js                     # Script pour importer des données JSON dans MongoDB
│   ├── jest.config.js               # Configuration de Jest pour les tests
│   ├── package.json                 # Fichier de configuration des dépendances backend
│   ├── package-lock.json            # Fichier de verrouillage des dépendances backend
│   ├── secret_keys.env              # Fichier contenant les clés secrètes (JWT, etc.)
│   ├── models/                      # Modèles Mongoose pour MongoDB
│   │   ├── Comment.js               # Schéma pour les commentaires
│   │   ├── Game.js                  # Schéma pour les données de jeux
│   │   ├── User.js                  # Schéma pour les utilisateurs
│   │   └── filters.js               # Schéma pour les filtres de recherche
│   ├── _tests_/                     # Dossier contenant les tests
│   │   ├── integration/             
│   │   │   └── app.test.js          # Tests d'intégration pour les fonctionnalités globales
│   │   └── unit/                    
│   │       └── unit_test.test.js    # Tests unitaires pour des fonctions spécifiques                
├── mygamelist
│   ├── README.
│   ├── babel.config.
│   ├── cookies.
│   ├── jest.config.
│   ├── vite.config.
│   ├── package.json                 # Dépendances et scripts pour le frontend
│   ├── public
│   │   ├── index.
│   │   ├── manifest.json            # Fichier de configuration pour PWA
│   │   ├── robots.txt               # Directives pour les robots de moteurs de recherche
│   │   └── images
│   ├── server
│   │   ├── API_Documentation.docx
│   │   ├── app.js                   # Script Node.js serveur
│   │   ├── Schemas/                 # Contient les schémas utilisés pour MongoDB
│   │   └── __tests__/               # Dossier pour les tests d'intégration et unitaires
│   └── src
│       ├── App.js
│       ├── components/              # Dossier pour les composants React
├── schema/
│   ├── database_schema/             # Schémas de la base de données
│   │   └── database_schema.drawio   # Diagramme du schéma de la base
│   ├── sequence_schema/             # Diagrammes de séquence
│       ├── Game Search.txt
│       ├── User Interaction.txt
│       └── User Management.txt
├── GamesDATA.json
├── progress.json
├── README.md
```

## Technologies utilisées

### Backend
- **Node.js** : Serveur API et logique métier.
- **Express.js** : Middleware pour les points de terminaison API.
- **MongoDB** : Base de données NoSQL pour les données des jeux et des filtres.
- **Mongoose** : Object-Document Mapping pour MongoDB.

### Frontend
- **React** : Développement de l'interface utilisateur.
- **CSS** : Style des composants et des pages.

### Outils supplémentaires
- **Jest** : Framework de tests.
- **Concurrently** : Exécution simultanée de plusieurs scripts pendant le développement.

## Installation

1. Cloner le dépôt :
```bash
git clone https://gitlab.sorbonne-paris-nord.fr/12201950/rebirth.git
cd rebirth
```

2. Installer les dépendances pour le backend :
```bash
cd backend
npm install
```

3. Installer les dépendances pour le frontend :
```bash
cd ../mygamelist
npm install
```
4. Lancer la construction de la base de données (Dans le dossier racine du projet):
```bash
npm run bdd
```

5. Lancer le projet (Dans le dossier racine du projet):
```bash
npm run start
```

5. Ouvrir http://localhost:3000 pour voir l'application(ce fait automatiquement normalement).

## Utilisation

- Rechercher des jeux par titre, genre, éditeur et autres attributs.
- Consulter des informations détaillées sur des jeux spécifiques.
- Gérer les comptes utilisateurs et les listes de jeux personnalisées.

## Licence
Ce projet est sous licence MIT. 

