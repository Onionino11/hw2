const number = 3;

function handleResponse(response) {
    if (!response.ok) throw new Error('Errore nella risposta: ' + response.status);
    return response.json();
}

function processData(data) {
    if(typeof onJsonItems === 'function') {
        onJsonItems(data);
    } else if(window.onJsonItems) {
        window.onJsonItems(data);
    }
}

function handleError(error) {
    // Nessun console.log o console.error
}

fetch('http://localhost/hw2/laravel_app/public/db/' + encodeURIComponent(categoria) + '/' + number)
    .then(handleResponse)
    .then(processData)
    .catch(handleError);
