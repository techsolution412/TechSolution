document.getElementById('contactForm').addEventListener('submit', function(event) {
    event.preventDefault(); // empeche le rechargement
    const messageConfirm = document.getElementById('messageConfirm');

    const formData = new FormData(this);

    // Envoyer les donnees a l'API de traitement
    fetch('config/traitements.php', {
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
            this.reset(); // Reinitialiser le formulaire apres soumission
        }else{
            messageConfirm.className = "bg-red-100 border border-red-400 text-red-700 w-full rounded-lg px-4 py-3 rounded mb-4 " ;
        }
        messageConfirm.innerHTML = data.message;

        
    })
    .catch(error => console.error('Error:', error));
});