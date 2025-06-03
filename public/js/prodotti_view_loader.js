document.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    const query = params.get('query');
    const number = params.get('number');
    if(query && number) {
        fetch('../php/api_prodotti_db.php?query=' + encodeURIComponent(query) + '&number=' + encodeURIComponent(number))
            .then(function(response) {
                if (!response.ok) throw new Error('Errore nella risposta: ' + response.status);
                return response.json();
            })
            .then(function(data) {
                if(typeof onJsonItems === 'function') {
                    onJsonItems(data);
                } else if(window.onJsonItems) {
                    window.onJsonItems(data);
                }
            })
            .catch(function(error) {
                console.error('Errore nella richiesta:', error);
            });
    }
});
