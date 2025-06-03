function createItem(elemento) {
    const panelItem = document.createElement('div');
    panelItem.classList.add('panel-item', 'boxed');
    panelItem.dataset.prodotto = elemento.prodotto || 0;
    panelItem.dataset.immagine = elemento.immagine;
    panelItem.dataset.nome = elemento.nome;
    panelItem.dataset.bestseller = elemento.bestseller ? 1 : 0;
    panelItem.dataset.burger = elemento.burger ? 1 : 0;
    panelItem.dataset.chips = elemento.chips ? 1 : 0;
    panelItem.dataset.drink = elemento.drink ? 1 : 0;
    panelItem.dataset.descrizione = elemento.descrizione;
    panelItem.dataset.nProdotti = elemento.prodotti;
    panelItem.dataset.prezzo= elemento.prezzo;

    const img = document.createElement('img');
    img.classList.add('item-img');
    if (elemento.immagine && elemento.immagine.startsWith('http')) {
        img.src = elemento.immagine;
    } else if (elemento.immagine) {
        img.src = '../assets/img/' + elemento.immagine;
    } else {
        img.src = '../assets/img/default.png';
    }
    panelItem.appendChild(img);

    const itemBody = document.createElement('div');
    itemBody.classList.add('item-body');

    const itemDescription = document.createElement('div');
    itemDescription.classList.add('item-description');

    const itemTitle = document.createElement('h2');
    itemTitle.classList.add('item-titolo');

    const itemCategory = document.createElement('a');
    itemCategory.classList.add('item-category');
    itemCategory.href = '#';
    itemCategory.textContent = elemento.nome;

    const opzionali = document.createElement('div');
    opzionali.classList.add('opzionali');

    if (elemento.bestseller=="1") {
        const bestseller = document.createElement('div');
        bestseller.classList.add('bestseller');
        bestseller.textContent = 'Best seller';
        opzionali.appendChild(bestseller);
    }
    if (elemento.burger =="1") {
        const burgerIcon = document.createElement('img');
        burgerIcon.classList.add('burger', 'icon');
        burgerIcon.src = '../assets/img/burger.svg';
        opzionali.appendChild(burgerIcon);
    }
    if (elemento.chips == "1") {
        const chipsIcon = document.createElement('img');
        chipsIcon.classList.add('chips', 'icon');
        chipsIcon.src = '../assets/img/chips.svg';
        opzionali.appendChild(chipsIcon);
    }
    if (elemento.drink == "1") {
        const drinkIcon = document.createElement('img');
        drinkIcon.classList.add('drink', 'icon');
        drinkIcon.src = '../assets/img/drink.svg';
        opzionali.appendChild(drinkIcon);
    }

    itemTitle.appendChild(itemCategory);
    itemTitle.appendChild(opzionali);
    itemDescription.appendChild(itemTitle);
    // Mostra sempre una descrizione di default se vuota
    itemDescription.appendChild(document.createTextNode(elemento.descrizione && elemento.descrizione.trim() !== '' ? elemento.descrizione : 'Nessuna descrizione disponibile.'));
    itemBody.appendChild(itemDescription);

    const itemButton = document.createElement('div');
    itemButton.classList.add('item-button');

    const prodottiLink = document.createElement('a');
    prodottiLink.href = '#';
    itemButton.appendChild(prodottiLink);

    const prodottiText = document.createElement('strong');
    if (elemento.prodotti>0) {
        prodottiText.classList.add('N-Prodotti');
        prodottiText.textContent = elemento.prodotti + ' prodotti';
        prodottiLink.appendChild(prodottiText);
        const square = document.createElement('div');
        square.classList.add('square');
        square.textContent = '>';
        itemButton.appendChild(square);
    } else {
        prodottiLink.href = '../php/add_to_cart.php?id=' + encodeURIComponent(elemento.prodotto) +
            '&nome=' + encodeURIComponent(elemento.nome) +
            '&descrizione=' + encodeURIComponent(elemento.descrizione) +
            '&prezzo=' + encodeURIComponent(elemento.prezzo);
        prodottiText.classList.add('N-Prodotti');
        prodottiText.textContent = elemento.prezzo + '€';
        prodottiLink.appendChild(prodottiText);
        const addLink = document.createElement('a');
        addLink.classList.add('square');
        addLink.textContent = '+';
        addLink.href = '../php/add_to_cart.php?id=' + encodeURIComponent(elemento.prodotto) +
            '&nome=' + encodeURIComponent(elemento.nome) +
            '&descrizione=' + encodeURIComponent(elemento.descrizione) +
            '&prezzo=' + encodeURIComponent(elemento.prezzo);
        itemButton.appendChild(addLink);
    }

    itemBody.appendChild(itemButton);
    if (elemento.nome === "MALU BURGER (SOLO PANINO)") {
        itemButton.addEventListener('click', goToHamburger);
    } else if (elemento.nome === "PER INIZIARE") {
        itemButton.addEventListener('click', goToSnac);
    } else if (elemento.nome === "MALU PROMO MENU'") {
        itemButton.addEventListener('click', goToPasta);
    } else if (elemento.nome === "MALU LIGHT") {
        itemButton.addEventListener('click', goToSalad);
    } else if (elemento.nome === "DA BERE") {
        itemButton.addEventListener('click', goToDrink);
    } else if (elemento.nome === "DOLCI") {
        itemButton.addEventListener('click', goToDessert);
    }
    panelItem.appendChild(itemBody);
    return panelItem;
}

