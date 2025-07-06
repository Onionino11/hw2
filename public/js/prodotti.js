

function handleFormSubmit (event)
{
    event.preventDefault();
    const form = e.currentTarget;
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(parseResponse)
    .then(Successorlogin);
};

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
    itemTitle.appendChild(itemCategory);

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
    itemTitle.appendChild(opzionali);

    itemDescription.appendChild(itemTitle);
    const descrizioneElement = document.createElement('p');
    if (elemento.descrizione && elemento.descrizione.trim() !== '') {
        descrizioneElement.textContent += elemento.descrizione;
    } else {
        descrizioneElement.textContent += 'Nessuna descrizione disponibile.';
    }
    itemDescription.appendChild(descrizioneElement);
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
        square.classList.add('cart-item-btn-add');
        square.textContent = '>';
        itemButton.appendChild(square);
    } else {
        prodottiText.classList.add('N-Prodotti');
        prodottiText.textContent = elemento.prezzo + '€';
        
        const priceButton = document.createElement('button');
        priceButton.classList.add('text-button');
        priceButton.dataset.prodottoId = elemento.prodotto; 
        priceButton.appendChild(prodottiText);
        priceButton.addEventListener('click', handleAddToCart); 
    
        const addButton = document.createElement('button');
        addButton.classList.add('square', 'cart-item-btn-add');
        addButton.dataset.prodottoId = elemento.prodotto; 
        addButton.textContent = '+';
        addButton.addEventListener('click', handleAddToCart);
    
        itemButton.appendChild(priceButton);
        itemButton.appendChild(addButton);
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

function handleAddToCart(event) {
    event.preventDefault();
    
    const prodottoId = event.target.dataset.prodottoId; 
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    fetch('/hw2/laravel_app/public/api/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            id: prodottoId
        })
    })
    .then(parseResponse)
    .then(handleData);
}


function onJsonItems(data) {
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

