const panelBody = document.querySelector('#panel-body');

function handleResponse(response) {
    return response.json();
}

function processData(data) {
    for (const elemento of data) {
        const panelItem = createItem(elemento);
        panelBody.appendChild(panelItem);
    }
}

function handleError() {
    panelBody.textContent = 'Errore nel caricamento delle categorie';
}

fetch('http://localhost/hw2/laravel_app/public/categorie')
    .then(handleResponse)
    .then(processData)
    .catch(handleError);