function getNumberof(product){
    let number = 0;
    const panelItems = document.querySelectorAll('#panel-body .panel-item');
    for (const item of panelItems) {
        if (item.dataset.nome === product) {
            number = item.dataset.nProdotti;
            break; 
        }
    }
    return number;
}

function createFried(){
    number = getNumberof('PER INIZIARE');
    createCibo('snac', number);
}
function createHamburger(){ 
    number = getNumberof('MALU BURGER (SOLO PANINO)');
    createCibo('hamburger', number);
}
function createPlate(){
    number = getNumberof("MALU PROMO MENU'");
    createCibo('pasta', number);
}
function createSalad(){
    number = getNumberof('MALU LIGHT');
    createCibo('salad', number);
}
function createDrink(){
    number = getNumberof('DA BERE');
    createCibo('drink', number);
}
function createDessert(){
    number = getNumberof('DOLCI');
    createCibo('dessert',number);
}

function createCibo(query,number) {
    hideItemsCategoria(); 
    fetch('../php/api_prodotti.php?query=' + encodeURIComponent(query) + '&number=' + number)
        .then(onSuccess, onError)
        .then(onJsonItems);
}

function onSuccess(response) {
    if (!response.ok) {  
        throw new Error('Errore nella risposta: ' + response.status);
    }
    return response.json();
}

function onError(error) {
    console.error('Errore nella richiesta:', error);
}

function onJsonItems(data) {
    console.log('Risultato della fetch:', data);
    const Results = data.results || [];
    for (const item of Results) {
        let element;
        // Controllo se i campi sono vuoti o nulli e applico fallback
        const nome = item.nome && item.nome.trim() !== '' ? item.nome : 'Sconosciuto';
        const descrizione = item.descrizione && item.descrizione.trim() !== '' ? item.descrizione : 'Nessuna descrizione disponibile.';
        let immagine = item.immagine && item.immagine.trim() !== '' ? item.immagine : 'default.png';
        if (immagine && !immagine.startsWith('http') && !immagine.endsWith('.png') && !immagine.endsWith('.jpg') && !immagine.endsWith('.jpeg')) {
            immagine = 'default.png';
        }
        // Modifica: considera prodotto DB se c'è item.nome (non richiede descrizione)
        if (item.nome) {
            element = {
                prodotto: item.id || 0,
                immagine: immagine,
                nome: nome,
                descrizione: descrizione,
                prodotti: item.prodotti || 0,
                prezzo: item.prezzo || '',
                bestseller: item.bestseller || false,
                burger: item.burger || false,
                chips: item.chips || false,
                drink: item.drink || false
            };
        } else {
            // Risposta Spoonacular
            element = {
                prodotto: item.id || 0,
                immagine: item.image || 'default.png',
                nome: item.title || 'Sconosciuto',
                descrizione: item.summary ? item.summary.replace(/<[^>]+>/g, '') : 'Nessuna descrizione disponibile.',
                prodotti: 0,
                prezzo: getRandomFloat(5, 20),
                bestseller: false,
                burger: false,
                chips: false,
                drink: false
            };
        }
        const panelItem = createItem(element);
        const panelBody = document.querySelector('#panel-body');
        panelBody.appendChild(panelItem);
    }
}

function hideItemsCategoria() {
    console.log('hideItemsCategoria');
    const panelItems = document.querySelectorAll('#panel-body .panel-item');
    for (const item of panelItems) {
        if (item.dataset.prodotto == 0) {
            item.classList.add('hidden');
        }
    }
}

function getRandomFloat(min, max) {
    return ((Math.random() * (max - min) + min).toFixed(1)+'0');
}

function goToHamburger() {
    window.location.href = '../php/prodotti_view.php?query=hamburger&number=' + getNumberof('MALU BURGER (SOLO PANINO)');
}
function goToSnac() {
    window.location.href = '../php/prodotti_view.php?query=snac&number=' + getNumberof('PER INIZIARE');
}
function goToPasta() {
    window.location.href = '../php/prodotti_view.php?query=pasta&number=' + getNumberof("MALU PROMO MENU'");
}
function goToSalad() {
    window.location.href = '../php/prodotti_view.php?query=salad&number=' + getNumberof('MALU LIGHT');
}
function goToDrink() {
    window.location.href = '../php/prodotti_view.php?query=drink&number=' + getNumberof('DA BERE');
}
function goToDessert() {
    window.location.href = '../php/prodotti_view.php?query=dessert&number=' + getNumberof('DOLCI');
}
