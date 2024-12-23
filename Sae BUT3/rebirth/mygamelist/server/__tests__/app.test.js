import request from 'supertest';
import agent from 'supertest-session'; // Pour des requêtes avec cookie persistant.
import app from '../app.js';
import jwt from 'jsonwebtoken';

process.env.JWT_SECRET = '454754fdfd7545d7f54'; // Fausse clé pour test.
process.env.COOKIE_SECRET = '487Abc*784BCVZEI14f'

describe('/search_game.',()=>{
    test('should return a list of games including the name requested', async() =>{

        //Arrange
        const attempt_title="Journey"
        const expected_response=[{
          "game_id": 1,
          "title": "Journey",
          "description": "A third-person adventure game in which the player, controlling a robed figure, makes a pilgrimage through a desert landscape to a rugged mountain with a beacon of light in the distance while uncovering the history of their people, rescuing and cooperating with friendly creatures, avoiding predatory ones and communicating with other travelers.",
          "platforms": [
              "PC (Microsoft Windows)",
              "PlayStation 3",
              "iOS",
              "PlayStation 4"
          ],
          "platform_logos": [
              {
                  "thumb": "//images.igdb.com/igdb/image/upload/t_thumb/plim.jpg",
                  "original": "//images.igdb.com/igdb/image/upload/t_original/plim.jpg"
              },
              {
                  "thumb": "//images.igdb.com/igdb/image/upload/t_thumb/tuyy1nrqodtmbqajp4jg.jpg",
                  "original": "//images.igdb.com/igdb/image/upload/t_original/tuyy1nrqodtmbqajp4jg.jpg"
              },
              {
                  "thumb": "//images.igdb.com/igdb/image/upload/t_thumb/pl6w.jpg",
                  "original": "//images.igdb.com/igdb/image/upload/t_original/pl6w.jpg"
              },
              {
                  "thumb": "//images.igdb.com/igdb/image/upload/t_thumb/pl6f.jpg",
                  "original": "//images.igdb.com/igdb/image/upload/t_original/pl6f.jpg"
              }
          ],
          "genres": [
              "Platform",
              "Adventure"
          ],
          "cover": {
              "thumb": "//images.igdb.com/igdb/image/upload/t_thumb/co1q8q.jpg",
              "original": "//images.igdb.com/igdb/image/upload/t_original/co1q8q.jpg"
          },
          "developers": [
              "ThatGameCompany"
          ],
          "publishers": [
              "Annapurna Interactive",
              "Sony Computer Entertainment"
          ],
          "artworks": [
              {
                  "thumb": "//images.igdb.com/igdb/image/upload/t_thumb/wbqiacfvz9tybz2xkvq6.jpg",
                  "original": "//images.igdb.com/igdb/image/upload/t_original/wbqiacfvz9tybz2xkvq6.jpg"
              },
              {
                  "thumb": "//images.igdb.com/igdb/image/upload/t_thumb/gvdadnl6c3wv1vfjoclx.jpg",
                  "original": "//images.igdb.com/igdb/image/upload/t_original/gvdadnl6c3wv1vfjoclx.jpg"
              },
              {
                  "thumb": "//images.igdb.com/igdb/image/upload/t_thumb/hzjyixtxakdbltne2ips.jpg",
                  "original": "//images.igdb.com/igdb/image/upload/t_original/hzjyixtxakdbltne2ips.jpg"
              },
              {
                  "thumb": "//images.igdb.com/igdb/image/upload/t_thumb/zl3fejxnms0vc5ggvugi.jpg",
                  "original": "//images.igdb.com/igdb/image/upload/t_original/zl3fejxnms0vc5ggvugi.jpg"
              },
              {
                  "thumb": "//images.igdb.com/igdb/image/upload/t_thumb/ekdes6jgjmwwfwlxpx6f.jpg",
                  "original": "//images.igdb.com/igdb/image/upload/t_original/ekdes6jgjmwwfwlxpx6f.jpg"
              },
              {
                  "thumb": "//images.igdb.com/igdb/image/upload/t_thumb/osfmmqyc3nkf8ahkrw9b.jpg",
                  "original": "//images.igdb.com/igdb/image/upload/t_original/osfmmqyc3nkf8ahkrw9b.jpg"
              },
              {
                  "thumb": "//images.igdb.com/igdb/image/upload/t_thumb/hwnjiwo3mookxjxpuler.jpg",
                  "original": "//images.igdb.com/igdb/image/upload/t_original/hwnjiwo3mookxjxpuler.jpg"
              },
              {
                  "thumb": "//images.igdb.com/igdb/image/upload/t_thumb/rvvvakz9bfovqmz0iq9m.jpg",
                  "original": "//images.igdb.com/igdb/image/upload/t_original/rvvvakz9bfovqmz0iq9m.jpg"
              },
              {
                  "thumb": "//images.igdb.com/igdb/image/upload/t_thumb/g5kj40c0drtes2eafmf7.jpg",
                  "original": "//images.igdb.com/igdb/image/upload/t_original/g5kj40c0drtes2eafmf7.jpg"
              },
              {
                  "thumb": "//images.igdb.com/igdb/image/upload/t_thumb/spcbrvdv4jgittwiotrp.jpg",
                  "original": "//images.igdb.com/igdb/image/upload/t_original/spcbrvdv4jgittwiotrp.jpg"
              },
              {
                  "thumb": "//images.igdb.com/igdb/image/upload/t_thumb/evqu3ma8mxwgpfirhyod.jpg",
                  "original": "//images.igdb.com/igdb/image/upload/t_original/evqu3ma8mxwgpfirhyod.jpg"
              },
              {
                  "thumb": "//images.igdb.com/igdb/image/upload/t_thumb/ar4jg.jpg",
                  "original": "//images.igdb.com/igdb/image/upload/t_original/ar4jg.jpg"
              }
          ],
          "game_modes": [
              "Single player",
              "Multiplayer",
              "Co-operative"
          ],
          "player_perspectives": [
              "Third person",
              "Side view"
          ],
          "themes": [
              "Fantasy",
              "Kids"
          ],
          "franchises": [],
          "dlcs": [],
          "game_engines": [
              "PhyreEngine"
          ],
          "videos": [
              "https://www.youtube.com/watch?v=61DZC-60x20",
              "https://www.youtube.com/watch?v=mU3nNT4rcFg"
          ],
          "release_date": "2012-03-13",
          "total_rating": 89.80978909482897,
          "total_rating_count": 1027,
          "added":500,
        
      }];

        // Act
        const response = await request(app).get('/search_game').query({title:attempt_title}); 

        // Asserts
        expect(response.status).toBe(200); // Vérifie que la réponse a un statut 200
        expect(response.body).toEqual(expected_response);
    })

    test("should throw exception if no query is specified", async ()=>{

        // Arrange
        const expected_response=`Aucun paramètre n'a été spécifié.`;

        // Act
        const response = await request(app).get('/search_game');

        // Asserts
        expect(response.status).toBe(400);
        expect(response.body.message).toEqual(expected_response);
  
  
    });

    test("should throw exception if the game does not exist", async ()=>{

        // Arrange
        const attempt_title="Rds";
        const expected_response=`Aucune données n'a été trouvé pour la requête saisie.`;

        // Act
        const response = await request(app).get('/search_game').query({title:attempt_title});

        // Asserts
        expect(response.status).toBe(404);
        expect(response.body.message).toEqual(expected_response);

    });

});


