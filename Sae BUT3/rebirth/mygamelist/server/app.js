import express from 'express';
import cors from 'cors';
// import mongoose, { mongo } from 'mongoose';
import { mongomock } from './mongomock.js'; // Database mocké.
import jwt from 'jsonwebtoken';
import crypto from 'crypto-js';
import dotenv from 'dotenv';
import bcrypt from 'bcrypt';
import cookieParser from 'cookie-parser'; 
import nodemailer from 'nodemailer';
import useragent from 'useragent';
import mongoose from 'mongoose';


mongoose.connect("mongodb://127.0.0.1:27017/gameverse", { useNewUrlParser: true, useUnifiedTopology: true })
  .then(() => console.log("Connecté à MongoDB avec succès!"))
  .catch(err => console.error("Erreur de connexion à MongoDB :", err));

  const tokenSchema = new mongoose.Schema({
    token: { type: String, required: true },
    type: { type: String, enum: ['access', 'refresh'], required: true },
    userId: { type: mongoose.Schema.Types.ObjectId, ref: 'User', required: true },
    createdAt: { type: Date, default: Date.now },
    expiredAt: { type: Date },
    isRevoked: { type: Boolean, default: false },
    revokedAt: { type: Date, default: null },
    ipAddress: { type: String },
    deviceInfo: { type: String },
  });
  
  const TokensCollection = mongoose.model('Tokens', tokenSchema);

const app = express();

// Charger le fichier d'environnement, contenant les clés secrètes.
dotenv.config({ path: '/home/rds/Desktop/rebirth/mygamelist/server/secret_keys.env' });

app.use(express.json()); // pour analyser le JSON des requêtes.

// Configuration Cors
const corsOptions = {
    origin: 'http://localhost:3000', // L'origine exacte à autoriser.
    credentials: true, // Autorise l'envoi des cookies et des credentials.
    allowedHeaders:['Content-Type', 'Authorization'] //En-têtes autorisés.
  };

  app.use(cors(corsOptions));

app.use(express.urlencoded({ extended: true }));
app.use(cookieParser(process.env.COOKIE_SECRET)); // Facilite l'accès aux cookies.

// JWT Config
const options = {
    expiresIn: '15m',  // Expiration du token (15 minutes).
    algorithm: 'HS256'      // L'algorithme de signature à utiliser (ici HMAC avec SHA-256).
    
};


const checkIfEmailIsValid = (email) => {
    const emailRegex = /^(?=.{1,55}$)[a-zA-Z0-9](?!.*\.\.)[a-zA-Z0-9._%+-]{0,62}@[a-zA-Z0-9.-]{1,63}\.[a-zA-Z]{2,6}$/;

    return emailRegex.test(email);
}

const checkIfUserNameIsValid = (username) => {
    const usernameRegex = /^(?=.{7,25}$)(?!.*--)(?!.*([a-zA-Z])\1\1)[a-zA-Z0-9](?!.*-$)[a-zA-Z0-9-]*[a-zA-Z0-9]$/;

    return usernameRegex.test(username);
}

const checkIfPassIsValid = (password) => {
    const passRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/;

    return passRegex.test(password);

}

const hashPassword = async (password) => {
    try{
        const saltRounds=10; // Nb de tours pour gen le sel (plus il est élévé, plus c'est sécurisé).
        const hashPassword = await bcrypt.hash(password, saltRounds);
        return hashPassword

    } catch(e){
        return e;
    }
    
}

const verifyToken = (req, res, next) => {
    const authHeader = req.headers.authorization;

    // Vérifier la présence de l'en-tête Authorization.
    if (!authHeader){
        return res.status(401).json({ message: `Unauthorized: L'action effectué nécessite d'être connecté.` }); // Retourne une reponse avec un status 401 et un message de non authorisation.
    }

    // Extraire le token.
    const accessToken = authHeader.split(' ')[1];
    try {
        // Vérifier et décoder le JWT.
        const decoded_data = jwt.verify(accessToken, process.env.ACCES_JWT_SECRET);
        console.log("decoded_data",decoded_data)
        // Ajouter les données utilisateur dans la requête.
        req.user =  decoded_data;
        next(); // Passe au middleware ou à la route suivant.
    } catch (e) {
        if (e.name === 'TokenExpiredError' || e.name === "JsonWebTokenError") {
            return refreshAccesToken(req, res, next); // Appeler le middleWare de rafraîchissement.
        } else {
            return res.status(401).json({ error: 'Token invalide'});
        }
    }
    
    
}

