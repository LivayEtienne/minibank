document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');

    // Validation en temps réel
    loginForm.addEventListener('input', function(event) {
        const target = event.target;

        // Vérifiez si l'élément a un message d'erreur associé
        const errorMessageElement = document.getElementById(`${target.name}Error`);
        if (!errorMessageElement) return; // Quitter si l'élément d'erreur n'existe pas

        // Réinitialiser le message d'erreur
        errorMessageElement.textContent = '';
        target.classList.remove('valid', 'invalid');

        let isValid = true;

        // Validation pour le numéro de téléphone
        if (target.name === 'telephone') {
            const regex = /^\+?[0-9]{9}$/; // Ajustez selon le format de numéro valide
            if (!regex.test(target.value)) {
                isValid = false;
                errorMessageElement.textContent = 'Numéro de téléphone invalide.';
            }
        }

        // Validation pour le mot de passe
        if (target.name === 'password') {
            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/; // Au moins 8 caractères, 1 majuscule, 1 minuscule, 1 chiffre
            if (!regex.test(target.value)) {
                isValid = false;
                errorMessageElement.textContent = 'Doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre.';
            }
        }

        // Ajouter les classes de validation
        if (isValid) {
            target.classList.add('valid');
            target.classList.remove('invalid');
        } else {
            target.classList.add('invalid');
            target.classList.remove('valid');
        }
    });
});