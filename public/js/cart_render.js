function renderCart(cartData) {
    const cartCollection = document.getElementById('cart-collection');
    while (cartCollection.firstChild) {
        cartCollection.removeChild(cartCollection.firstChild);
    }
    let totale = 0;
    if (!cartData || !Array.isArray(cartData.items) || cartData.items.length === 0) {
        const vuotoDiv = document.createElement('div');
        vuotoDiv.classList.add('cart-item', 'vuoto');
        vuotoDiv.textContent = 'Il carrello è vuoto';
        cartCollection.appendChild(vuotoDiv);
        document.getElementById('totale').textContent = '0,00 €';
        var btn = document.getElementById('ConcludiOrdine');
        if(btn) btn.classList.add('hidden');
        return;
    }
    var btn = document.getElementById('ConcludiOrdine');
    if(btn) btn.classList.remove('hidden');
    for (const item of cartData.items) {
        totale += item.prezzo * item.quantita;
        const cartItem = document.createElement('div');
        cartItem.classList.add('cart-item');
        cartItem.dataset.prodotto = item.prodotto_id;
        const left = document.createElement('div');
        left.classList.add('cart-item-left');
        const leftTop = document.createElement('div');
        leftTop.classList.add('cart-item-left-top');
        const btnAdd = document.createElement('button');
        btnAdd.classList.add('cart-item-btn-add');
        btnAdd.textContent = '+';
        btnAdd.onclick = addToCartHandler;
        leftTop.appendChild(btnAdd);
        const qtyDiv = document.createElement('div');
        qtyDiv.classList.add('cart-item-quantity');
        const qtySpan = document.createElement('span');
        qtySpan.textContent = item.quantita;
        qtyDiv.appendChild(qtySpan);
        qtyDiv.appendChild(document.createTextNode('x'));
        leftTop.appendChild(qtyDiv);
        const btnRemove = document.createElement('button');
        btnRemove.classList.add('cart-item-btn-remove');
        btnRemove.textContent = '-';
        btnRemove.onclick = removeFromCartHandler;
        leftTop.appendChild(btnRemove);
        left.appendChild(leftTop);
        const leftBottom = document.createElement('div');
        leftBottom.classList.add('cart-item-left-bottom');
        leftBottom.textContent = item.nome;
        left.appendChild(leftBottom);
        cartItem.appendChild(left);
        const right = document.createElement('div');
        right.classList.add('cart-item-right');
        const prezzo = document.createElement('div');
        prezzo.classList.add('cart-item-prezzo');
        const prezzoValue = parseFloat(item.prezzo);
        prezzo.textContent = prezzoValue.toFixed(2).replace('.', ',') + ' €';
        right.appendChild(prezzo);
        const remove = document.createElement('button');
        remove.classList.add('cart-item-remove');
        remove.textContent = 'x';
        remove.onclick = removeItemFromCartHandler;
        right.appendChild(remove);
        cartItem.appendChild(right);
        cartCollection.appendChild(cartItem);
    }
    document.getElementById('totale').textContent = totale.toFixed(2).replace('.', ',') + ' €';
}

function addToCartHandler(event) {
    const button = event.target;
    const cartItem = button.closest('.cart-item');
    const prodottoId = cartItem.dataset.prodotto;
    
    const form = document.createElement('form');
    form.action = '/hw2/laravel_app/public/api/cart/add';
    form.method = 'post';
    form.classList.add('hidden-form');
    
    const inputProdottoId = document.createElement('input');
    inputProdottoId.name = 'id';
    inputProdottoId.value = prodottoId;
    form.appendChild(inputProdottoId);
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const inputCsrf = document.createElement('input');
    inputCsrf.name = '_token';
    inputCsrf.value = csrfToken;
    form.appendChild(inputCsrf);
    
    document.body.appendChild(form);
    
    function parseResponse(response) {
        return response.json();
    }
    
    function handleData(data) {
        if (data.success) reloadCart();
    }
    
    function cleanupForm() {
        document.body.removeChild(form);
    }
    
    fetch(form.action, {
        method: 'POST',
        body: new FormData(form)
    })
    .then(parseResponse)
    .then(handleData)
    .finally(cleanupForm);
}

function removeFromCartHandler(event) {
    const button = event.target;
    const cartItem = button.closest('.cart-item');
    const prodottoId = cartItem.dataset.prodotto;
    
    const form = document.createElement('form');
    form.action = '/hw2/laravel_app/public/api/cart/remove';
    form.method = 'post';
    form.classList.add('hidden-form');
    
    const inputProdottoId = document.createElement('input');
    inputProdottoId.name = 'id';
    inputProdottoId.value = prodottoId;
    form.appendChild(inputProdottoId);
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const inputCsrf = document.createElement('input');
    inputCsrf.name = '_token';
    inputCsrf.value = csrfToken;
    form.appendChild(inputCsrf);
    
    document.body.appendChild(form);
    
    function parseResponse(response) {
        return response.json();
    }
    
    function handleData(data) {
        if (data.success) reloadCart();
    }
    
    function cleanupForm() {
        document.body.removeChild(form);
    }
    
    fetch(form.action, {
        method: 'POST',
        body: new FormData(form)
    })
    .then(parseResponse)
    .then(handleData)
    .finally(cleanupForm);
}

function removeItemFromCartHandler(event) {
    const button = event.target;
    const cartItem = button.closest('.cart-item');
    const prodottoId = cartItem.dataset.prodotto;
    
    const form = document.createElement('form');
    form.action = '/hw2/laravel_app/public/api/cart/remove';
    form.method = 'post';
    form.classList.add('hidden-form');
    
    const inputProdottoId = document.createElement('input');
    inputProdottoId.name = 'id';
    inputProdottoId.value = prodottoId;
    form.appendChild(inputProdottoId);
    
    const inputRemoveAll = document.createElement('input');
    inputRemoveAll.name = 'remove_all';
    inputRemoveAll.value = '1';
    form.appendChild(inputRemoveAll);
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const inputCsrf = document.createElement('input');
    inputCsrf.name = '_token';
    inputCsrf.value = csrfToken;
    form.appendChild(inputCsrf);
    
    document.body.appendChild(form);
    
    function parseResponse(response) {
        return response.json();
    }
    
    function handleData(data) {
        if (data.success) reloadCart();
    }
    
    function cleanupForm() {
        document.body.removeChild(form);
    }
    
    fetch(form.action, {
        method: 'POST',
        body: new FormData(form)
    })
    .then(parseResponse)
    .then(handleData)
    .finally(cleanupForm);
}

function reloadCart() {
    function parseResponse(r) {
        return r.json();
    }
    
    function handleData(data) {
        renderCart(data);
    }
    
    fetch('/hw2/laravel_app/public/api/cart')
        .then(parseResponse)
        .then(handleData);
}

reloadCart();