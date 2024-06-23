$(document).ready(function() {

    // Écouteurs d'événements pour les boutons de langue
    $('#lang-fr').click(function() {
      updateContent('fr');
    });
  
    $('#lang-en').click(function() {
      updateContent('en');
    });
  
    $('#lang-es').click(function() {
      updateContent('es');
    });
  
    // Fonction pour mettre à jour le contenu de la page en fonction de la langue sélectionnée
    function updateContent(language) {
      // Définir les traductions pour chaque langue
      var translations = {
        'fr': {
          'siteTitle': 'Le Grand Continent',
          'Accueil': 'ACCUEIL',
          'Evenement': 'ÉVÉNEMENTS',
          'APropos': 'À PROPOS DE NOUS',
          'welcomeHeading': 'Bienvenue sur mon site !',
          'welcomeMessage': 'Contenu de la page d\'accueil.',
          'reseaux':'Réseaux sociaux',
          'mentionsLegales':'Mentions légales :',
          'autre':'Autre lien :',
          'connexion':'Connexion',
          'inscription':'Inscription',
          'PDC':'Politique de confidentialité',
          'CGU':"Conditions d'utilisation",
          'newletters':'Inscription à la newsletter',
          'Titrearticle':'Débat du Grand Continent',
          'ref1':"Ces dernières années, l'intelligence artificielle a connu des avancées majeures. Leurs productions qui étaient jusqu'à présent imparfaites sont aujourd'hui très difficiles à différencier d'un humain. De plus, l'intelligence artificielle est de plus en plus utilisée dans le monde professionnel. Art, économie, code, l'intelligence artificielle est présente dans tous les domaines professionnels.",
          'ref2':"Le Grand Continent organise \"L'Intelligence Artificielle au Service du Monde du Travail\", un événement rassemblant des professionnels et des chercheurs de l'IA lors d'une conférence portant sur l'intelligence artificielle et la direction qu'elle prend.",
          'ref3':"De nombreux professionnels de l'intelligence artificielle participeront à l'événement. Parmi les intervenants, nous aurons le plaisir d'entendre :",
          'ref4':'Les Invités',
          'ref5':"Anne-Marie Kermarrec : Professeure et directrice de la section informatique de l'école polytechnique fédérale de Lausanne et chercheuse renommée, autrice de \"Numérique, compter avec les femmes\".",
          'ref6':"André Seznec : Professeur d'informatique à l'Université de Rennes 1, expert en architecture des ordinateurs et en microprocesseurs. Ses recherches ont conduit à des avancées significatives dans la conception de mémoires cache et de stratégies de prédiction de branchement, contribuant ainsi à améliorer les performances des processeurs.",
          'ref7':"Fredo Durand : Chercheur de premier plan dans le domaine de la vision par ordinateur et de la synthèse d'images. Professeur au Massachusetts Institute of Technology, il a ouvert de nouvelles perspectives dans les domaines de la réalité virtuelle et de la réalité augmentée.",
          'ref8':"Alain Bui : Expert en intelligence artificielle et en apprentissage automatique. Professeur et chercheur, il a contribué à développer des méthodes avancées pour l'analyse de données complexes et hétérogènes, avec des applications dans des domaines tels que la santé, les réseaux sociaux et l'optimisation des ressources.",
          'ref9':'Luc Julia : Personnalité clé dans le domaine de l\'intelligence artificielle, ayant joué un rôle central dans le développement de Siri, l\'assistant vocal d\'Apple. En tant que chercheur et entrepreneur, il a apporté des contributions significatives à l\'interface homme-machine, à l\'apprentissage automatique et à la conception de systèmes intelligents.',
        },
        'en': {
          'siteTitle': 'Le Grand Continent',
          'Accueil': 'HOME',
          'Evenement': 'EVENTS',
          'APropos': 'ABOUT US',
          'welcomeHeading': 'Welcome to my website!',
          'welcomeMessage': 'Homepage content.',
          'reseaux':'Social networks',
          'mentionsLegales':'Legal Notice :',
          'autre':'Other link :',
          'connexion':'Log in',
          'inscription':'Sign up',
          'PDC':'Privacy policy',
          'CGU':'Terms of service',
          'newletters':'Newsletter Sign-Up',
          'Titrearticle':'Great Continent Debate',
          'ref1':'In recent years, artificial intelligence has made major advances. Their productions which were until now imperfect are today very difficult to differentiate from a human. In addition, artificial intelligence is increasingly used in the professional world. Art, economy, code, artificial intelligence is present in all professional fields.',
          'ref2':'Le Grand Continent is organizing "Artificial Intelligence at the Service of the World of Work", an event bringing together AI professionals and researchers at a conference on artificial intelligence and the direction it is taking.',
          'ref3':'Many artificial intelligence professionals will participate in the event. Among the speakers, we will have the pleasure of hearing:',
          'ref4':'The guests',
          'ref5':"Anne-Marie Kermarrec: Professor and director of the computer science section of the Swiss Federal Institute of Technology in Lausanne and renowned researcher, author of \"Digital, counting with women\".",
          'ref6':'André Seznec: Computer science professor at the University of Rennes 1, expert in computer architecture and microprocessors. His research has led to significant advances in cache memory design and branch prediction strategies, helping to improve processor performance.',
          'ref7':'Fredo Durand: Leading researcher in the field of computer vision and image synthesis. A professor at the Massachusetts Institute of Technology, he has opened up new perspectives in the fields of virtual reality and augmented reality.',
          'ref8':'Alain Bui: Expert in artificial intelligence and machine learning. Professor and researcher, he has contributed to developing advanced methods for the analysis of complex and heterogeneous data, with applications in fields such as health, social networks and resource optimization.',
          'ref9':'Luc Julia: Key personality in the field of artificial intelligence, having played a central role in the development of Siri, Apple\'s voice assistant. As a researcher and entrepreneur, he has made significant contributions to human-computer interface, machine learning, and intelligent systems design.',
        },
        'es': {
          'siteTitle': 'Le Grand Continent',
          'Accueil': 'HOME',
          'Evenement': 'EVENTOS',
          'APropos': 'A PROPÓSITO DE NOSOTROS',
          'welcomeHeading': '¡Bienvenido a mi sitio web!',
          'welcomeMessage': 'Contenido de la página de inicio.',
          'reseaux':'Redes sociales',
          'mentionsLegales':'Notas legales :',
          'autre':'Otro enlace :',
          'connexion':'Inicia sesión',
          'inscription':'Regístrate',
          'PDC':'Política de privacidad',
          'CGU':'Términos y condiciones de uso',
          'newletters':'Inscríbase al boletín',
          'Titrearticle':'Gran Debate Continente',
          'ref1':'En los últimos años, la inteligencia artificial ha hecho grandes avances. Sus producciones hasta ahora imperfectas son hoy muy difíciles de diferenciar de un humano. Además, la inteligencia artificial es cada vez más utilizada en el mundo profesional. Arte, economía, código, inteligencia artificial está presente en todos los campos profesionales.',
          'ref2':'Le Grand Continent organiza "Inteligencia artificial al servicio del mundo del trabajo", un evento que reúne a profesionales e investigadores de IA en una conferencia sobre inteligencia artificial y el rumbo que está tomando.',
          'ref3':'Muchos profesionales de la inteligencia artificial participarán en el evento. Entre los ponentes, tendremos el placer de escuchar:',
          'ref4':'Los invitados',
          'ref5':'Anne-Marie Kermarrec: Profesora y directora de la sección de informática del Swiss Federal Institute of Technology en Lausanne y reconocida investigadora, autora de "Digital, contando con mujeres".',
          'ref6':'André Seznec: Profesor de informática en la Universidad de Rennes 1, experto en arquitectura informática y microprocesadores. Su investigación ha llevado a avances significativos en el diseño de memoria caché y estrategias de predicción de bifurcaciones, lo que ayuda a mejorar el rendimiento del procesador.',
          'ref7':'Fredo Durand: investigador líder en el campo de la visión artificial y la síntesis de imágenes. Profesor del Instituto Tecnológico de Massachusetts, ha abierto nuevas perspectivas en los campos de la realidad virtual y la realidad aumentada.',
          'ref8':'Alain Bui: Experto en inteligencia artificial y aprendizaje automático. Profesor e investigador, ha contribuido al desarrollo de métodos avanzados para el análisis de datos complejos y heterogéneos, con aplicaciones en campos como la salud, las redes sociales y la optimización de recursos.',
          'ref9':'Luc Julia: Personalidad clave en el campo de la inteligencia artificial, habiendo jugado un papel central en el desarrollo de Siri, el asistente de voz de Apple. Como investigador y empresario, ha realizado contribuciones significativas a la interfaz hombre-computadora, el aprendizaje automático y el diseño de sistemas inteligentes.',
        }
      }
      /*
      console.log(translations[language]);
      for(const i in translations[language]){
        let value = translations[language][i];
        $('#' + i).text(value);
        console.log('#' + i + " " +value);
        }*/
      $('#site-title').text(translations[language].siteTitle);
      $('#Accueil').text(translations[language].Accueil);
      $('#Evenement').text(translations[language].Evenement);
      $('#APropos').text(translations[language].APropos);
      $('#welcome-heading').text(translations[language].welcomeHeading);
      $('#welcome-message').text(translations[language].welcomeMessage);
      $('#reseaux').text(translations[language].reseaux);
      $('#mentionsLegales').text(translations[language].mentionsLegales);
      $('#autre').text(translations[language].autre);
      $('#connexion').text(translations[language].connexion);
      $('#inscription').text(translations[language].inscription);
      $('#PDC').text(translations[language].PDC);
      $('#CGU').text(translations[language].CGU);
      $('#newletters').text(translations[language].newletters);
      $('#Titrearticle').text(translations[language].Titrearticle);
      $('#ref1').text(translations[language].ref1);
      $('#ref2').text(translations[language].ref2);
      $('#ref3').text(translations[language].ref3);
      $('#ref4').text(translations[language].ref4);
      $('#ref5').text(translations[language].ref5);
      $('#ref6').text(translations[language].ref6);
      $('#ref7').text(translations[language].ref7);
      $('#ref8').text(translations[language].ref8);
      $('#ref9').text(translations[language].ref9);
      console.log(language);
      if(language == "fr"){
        $('#bannière').attr('src', 'assets/affiche2024.png');
      }
      if(language == "en"){
        $('#bannière').attr('src', 'assets/affiche2024en.png');
      }
      if(language == "es"){
        $('#bannière').attr('src', 'assets/affiche2024es.png');
      }      
      console.log("langue séléctionné :"+language);
      localStorage.setItem("language", language);
    }
    // Récupérer la langue sélectionnée du stockage local
    function getSelectedLanguage() {
      return localStorage.getItem("language");
    }
    // Mettre à jour la langue sélectionnée sur toutes les pages
    var selectedLanguage = getSelectedLanguage();
    if (selectedLanguage) {
      updateContent(selectedLanguage);
    } 
  });