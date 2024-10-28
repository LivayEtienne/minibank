function toggleSolde() {
    const montant = document.getElementById('montant');
    const montantVisible = document.getElementById('montant-visible');
    const toggleIcon = document.getElementById('toggle');

    if (montant.style.display === 'none') {
        montant.style.display = 'inline';
        montantVisible.style.display = 'none';
        toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
    } else {
        montant.style.display = 'none';
        montantVisible.style.display = 'inline';
        toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
    }
}