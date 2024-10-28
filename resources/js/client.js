/*

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
*/
function toggleSolde() {
    // Sélection des éléments avec les montants caché et visible
    const montant = document.getElementById('montant');
    const montantVisible = document.getElementById('montant-visible');
    const toggleIcon = document.getElementById('toggle');

    // Toggle entre le montant caché et visible
    if (montant.style.display === 'none') {
        montant.style.display = 'inline'; // Afficher les étoiles
        montantVisible.style.display = 'none'; // Cacher le montant réel
        toggleIcon.classList.replace('fa-eye-slash', 'fa-eye'); // Changer l'icône pour "voir"
    } else {
        montant.style.display = 'none'; // Cacher les étoiles
        montantVisible.style.display = 'inline'; // Afficher le montant réel
        toggleIcon.classList.replace('fa-eye', 'fa-eye-slash'); // Changer l'icône pour "cacher"
    }
}

document.getElementById('clientForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Empêche le rechargement de la page
    // Appeler la fonction pour récupérer les données ici
});
 /*
<script>
    function toggleSolde() {
        // Sélection des éléments avec les montants caché et visible
        const montant = document.getElementById('montant');
        const montantVisible = document.getElementById('montant-visible');
        const toggleIcon = document.getElementById('toggle');

        // Toggle entre le montant caché et visible
        if (montant.style.display === 'none') {
            montant.style.display = 'inline'; // Afficher les étoiles
            montantVisible.style.display = 'none'; // Cacher le montant réel
            toggleIcon.classList.replace('fa-eye-slash', 'fa-eye'); // Changer l'icône pour "voir"
        } else {
            montant.style.display = 'none'; // Cacher les étoiles
            montantVisible.style.display = 'inline'; // Afficher le montant réel
            toggleIcon.classList.replace('fa-eye', 'fa-eye-slash'); // Changer l'icône pour "cacher"
        }
    }
</script>
 */