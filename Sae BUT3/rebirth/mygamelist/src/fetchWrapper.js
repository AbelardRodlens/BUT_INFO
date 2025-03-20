export default async function fetchWrapper(link, method, authHeader, data = null) {
    let accessToken;
  
    // Récupérer le token d'accès si `authHeader` est activé
    if (authHeader) {
      accessToken = localStorage.getItem('accessToken') || 'vide';
    }
  
    try {
      // Créer les options pour la requête
      const options = {
        method: method,
        credentials: "include", // Inclut les cookies dans la requête
        headers: {
          ...(accessToken && { 'Authorization': `Bearer ${accessToken}` }),
          'Content-Type': 'application/json',
        },
      };
  
      
      if (method === "POST" && data) {
        options.body = JSON.stringify(data);
      }
  
      // Envoyer la requête
      const response = await fetch(link, options);
      return response;
    } catch (e) {
      console.error(e.message);
    }
  }