const refreshAccesToken = (req, res, next) => {
    const refreshToken = req.signedCookies.refreshToken;
    
    if (refreshToken) {
        jwt.verify(refreshToken, process.env.REFRESH_JWT_SECRET, (error, decoded) => {
            if (error) {
                res.status(401).json({message:'refreshToken inexistant',redirectUrl: 'http://localhost:3000/'});
            } else {
                const newAccessToken = jwt.sign({
                    ...req.user, // Récupérer les données de l'ancien accessToken.
                    "csrf_token":crypto.lib.WordArray.random(32).toString(crypto.enc.Hex)
                }, process.env.ACCES_JWT_SECRET, options);

                req.newAccesToken = newAccessToken;
            }
        });
        next();
    } else {
        res.status(401).json({ message:'Refresh Token manquant.' ,redirectUrl: 'http://localhost:3000/', removeAccessToken:true});
    }
}

const checkIfTokenRevoked = async (req, res, next) => {
    const accessToken = req.headers.authorization.split(" ")[1];
    const refreshToken = req.signedCookies.refreshToken;

    if (accessToken && refreshToken) {
        try {
            const accessTokenIsRevoked = await TokensCollection.findOne({token: accessToken, isRevoked: true});
            const refreshTokenIsRevoked = await TokensCollection.findOne({token: refreshToken, isRevoked: true});

            if (accessTokenIsRevoked || refreshTokenIsRevoked) {
                return res.status(401).json({message:`Unauthorized: acces or refresh token are revoked.`});
            }

            next();
        } catch(e) {
            return res.status(500).json({message:`problem encountered during operation.`});
        }
        
    } else {
        return res.status(401).json({message:`Unauthorized: no tokens found.`});
    }

}

const authRequiredRoutes = ['/mygamelist', '/profile', '/settings']; 

const checkAuthorization = (req, res, next) => {
    if (authRequiredRoutes.includes(req.originalUrl) && !req.user) {
        return res.status(401).json({ message: 'Unauthorized: accès interdit.' });
    }
    next();
}



// Configuration du transporter
const transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
        user: process.env.EMAIL_USER, // Mail
        pass: process.env.EMAIL_PASS, // MDP d'application
    }
});

export const sendRecoveryMail = (to, text) => {
    const mailOptions = {
        from: process.env.EMAIL_USER,
        to, 
        subject:"MangaVerse procédure de récupération de mot de passe.",
        text,
    };

    return transporter.sendMail(mailOptions);
}

app.get('/search_game', (req,res)=>{
    const {title, platforms, genres, developers, publishers, game_modes, themes} = req.query;

    const game_id = Number(req.query.game_id);
    const page_number = Number(req.query.page_number) || 1;
    

    const params_to_verify = { title, game_id, platforms, genres, developers, publishers, game_modes, themes }; // Filtres à vérifier.

    const filters={}; // Filtres qui vont être utilisés.

    Object.entries(params_to_verify).forEach(([key,value]) =>{
        if(value) filters[key] = value; // Ajoute le filtre si défini.
    });


    mongomock.findGames(filters,page_number).then(games=>{
        console.log(games);
        res.json(games);
    }).catch(error =>{
        let statusValue;
        switch(true){
            case (error instanceof TypeError) || (error instanceof ReferenceError):
                statusValue=400;
                break;
            case(error.message === `Aucune données n'a été trouvé pour la requête saisie.`):
                statusValue=404;
                break;
            default:
                statusValue=500;
        }

        res.status(statusValue).json({message:error.message, status:error.status, timestamp:error.timestamp});
    })

});

app.get('/mygamelist', verifyToken, checkIfTokenRevoked, (req, res) => {
    const user_id = Number(req.query.user_id);
    const response ={};

    if (req.newAccesToken) {
        response['newAccesToken'] = req.newAccesToken;
    }
    mongomock.userGameList(user_id)
        .then(gameList => {

            if (gameList === null || gameList.length === 0) {
                res.status(404).json({ message: "Aucun jeu trouvé pour cet utilisateur." });
            } else {
                res.status(200).json({...response, gameList});
            }
        })
        .catch(error => {

            let statusValue;

            if( error instanceof TypeError || error instanceof ReferenceError){
                statusValue=400;
            } 
            else if(error.message === `L'utilisateur d'id (${user_id}) n'a pas été trouvé.`){
                statusValue=404;
            } 
            else {
                statusValue=500;
            }
            
            res.status(statusValue).json({message:error.message, status:error.status, timestamp:error.timestamp});
        });

});

