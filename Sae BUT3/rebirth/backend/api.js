const express = require("express");
const bodyParser = require("body-parser");
const cors = require("cors");
const mongoose = require("mongoose");
const jwt = require('jsonwebtoken');
const dotenv =  require('dotenv');
const cookieParser = require('cookie-parser');
const apiFunctions = require('./api_functions.js')
const { applyTimestamps } = require("./models/Game.js");
const crypto = require('crypto');



// Configuration
const app = express();
const PORT = 5001;

// Configuration Cors
const corsOptions = {
  origin: 'http://localhost:3000', // L'origine exacte à autoriser.
  credentials: true, // Autorise l'envoi des cookies et des credentials.
  allowedHeaders:['Content-Type', 'Authorization'] //En-têtes autorisés.
};

//  Load the environment file containing the secret keys.
dotenv.config({ path: 'C:/Users/Test/Desktop/rebirth/rebirth/backend/secret_keys.env' }); // Didn't work with a relative path, so you'll have to adapt it to your system.

// JWT Config
const options = {
  expiresIn: '15m',  // Token expiry (15 minutes).
  algorithm: 'HS256'      // The signature algorithm (here HMAC with SHA-256).
  
};


// Middleware
app.use(cors(corsOptions));
app.use(bodyParser.json());
app.use(cookieParser("45V7acbU98B54dfla9*@cH74nJIwz-AI1954cvbn")); // Makes it easier to handle cookies




const refreshAccesToken = (req, res, next) => {
  const refreshToken = req.signedCookies.refreshToken;
 
  if (!refreshToken) return res.status(401).json({ message:'Refresh Token missing.' ,redirectUrl: '/login', removeAccessToken:true}); 

  try {
    
    jwt.verify(refreshToken, process.env.REFRESH_JWT_SECRET, async (error, decoded) => {
        if (error) {
            return res.status(401).json({message:'Invalid refreshToken',redirectUrl: '/login'});  
        } else {

            try {
              const user_id = decoded.user_id;

              const user = await apiFunctions.getUser(user_id);

              if (!user) return res.status(404).json({ message:'The information did not allow us to manage the request.' ,redirectUrl: '/login', removeAccessToken:true}); 

              const userData = user._doc;

              const newAccessToken = jwt.sign({
                  ...{
                    user_id: userData.user_id,
                    username: userData.username, 
                    email: userData.email, 
                    createdAt: userData.createdAt}, // Retrieve data from the old accessToken.

              }, process.env.ACCES_JWT_SECRET, options);

              req.newAccesToken = newAccessToken;
              next();

            } catch (e) {
                res.status(500).json({ message:'Error has occured during the process.' ,status: 500, timestamp: new Date().toString()}); 
            }
          } 
    });

  } catch (e) {
    return res.status(500).json({ message:'Unexpected error as occured.' ,status: 500, timestamp: new Date().toString()}); 
  }
}

const checkIfTokenRevoked = async (req, res, next) => {
  const accessToken = req.headers.authorization.split(" ")[1];
  const refreshToken = req.signedCookies.refreshToken;

  // if (accessToken && refreshToken) {
  //     try {
  //         const accessTokenIsRevoked = await TokensCollection.findOne({token: accessToken, isRevoked: true});
  //         const refreshTokenIsRevoked = await TokensCollection.findOne({token: refreshToken, isRevoked: true});

  //         if (accessTokenIsRevoked || refreshTokenIsRevoked) {
  //             return res.status(401).json({message:`Unauthorized: acces or refresh token are revoked.`});
  //         }

  //         next();
  //     } catch(e) {
  //         return res.status(500).json({message:`problem encountered during operation.`});
  //     }
      
  // } else {
  //     return res.status(401).json({message:`Unauthorized: one or several tokens token are missing .`});
  // }

}


// Check the validity of the accessToken
const verifyToken = (req, res, next) => {
  const authHeader = req.headers.authorization;

  // Check for the presence of the Authorization header.
  if (!authHeader){
      return res.status(401).json({ message: `Unauthorized: The request does not contain an Authorization header.` }); // Returns a response with a 401 status and a non-authorization message.
  }

  // Extract the accesToken.
  const accessToken = authHeader.split(' ')[1];

  try {
      // Check and decoded the accesToken
      const decoded_data = jwt.verify(accessToken, process.env.ACCES_JWT_SECRET);
      
      // Add the user's datas in the request
      req.user =  decoded_data;
      next(); // Goes to the next middleware or route.
  } catch (e) {
      if (e.name === 'TokenExpiredError' || e.name === 'JsonWebTokenError') {
          return refreshAccesToken(req, res, next); // Call the refreshing middleware.
      } else {
          return res.status(401).json({ message: 'invalid Token', redirectUrl: '/login'});
      }
  }
  
  
}

