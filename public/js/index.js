const panelBody = document.querySelector('#panel-body');
fetch('http://localhost/hw2/laravel_app/public/categorie')
    .then(response => response.json())
    .then(data => {
        for (const elemento of data) {
            const panelItem = createItem(elemento);
            panelBody.appendChild(panelItem);
        }
    })
    .catch(error => {
        panelBody.textContent = 'Errore nel caricamento delle categorie';
    });