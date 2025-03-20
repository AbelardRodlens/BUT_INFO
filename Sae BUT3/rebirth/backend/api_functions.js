const bcrypt = require('bcrypt');
const jwt = require('jsonwebtoken');
const useragent = require('useragent');
const nodemailer = require('nodemailer');
const mongoose = require('mongoose');
const Game = require("./models/Game");
const User = require('./models/User.js')
const Comment = require('./models/Comment.js');
const Filters = require("./models/filters");;
require('dotenv').config({ path: 'C:/Users/Test/Desktop/rebirth/rebirth/backend/secret_keys.env' });


const transporter = nodemailer.createTransport({
  service: "gmail",
  auth: {
    user: "gameverse.service@gmail.com",
    pass: "oozc lkbi pejy hzle"
  }
})

const checkIfEmailIsValid = (email) => {
    if (!email) throw new ReferenceError("Missing argument.");
    if (typeof email !== "string") throw new TypeError("Argument has wrong type.");

    const emailRegex = /^(?=.{1,100}$)(?=.{1,64}@)[a-zA-Z0-9](?!.*\.\.)[a-zA-Z0-9._%+-]{0,62}@[a-zA-Z0-9-]{1,35}\.[a-zA-Z]{2,6}$/;

    try {
        return emailRegex.test(email);
    } catch(e) {
        throw e;
    }
}

 const checkIfUserNameIsValid = (username) => {
    if (!username) throw new ReferenceError("Missing argument.");
    if (typeof username !== "string") throw new TypeError("Argument has wrong type.");

    const usernameRegex = /^(?=.{7,35}$)(?!.*--)(?!.*([a-zA-Z])\1\1)[a-zA-Z0-9](?!.*-$)[a-zA-Z0-9-]*[a-zA-Z0-9]$/;

    try {
        return usernameRegex.test(username);
    } catch(e) {
        throw e;
    }
}

 const checkIfPassIsValid = (password) => {
    if (!password) throw new ReferenceError("Missing argument.");
    if (typeof password !== "string") throw new TypeError("Argument has wrong type.");

    const passRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&\s])((?!\s\s).){8,128}$/;

    try {
        return passRegex.test(password);
    } catch(e) {
        throw e;
    }

}

 const hashPassword = async (password) => {
    if (!password) throw new ReferenceError("Missing argument.");
    if (typeof password !== "string") throw new TypeError("Argument has wrong type.");

    try{
        const saltRounds=10; // Nb de tours pour gen le sel (plus il est élévé, plus c'est sécurisé).
        const hashPassword = await bcrypt.hash(password, saltRounds);
        return hashPassword

    } catch(e){
        return e;
    }
    
}

