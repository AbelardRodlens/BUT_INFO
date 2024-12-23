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
          'titrearticleia':'Est-ce que l\'intelligence artificielle change tout ?',
          'ref1':'Date de l\'évènement:',
          'ref2':'Mardi 4 avril 2023',
          'ref3':'De 19:30 à 20:30',
          'ref4':'Ecole Normale Supérieure',
          'ref5':'45 rue d\'ulm',
          'ref6':' 75005 Paris',
          'ref7':'Les progrès en intelligence artificielle commencent à peine à bouleverser notre siècle. Les succès de ChatGPT ou d’AlphaFold ne sont que les prémisses de la fulgurance technologique de la prochaine décennie. Elle va mener à des transformations radicales de nos sociétés, de l’économie et des relations internationales.',
          'ref8':'Quels sont les entités, États, entreprises ou individus qui vont bénéficier le plus de cette technologie pour accroître leur puissance ? Comment les transformations de cette technique s’expriment-elles dans les différentes sphères de notre existence ? Comment cette technologie bouleverse-t-elle les certitudes acquises depuis plusieurs décennies en matière de géopolitique, de souveraineté économique et stratégique, de défense des valeurs et des libertés individuelles ou d’éducation ? Comment l’Europe peut-elle se positionner au sein de la compétition entre la Chine et les États-Unis dans le domaine ?',
          'ref9':'Pour répondre à ces questions, Le Grand Continent inaugure à l’occasion de ce mardi une série de publications intitulée “Puissances de l’Intelligence Artificielle”, qui donne la parole aux chercheurs, ingénieurs, philosophes et décideurs pour analyser les questions soulevées par les nouveaux paradigmes de l\'IA.',
          'orateurs':'Les orateurs',
          'ref10':'Charleyne Biondi, docteure en science politique, auteure de Dé-coder, une contre-histoire du numérique (2022)',
          'ref11':'Jean-Emmanuel Bibault, Professeur des Universités – Praticien Hospitalier à l’Université de Paris / Hôpital Européen Georges Pompidou, chercheur en machine learning à l’INSERM, auteur de 2041, l’Odyssée de la médecine – comment l’intelligence artificielle bouleverse la médecine (2022)</li>',
          'ref12':'Anne Bouverot, cofondatrice et présidente de la Fondation Abeona “Championing Responsible AI”, Présidente du Conseil d’Administration de Technicolor, Présidente du Conseil d\'administration de l’Ecole Normale Supérieure, docteure en intelligence artificielle (1991)',
          'ref13':'Cedric O, ancien Secrétaire d’Etat chargé du Numérique, membre du haut comité consultatif de l’Agence spatiale européenne',
          'ref14':'Victor Storchan, ingénieur en machine learning, cofondateur de Althica, responsable de la série “Puissances de l’Intelligence Artificielle”, qui assurera la modération de la discussion',
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
          'titrearticleia':'Does artificial intelligence change everything?',
          'ref1':'Event date:',
          'ref2':'Tuesday, April 4, 2023',
          'ref3':'From 7:30 p.m. to 8:30 p.m.',
          'ref4':'Ecole Normale Supérieure',
          'ref5':'45 rue d\'ulm',
          'ref6':' 75005 Paris',
          'ref7':'Advances in artificial intelligence are just beginning to change our century. The successes of ChatGPT or AlphaFold are only the beginnings of the technological brilliance of the next decade. It will lead to radical transformations of our societies, the economy and international relations.',
          'ref8':'Which entities, states, companies or individuals will benefit the most from this technology to increase their power? How are the transformations of this technique expressed in the different spheres of our existence? How does this technology upset the certainties acquired over several decades in terms of geopolitics, economic and strategic sovereignty, the defense of individual values ​​and freedoms or education? How can Europe position itself within the competition between China and the United States in this field?',
          'ref9':'To answer these questions, Le Grand Continent is launching on the occasion of this Tuesday a series of publications entitled "Powers of Artificial Intelligence", which gives the floor to researchers, engineers, philosophers and decision-makers to analyze the questions raised by the new AI paradigms.',
          'orateurs':'The speakers',
          'ref10':'Charleyne Biondi, doctor in political science, author of De-coding, a counter-history of digital (2022)',
          'ref11':'Jean-Emmanuel Bibault, University Professor – Hospital Practitioner at the University of Paris / European Hospital Georges Pompidou, researcher in machine learning at INSERM, author of 2041, the Odyssey of medicine – how artificial intelligence is changing the medicine (2022)',
          'ref12':'Anne Bouverot, co-founder and president of the Abeona “Championing Responsible AI” Foundation, President of the Board of Directors of Technicolor, President of the Board of Directors of the Ecole Normale Supérieure, doctor in artificial intelligence (1991)',
          'ref13':'Cedric O, former Secretary of State for Digital Affairs, member of the High Advisory Committee of the European Space Agency',
          'ref14':'Victor Storchan, ingeniero de aprendizaje automático, cofundador de Althica, responsable de la serie "Poderes de la inteligencia artificial", quien moderará la discusión.',
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
          'titrearticleia':'¿La inteligencia artificial lo cambia todo?',
          'ref1':'Fecha del evento:',
          'ref2':'martes, 4 de abril de 2023',
          'ref3':'De 19:30 a 20:30',
          'ref4':'Ecole Normale Supérieure',
          'ref5':'45 rue d\'ulm',
          'ref6':'75005 Paris',
          'ref7':'Los avances en inteligencia artificial apenas comienzan a cambiar nuestro siglo. Los éxitos de ChatGPT o AlphaFold son solo el comienzo de la brillantez tecnológica de la próxima década. Conducirá a transformaciones radicales de nuestras sociedades, la economía y las relaciones internacionales.',
          'ref8':'¿Qué entidades, estados, empresas o personas se beneficiarán más de esta tecnología para aumentar su poder? ¿Cómo se expresan las transformaciones de esta técnica en las distintas esferas de nuestra existencia? ¿Cómo trastorna esta tecnología las certezas adquiridas a lo largo de varias décadas en materia de geopolítica, soberanía económica y estratégica, defensa de los valores y libertades individuales o educación? ¿Cómo puede Europa posicionarse dentro de la competencia entre China y Estados Unidos en este campo?',
          'ref9':'Para responder a estas preguntas, Le Grand Continent lanza con motivo de este martes una serie de publicaciones titulada "Poderes de la inteligencia artificial", que da la palabra a investigadores, ingenieros, filósofos y tomadores de decisiones para analizar las preguntas que plantea la nueva Paradigmas de IA.',
          'orateurs':'Los altavoces', 
          'ref10':'Charleyne Biondi, doctora en ciencias políticas, autora de Descodificar, una contrahistoria de lo digital (2022)',
          'ref11':'Jean-Emmanuel Bibault, Profesor Universitario – Practicante de Hospital en la Universidad de París / Hospital Europeo Georges Pompidou, investigador en aprendizaje automático en INSERM, autor de 2041, la Odisea de la medicina – cómo la inteligencia artificial está cambiando la medicina (2022)',
          'ref12':'Anne Bouverot, cofundadora y presidenta de la Fundación Abeona “Championing Responsible AI”, Presidenta del Consejo de Administración de Technicolor, Presidenta del Consejo de Administración de la Ecole Normale Supérieure, doctora en inteligencia artificial (1991)',
          'ref13':'Cedric O, exsecretario de Estado de Asuntos Digitales, miembro del Alto Comité Consultivo de la Agencia Espacial Europea',
          'ref14':'Victor Storchan, ingeniero de aprendizaje automático, cofundador de Althica, responsable de la serie "Poderes de la inteligencia artificial", quien moderará la discusión.',      
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
      $('#titrearticleia').text(translations[language].titrearticleia);
      $('#ref1').text(translations[language].ref1);
      $('#ref2').text(translations[language].ref2);
      $('#ref3').text(translations[language].ref3);
      $('#ref4').text(translations[language].ref4);
      $('#ref5').text(translations[language].ref5);
      $('#ref6').text(translations[language].ref6);
      $('#ref7').text(translations[language].ref7);
      $('#ref8').text(translations[language].ref8);
      $('#ref9').text(translations[language].ref9);
      $('#orateurs').text(translations[language].orateurs);
      $('#ref10').text(translations[language].ref10);
      $('#ref11').text(translations[language].ref11);
      $('#ref12').text(translations[language].ref12);
      $('#ref13').text(translations[language].ref13);
      $('#ref14').text(translations[language].ref14);
/*      $('#').text(translations[language].);
      $('#').text(translations[language].);
      $('#').text(translations[language].);
      $('#').text(translations[language].);
      $('#').text(translations[language].);
      $('#').text(translations[language].);
      $('#').text(translations[language].);
      $('#').text(translations[language].);
      $('#').text(translations[language].);
      $('#').text(translations[language].);*/
  
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