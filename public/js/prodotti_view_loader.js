const number = 3;
fetch('http://localhost/hw2/laravel_app/public/db/' + encodeURIComponent(categoria) + '/' + number)
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
