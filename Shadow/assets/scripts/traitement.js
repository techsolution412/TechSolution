document.getElementById('updateForm').addEventListener('submit', function(event) {
    event.preventDefault(); // empeche le rechargement
    const messageConfirm = document.getElementById('messageConfirm');

    const formData = new FormData(this);

    // Envoyer les donnees a l'API de traitement
    fetch('back/traitement.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // console.log(data);
        
        // Afficher le message de confirmation
        // messageConfirm.innerHTML = data.message
        if (data.succes) {
            messageConfirm.className = "bg-green-100 border border-green-400 text-green-700 w-full rounded-lg px-4 py-3 rounded mb-4 ";
            new Promise(resolve => setTimeout(resolve, 2000)); // Attendre 2 secondes
            location.reload(); // Reinitialiser le formulaire apres soumission
            // rechargerFormulaire(); // Recharger le formulaire avec les nouvelles données
        }else{
            messageConfirm.className = "bg-red-100 border border-red-400 text-red-700 w-full rounded-lg px-4 py-3 rounded mb-4 " ;
        }
        messageConfirm.innerHTML = data.message;

        
    })
    .catch(error => console.error('Error:', error));
});

// Fonction pour recharger le formulaire avec les données mises à jour

// async function rechargerFormulaire() {
//     try {
//         const response = await fetch('back/api/get-form-data'); // Change this URL to your actual API endpoint
//         const data = await response.json();
        
//         // Mettre à jour les champs du formulaire
//         document.getElementById('nom').value = data.nom;
//         document.getElementById('email').value = data.email;
//         document.getElementById('telephone').value = data.telephone;
//         document.getElementById('date').value = data.date;
//         document.getElementById('heure').value = data.heure;
//         document.getElementById('service').value = data.service;
//         document.getElementById('statut').value = data.statut;
//         document.getElementById('message').value = data.message;

//     } catch (error) {
//         console.error('Erreur:', error);
//     }
// }


// async function rechargerFormulaire() {
//   try {
//     const response = await fetch('/api/get-form-data');
//     const data = await response.json();
    
//     // Mettre à jour les champs du formulaire
//     document.getElementById('nom').value = data.nom;
//     document.getElementById('email').value = data.email;
//     // ... autres champs
    
//   } catch (error) {
//     console.error('Erreur:', error);
//   }
// }

// // Appeler cette fonction quand nécessaire
// rechargerFormulaire();