describe('/add_user',()=>{

    test('should add an new user in the database.', async() =>{

        //Arrange
        const attempt_user_email = "overwatchfinito@gmail.com";
        const attempt_user_username = "username8482";
        const attempt_user_pass = "Celineceline667*";

        // Act
        const response = await request(app).post('/add_user').send({user_email:attempt_user_email, user_pass:attempt_user_pass, user_username:attempt_user_username}); 

        // Asserts
        expect(response.status).toBe(200);
        expect(response.body).toEqual("L'utilisateur a bien été ajouté.");

    });

    test('should throw an exception if one of the queries is not specified.', async() =>{

      //Arrange
      const attempt_user_email ="area8481@gmail.com";
      const attempt_user_username = "Jjkcestguez77";
      
      const expected_response =`Un ou plusieurs paramètres sont manquants.`;

      // Act
      const response = await request(app).post('/add_user').send({user_email:attempt_user_email, user_username:attempt_user_username}); 

      // Asserts
      expect(response.status).toBe(400);
      expect(response.body.message).toEqual(expected_response);

  });

    test('should throw an exception if the email or the username are already taken.', async() =>{

        //Arrange
        const attempt_user_email ="Thomaslebouc@gmail.com";
        const attempt_user_username = "SolidCommeGoku";
        const attempt_password = "Gohan95*";
        
        const expected_response ="L'email saisie n'est pas disponible.";

        // Act
        const response = await request(app).post('/add_user').send({user_email:attempt_user_email, user_username:attempt_user_username, user_pass:attempt_password}); 

        // Asserts
        expect(response.status).toBe(409);
        expect(response.body.message).toEqual(expected_response);

    });

    test('should throw an exception if the password or the username are invalid.', async() =>{

        //Arrange
        const attempt_user_email ="louisssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss.phillipegmail.com";
        const attempt_user_username = "username3316";
        const attempt_password = "mdpmdpA95*";
        
        const expected_response =`Email invalid.`;

        // Act
        const response = await request(app).post('/add_user').send({user_email:attempt_user_email, user_username:attempt_user_username, user_pass:attempt_password}); 

        // Asserts
        expect(response.status).toBe(500);
        expect(response.body.message).toEqual(expected_response);

    });

    
});

