// Toggle allergies details
        document.getElementById('allergies').addEventListener('change', function() {
            const allergiesDetails = document.getElementById('allergiesDetails');
            allergiesDetails.style.display = this.checked ? 'block' : 'none';
        });

        // Help Modal
        const helpModal = document.getElementById('helpModal');
        const helpBtn = document.getElementById('helpBtn');
        const closeHelpModal = document.getElementById('closeHelpModal');
        const closeHelpModalBtn = document.getElementById('closeHelpModalBtn');

        helpBtn.addEventListener('click', () => {
            helpModal.classList.remove('opacity-0', 'pointer-events-none');
            helpModal.querySelector('div').classList.remove('translate-y-4');
        });

        [closeHelpModal, closeHelpModalBtn].forEach(btn => {
            btn.addEventListener('click', () => {
                helpModal.classList.add('opacity-0', 'pointer-events-none');
                helpModal.querySelector('div').classList.add('translate-y-4');
            });
        });

        // Confirmation Modal
        const confirmationModal = document.getElementById('confirmationModal');
        const saveBtn = document.getElementById('saveBtn');
        const closeConfirmationModalBtn = document.getElementById('closeConfirmationModalBtn');
        const viewReservationBtn = document.getElementById('viewReservationBtn');

        saveBtn.addEventListener('click', () => {
            // Here you would normally save the data
            // For demo purposes, we'll just show the modal
            confirmationModal.classList.remove('opacity-0', 'pointer-events-none');
            confirmationModal.querySelector('div').classList.remove('translate-y-4');
        });

        closeConfirmationModalBtn.addEventListener('click', () => {
            confirmationModal.classList.add('opacity-0', 'pointer-events-none');
            confirmationModal.querySelector('div').classList.add('translate-y-4');
        });

        viewReservationBtn.addEventListener('click', () => {
            alert('Redirection vers la page de la réservation...');
            confirmationModal.classList.add('opacity-0', 'pointer-events-none');
            confirmationModal.querySelector('div').classList.add('translate-y-4');
        });

        // Cancel button
        document.getElementById('cancelBtn').addEventListener('click', () => {
            if(confirm('Voulez-vous vraiment annuler toutes les modifications ?')) {
                // Reset form to original values
                document.getElementById('reservationForm').reset();
            }
        });