// Fonction pour échapper les caractères spéciaux dans une rege
function escapeRegExp(string) {
  return string.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
}

  
// Objet regroupant les fonctions API
const apiFunctions = {
  transformToFrench: (game) => {
    const transformedGame = { ...game._doc };

    // Formater la date de sortie
    if (transformedGame.release_date) {
      transformedGame.release_date = new Date(transformedGame.release_date).toISOString().split("T")[0];
    }

    transformedGame.description = game.description?.fr || game.description?.en;
    transformedGame.genres = game.genres?.fr || game.genres?.en;
    transformedGame.game_modes = game.game_modes?.fr || game.game_modes?.en;
    transformedGame.player_perspectives = game.player_perspectives?.fr || game.player_perspectives?.en;
    transformedGame.themes = game.themes?.fr || game.themes?.en;
    return transformedGame;
  },



  getAutocomplete: async (query, limit = 10) => {
    try {
      if (!query || typeof query !== "string") {
        throw new Error("Le paramètre 'query' doit être une chaîne de caractères non vide.");
      }
  
      // La regex utilise "^" pour correspondre uniquement aux chaînes qui commencent par la requête
      const regex = new RegExp(`^${escapeRegExp(query.trim())}`, "i");
      const suggestions = await Game.find({
        $or: [
          { title: { $regex: regex } },
          { developers: { $regex: regex } },
          { publishers: { $regex: regex } },
        ],
      })
        .limit(Number(limit) * 5) // On récupère plus de résultats pour avoir des choix après filtrage
        .select("title developers publishers -_id");
  
      if (!suggestions.length) {
        return [];
      }
  
      // Crée un tableau avec les éditeurs et développeurs uniques par combinaison (titre + éditeur/développeur)
      const seenCombinations = new Set();
  
      const filteredSuggestions = suggestions.filter((suggestion) => {
        const firstDeveloper = Array.isArray(suggestion.developers) && suggestion.developers.length > 0
          ? suggestion.developers[0]
          : null;
  
        const firstPublisher = Array.isArray(suggestion.publishers) && suggestion.publishers.length > 0
          ? suggestion.publishers[0]
          : null;
  
        // Génère une clé unique basée sur le titre, le développeur et l'éditeur
        const combinationKey = `${suggestion.title}_${firstDeveloper || ""}_${firstPublisher || ""}`;
  
        // Vérifie si la combinaison a déjà été vue
        if (seenCombinations.has(combinationKey)) {
          return false; // Exclut cet élément
        }
  
        // Ajoute la combinaison au set des éléments vus
        seenCombinations.add(combinationKey);
  
        // Conserve cet élément dans les résultats
        return true;
      });
  
      // Retourne uniquement jusqu'à `limit` résultats après le filtrage
      return filteredSuggestions.slice(0, limit).map((suggestion) => ({
        title: suggestion.title,
        developers: Array.isArray(suggestion.developers) ? suggestion.developers[0] : suggestion.developers,
        publishers: Array.isArray(suggestion.publishers) ? suggestion.publishers[0] : suggestion.publishers,
      }));
    } catch (error) {
      throw new Error(`Erreur lors de l'autocomplétion : ${error.message}`);
    }
  },
  
  

  

  getFilters: async () => {
    try {
      const filters = await Filters.findOne({});
      if (!filters) {
        throw new Error("Filtres non trouvés");
      }
      return filters;
    } catch (error) {
      throw new Error(`Erreur lors de la récupération des filtres : ${error.message}`);
    }
  },

  searchGames: (query, page_number = 1) => {
    return new Promise(async (resolve, reject) => {
      try {
        const maxGamesPerPage = 9;
        const skip = (page_number - 1) * maxGamesPerPage;

        const dbQuery = {};
        const queryWithLanguage = ["genres", "game_modes", "player_perspectives", "themes"];
        const simpleFilters = ["developers", "publishers", "game_engines", "platforms"];

        Object.keys(query).forEach((key) => {
          const value = query[key]?.trim(); // Supprime les espaces inutiles et vérifie si vide
          if (value && key !== "page_number") {
            // Gérer les filtres avec une structure multilingue
            if (queryWithLanguage.includes(key)) {
              dbQuery[`${key}.fr`] = {
                $all: value.split(",").map((v) => new RegExp(escapeRegExp(v.trim()), "i")),
              };
            }
            // Gérer les filtres simples
            else if (simpleFilters.includes(key)) {
              dbQuery[key] = {
                $all: value.split(",").map((v) => new RegExp(escapeRegExp(v.trim()), "i")),
              };
            }
            // Gérer les titres avec regex
            else if (key === "title") {
              dbQuery[key] = { $regex: new RegExp(escapeRegExp(value), "i") };
            }
          }
        });

        const totalResults = await Game.countDocuments(dbQuery);

        if (skip >= totalResults) {
          return resolve([]);
        }

        // Mesurer le temps MongoDB
        const startMongoTime = Date.now();
        const games = await Game.find(dbQuery).skip(skip).limit(maxGamesPerPage);
        const mongoDuration = Date.now() - startMongoTime;

        // Mesurer le temps de traitement
        const startProcessingTime = Date.now();
        const transformedGames = games.map(apiFunctions.transformToFrench);
        const processingDuration = Date.now() - startProcessingTime;

        console.log(`⏱️ Temps de recherche MongoDB : ${mongoDuration} ms`);
        console.log(`⏱️ Temps de traitement côté serveur : ${processingDuration} ms`);
        console.log(`⏱️ Temps total de la requête : ${mongoDuration + processingDuration} ms`);

        resolve(transformedGames);
      } catch (error) {
        reject(error);
      }
    });
  },

  getGameById: async (game_id) => {
    try {
      const game = await Game.findOne({ game_id: Number(game_id) });
      if (!game) {
        throw new Error("Jeu non trouvé");
      }
      return apiFunctions.transformToFrench(game);
    } catch (error) {
      throw new Error(`Erreur lors de la récupération du jeu : ${error.message}`);
    }
  },

  getTopRatedByField: async (field, value, lang) => {
    const fieldWithLanguage = ["genres", "game_modes", "themes"];
    const filter = fieldWithLanguage.includes(field) && lang
      ? { [`${field}.${lang}`]: { $regex: new RegExp(escapeRegExp(value), "i") } }
      : { [field]: { $regex: new RegExp(escapeRegExp(value), "i") } };

    try {
      const games = await Game.find(filter).sort({ added: -1 }).limit(10);
      if (!games.length) {
        throw new Error(`Aucun jeu trouvé pour le champ : ${field} avec la valeur : ${value}`);
      }
      return games.map(apiFunctions.transformToFrench);
    } catch (error) {
      console.error(`Erreur dans getTopRatedByField: ${error.message}`);
      throw error;
    }
  },

  processLogin: async (user_email, user_pass, req) => {
    if (!user_email) {
      throw new Error("No Email has been specified.");
    }

    if (!user_pass) {
        throw new Error("No password has been specified.");
    }

    try {
        const user = await User.findOne({ email: user_email }).select({ user_id: 1, pass: 1, username: 1, email: 1, createdAt: 1, registrationToken: 1});

        if (!user) {
            throw new Error("The data entered did not allow you to be authenticated.");
        }

        if (user.registrationToken) {
          throw new Error("The account is not activated.");
        }

        const isMatch = await bcrypt.compare(user_pass, user.pass);
        if (!isMatch) {
            throw new Error("The data entered did not allow you to be authenticated.");
        }

        const createdAtDate = new Date(user.createdAt);

        const accessToken = jwt.sign(
            {
                user_id: user.user_id,
                username: user.username,
                email: user.email,
                createdAt: new Intl.DateTimeFormat('en-US').format(createdAtDate),
            },
            process.env.ACCES_JWT_SECRET,
            { expiresIn: '15m', algorithm: 'HS256' }
        );

        const refreshToken = jwt.sign({
          user_id: user.user_id 
          },
          process.env.REFRESH_JWT_SECRET, 
          {
            expiresIn: '5d',
            algorithm: 'HS256',
          }
        );



        return { accessToken, refreshToken };
    } catch(e) {
        throw e;
    }
  
  },

  logoutProcess: async (refreshToken, accessToken, req) => {
    if (!refreshToken || !accessToken) throw new ReferenceError('Both refreshToken and accessToken are required.');
    if(typeof refreshToken !== "string" || typeof accessToken !== "string") throw new TypeError('Wrong type arguments.');

    if (!req.headers['user-agent']) throw new Error("User-Agent header is missing.");
      
    if (!req.user) throw new ReferenceError("User infos are missing.");

    const user = req.user;
      
    try {
      const agent = useragent.parse(req.headers['user-agent']);

      const tokens = [
        {
          token: accessToken,
          type:"access",
          user_id: user.user_id,
          createdAt: new Date(),
          expiredAt: new Date(Date.now() + 15 * 60 * 1000), // Expires in 15 minutes
          ipAddress: req.headers['x-forwarded-for'] || req.socket.remoteAddress,
          deviceInfo: agent.device,
          isRevoked: false,
          revokedAt: null,
        },

        {
          token: refreshToken,
          type:"refresh",
          user_id:  user.user_id,
          createdAt: new Date(),
          expiredAt: new Date(Date.now() + 5 * 24 * 60 * 60 * 1000), // Expires in 5 days
          ipAddress: req.headers['x-forwarded-for'] || req.socket.remoteAddress,
          deviceInfo: agent.device,
          isRevoked: false,
          revokedAt: null,
        }

      ]
      
      const updatedUser = await User.findOneAndUpdate(
        { user_id: user.user_id },
        { $push: { tokens: {$each: tokens } } },
        { new: true }
      )

      if (!updatedUser) {
        throw new Error("User not found or update failed.", updatedUser);
      }

    } catch (e) {
      throw new Error(` An error has occured: ${e.message}`);
    }

       
    // have to return InsertMany value
    return { message: 'Successful disconnection', removeAccessToken: true };
},
  changePassword: async (user_email, new_password) => {

    if (!user_email || !new_password) throw new Error("Arguments missing.");

    try {
        // Search the user in the database
        const user = await User.findOne({ email: user_email }).select({ pass: 1});
        if (!user) {
            throw  new Error("No user was found with the specified email address.");
        }

        // Check the compliance of the password
        if (!checkIfPassIsValid(new_password)) {
            throw new Error("The password must contain at least 8 characters, 1 uppercase letter, and one special character.");
        }

        // Check if the new password is different from the old one
        const isSamePassword = await bcrypt.compare(new_password, user.pass);
        if (isSamePassword) {
            throw  new Error("The new password must be different from the old one.");
        }

        // Hash the new password
        const hashedPassword = await hashPassword(new_password);

        // Update the user's password in the database
        await User.updateOne(
          { email: user_email },
          { $set: { pass: hashedPassword } } 
        );
        
        return {message: "The password has been changed successfully.", removeAccessToken: true, redirectUrl:'/login'};
    } catch (e) {
      throw new Error(` An error has occured: ${e.message}`);
    }
  }
,
  delUser: async (user_id, attempt_pass) => {
  // Validate the input parameters
    try {
        if (!user_id) {
            throw new Error("No user id specified.");
        }
        if (!attempt_pass) {
            throw new Error("No password specified.");
        }
        if (attempt_pass.length > 128) {
            throw new Error("The information provided is incorrect.");
        }


        // Retrieve the user from the database
        const user = await User.findOne({ user_id }).select({ pass: 1 });
        if (!user) {
            throw new Error("No user has been found.");
        }

        // Compare the provided password with the stored password
        const isSamePassword = await bcrypt.compare(attempt_pass, user.pass);
        if (!isSamePassword) {
            throw new Error("The information provided is incorrect.");
        }

        // Delete the user from the database
        return await User.deleteOne({ user_id });
    } catch(e) {
          throw new Error(`An error has occured: ${e.message}`);
    }
  },

  addUser: async (user_email, user_pass, user_username, token) => {
    if (!user_email || !user_pass || !user_username || !token) throw new Error("missing arguments.");
    if (typeof user_email !== "string" || typeof user_pass !== "string" || typeof user_username !== "string") throw new Error("Wrong type arguments.");

    try {

        // Check if email / pass / username are valid.
        if (!checkIfEmailIsValid(user_email)) throw new Error('Invalid email.');
        if (!checkIfPassIsValid(user_pass)) throw new Error('Invalid password.');
        if (!checkIfUserNameIsValid(user_username)) throw new Error('Invalid username.');

        // Check if email or  username is already taken.
        const  existingUser = await User.findOne({
          $or: [
            { email: user_email },
            { username: user_username }
          ]  
        }).select({ email: 1, username: 1});

        if (existingUser) {
          if (existingUser.email === user_email) {
            throw new Error('Email already taken.');

          } else {
            throw new Error(`Username already taken.`);
          }
        }

        const hashPass= await hashPassword(user_pass);

        const response = await User.create({ email:user_email, pass:hashPass, username:user_username, registrationToken: token });
        return response
    } catch (e) {
        throw new Error(`An error has occured: ${e.message}`);
    }
}
, 

sendFinalisationMail: async (to, token) => {

  if (!to || !token) throw new Error('Token or recipient is missing.');
  
  const html = `
    <p>Hey !!!</p>
    <p>Merci de t’être inscrit sur <strong>GameVerse</strong>, le paradis des gamers 🎉 !</p>
    <p>Pour finaliser ton inscription et rejoindre notre communauté, clique sur le bouton ci-dessous :</p>
    <p><a href="http://localhost:3000/login?token=${token}" style="padding: 10px 20px; color: white; background-color: #007bff; text-decoration: none; border-radius: 5px;">Valider mon inscription</a></p>
    <p><strong>⚠️ Attention :</strong> Tu as 3 jours pour valider ton inscription. Après ce délai, ton inscription sera annulée et tu devras recommencer.</p>
    <p>Si tu n’as pas demandé cette inscription, ignore simplement cet e-mail.</p>
    <p>Merci de faire partie de l’aventure GameVerse 🎮 !</p>
    <p>À très bientôt,<br>L’équipe <strong>GameVerse</strong></p>
    <br>
    <p style="text-align: center; color:black">
      <img src="https://i.imgur.com/p0XpO6K.png" alt="Bannière GameVerse" style="max-width: 100%; height: auto; border-radius: 8px;">
    </p>
  `
  const mailOptions = {
    from: "gameverse.service@gmail.com",
    to,
    subject: "GameVerse finaliser ton inscription.",
    html
  }

  try {
    await transporter.sendMail(mailOptions);
    return "Email sended.";
  } catch (e) {
    throw new Error(`An error has occured: ${e.message}`);
  }
},

finalizeRegistration: async (registrationToken) => {
  if (!registrationToken) throw new Error('Token is missing.');

  try {
    const updateUser = await User.findOneAndUpdate(
      { registrationToken },
      { $unset: {
          registrationToken: "",
          deletionDate: ""
       }},
      { new: true }
    );

    if (!updateUser) throw new Error('User not found.');

    return "Inscription finalisé.";
  } catch (e) {
    throw new Error(`An error has occured: ${e.message}`);
  }
},


  getUser: async (user_id) => {
    if (!user_id) throw new ReferenceError("No User Id specified.");

    try {
      const user = await User.findOne({ user_id }).select({
        user_id: 1,
        username: 1, 
        email: 1, 
        profile_picture: 1,
        bio: 1,
        createdAt: 1,
        
      });

      if (!user) throw new Error(`User not found.`);

      return user;
    } catch (e) {
      throw new Error(`An error has occured: ${e.message}`);
    }

  },

  getUserGameList: async (user_id) => {
    // If no user_id is provided, throw an error
    if (!user_id) {
        throw new Error("The user_id has not been specified.");
    }

    if (typeof user_id !== "number") {
        throw new Error("Wrong type argument.");
    }

    try {
         // Get the user from the database
        const user = await User.findOne({ user_id }).select({ game_list: 1});
        
        // If the user does not exist, throw an error
        if (!user) {
            throw new Error("Your request could not be processed, please check again.");
        }

        // Get the user's game list from the database
        const gameList = await Game.find({ game_id: { $in: user.game_list } }).select({ game_id: 1, cover: 1, title: 1 });

        // Return the game list along with any other additional information
        return gameList;

    } catch(e) {
        throw new Error(`An error has occured: ${e.message}`);
    }
  },

  addGameToList: async (user_id, game_id) => {
    if (!user_id) {
        throw new Error("No user_id specified.");
    }

    if (!game_id) {
        throw new Error("No game_id specified.");
    }

    if (typeof game_id != "number" || typeof user_id !== "number") {
        throw new Error("Arguments must be number.");
    }
   
    try {
        // Check if the game exist
        const game = await Game.findOne({ game_id});
        if (!game) {
            throw new Error("The game has not been found.");
        }

        // Update the userGameList
        const user = await User.findOneAndUpdate( 
          {user_id},
          { $addToSet: { game_list: game.game_id } } ,
          { returnDocument: "after" }
        );

        if (!user) {
            throw new Error("The user has not been found.");
        }

        
        await Game.findOneAndUpdate(
          { game_id },
          { $inc: { added: 1 } },
        );

       return user.game_list;
        
    } catch(e) {
      throw new Error(`An error has occured: ${e.message}`);
    }
  },

  removeGameToList: async (user_id, game_id) => {
    if (!user_id) {
        throw new Error("No user_id specified.");
    }

    if (!game_id) {
        throw new Error("No game_id specified.");
    }

    if (typeof game_id !== "number" || typeof user_id !== "number") {
        throw new Error("Arguments must be numbers.");
    }

    try {
        
        const game = await Game.findOne({ game_id });
        if (!game) {
            throw new Error("The game has not been found.");
        }

        // Del the game from the list
        const user = await User.findOneAndUpdate(
            { user_id }, 
            { $pull: { game_list: game_id } },
            { returnDocument: "after" }
        );

        if (!user) {
            throw new Error("The user has not been found.");
        }

        await Game.findOneAndUpdate(
          { game_id },
          { $inc: { added: -1 } },
        );

        return user.game_list;
    } catch (e) {
        throw new Error(`An error has occurred: ${e.message}`);
    }
  },

  addComment: async (user_id, comment_content, game_id, parent_id) => {
    try {
        // Verifying the user's existence
        const user = await User.findOne(user_id).selec({ user_id: 1});
        if (!user) {
            throw new Error('User not found.');
        }

        // Verifying the game's existence
        const game = await Game.findOne({ game_id }).select({ game_id: 1 });
        if (!game) {
            throw new Error('Game not found.');
        }

        // Create a new comment
        const newComment = {
            user_id,
            content: comment_content,
            game_id,
            parent_id,
        };

        // Save it in the bd
        const response = await Comment.create(newComment);

        // Return the response
        return "Comment has been created";
    } catch(e) {
      throw new Error(`An error has occurred: ${e.message}`);
    }
  },

  delComment: async (user_id, game_id, comment_id) => {

   try {
      if (!user_id || !game_id || !comment_id) throw new Error("Arguments missing.");

      // Check if the user exists in the database
      const user = await User.findOne(user_id).selec({ user_id: 1});
      if (!user) {
          throw new Error("Resource not found.");
      }

      // Check if the game exists in the database
      const game = await Game.findOne({ game_id }).select({ game_id: 1 });
      if (!game) {
          throw new Error("Game not found.");
      }

      // Fetch all comments of the game and verify the comment exists
      await Comment.findOneAndUpdate({comment_id});

      return "Comment has been deleted."

   } catch(e) {
      throw new Error(`An error has occurred: ${e.message}`);
   }

  },

  fetchGameComments: async (game_id, page_number) => {
    // Vérification que les paramètres sont définis
    if (!game_id) {
        throw new Error("Game Id not specified.");
    }

    if (!page_number) {
        throw new Error("Page number not specified.");
    }


    try {
        // Check if game exist
        const game = await Game.findOne({game_id}).select({ game_id: 1 });
        if (!game) {
            throw new Error(`Game not found.`);
        }

        const gameComments = await Comment.find({ game_id }).skip( ( page_number - 1) * 10 ).limit(10);

        return gameComments;
    } catch (e) {
      throw new Error(`An error has occurred: ${e.message}`);
    }
  },


  fetchUserDevices: async (user_id) => {
    if (!user_id) throw new Error("User no specified.");

    try {

      const devices = await User.aggregate([ 
        { $match: { user_id } },
        { $unwind: "$tokens" },
        { $group: { _id: null, distinctDevices: { $addToSet: "$tokens.deviceInfo" } } },
        { $project: { _id: 0, distinctDevices: 1 } }
      ]);

      return devices[0];

    } catch (e) {
      throw new Error(`An error has occured: ${e.message}`);
    }
  }

}

  


  module.exports = apiFunctions;