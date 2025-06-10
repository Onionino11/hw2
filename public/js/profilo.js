function toggleDettagliOrdine(row) {
    const ordineId = row.getAttribute('data-ordine-id');
    const dettagliRow = document.getElementById('dettagli-' + ordineId);
    
    if (dettagliRow) {
        dettagliRow.classList.toggle('hidden');
        
        const arrow = row.querySelector('.dettagli-btn');
        if (arrow) {
            arrow.innerHTML = dettagliRow.classList.contains('hidden') ? '&#9660;' : '&#9650;';
        }
    }
}

function initProfiloPage() {
    const ordineRows = document.querySelectorAll('.ordine-row');
    
    for (const row of ordineRows) {
        function handleRowClick() {
            toggleDettagliOrdine(this);
        }
        row.addEventListener('click', handleRowClick);
    }
}

initProfiloPage();
