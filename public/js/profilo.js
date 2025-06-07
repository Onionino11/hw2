// Funzione per gestire il toggle dei dettagli dell'ordine
document.addEventListener('DOMContentLoaded', function() {
    const ordineRows = document.querySelectorAll('.ordine-row');
    
    ordineRows.forEach(row => {
        row.addEventListener('click', function() {
            const ordineId = this.getAttribute('data-ordine-id');
            const dettagliRow = document.getElementById('dettagli-' + ordineId);
            
            if (dettagliRow) {
                // Toggle la classe hidden
                dettagliRow.classList.toggle('hidden');
                
                // Cambia la direzione della freccia
                const arrow = this.querySelector('.dettagli-btn');
                if (arrow) {
                    arrow.innerHTML = dettagliRow.classList.contains('hidden') ? '&#9660;' : '&#9650;';
                }
            }
        });
    });
});