app.post('/add_user', async (req,res)=>{

    const {user_email, user_username, user_pass} = req.body;

    if(!user_email || !user_username || !user_pass) return res.status(400).json({message:`Un ou plusieurs paramètres sont manquants.`, status:400, timestamp: new Date().toDateString()});

    if(!checkIfEmailIsValid(user_email)) {
        return res.status(500).json({
            message: `Email invalid.`,
            status:500,
            timestamp:new Date().toDateString()
        })
    };

    if(!checkIfUserNameIsValid(user_username)) { 
        return res.status(500).json({
            message: `Username invalid.`,
            status:500,
            timestamp:new Date().toDateString()
        })
    };

    if(!checkIfPassIsValid(user_pass)) {
        return res.status(500).json({
            message: `Mot de passe trop simple et/ou trop court.`,
            status:500,
            timestamp:new Date().toDateString()
        });
    };
    
    const hashPass= await hashPassword(user_pass);

    mongomock.addUser({"email":user_email, "pass":hashPass, "username":user_username,"Game_list":[],"profile_picture":""}).then(promise_response=>{
        res.json(promise_response);

    }).catch(error =>{

        let statusValue;

        if(error instanceof TypeError){
            statusValue=500;
        }
        else if(error.message === `L'email saisie n'est pas disponible.` || error.message === `L'username saisie n'est pas disponible.`){
            statusValue=409;
        }
        else if(error.message === `Un ou plusieurs paramètres sont manquants.`){
            statusValue=400;
        }
        else{
            statusValue=500;
        }

        res.status(statusValue).json({message:error.message, status:error.status, timestamp:error.timestamp});
    })

});

app.get('/login',verifyToken, (req, res) => {
    // Si l'utilisateur est déjà connecté, redirige-le ailleurs
    const authHeader = req.headers.authorization;

    if(req.user) {
        const accessToken = req.headers.authorization.split(' ')[1];
        if (accessToken) {
            return res.status(200).json({redirectUrl: 'http://localhost:3000/'});
        }
    }

    if (req.newAccesToken) {
        console.log(req.newAccesToken);
        return res.status(200).json({newAccessToken: req.newAccesToken || null, redirectUrl: 'http://localhost:3000/'})
    }
    
    res.status(200);
    
  });

app.post('/login_process', (req,res)=>{
    
    const user_email = req.body.user_email;
    const user_pass = req.body.user_pass;

    if(!user_pass) return res.status(400).json({message:`Aucun mot de passe n'a été spécifié.`});

    mongomock.findUser(user_email).then(user_info=>{
        const user = user_info;

        if(!user) throw new Error(`Les données saisies n'ont pas permis de vous authentifier.`);

        bcrypt.compare(user_pass,user.pass).then( async (isMatch) => {
            if(isMatch){
                const agent = useragent.parse(req.headers['user-agent']); // Facilite l'extraction des informations de l'agent.

                const accessToken = jwt.sign({
                    "user_id":user.user_id,
                    "user_email":user.user_email,
                    "photoprofil":user.photoprofil,
                    "csrf_token":crypto.lib.WordArray.random(32).toString(crypto.enc.Hex)
                }, process.env.ACCES_JWT_SECRET, options);

                const refreshToken = jwt.sign({},process.env.REFRESH_JWT_SECRET,{
                    expiresIn: '5d', 
                    algorithm: 'HS256'
                });
            
                res.cookie('refreshToken', refreshToken, {
                    httpOnly:true,          // Le cookie ne sera pas accessible depuis le JS.
                    secure:false,            // Le cookie sera envoyé via le protocol HTTPS. (mettre à true en production)
                    sameSite:'Lax',      // On accepte que les cookies venant du même domaine (comprend sous-domaines).  
                    maxAge: 5 * 24 * 60 * 60 * 1000,   // Expiration 5j.
                    signed: true,
                    credentials:true,
                });

                await TokensCollection.create({
                    token: accessToken, type: "access",
                    userId: new mongoose.Types.ObjectId(user.user_id),
                    createdAt: new Date(Date.now()).toUTCString(), expiredAt: new Date(Date.now() + 15 * 60 * 1000).toUTCString(),
                    ipAddress: req.headers['x-forwarded-for'] || req.socket.remoteAddress,
                    deviceInfo: agent.device 
                });

                await TokensCollection.create({
                    token: refreshToken,
                    type: "refresh",
                    userId: new mongoose.Types.ObjectId(user.user_id),
                    createdAt: new Date(Date.now()).toUTCString(),
                    expiredAt: new Date(Date.now() + 5 * 24 * 60 * 3600 * 1000).toUTCString(),
                    ipAddress: req.headers['x-forwarded-for'] || req.socket.remoteAddress,
                    deviceInfo: agent.device 
                });

                return res.status(200).json({accessToken});
            } else {
                return res.status(401).json({message: `Les données saisies n'ont pas permis de vous authentifier.`})
            }
        }).catch(error => {
            let statusValue;

            if (error instanceof ReferenceError) {
                statusValue = 400;
            } else {
                statusValue = 500;
            }

            return res.status(statusValue).json({ message: error.message, status: error.status, timestamp: error.timestamp });
        });
    
    }).catch(error =>{
        let statusValue;

        if (error instanceof ReferenceError) {
            statusValue = 400;
        } else {
            statusValue = 500;
        }
        return res.status(statusValue).json({message:error.message, status:error.status, timestamp:error.timestamp});
    })
        
});

