



// Script pour masquer/démasquer le montant
const toggleButton = document.getElementById('toggle');
const montantElement = document.getElementById('montant');

toggleButton.addEventListener('click', () => {
    if (montantElement.textContent.trim() === '***********') {
        montantElement.textContent = '{{ $montant }} F'; // Afficher le montant de la base de données
        toggleButton.classList.remove('fa-eye-slash');
        toggleButton.classList.add('fa-eye');
    } else {
        montantElement.textContent = '***********'; // Masquer le montant avec des astérisques
        toggleButton.classList.remove('fa-eye');
        toggleButton.classList.add('fa-eye-slash');
    }
});