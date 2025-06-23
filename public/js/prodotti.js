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
        img.src = 'http://localhost/hw2/laravel_app/public/img/' + elemento.immagine;
    } else {
        img.src = 'http://localhost/hw2/laravel_app/public/img/default.png';
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

    if (elemento.bestseller == 1 || elemento.bestseller === "1") {
        const bestseller = document.createElement('div');
        bestseller.classList.add('bestseller');
        bestseller.textContent = 'Best seller';
        opzionali.appendChild(bestseller);
    }
    if (elemento.burger == 1 || elemento.burger === "1") {
        const burgerIcon = document.createElement('img');
        burgerIcon.classList.add('burger', 'icon');
        burgerIcon.src = 'http://localhost/hw2/laravel_app/public/img/burger.svg';
        opzionali.appendChild(burgerIcon);
    }
    if (elemento.chips == 1 || elemento.chips === "1") {
        const chipsIcon = document.createElement('img');
        chipsIcon.classList.add('chips', 'icon');
        chipsIcon.src = 'http://localhost/hw2/laravel_app/public/img/chips.svg';
        opzionali.appendChild(chipsIcon);
    }
    if (elemento.drink == 1 || elemento.drink === "1") {
        const drinkIcon = document.createElement('img');
        drinkIcon.classList.add('drink', 'icon');
        drinkIcon.src = 'http://localhost/hw2/laravel_app/public/img/drink.svg';
        opzionali.appendChild(drinkIcon);
    }

    itemTitle.appendChild(itemCategory);
    itemTitle.appendChild(opzionali);
    itemDescription.appendChild(itemTitle);
    itemDescription.appendChild(document.createTextNode(elemento.descrizione && elemento.descrizione.trim() !== '' ? elemento.descrizione : 'Nessuna descrizione disponibile.'));
    itemBody.appendChild(itemDescription);

    const itemButton = document.createElement('a');
    itemButton.classList.add('item-button');
    itemButton.href = '#';

    const prodottiText = document.createElement('strong');
    if (elemento.prodotti>0) {
        prodottiText.classList.add('N-Prodotti');
        prodottiText.textContent = elemento.prodotti + ' prodotti';
        itemButton.appendChild(prodottiText);
        const square = document.createElement('div');
        square.classList.add('square');
        square.textContent = '>';
        itemButton.appendChild(square);
    } else {
        prodottiText.classList.add('N-Prodotti');
        prodottiText.textContent = elemento.prezzo + '€';
        
        const priceForm = document.createElement('form');
        priceForm.method = 'POST';
        priceForm.action = '/hw2/laravel_app/public/api/cart/add';
        priceForm.classList.add('inline-form');
        
        const csrfField = document.createElement('input');
        csrfField.type = 'hidden';
        csrfField.name = '_token';
        csrfField.value = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        priceForm.appendChild(csrfField);
        

        const idField = document.createElement('input');
        idField.type = 'hidden';
        idField.name = 'id';
        idField.value = elemento.prodotto;
        priceForm.appendChild(idField);
        
        const nomeField = document.createElement('input');
        nomeField.type = 'hidden';
        nomeField.name = 'nome';
        nomeField.value = elemento.nome;
        priceForm.appendChild(nomeField);
        
        const descField = document.createElement('input');
        descField.type = 'hidden';
        descField.name = 'descrizione';
        descField.value = elemento.descrizione;
        priceForm.appendChild(descField);
        
        const prezzoField = document.createElement('input');
        prezzoField.type = 'hidden';
        prezzoField.name = 'prezzo';
        prezzoField.value = elemento.prezzo;
        priceForm.appendChild(prezzoField);
        
        const submitBtn = document.createElement('button');
        submitBtn.type = 'submit';
        submitBtn.classList.add('text-button');
        submitBtn.appendChild(prodottiText);
        priceForm.appendChild(submitBtn);
        
        itemButton.appendChild(priceForm);
        

        const addForm = document.createElement('form');
        addForm.method = 'POST';
        addForm.action = '/hw2/laravel_app/public/api/cart/add';
        addForm.classList.add('inline-form', 'ml-auto');
        

        addForm.appendChild(csrfField.cloneNode(true));
        addForm.appendChild(idField.cloneNode(true));
        addForm.appendChild(nomeField.cloneNode(true));
        addForm.appendChild(descField.cloneNode(true));
        addForm.appendChild(prezzoField.cloneNode(true));

        const addBtn = document.createElement('button');
        addBtn.type = 'submit';
        addBtn.classList.add('square');
        addBtn.textContent = '+';
        addForm.appendChild(addBtn);
        
        const handleFormSubmit = function(e) {
            e.preventDefault();
            const form = e.currentTarget;
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(function parseResponse(response) {
                return response.json();
            })
            .then(function handleData(data) {
                if (data.success) {
                    if (typeof reloadCart === 'function') {
                        reloadCart();
                    }
                } else {
                    document.querySelector('#errori').textContent="Effettuare il login per aggiungere un prodotto al carrello";
                }
            });
        };
        
        priceForm.addEventListener('submit', handleFormSubmit);
        addForm.addEventListener('submit', handleFormSubmit);
        
        itemButton.appendChild(addForm);
    }

    itemBody.appendChild(itemButton);
    if (elemento.nome === "MALU BURGER (SOLO PANINO)") {
        itemButton.href = 'http://localhost/hw2/laravel_app/public/MALU%20BURGER%20(SOLO%20PANINO)';
    } else if (elemento.nome === "PER INIZIARE") {
        itemButton.href = 'http://localhost/hw2/laravel_app/public/PER_INIZIARE';
    } else if (elemento.nome === "MALU PROMO MENU'") {
        itemButton.href = 'http://localhost/hw2/laravel_app/public/MALU%20PROMO%20MENU';
    } else if (elemento.nome === "MALU LIGHT") {
        itemButton.href = 'http://localhost/hw2/laravel_app/public/MALU%20LIGHT';
    } else if (elemento.nome === "DA BERE") {
        itemButton.href = 'http://localhost/hw2/laravel_app/public/BEVANDE';
    } else if (elemento.nome === "DOLCI") {
        itemButton.href = 'http://localhost/hw2/laravel_app/public/DOLCI';
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
    fetch('http://localhost/hw2/laravel_app/public/api/' + encodeURIComponent(query) + '/' + number)
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
        const nome = item.nome && item.nome.trim() !== '' ? item.nome : 'Sconosciuto';
        const descrizione = item.descrizione && item.descrizione.trim() !== '' ? item.descrizione : 'Nessuna descrizione disponibile.';
        let immagine = item.immagine && item.immagine.trim() !== '' ? item.immagine : 'default.png';
        if (immagine && !immagine.startsWith('http') && !immagine.endsWith('.png') && !immagine.endsWith('.jpg') && !immagine.endsWith('.jpeg')) {
            immagine = 'default.png';
        }

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
        }
        const panelItem = createItem(element);
        const panelBody = document.querySelector('#panel-body');
        panelBody.appendChild(panelItem);
    }
}

function hideItemsCategoria() {
    const panelItems = document.querySelectorAll('#panel-body .panel-item');
    for (const item of panelItems) {
        if (item.dataset.prodotto == 0) {
            item.classList.add('hidden');
        }
    }
}
