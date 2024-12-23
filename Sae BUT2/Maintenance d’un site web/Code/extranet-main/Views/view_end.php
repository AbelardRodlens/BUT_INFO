<!-- Vue contenant le footer et la fermeture des balises body et html -->


<script src="https://kit.fontawesome.com/5aa2ca8fd4.js" crossorigin="anonymous"></script>
<script>
    let barre_recherche=document.getElementById('recherche');
    

    barre_recherche.addEventListener('keyup', async function(e) {
    try {
        
        <?php if($_GET && $_GET['controller'] == 'prestataire' && $_GET['action'] == 'default'): ?>

        const reponse = await fetch('?controller=prestataire&action=reshearchClients', {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ msg: e.target.value })
        });

        // Vérifiez que la requête a été effectuée avec succès
        if (!reponse.ok) {
            throw new Error('Network response was not ok: ' + reponse.statusText);
        }

        // Transformez la réponse en JSON
        const rep = await reponse.json();

        

        // Supprimez tous les blocs existants
        const blocks = document.querySelectorAll('.block');
        blocks.forEach(block => block.remove());

        // Créez et ajoutez de nouveaux blocs pour chaque élément de la réponse
        rep.forEach(ligne => {
            let new_block = document.createElement('a');
            new_block.classList.add('block');
            new_block.href = "?controller=prestataire&action=composantes&id=" + ligne.id + "&client=" + encodeURIComponent(ligne.nom_client);
            
            let h2 = document.createElement('h2');
            h2.textContent = ligne.nom_client;

            new_block.appendChild(h2);
            document.querySelector('.element-block').appendChild(new_block);
        });

        <?php else: ?> 

            const urlParams = new URLSearchParams(window.location.search);  // Récupère les paramètres de l'URL.
            const id = urlParams.get('id'); // Récupère id_client.
            console.log(id);
            const reponse = await fetch('?controller=prestataire&action=reshearchComposantes', {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ msg: e.target.value, id })
            });

            // Vérifiez que la requête a été effectuée avec succès
            if (!reponse.ok) {
                throw new Error('Network response was not ok: ' + reponse.statusText);
            }

            // Transformez la réponse en JSON
            const rep = await reponse.json();

            

            // Supprimez tous les blocs existants
            const blocks = document.querySelectorAll('.block');
            blocks.forEach(block => block.remove());

            // Créez et ajoutez de nouveaux blocs pour chaque composante de la réponse
            rep.forEach(ligne => {
                let new_block = document.createElement('a');
                new_block.classList.add('block');
                new_block.href = "?controller=prestataire&action=dashboard&id=" + ligne.id_composante; // création du block contenant les informations de la composante.
                
                let h2 = document.createElement('h2');
                h2.textContent = ligne.nom_composante;

                new_block.appendChild(h2);
                document.querySelector('.element-block').appendChild(new_block);
            });

            
        <?php endif; ?> 
        
        
    } catch (error) {
        console.error('Erreur:', error);
    }
});
</script>


</body>
</html>
