let clientId;

function showBlockModal(id) {
    clientId = id;
    $('#blockModal').modal('show'); // Assurez-vous que le modal est correctement identifié
}

// Assurez-vous que le bouton "confirmBlock" existe dans le DOM avant d'ajouter l'événement
document.addEventListener('DOMContentLoaded', function() {
    const confirmButton = document.getElementById('confirmBlock');
    const modal = document.getElementById('modal'); // Assurez-vous que votre modal a cet ID
    const modalMessage = document.getElementById('modalMessage'); // Pour afficher des messages
    const closeButton = document.querySelector('.close'); // Bouton de fermeture du modal

    if (confirmButton) {
        confirmButton.addEventListener('click', function() {
            // Affichage du modal de confirmation
            modal.style.display = 'block';
            modalMessage.textContent = 'Êtes-vous sûr de vouloir bloquer ce client ?'; // Message de confirmation

            // Gérer le clic sur le bouton de confirmation dans le modal
            const confirmAction = document.getElementById('confirmAction'); // Bouton de confirmation dans le modal
            confirmAction.onclick = function() {
                fetch(`/clients/block/${clientId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        // Any additional data if needed
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.success);
                        location.reload(); // Optionnel pour recharger la page
                    } else {
                        alert(data.error);
                    }
                    modal.style.display = 'none'; // Ferme le modal après l'action
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('Une erreur s\'est produite, veuillez réessayer.'); // Notification d'erreur
                    modal.style.display = 'none'; // Ferme le modal en cas d'erreur
                });
            };
        });
    }

    // Gestion du clic sur le bouton de fermeture du modal
    if (closeButton) {
        closeButton.onclick = function() {
            modal.style.display = 'none'; // Ferme le modal
        };
    }

    // Fermer le modal si l'utilisateur clique en dehors de celui-ci
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = 'none'; // Ferme le modal
        }
    };
});