app.post('/logout', verifyToken, async (req,res) => {
    const refreshToken = req.signedCookies.refreshToken;
    const accessToken = req.headers.authorization.split(' ')[1];

    if (refreshToken && accessToken) {
        await TokensCollection.updateOne(
            {token: refreshToken},
            {$set: { isRevoked: true, revokedAt: new Date(Date.now()).toUTCString()}}
        )

        await TokensCollection.updateOne(
            {token: accessToken},
            {$set: { isRevoked: true, revokedAt: new Date(Date.now()).toUTCString()}}
        )
    }
    res.clearCookie('refreshToken',{
        httpOnly:true,          
        secure:false,
        sameSite:'Lax', 
        signed: true,
    });

    res.status(200).json({message: `Deconnexion réussie`});
});

app.get('/fetch_game_comments', (req,res)=>{
    const game_id = Number(req.query.game_id);
    const page_number = Number(req.query.page_number || 1);
    
    mongomock.fetchGameComments(game_id,page_number).then(promise_response=>{
        res.json(promise_response);
    }).catch(error =>{
        let statusValue;

        if (error instanceof ReferenceError) {
            statusValue = 400;
        } 
        else if(error.message === `Le jeu d'id (${game_id}) n'a pas été trouvé dans la bd.`) {
            statusValue = 401;
        } else {
            statusValue = 500;
        }

        res.status(statusValue).json({message:error.message, status:error.status, timestamp:error.timestamp});
    })

});

app.post('/add_comment', verifyToken, (req,res)=>{
    const user_id = Number(req.body.user_id);
    const comment_content = String(req.body.comment_content);
    const game_id=Number(req.body.game_id);
    const parent_id = Number(req.body.parent_id) || 0; //Si parent_id est undefined, on assigne 0.

    mongomock.addComments({user_id,comment_content,game_id,parent_id}).then(promise_response=>{
        res.json(promise_response);
    }).catch(error =>{
        let statusValue;

        if(error instanceof ReferenceError) {
            statusValue = 400;
        } else {
            statusValue = 500;
        }
        res.status(statusValue).json({message:error.message, status:error.status, timestamp:error.timestamp});
    })
    
});

app.post('/reply_to_comment', verifyToken, (req,res)=>{
    if(req.session.user_id){
        const game_id = Number(req.body.game_id);
        const comment_id=Number(req.body.target_comment_id);
        const user_id = Number(req.body.user_id);
        const target_user_id = Number(req.body.target_user_id);
        const user_comment = req.body.response_content;
    
        mongomock.replyToComment(game_id, comment_id, user_id, target_user_id, user_comment).then((promise_response) => {
            res.json(promise_response);
        }).catch((error) => {
            res.status(500).json({message: "Soucis rencontré lors du reply", error});
        })
    } else {
        res.redirect('/')
    }
});

app.post('/add_game_to_list', verifyToken, (req,res)=>{
    const user_id = Number(req.body.user_id);
    const game_id = Number(req.body.game_id);
    
    mongomock.addGameIntoList(user_id,game_id).then((promise_response)=>{
        res.json(promise_response);
    }).catch((error)=>{
        res.status(500).json({message: "Soucis rencontré lors de l'ajout du jeu :",error})
    })
   
});

app.post('/like_comment', verifyToken, (req,res)=>{
    const user_id = Number(req.body.user_id);
    const game_id = Number(req.body.game_id);
    const comment_id= Number(req.body.comment_id);
    
    mongomock.addCommentLike(user_id,game_id,comment_id).then((promise_response)=>{
        res.json(promise_response);
    }).catch((error)=>{
        res.status(500).json({message: "Soucis rencontré lors de l'ajout du jeu :",error})
    })
   
});

