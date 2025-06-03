const panelBody = document.querySelector('#panel-body');
fetch('../php/get_categorie.php')
    .then(response => response.json())
    .then(data => {
        for (const elemento of data) {
            const panelItem = createItem(elemento);
            panelBody.appendChild(panelItem);
        }
    })
    .catch(error => {
        panelBody.innerHTML = '<p>Errore nel caricamento delle categorie.</p>';
    });