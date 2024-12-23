import { mockData } from "./mockdata.js";



const isEqual = (first_array,second_array)=>{

    if(first_array.length === second_array.length){
        return first_array.every((array_value,index) => array_value === second_array[index]);
    }
    return false;
}

const inUsers = (user_id)=>{
  return mockData["users"].some((user)=> user["user_id"] === user_id);

}

const checkIfEmailIsAlreadyTaken= (email)=>{
   return mockData["users"].some((user)=> user["email"] === email);
}

const checkIfUsernameIsAlreadyTaken =(username)=>{
  return mockData["users"].some((user)=> user["username"] === username);

}

const checkIfGameExist = (game_id) => {
  return mockData["games"].some((game) => game.game_id === game_id);
}

const checkIfCommentExist = (comment_id)=>{
  try{
    return mockData["comments"].some((comment) => comment["comment_id"] === comment_id);
    
  } catch(e){
    return e;
  }
}

const findTitleAbbreviation = (str)=>{
  try{
    const str_trim = str.trim();
    let abreviation="";
    const words = str_trim.split(" ");

    for(let word of words){
      if(word.length > 0){
        abreviation += word[0];
      }
    } 

    return abreviation;
  }catch(e){
    console.error(e.message);
  }

}

 export const mongomock={
  findGames: (object,page_number) => {
    return new Promise((resolve, reject) => {
      try {
        // Vérifications initiales
        if (Object.keys(object).length === 0)
          return reject(new ReferenceError(`Aucun paramètre n'a été spécifié.`));
        if (page_number === undefined)
          return reject(new ReferenceError(`Veuillez spécifier le numéro de la page !!!`));
        if (typeof page_number !== "number")
          return reject(new TypeError(`L'argument page_number doit être de type number.`));
        if (mockData["games"].length === 0)
          return reject(new Error(`La collection jeux semble vide.`));

        const maxGamesPerPage = 10; // Nombre maximum de jeux par page
        const lastPage = page_number - 1; // Page précédente (basée sur un index 0)
        const indexFirstGameOfThePage = lastPage * maxGamesPerPage; // Index du premier jeu de la page
        const indexLastGameOfThePage = page_number * maxGamesPerPage; // Index du dernier jeu de la page

        // Filtrage des résultats selon les critères
        const results = mockData["games"].filter(game =>
          Object.keys(object).every(key => {
            const keyValue = object[key];
            const gameValue = game[key];

            if (keyValue && (typeof keyValue === "string" || typeof keyValue === "number")) {
              if (typeof gameValue === "number") {
                // Si la valeur de l'attribut du jeu est un nombre
                return gameValue === keyValue;
              }
              if (Array.isArray(gameValue)) {
                // Si l'attribut est un tableau (par exemple, genres ou plateformes)
                const keyValues = keyValue.split(',').map(value => value.trim().toLowerCase());
                return keyValues.every(item =>
                  gameValue.some(gameItem => String(gameItem).toLowerCase().includes(item))
                );
              }
              // Comparaison de chaînes de caractères insensible à la casse
              return String(gameValue).toLowerCase().includes(String(keyValue).toLowerCase()) ||  String(findTitleAbbreviation(gameValue).toLowerCase()).includes(keyValue.toLowerCase());
            }
            // Comparaison pour des structures plus complexes (tableaux, objets, etc.)
            return isEqual(keyValue, gameValue);
          })
        );

        // Vérifications post-filtrage
        if (results.length === 0)
          return reject(new Error(`Aucune données n'a été trouvé pour la requête saisie.`));

        // Pagination des résultats
        if (results.length - 1 >= indexFirstGameOfThePage) {
          return resolve(results.slice(indexFirstGameOfThePage, indexLastGameOfThePage));
        } else {
          return resolve([]); // Pas de résultats pour cette page
        }
      } catch (e) {
        return reject(new Error(`Un problème avec la base de données a empêché la récupération des jeux : ${e.message}`));
      }
    });
  },


  userGameList :(user_id) =>{
    return new Promise((resolve, reject) => {
      try {
        if(!user_id) return reject(new ReferenceError(`Aucun user_id n'a été spécifié !!!`));
        if(typeof user_id !== "number") return reject(new TypeError(`l'attribut user_id doit être un number.`));

        const user = mockData["users"].find((user)=> user.user_id === user_id);

        if (!user) {
          reject(new Error(`L'utilisateur d'id (${user_id}) n'a pas été trouvé.`));  // Rejet de la promesse si l'utilisateur n'a pas trouvé.
        }

        resolve(user["game_list"]);
      } catch (e) {
        reject(new Error(`Soucis rencontré avec la bd lors de la récupération de la liste de jeux de l'user ${user_id}: ${e.message}`));  // Rejeter la promesse en cas d'exception.
      }
    });
  },
  

  addUser: (user)=>{
    return new Promise((resolve,reject)=>{

      try {

        if(typeof user === "object" ){

          if(user["email"] && user["username"] && user["pass"]){
            
            if(checkIfEmailIsAlreadyTaken(user["email"])) return reject(new Error(`L'email saisie n'est pas disponible.`));
            if(checkIfUsernameIsAlreadyTaken(user["username"])) return reject(new Error(`L'username saisie n'est pas disponible.`));

            mockData["users"].push({...user, "created_at":new Date()});
            
          } else {
              return reject(new Error(`Un ou plusieurs paramètres sont manquants.`));
          }

        } else {
            return reject(new TypeError(`l'attribut user doit être de type objet !!!`));
        }

        return resolve(`L'utilisateur a bien été ajouté.`);

      } catch(e){
          return reject(new Error(`Problème rencontré lors de l'ajout d'un utilisateur à la bd: ${e.message}`));
      }
    })

      },
  addGameIntoList: (user_id,game_id)=>{
      return new Promise((resolve,reject)=>{
        try{
          if(typeof user_id === "number" && typeof game_id === "number"){
            if(inUsers(user_id)){
              const game= mockData["games"].find(game => game.game_id === game_id);
              const user= mockData["users"].find(user => user.user_id === user_id);

              user["game_list"].push(game);
              resolve(`Le jeu a bien été ajouté à la liste de l'user :${user_id}`);

            } else {
              reject(new Error("L'utilisateur n'a pas été trouvé dans la bd."));
            }
        } else {
          reject(new Error("Les valeurs passé en paramètres ne sont pas du bon type."));
        }
    
        } catch(e){
          reject(`Soucis lors de l'ajout à la list: ${e.message}`);
        }
      })

  },

  addComments: (newComment)=>{
    return new Promise((resolve,reject)=>{
      try {
        const {comment_content, parent_id, user_id,game_id} = newComment;

        if(parent_id !== 0 && !checkIfCommentExist(parent_id)) return reject(new ReferenceError(`Le commentaire parent d'id (${parent_id}) n'existe pas.`));

        if(typeof user_id === "number" && typeof parent_id === "number" && typeof comment_content === "string" && typeof game_id === "number"){
          if(!inUsers(user_id)) reject(new ReferenceError(`L'utilisateur ${user_id} est inexistant.`)); 

          if(!checkIfGameExist(game_id)) reject(`Le jeu d'id (${game_id} n'a pas été trouvé.)`); // Vérifie l'existance du jeu.
          
          // Ajoute le commentaire dans la bd mocké.
          mockData["comments"].push({...newComment,"created_at": new Date()});

          //Retourne un message différent selon parent_id.
          return  parent_id === 0 ? resolve(` Le commentaire de l'user d'id(${user_id} a bien été ajouté au jeu (${game_id}.`) : resolve(` L'user (${user_id} a bien répondu au commentaire d'id (${parent_id}) du jeu  d'id(${game_id}.`);
          
        } else {
            reject(new TypeError(`Un ou plusieurs attributs n'ont pas le bon type de valeur attendue.`)); // Retourne une exception au gestionnaire de la promesse.
        }
  
      } catch (exception){
          reject(new Error(`Soucis rencontré lors de l'ajout du commentaire: ${exception.message}`)) //Retourne une exception contenant l'erreur de exception géré.
        }
    })
},

  hasLikedComment:(user_id,comment_id,game_id)=>{
      const game = mockData["games"].find(game => game.game_id === game_id);
      if (!game) return false; // Jeu non trouvé

      const comment = game["comments"].find(comment => comment.comment_id === comment_id);
      if (!comment) return false; // Commentaire non trouvé

      return comment["likes"].some(like => like.user_id === user_id);
  },

  hasLikedResponse:(user_id,game_id,comment_id,response_id)=>{
      try{
        const game = mockData["games"].find(game => game["game_id"] === game_id);
        if (!game) return false; // Jeu non trouvé

        const comment = game["comments"].find(comment => comment["comment_id"] === comment_id);
        if (!comment) return false; // Commentaire non trouvé

        const response = comment["responses"].find((response) =>response["response_id"] === response_id);
        if(!response) return false;

        return response["likes"].some(like => like["user_id"] === user_id);
      } catch(e){
          console.error(e.message);
      }
  },

  fetchGameComments: (game_id,page_number) => {
    return new Promise((resolve,reject) => {
      try{

        if(!game_id) return reject(new ReferenceError(`Le paramètre game_id n'a pas été spécifié.`));
        if(typeof game_id !== "number") return reject(new TypeError(`On s'attend à ce que l'attribut game_id soit un number.`));

        const game = mockData["games"].filter((game) => game.game_id === game_id);
        const maxCommentPerPages = 10;
        const indexFirstComment = (page_number - 1) * maxCommentPerPages;
        const indexLastComment = page_number * maxCommentPerPages;

        if(!game) return reject(new Error(`Le jeu d'id (${game_id}) n'a pas été trouvé dans la bd.`));

        const game_comments = mockData["comments"].filter((comment) => comment.game_id === game_id);

        if(game_comments.length - 1 >= indexFirstComment){
          return resolve(game_comments.slice(indexFirstComment,indexLastComment));
        } else {
          return resolve([]);
        }

      } catch(e){
        return reject(new Error(`Une erreur n'a pas permis la récupération des commentaires de la page ${page_number} du jeu ${game_id}: ${e.message}`));
      }
    })
  },

  addCommentLike: (user_id,game_id,comment_id)=>{
      return new Promise((resolve,reject) =>{
        try{
          if(!user_id || !game_id || !comment_id) reject(new Error(`Un ou plusieurs paramètres ne sont pas définis`));
          if(typeof user_id !== "number" || typeof game_id !== "number" || typeof comment_id !== "number") reject(new Error(`Un ou plusieurs paramètres ne sont pas du bon type.`));
          if(!inUsers(user_id)) return reject(new Error(`L'user d'id (${user_id}) est inexistant.`));

          const game = mockData["games"].find(game => game.game_id === game_id);
          if (!game) return reject(new Error(`Le jeu ${game_id} n'a pas été trouvé.`)); // Si le jeu n'existe pas on rompt la promesse.

          const comment = mockData["comments"].find(comment => comment.comment_id === comment_id);
          if (!comment) return reject(new Error(`Le commentaire ${comment_id} n'a pas été trouvé.`)); // Si le commentaire n'existe pas on rompt la promesse.

          comment["likes"].push({"user_id":user_id}); // Ajoute le like au commentaire.
          
          return resolve(`Le commentaire ${comment_id} du jeu ${game_id} a bien été liké par l'user: ${user_id}`); // On achève la promesse.
        

        } catch(e) {
            return reject(new Error(`Un soucis n'a pas permis l'ajout du commentaire: ${e.message}`));
        }
      })

  },

  addResponseLike:(user_id,game_id,comment_id,response_id)=>{
      const comment=this.findComment(comment_id,game_id);
      if(!comment) return false;

      const response=comment["responses"].find((response)=> response["response_id"] === response_id);
      if(!response) return false;

      response["likes"].push({user_id});
      return true;
  },

  deleteCommentLike: (user_id,game_id,comment_id) =>{
      if(this.hasLikedComment(user_id,comment_id,game_id)){
          const comment= this.findComment(comment_id,game_id);
          comment["likes"]=comment["likes"].filter((like)=> like["user_id"] !== user_id);
      }
  },

  deleteResponseLike:(user_id, game_id, comment_id, response_id) =>{
      if(this.hasLikedResponse(user_id,game_id,comment_id,response_id)){
          const comment=this.findComment(comment_id,game_id);
          if(!comment) return false;

          const response=comment["responses"].find((response)=> response["response_id"] === response_id);
          if(!response) return false;

          response["likes"]=response["likes"].filter((like)=> like["user_id"] !== user_id);
          return true;

          
      }
  },

  findUser: (user_email) => {
    return new Promise((resolve, reject) => {
      try {
        if(!user_email) return reject(new ReferenceError(`Aucun mail n'a été spécifié.`));
        if(typeof user_email !== "string") return reject(new TypeError(`L'attribut user_email doit être de type string !!!`));

        const user = mockData["users"].find(
          (user) => user["email"] === user_email
        );
        if (user) {
          return resolve(user);
        } else {
          return resolve(null);
        }
      } catch (e) {
          return reject(new Error(`Une erreur est survenue lors de la récupération d'un user: ${e.message}`));
      }
    });
  },

  changePassword: (user_id,new_password) =>{
    return new Promise((resolve,reject) => {
      try{
        if(!user_id || !new_password) return reject(ReferenceError(`Un ou plusieurs paramètres ne sont pas définis.`));
        if(typeof user_id !== "number" || typeof new_password !== "string") return reject(TypeError(`Un ou plusieurs paramètres ne sont pas du bon type.`));
        
          const user = mockData["users"].find(user => user.user_id === user_id);
          user.pass=new_password;
          return resolve(`Le mot de pass de l'user ${user_id} a bien été changé.`);
        
      } catch (e) {
          return reject(new Error(`Une erreur n'a pas permis le changement de mot de passe. Erreur: ${e.message}`));
      }
    })
  },

  tenMostAddedGames:() => {
    return new Promise((resolve,reject) => {
      try{
        if(mockData["games"].length === 1) resolve(mockData["games"]);
        else if(mockData["games"].length > 0){
          const sorted_list=mockData["games"].sort((a,b) => b.added - a.added);
          return resolve(sorted_list.slice(0,10));
        } else {
        return reject(new Error(`Aucun jeu présent dans la base de données.`));
        }
      } catch(e) {
          return reject(`Une erreur est survenu lors de l'exctraction des jeux :${e.message}`);
      }
    })
  },

  topRatedGameByGenre:(genre) => {
    return new Promise((resolve,reject) =>{
      try{
        if(typeof genre !== "string") reject(new Error(`L'argument genre doit être une chaîne de caractères.`));
        if(genre.trim() === "") reject(new Error(`La chaîne ne doit pas être vide !!!`));
        let games=mockData["games"].filter((game) => game.genres.includes(genre) );
        if(games.length === 0) reject(new Error(`Aucun jeux de type ${genre} n'a été trouvé.`));
        games.sort((a,b) => b.total_rating - a.total_rating);
        return resolve(games.slice(0,10));

      } catch(e){
          return reject(`Une erreur n'a pas permis la récupération des jeux les mieux notés: ${e.message}`);
      }
    })
  },

  mostRecentGame:(game_type, page_number) => {
    return new Promise ((resolve,reject) => {
      try {
        if(!page_number) return reject(new Error(`Veuillez spécifier un numéro de page.`));
        if(page_number === 0) return reject(new Error(`La numérotation des pages comment par 1.`));
        if( mockData["games"].length === 0 ) return reject(new Error(`La bd ne comporte aucun jeux.`)); // Rompt la promesse si la collection jeux est vide.
        if( mockData["games"] === 1) return resolve(mockData["games"]); // Achève la promesse si il n'y a qu'un jeu dans la collection.

        const lastPage= page_number - 1;
        const maxGamesPerPage = 10;
        const indexFirstGameOfThePage = lastPage * maxGamesPerPage;
        const indexLastGameOfThePage = page_number * maxGamesPerPage;
        let game;

        game_type !== "any" ? game = mockData["games"].filter((game) => game.genres.includes(game_type)) : game = mockData["games"]; // Récupère tous les jeux si aucun genre n'est spécifié.

        let recent_games=game.sort((a,b) => new Date(b.release_date) - new Date(a.release_date)); // Tri la collection par release_date décroissant.

        if(game.length - 1 >= indexFirstGameOfThePage){
          recent_games = recent_games.slice(indexFirstGameOfThePage,  indexLastGameOfThePage); // On récupère les 10 jeux de la page.
          return resolve(recent_games); // Renvoie une version réduite du tableau trié.

        } else {
          return resolve([]); // Renvoie un tableau vide puisqu'il n'y a plus rien à récupérer.
        }
        
      } catch (e) {
          return reject(`Une erreur n'a pas permis la récupération des jeux les plus récents : ${e.message}`);
      }
    })
  }
}