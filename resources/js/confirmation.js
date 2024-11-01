

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');

    // Fonction pour afficher l'aperçu de l'avatar
    function previewAvatar(event) {
        const avatarPreview = document.getElementById('avatarPreview');
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            avatarPreview.src = e.target.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }

    // Validation en temps réel
    form.addEventListener('input', function(event) {
        const target = event.target;
        const errorMessageElement = document.querySelector(`.${target.name}-error`);
        let isValid = true;

        // Réinitialiser le message d'erreur
        errorMessageElement.textContent = '';
        target.classList.remove('valid', 'invalid');

        // Vérifications spécifiques selon le nom du champ
        if (target.name === 'prenom' || target.name === 'nom') {
            const regex = /^[A-Z][a-zA-Z]*$/; // Commence par une majuscule, suivi de lettres
            if (!regex.test(target.value)) {
                isValid = false;
                errorMessageElement.textContent = 'Doit commencer par une majuscule et ne contenir que des lettres.';
            }
        }

        if (target.name === 'telephone') {
            // Regex pour le format de numéro de téléphone sénégalais (commençant par 70, 75, 76, 77, 78 suivi de 7 chiffres)
            const regex = /^7[0-8][0-9]{7}$/;
            if (!regex.test(target.value)) {
                isValid = false;
                errorMessageElement.textContent = 'Le numéro de téléphone doit commencer par 70, 75, 76, 77 ou 78 et contenir 9 chiffres au total.';
            }
        }

        if (target.name === 'adresse') {
            if (target.value.trim() === '') {
                isValid = false;
                errorMessageElement.textContent = 'L\'adresse ne peut pas être vide.';
            }
        }

        if (target.name === 'date_naissance') {
            const birthDate = new Date(target.value);
            const today = new Date();
            if (birthDate >= today) {
                isValid = false;
                errorMessageElement.textContent = 'La date de naissance doit être dans le passé.';
            }
        }

        if (target.name === 'mot_de_passe') {
            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/; // Au moins 8 caractères, une majuscule, une minuscule et un chiffre
            if (!regex.test(target.value)) {
                isValid = false;
                errorMessageElement.textContent = 'Doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre.';
            }
        }

        if (target.name === 'cni') {
            if (target.value.trim() === '') {
                isValid = false;
                errorMessageElement.textContent = 'Le numéro de carte d\'identité ne peut pas être vide.';
            }
        }

        // Ciblez l'élément du champ de rôle et le conteneur de message d'erreur
const roleSelect = document.querySelector('select[name="role"]');
const errorMessageElements = document.getElementById('roleError'); // Supposant un élément pour afficher les erreurs

roleSelect.addEventListener('change', (event) => {
    let isValid = true;
    const target = event.target;

    // Vérifiez que la valeur du rôle est l'une des options valides
    if (target.name === 'role') {
        if (!['client', 'distributeur'].includes(target.value.trim())) {
            isValid = false;
            errorMessageElements.textContent = 'Veuillez choisir un rôle valide.';
        } else {
            errorMessageElements.textContent = ''; // Effacez le message d'erreur si la sélection est correcte
        }
    }
});


        // Ajouter les classes de validation
        if (isValid) {
            target.classList.add('valid');
            target.classList.remove('invalid');
            errorMessageElement.textContent = ''; // Effacer le message d'erreur si valide
        } else {
            target.classList.add('invalid');
            target.classList.remove('valid');
        }
    });

    // Écouteur pour l'aperçu de la photo
    const photoInput = document.getElementById('photo');
    photoInput.addEventListener('change', previewAvatar);
});

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submitBtn');

    // Fonction pour afficher l'aperçu de l'avatar
    function previewAvatar(event) {
        const avatarPreview = document.getElementById('avatarPreview');
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            avatarPreview.src = e.target.result;
            avatarPreview.style.display = 'block'; // Afficher l'aperçu
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }

    // Fonction pour vérifier la validité de tous les champs
    function checkFormValidity() {
        const inputs = form.querySelectorAll('input');
        let isValid = true;

        inputs.forEach(input => {
            const errorMessageElement = document.querySelector(`.${input.name}-error`);
            // Vérifiez si le champ a une classe "invalid"
            if (input.classList.contains('invalid')) {
                isValid = false;
            }

            // Si un champ est requis et vide
            if (input.hasAttribute('required') && input.value.trim() === '') {
                isValid = false;
            }
        });

        // Activez ou désactivez le bouton en fonction de la validité du formulaire
        submitBtn.disabled = !isValid;
    }

});