app.post('/change_password', async (req,res)=>{
    const { user_email, new_password } = req.body;

    if (!user_email || !new_password) {
        return res.status(400).json({ message: "Email et nouveau mot de passe sont requis." });
    }

    if (!checkIfPassIsValid(new_password)) {
        return res.status(400).json({ message: "Le mot de passe doit contenir au moins 8 caractères, 1 lettre majuscule et un caractère spécial." });
    }


    try {
        // Recherche de l'utilisateur
        const user = await mongomock.findUser(user_email);
        if (!user) {
            return res.status(404).json({ message: "Utilisateur non trouvé." });
        }

        // Vérification si le mot de passe est le même
        const isSamePassword = await bcrypt.compare(new_password, user.pass);
        if (isSamePassword) {
            return res.status(400).json({
                message: "Le nouveau mot de passe doit être différent de l'ancien.",
                status: 400,
                timestamp: new Date().toDateString()
            });
        }

        // Vérification de la validité du mot de passe
        if (typeof new_password !== "string" || new_password.trim() === "") {
            return res.status(400).json({ message: "Le mot de passe est invalide." });
        }

        // Hash du nouveau mot de passe
        const hashedPassword =await bcrypt.hash(new_password,10);

        // Changement du mot de passe dans la base de données
        const promise_response = await mongomock.changePassword(user.user_id, hashedPassword);
        return res.status(200).json(promise_response);

    } catch (error) {
        // Capture des erreurs
        console.error("Erreur interne :", error);
        return res.status(500).json({ message: "Erreur interne.", error: error.message });
    }
    
   
});

// app.post('/send_password_recovery_mail',(req,res) => {
//     const user_email = req.user_email;

//     if(!user_email) return res.status(400).json({message:`Veuillez spécifier un mail`,status:400, timestamp: new Date().toDateString()});
//     if(!checkIfEmailIsValid(user_email)) return res.status(400).json({message:`Mail invalide`,status:400, timestamp: new Date().toDateString()});

//     mockData.findUser(user_email).then(user => {    
//         const cookieData = {    // Données qui seront stocké dans le cookie.
//             recovery_token: crypto.lib.WordArray.random(32).toString(crypto.enc.Hex),
//             user_id:user.user_id,
//             user_email:user.user_email,
//         }

//         res.cookie('recovery_cookie', JSON.stringify(cookieData), { // Ajoute le cookie dans l'entête de la réponse.
//             httpOnly: true,
//             secure: true,
//             maxAge: 60 * 60 * 1000, // 1h de durée de vie.
//             signed: true, // Signe le cookie pour garantir son intégrité.
//         });

//         const resetLink = (`https:5001/reset-password?token=${cookieData.recovery_token}`);
//         const text = `Cliquez sur le lien suivant pour réinitialiser votre mot de passe : ${resetLink}`;
//         sendRecoveryMail(user.user_email,text);

//         res.status(200).json(`L'email de récupération a bien été envoyé.`);
//     }).catch(error => {
//         res.status(500).json({message:`Une erreur est survenu lors de l'envoie du mail.`,status:500, timestamp: new Date().toDateString()});
//     })
   
// });

app.get('/most_added_games', (req,res)=>{
    
    mongomock.tenMostAddedGames().then((promise_response)=>{
        res.json(promise_response);
    }).catch((error)=>{
        res.status(500).json({message: "Soucis rencontré lors de l'ajout du jeu :",error})
    })
   
});

app.get('/top_rated_games_by_genre', (req,res)=>{
    const genre=req.query.genre;

    mongomock.topRatedGameByGenre(genre).then((promise_response)=>{
        res.json(promise_response);
    }).catch((error)=>{
        res.status(500).json({message: "Soucis rencontré lors de la récupération des top_rated_games_by_genre :",error})
    })
   
});

app.get('/most_recent_games', (req,res)=>{
    const page_number=req.query.page_number;
    const game_type=req.query.game_type || "any";

    mongomock.mostRecentGame(game_type,page_number).then((promise_response)=>{
        res.json(promise_response);
    }).catch((error)=>{
        res.status(500).json({message: "Soucis rencontré lors de la récupération des top_rated_games_by_genre :",error})
    })
   
});

const PORT = 5001; // Changez 5000 en un autre port, comme 5001

app.listen(PORT, () => {
  console.log(`Serveur en cours d'exécution sur http://localhost:${PORT}`);
});


export default app;