describe('/login_process',()=>{
   
    test('Should create a JWT and redirect at home page, if the informations are rights.', async() =>{
        //Arrange
        const attempt_user_email="3316@gmail.com";
        const attempt_user_pass="monMotDePasseSecurise123!";
        
        // Act
        const response = await agent(app).post('/login_process').send({user_email:attempt_user_email, user_pass:attempt_user_pass}); 

        // Asserts
        expect(response.status).toBe(302);
        expect(response.headers['set-cookie']).toBeDefined();

    });

    test('Should not authorize login if the information is incorrect.', async() =>{
      //Arrange
      const attempt_user_email="tequiero@gmail.com";
      const attempt_user_pass="toutpourquitterlequartier";

      const expected_response = "Les données saisies n'ont pas permis de vous authentifier.";

      // Act
      const response = await request(app).post('/login_process').send({user_email:attempt_user_email, user_pass:attempt_user_pass}); 

      // Asserts
      expect(response.status).toBe(500);
      expect(response.body.message).toEqual(expected_response);

    });

    test('Should throw an exception if one information is not given.', async() =>{
        //Arrange
        const attempt_user_email="tequiero@gmail.com";
    

        const expected_response = `Aucun mot de passe n'a été spécifié.`;

        // Act
        const response = await request(app).post('/login_process').send({user_email:attempt_user_email}); 

        // Asserts
        expect(response.status).toBe(400);
        expect(response.body.message).toEqual(expected_response);

    });


});

describe('/fetch_game_comments', () => {
    test('Should return the comments of a given page for a game.', async () => {
        //Arrange
        const attempt_game_id = 1;
        const attempt_page_number = 1;

        const expected_response = [{
            "comment_id":1,
            "user_id":6309,
            "game_id":1,
            "content":"Super",
            "parent_id":0,
            "likes":[],
            "created_at":"2024-11-29T12:00:00Z"
        }] ;

        //Act
        const response = await request(app).get('/fetch_game_comments').query({game_id:attempt_game_id, page_number: attempt_page_number})

        //Asserts
        expect(response.status).toBe(200);
        expect(response.body).toEqual(expected_response);
  });

  
})



describe('/change_password', () => {
    test('should change the user password.', async () => {
        //Arrange
        const attempt_user_id = 3316;
        const attempt_user_email = "3316@gmail.com";
        const attempt_password = "Moddjito123*";

        const expected_response = `Le mot de pass de l'user ${attempt_user_id} a bien été changé.`;

        // Act
        const response = await request(app)
            .post('/change_password')
            .send({ user_email: attempt_user_email, new_password: attempt_password });
        
        // Asserts
        expect(response.status).toBe(200);
        expect(response.body).toEqual(expected_response);
    });
});