const checkCommentCompliance = (req, res, next) => {
  const comment = req.body.comment_content;

  // Check that the comment_content parameter has been specified
  if (!comment) return res.status(400).json({ message: 'No comment specified.', status: 400, timestamp: new Date().toString() });

  // Check that the comment does not exceed 1000 characters
  if (comment.length > 1000) return res.status(400).json({ message: 'The comment exceed thousand characters.', status: 400, timestamp: new Date().toString() });

  // Check that the comment is not an forbidden word (Collection of banwords ?)

  next(); // Go to the next path
}

const checkIfAccountIsActivated = (req, res, next) => {
  
}

const checkIfNewAccessToken = (req) => {
  if (req.newAccesToken) {
      return {newAccessToken: req.newAccesToken}
  }

  return {};
}


// Routes API

app.get("/top_rated_by_field", async (req, res) => {
  const { field, value, lang = "fr" } = req.query;

  if (!field || !value) {
    return res.status(400).json({ error: "Les paramètres 'field' et 'value' sont requis." });
  }

  try {
    const games = await apiFunctions.getTopRatedByField(field, value, lang);
    res.status(200).json(games);
  } catch (error) {
    console.error(`Erreur lors de la récupération des jeux pour ${field}=${value}:`, error);
    res.status(500).json({ error: error.message || "Erreur interne du serveur" });
  }
});



