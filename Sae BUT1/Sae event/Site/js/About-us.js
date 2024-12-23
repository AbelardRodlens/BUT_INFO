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
          'axel':'Mon rôle de chef d\'équipe est d\'organiser les phases par lesquelles doivent passer les différents travaux afin de mener les projets à bien, mais aussi de participer à celles-ci. C\'est la cohésion présente au sein de cette équipe qui la rend si intéressante et productive.',
          'michael':"En tant que graphiste chargé de la conception d'une affiche et du programme de l’événement, mon rôle est de créer un visuel attrayant et efficace qui transmettra le message de manière claire et mémorable. En outre, je supervise le design du site web pour promouvoir l'événement. Je travaille en collaboration avec les développeurs web pour assurer que le design graphique du site est cohérent avec l'affiche.",
          'rodlens':"Pour ma part, je suis le journaliste de l'équipe. Mon rôle est de capturer les moments clés et de les relater le plus clairement possible pour faciliter le travail aux autres membres du groupe. J'ai le sentiment d'apporter ma pierre à l'édifice bâti par le groupe, je me sens utile.",
          'mathis':"Mon rôle de développeur dans cette équipe englobe toutes les activités liées à la programmation dite front end. Je vois ce rôle comme une occasion de rendre compte à travers mes codes des travaux et recherches de l'ensemble de l'équipe.",
          'allan':"En tant que développeur, mon rôle est d'assurer la bonne transmission au format numérique des travaux de l'équipe. Les différents membres de cette équipe possèdent des compétences variées, ces capacités utilisées à bon escient rendent le groupe plus efficace et rapide.",
          'layn':"En tant que chargé de communication, mon rôle est celui de passerelle entre l'équipe et les différents services externes afin d'assurer une communication optimale. L'équipe est dotée d'un bon relationnel ce qui permet de faciliter les rapports entre les membres et ainsi augmenter l'efficacité globale de l'équipe.",
          'ref1':"Nous sommes étudiants à l'Université Sorbonne Paris Nord, et dans le cadre d'un projet, nous avons réalisé ce site.",
          'ref2':"Notre objectif principal était de créer une plateforme en ligne conviviale et fonctionnelle pour répondre aux besoins spécifiques de notre projet. Nous avons mis en œuvre nos compétences en développement web pour concevoir et construire ce site de manière à ce qu'il soit attractif et facile à utiliser pour les utilisateurs.",
          'ref3':"Lors de la création du site, nous avons pris en compte divers aspects tels que la conception de l'interface utilisateur, l'organisation de l'information, la navigation fluide et l'accessibilité. Nous avons également travaillé sur l'optimisation du site pour assurer de bonnes performances et une compatibilité avec différents navigateurs et appareils.",
          'ref4':"Nous avons utilisé différentes technologies et langages de programmation pour développer ce site, tels que HTML, CSS, JavaScript, et peut-être des frameworks ou des bibliothèques spécifiques en fonction des besoins du projet. Nous avons également pris en compte les bonnes pratiques de développement web pour garantir un code propre, bien structuré et facilement maintenable.",
          'ref5':"Tout au long du processus de développement, nous avons collaboré en équipe, partageant des idées, résolvant des problèmes et prenant des décisions conjointement. Nous avons également effectué des tests et des itérations pour améliorer continuellement le site et nous assurer qu'il répond aux attentes des utilisateurs.",
          'ref6':"N'hésitez pas à explorer le site et à nous faire part de vos commentaires ou suggestions. Nous sommes ouverts à toute amélioration future et à l'opportunité d'enrichir notre expérience en développement web.",
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
          'axel':'My role as team leader is to organize the phases through which the various works must pass in order to carry out the projects, but also to participate in them. It is the cohesion present within this team that makes it so interesting and productive.',
          'michael':'As a graphic designer responsible for the design of a poster and the program of the event, my role is to create an attractive and effective visual that will convey the message in a clear and memorable way. In addition, I supervise the design of the website to promote the event. I work in collaboration with the web developers to ensure that the graphic design of the site is consistent with the poster.',
          'rodlens':'For my part, I am the journalist of the team. My role is to capture the key moments and relate them as clearly as possible to facilitate the work of the other members of the group. I have the feeling of bringing my stone to the edifice built by the group, I feel useful.',
          'mathis':"My role as a developer in this team encompasses all activities related to so-called front end programming. I see this role as an opportunity to report through my codes on the work and research of the entire team.",
          'allan':'As a developer, my role is to ensure the proper transmission in digital format of the team\'s work. The different members of this team have varied skills, these abilities used wisely make the group more efficient and fast.',
          'layn':'As a communication manager, my role is that of bridge between the team and the various external services in order to ensure optimal communication. The team has good interpersonal skills, which facilitates relations between members and thus increases the overall efficiency of the team.',
          'ref1':"We are students at the Sorbonne Paris Nord University, and as part of a project, we have created this site.",
          'ref2':"Our main objective was to create a user-friendly and functional online platform to meet the specific needs of our project. We have applied our web development skills to design and build this site in such a way that it is attractive and easy to use for users.",
          'ref3':"When creating the site, we considered various aspects such as user interface design, information organization, smooth navigation and accessibility. We have also worked on optimizing the site to ensure good performance and compatibility with different browsers and devices.",
          'ref4':"We have used different technologies and programming languages ​​to develop this site, such as HTML, CSS, JavaScript, and perhaps specific frameworks or libraries depending on the needs of the project. We have also taken into account good web development practices to ensure clean, well-structured and easily maintainable code.",
          'ref5':"Throughout the development process, we collaborated as a team, sharing ideas, solving problems and making decisions together. We have also carried out tests and iterations to continually improve the site and ensure that it meets user expectations.",
          'ref6':"Feel free to explore the site and send us your comments or suggestions. We are open to any future improvements and the opportunity to enrich our experience in web development.",
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
          'axel':'Mi papel como jefe de equipo es organizar las fases por las que deben pasar las distintas obras para llevar a cabo los proyectos, pero también participar en ellos. Es la cohesión presente dentro de este equipo lo que lo hace tan interesante y productivo.',
          'michael':'Como diseñador gráfico responsable del diseño de un cartel y del programa del evento, mi función es crear un visual atractivo y efectivo que transmita el mensaje de una manera clara y memorable. Además, superviso el diseño del sitio web para promocionar el evento. Trabajo en colaboración con los desarrolladores web para garantizar que el diseño gráfico del sitio sea coherente con el cartel.',
          'rodlens':'Por mi parte, soy el periodista del equipo. Mi papel es captar los momentos clave y relatarlos con la mayor claridad posible para facilitar el trabajo de los demás miembros del grupo. Tengo la sensación de llevar mi piedra al edificio construido por el grupo, me siento útil.',
          'mathis':'Mi papel como desarrollador en este equipo abarca todas las actividades relacionadas con la llamada programación front-end. Veo este rol como una oportunidad para informar a través de mis códigos sobre el trabajo y la investigación de todo el equipo.',
          'allan':'Como desarrollador, mi papel es asegurar la correcta transmisión en formato digital del trabajo del equipo. Los diferentes miembros de este equipo tienen habilidades variadas, estas habilidades usadas sabiamente hacen que el grupo sea más eficiente y rápido.',
          'layn':'Como responsable de comunicación, mi papel es el de puente entre el equipo y los distintos servicios externos para garantizar una comunicación óptima. El equipo tiene buenas habilidades interpersonales, lo que facilita las relaciones entre los miembros y, por lo tanto, aumenta la eficiencia general del equipo.',
          'ref1':"Somos estudiantes de la Universidad Sorbonne Paris Nord, y como parte de un proyecto, hemos creado este sitio.",
          'ref2':"Nuestro principal objetivo era crear una plataforma en línea funcional y fácil de usar para satisfacer las necesidades específicas de nuestro proyecto. Hemos aplicado nuestras habilidades de desarrollo web para diseñar y construir este sitio de tal manera que sea atractivo y fácil de usar para los usuarios.",
          'ref3':"Al crear el sitio, consideramos varios aspectos, como el diseño de la interfaz de usuario, la organización de la información, la navegación fluida y la accesibilidad. También hemos trabajado en la optimización del sitio para garantizar un buen rendimiento y compatibilidad con diferentes navegadores y dispositivos.",
          'ref4':"Hemos utilizado diferentes tecnologías y lenguajes de programación para desarrollar este sitio, como HTML, CSS, JavaScript y quizás frameworks o bibliotecas específicas según las necesidades del proyecto. También hemos tenido en cuenta las buenas prácticas de desarrollo web para garantizar un código limpio, bien estructurado y de fácil mantenimiento.",
          'ref5':"A lo largo del proceso de desarrollo, colaboramos como equipo, compartiendo ideas, resolviendo problemas y tomando decisiones juntos. También hemos realizado pruebas e iteraciones para mejorar continuamente el sitio y garantizar que cumpla con las expectativas de los usuarios.",
          'ref6':"Siéntase libre de explorar el sitio y enviarnos sus comentarios o sugerencias. Estamos abiertos a futuras mejoras y la oportunidad de enriquecer nuestra experiencia en desarrollo web.",
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
      $('#axel').text(translations[language].axel);
      $('#michael').text(translations[language].michael);
      $('#rodlens').text(translations[language].rodlens);
      $('#mathis').text(translations[language].mathis);
      $('#allan').text(translations[language].allan);
      $('#layn').text(translations[language].layn);
      $('#ref1').text(translations[language].ref1);
      $('#ref2').text(translations[language].ref2);
      $('#ref3').text(translations[language].ref3);
      $('#ref4').text(translations[language].ref4);
      $('#ref5').text(translations[language].ref5);
      $('#ref6').text(translations[language].ref6);
  
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