describe('/most_added_games',()=>{
    test('should fetch the ten most added games', async() =>{
        //Arrange
       const expected_response_length=10;
      

        // Act
        const response = await request(app).get('/most_added_games').query({}); 

        // Asserts
        expect(response.status).toBe(200);
        expect(response.body).toHaveLength(expected_response_length);
    })
});

describe('/top_rated_games_by_genre',()=>{
  test('should fetch the ten top rated games', async() =>{
      //Arrange
     const attempt_genre="Shooter";

     const expected_response_length=10;
    

      // Act
      const response = await request(app).get('/top_rated_games_by_genre').query({genre:attempt_genre}); 

      // Asserts
      expect(response.status).toBe(200);
      expect(response.body).toHaveLength(expected_response_length);
      
  })
});

describe('/most_recent_games',()=>{
  test('should fetch the ten most recent shooter games from page 2', async() =>{
      //Arrange
      const attempt_game_type="Shooter";
      const attempt_page_number=1;
      const expected_response_length=10;
    

      // Act
      const response = await request(app).get('/most_recent_games').query({game_type:attempt_game_type, page_number:attempt_page_number}); 

      // Asserts
      expect(response.status).toBe(200);
      expect(response.body).toHaveLength(expected_response_length);
      
  })
});

// describe('/send_password_recovery_mail',() => {
//     test('should send recovery email and set recovery cookie', async () => {
//         //Arrange
//         const attempt_user_id = 3316;
//         const attempt_user_email = "3316@gmail.com";
        
//         //Act
        
//         const response = await request(app).post('/send_password_recovery_mail').send({ user_email: attempt_user_email });

//         //Asserts
//         expect(response.status).toBe(200);
//         expect(response.body).toBe('L\'email de vérification a bien été envoyé.');

//         expect(sendRecoveryMail).toHaveBeenCalledWith(
//             attempt_user_email,
//             expect.stringContaining('Cliquez sur le lien suivant pour réinitialiser votre mot de passe')
//           );
      
//     })
// })