app.get("/filters", async (req, res) => {
  try {
    const filters = await apiFunctions.getFilters();
    res.status(200).json(filters);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});


app.get("/search_game", async (req, res) => {
  try {
    const games = await apiFunctions.searchGames(req.query, req.query.page_number);
    res.status(200).json(games);
  } catch (error) {
    res.status(500).json({ error: `Erreur lors de la recherche des jeux : ${error.message}` });
  }
});

app.get("/game/:game_id", async (req, res) => {
  try {
    const game = await apiFunctions.getGameById(req.params.game_id);
    res.status(200).json(game);
  } catch (error) {
    res.status(500).json({ error: `Erreur lors de la récupération du jeu : ${error.message}` });
  }
});


app.get("/most_recent_games", async (req, res) => {
  try {
    const games = await apiFunctions.getMostRecentGames(req.query.page_number);
    res.status(200).json(games);
  } catch (error) {
    res.status(500).json({ error: `Erreur lors de la récupération des jeux récents : ${error.message}` });
  }
});

app.get("/autocomplete", async (req, res) => {
  const { query, limit = 10 } = req.query;

  if (!query || query.trim() === "") {
    return res.status(400).json({ error: "Le paramètre 'query' est requis." });
  }

  try {
    const suggestions = await apiFunctions.getAutocomplete(query, limit);
    res.status(200).json(suggestions || []); // Toujours retourner un tableau
  } catch (error) {
    console.error(`Erreur lors de l'autocomplétion : ${error.message}`);
    res.status(500).json({ error: "Erreur interne du serveur." });
  }
});


app.post('/add_user', async (req,res)=>{

  const {user_email, user_username, user_pass} = req.body;

  if(!user_email || !user_username || !user_pass) return res.status(400).json({message:`One or more parameters are missing.`, status:400, timestamp: new Date().toString()});

  try {
     
      const response = await apiFunctions.addUser(user_email, user_pass, user_username);

      // Have to send verification mail


      res.json({data:response});

  } catch(e) {
      let statusValue;

      if (e.message === 'Email or username already taken.'){
          statusValue=409;
      }
      else if (e.message === "missing arguments." || e.message === "Wrong type arguments." || e.message.includes("Invalid")){
          statusValue=400;
      }
      else{
          statusValue=500;
      }

      res.status(statusValue).json({message:e.message, status:e.status, timestamp:e.timestamp});
  }

  

});

app.post('/auth/login_process', async (req, res) => {
  const { user_email, user_pass } = req.body;
  
  try {
      const { accessToken, refreshToken } = await apiFunctions.processLogin(user_email, user_pass, req);

      console.log('Le refresh token gen:', refreshToken);

      res.cookie('refreshToken', refreshToken, {
          httpOnly: true, // The cookie will not be accessible from JS
          secure: false,   // The cookie will be only send with HTTPS protocol
          sameSite: 'Lax',    // accept only cookies who are from same domain
          maxAge: 5 * 24 * 60 * 60 * 1000,
          signed: true,
          credentials: true,
      });

      return res.status(200).json({ data:accessToken });
  } catch (e) {
    
      return res.status(500).json({
          message: e.message || 'Internal server error',
          status: 500,
          timestamp: new Date().toISOString(),
      });
  }
});


app.get('/auth/status', verifyToken, (req, res) => {
  const response = {};
  console.log("Cookies signés (route auth) :", req.signedCookies.refreshToken);
  // Si l'utilisateur est déjà connecté, redirige-le ailleurs
  if(req.user) {
     return res.status(200).json({isConnected: true});
  }

  else if (req.newAccesToken) {
    console.log(req.newAccesToken);
    return res.status(200).json({newAccessToken: req.newAccesToken || null, isConnected: true})
  }
 
  res.status(200).json({isConnected: false});
  
});

app.post('/auth/logout', verifyToken, async (req,res) => {
  const refreshToken = req.signedCookies.refreshToken;
  const accessToken = req.headers.authorization.split(' ')[1];

  try {
      const response = await apiFunctions.logoutProcess(refreshToken, accessToken, req);

      res.clearCookie('refreshToken', {
          httpOnly: true,
          secure: false,
          sameSite: 'Lax',
          signed: true,
      });

      res.status(200).json({data:response, redirectUrl: "/", ...checkIfNewAccessToken(req)});
  } catch (e) {
      res.status(500).json({ message: e.message || 'Internal server error', status: 500 });
  }
});

app.post('/auth/change_password', verifyToken, async (req,res)=>{
  const user_email = req.body.user_email;
  const new_password = req.body.new_password;

  try {
      const response= await apiFunctions.changePassword(user_email, new_password);

      res.clearCookie('refreshToken', {
        httpOnly: true,
        secure: false,
        sameSite: 'Lax',
        signed: true,
    });
    
      return res.status(200).json({data:response});
  } catch (e) {
      return res.status(500).json({ message: e.message, status:500, timestamp: new Date().toString() });
  }
 
});

app.post('/auth/del_account', verifyToken, async (req, res) => {
  const user_id = Number(req.user?.user_id);
  const attempt_pass = req.user_pass;

  if (!user_id) return res.status(400).json({message: 'No user id specified.', status: 400, timestamp: new Date().toString()});
  if (!attempt_pass) return res.status(400).json({message: 'No password specified.', status: 400, timestamp: new Date().toString()});
  if (attempt_pass.length > 128) return res.status(400).json({message: 'The information provided is incorrect.', status: 400, timestamp: new Date().toString()});

  try {
      // Call the delUser function to delete the user
      const response = await apiFunctions.delUser(user_id, attempt_pass);

      // Send a successful response
      res.status(200).json({data:response});
  } catch (e) {
      // Determine the appropriate status code
      let statusValue;

      if (e.message.includes("specified") || e.message === "The information provided is incorrect.") {
          statusValue = 400;
      } else if (e.message.includes("found")) {
          statusValue = 404;
      } else {
          statusValue = 500;
      }

      // Send the error response
      res.status(statusValue).json({
          message: e.message,
          status: e.status,
          timestamp: e.timestamp,
      });
  }
})

app.post('/auth/register', async (req,res)=>{

  const {user_email, user_username, user_pass} = req.body;

  if(!user_email || !user_username || !user_pass) return res.status(400).json({message:`One or more parameters are missing.`, status:400, timestamp: new Date().toString()});
  console.log("username:", user_username)
  try {
     
      const token = crypto.randomBytes(32).toString("hex");

      if (!token) return res.status(500).json({message:`Token is undefined.`, status:400, timestamp: new Date().toString()});

      const user =  await apiFunctions.addUser(user_email, user_pass, user_username, token);

      // Send finalization mail
      const response = apiFunctions.sendFinalisationMail(user_email, token);

      res.json({data:response});

  } catch(e) {
      res.status(500).json({message:e.message, status:500, timestamp:new Date().toString()});
  }

});





app.get('/user/account', verifyToken, async (req, res) => {
  const user_id = Number(req.query.user_id) || req.user?.user_id;

  console.log("user_id valeur:", user_id);
  if (!user_id) return res.status(400).json({message: "Argument missing.", status: 400, timestamp: new Date().toDateString()});

  try {
    const user = await apiFunctions.getUser(user_id);
    const data = {
      bio: user.bio,
      profile_picture: user.profile_picture,
      devices: await apiFunctions.fetchUserDevices(user_id)
    }

    res.status(200).json({data, ...checkIfNewAccessToken(req)});
  } catch (e) {
    res.status(500).json({message: `Error occurred during data retrieval: ${e.message}`, status: 400, timestamp: new Date().toDateString()});
  }
});

app.post('/user/registration_finalization', async (req, res) =>{
  const {registrationToken} = req.body;
 
  if (!registrationToken) return res.status(400).json({message: "Argument missing.", status: 400, timestamp: new Date().toDateString()});

  try {

     await apiFunctions.finalizeRegistration(registrationToken);

 
     res.status(200).json("ok");
    
  } catch (e) {

  }
});

app.get('/gamelist/:user_id?', verifyToken, async (req, res) => {
  let user_id = Number(req.query.user_id);  // Retrieving user_id from the route parameters

  
  // If user_id is not provided in the parameters, use the user_id from the token
  if (!user_id) user_id = req.user?.user_id;

  
  try {
      // Call the getUserGameList function
      const userGameList = await apiFunctions.getUserGameList(user_id);   

      // Send the response back with the game list
      res.status(200).json({data: userGameList, ...checkIfNewAccessToken(req)});

  } catch (e) {
      // Send the error response
      res.status(500).json({
          message: e.message,
          status: 500,
          timestamp: new Date().toString(),
      });
  }

});


app.post('/gamelist/add_game', verifyToken, async (req,res)=>{
  const user_id = req.user?.user_id;
  const game_id = Number(req.body.game_id);

  if (!user_id || !game_id) return res.status(400).json({message: "Argument missing.", status: 400, timestamp: new Date().toDateString()});

  try {
      const response = await apiFunctions.addGameToList(user_id, game_id);
      res.json({data:response, ...checkIfNewAccessToken(req)});
  } catch (e) {
      res.status(500).json({ message: e.message, status: 500, timestamp:new Date().toString() });
  }
 
});

app.post('/gamelist/del_game', verifyToken, async (req,res)=>{
  const user_id = req.user?.user_id;
  const game_id = Number(req.body.game_id);

  if (!user_id || !game_id) return res.status(400).json({message: "Argument missing.", status: 400, timestamp: new Date().toDateString()});

  try {
      const response = await apiFunctions.removeGameToList(user_id, game_id);
      res.status(200).json({data:response, ...checkIfNewAccessToken(req)});
  } catch (e) {
      res.status(500).json({ message: e.message, status: 500, timestamp:new Date().toString() });
  }
 
});

app.post('/game/add_comment', verifyToken, checkCommentCompliance, async (req,res)=>{
  const user_id = req.user.user_id;
  const comment_content = String(req.body.comment_content);
  const game_id=Number(req.body.game_id);
  const parent_id = Number(req.body.parent_id) || 0; // 0 if parent_id is undefined.

  try {
      const response = await apiFunctions.addComment(user_id, comment_content, game_id, parent_id);
      res.json(response);
  } catch (e) {
      res.status(500).json({
          message: e.message,
          status: 500,
          timestamp: new Date().toString(),
      });
  }
  
});

app.post('/game/del_comment', verifyToken, async (req,res)=>{
  const user_id = req.user.user_id;
  const comment_id = Number(req.body.comment_id);
  const game_id=Number(req.body.game_id);

  if (!user_id || !comment_id || !game_id) return  res.status(400).json({message: "Some arguments are missing.", status:400, timestamp: new Date().toString()});

  try {
      const response = await apiFunctions.delComment(user_id, game_id, comment_id);
      return res.status(200).json({data:response, ...checkIfNewAccessToken(req)});
  } catch (e) {
    res.status(500).json({
      message: e.message,
      status: 500,
      timestamp: new Date().toString(),
  });
  }
  
});

app.get('/game/fetch_comments', async (req,res)=>{
  const game_id = Number(req.query.game_id);
  const page_number = Number(req.query.page_number || 1);
  
  try {
      const response = await apiFunctions.fetchGameComments(game_id, page_number);
      res.json({data:response, ...checkIfNewAccessToken(req)});
  } catch (e) {
    res.status(500).json({
      message: e.message,
      status: 500,
      timestamp: new Date().toString(),
  });
  }

});



// Démarrage du serveur uniquement après la connexion à MongoDB
const startServer = async () => {
  try {
    await mongoose.connect("mongodb://localhost:27017/gameLibrary", {
      useNewUrlParser: true,
      useUnifiedTopology: true,
    });
    console.log("✅ Connecté à MongoDB");

    app.listen(PORT, () => {
      console.log(`🚀 Serveur API en cours d'exécution sur http://localhost:${PORT}`);
    });
  } catch (error) {
    console.error("❌ Erreur lors de la connexion à MongoDB :", error.message);
  }
};

// Démarrer le serveur
startServer();
