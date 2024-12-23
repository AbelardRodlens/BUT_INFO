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