describe('Authorization dependent routes tests', () => {
    let cookie;


    beforeEach(async () => {
        // Créer un JWT pour le test
        const payload = {
            user_id: 3316,
            user_email: "3316@gmail.com"
        };
        
        cookie = jwt.sign(payload, process.env.JWT_SECRET, { expiresIn: '1h' });  // Génère un JWT signé

        // Simuler l'envoi du cookie dans les tests
    });

    
    describe('test on the mygamelist path', () => {
        test('should return the game list of a user, if he is authentificated', async() =>{
            // Arrange
             const expected_response = [1];
    
            // Act
            const response = await request(app).get('/mygamelist').set('Cookie', `jwt=${cookie}`);
    
            // Asserts
            expect(response.status).toBe(200);
            expect(response.body).toEqual(expected_response);
    
        });
    
        test('should return an exception if no user_id specified.', async() =>{
    
          // Arrange
          const expected_response = `Aucun user_id n'a été spécifié !!!`;
    
          // Act
          const response = await request(app).get('/mygamelist').set('Cookie', `jwt=${cookie}`);
    
          // Asserts
          expect(response.status).toBe(400); 
          expect(response.body.message).toEqual(expected_response);
    
        });
    
        test('should return an exception if the specified user does not exist.', async() =>{
    
          // Arrange
          const attempt_user_id = 5411111;
    
          const expected_response = `L'utilisateur d'id (${attempt_user_id}) n'a pas été trouvé.`;
    
          // Act
          const response = await request(app).get('/mygamelist').query({user_id:attempt_user_id}).set('Cookie', `jwt=${cookie}`);
    
          // Asserts
          expect(response.status).toBe(404); 
          expect(response.body.message).toEqual(expected_response);
    
        });
    });

    describe('/add_game_to_list',()=>{
        test('should add a game to a user list.', async() =>{
            //Arrange
            const attempt_user_id=3316;
            const attempt_game_id=2;
    
            const expected_response= `Le jeu a bien été ajouté à la liste de l'user :${attempt_user_id}`;
            
            // Act
            const response = await request(app).post('/add_game_to_list').send({user_id:attempt_user_id, game_id:attempt_game_id}).set('Cookie', `jwt=${cookie}`); 
    
            // Asserts
            expect(response.status).toBe(200);
            expect(response.body).toEqual(expected_response);
        })
    });

    describe('/like_comment',()=>{
        test('should increase by one the user comment.', async() =>{
            //Arrange
            const attempt_user_id=3316;
            const attempt_game_id=1;
            const attempt_comment_id=1;
    
            const expected_response = `Le commentaire ${attempt_comment_id} du jeu ${attempt_game_id} a bien été liké par l'user: ${attempt_user_id}`;
    
            // Act
            const response = await request(app).post('/like_comment').send({user_id:attempt_user_id, game_id:attempt_game_id, comment_id:attempt_comment_id}).set('Cookie', `jwt=${cookie}`); 
    
            // Asserts
            expect(response.status).toBe(200);
            expect(response.body).toEqual(expected_response);
        })
    });

    describe('/add_comment',()=>{
        test('Should add a comment to a game', async() =>{
            //Arrange
            const attempt_user_id = 3316;
            const attempt_user_comment = "que ca cook";
            const attempt_game_id = 1;
    
            const expected_response=` Le commentaire de l'user d'id(${attempt_user_id} a bien été ajouté au jeu (${attempt_game_id}.`;
    
            // Act
            const response = await request(app).post('/add_comment').send({user_id:attempt_user_id, comment_content:attempt_user_comment, game_id:attempt_game_id}).set('Cookie', `jwt=${cookie}`); 
    
            // Asserts
            expect(response.status).toBe(200);
            expect(response.body).toEqual(expected_response);
        });
    
        test('should reply to a comment, so add the response in the comment responses list.', async() =>{
          //Arrange
          const attempt_user_id = 3316;
          const attempt_user_comment = "je ne suis point d'accord mon cher ami.";
          const attempt_game_id = 1;
          const attempt_parent_id=1;
    
          const expected_response = ` L'user (${attempt_user_id} a bien répondu au commentaire d'id (${attempt_parent_id}) du jeu  d'id(${attempt_game_id}.`;
    
          // Act
          const response = await request(app).post('/add_comment').send({game_id:attempt_game_id, parent_id:attempt_parent_id, user_id:attempt_user_id, comment_content:attempt_user_comment}).set('Cookie', `jwt=${cookie}`); 
    
          // Asserts
          expect(response.status).toBe(200);
          expect(response.body).toEqual(expected_response);
      });
    
      test('Should not add a comment if the user does not exist.', async() =>{
        //Arrange
        const attempt_user_id = 9999;
        const attempt_user_comment = "que ca cook";
        const attempt_game_id = 1;
    
        const expected_response =`L'utilisateur ${attempt_user_id} est inexistant.`;
    
        // Act
        const response = await request(app).post('/add_comment').send({user_id:attempt_user_id, comment_content:attempt_user_comment, game_id:attempt_game_id}).set('Cookie', `jwt=${cookie}`); 
    
        // Asserts
        expect(response.status).toBe(400);
        expect(response.body.message).toEqual(expected_response);
    
      });
    
      test('Should not reply to a comment if the parent comment does not exist.', async() =>{
        //Arrange
        const attempt_user_id = 3316;
        const attempt_user_comment = "que ca cook";
        const attempt_game_id = 1;
        const attempt_parent_id = 444;
    
        const expected_response ="Le commentaire parent d'id (444) n'existe pas.";
    
        // Act
        const response = await request(app).post('/add_comment').send({user_id:attempt_user_id, comment_content:attempt_user_comment, game_id:attempt_game_id, parent_id:attempt_parent_id}).set('Cookie', `jwt=${cookie}`); 
    
        // Asserts
        expect(response.status).toBe(400);
        expect(response.body.message).toEqual(expected_response);
        
      });
    
    });

    test('should delete the authentification cookie', async () => {
        //Act
        const response = await request(app).get('/logout').set('Cookie', `jwt=${cookie}`);

        const cookies = response.headers['set-cookie'].join(';');
        const cookieExpireValue = cookies.match(/Expires=(.*?);/);
        const expiryDate = new Date(cookieExpireValue[1]);

        //Asserts

        
        expect(response.status).toBe(200);
        expect(expiryDate.getTime()).toBeLessThan(Date.now());
        
    });

})
