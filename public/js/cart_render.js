// assets/js/cart_render.js
// Popola il carrello dinamicamente usando i dati ricevuti dal backend (es. da api_cart.php)
function renderCart(cartData) {
    const cartCollection = document.getElementById('cart-collection');
    cartCollection.innerHTML = '';
    let totale = 0;
    if (!cartData || !Array.isArray(cartData.items) || cartData.items.length === 0) {
        const vuotoDiv = document.createElement('div');
        vuotoDiv.className = 'cart-item vuoto';
        vuotoDiv.textContent = 'Il carrello è vuoto';
        cartCollection.appendChild(vuotoDiv);
        document.getElementById('totale').textContent = '0,00 €';
        var btn = document.getElementById('ConcludiOrdine');
        if(btn) btn.classList.add('hidden');
        return;
    }
    var btn = document.getElementById('ConcludiOrdine');
    if(btn) btn.classList.remove('hidden');
    cartData.items.forEach(function(item) {
        totale += item.prezzo * item.quantita;
        const cartItem = document.createElement('div');
        cartItem.className = 'cart-item';
        cartItem.dataset.prodotto = item.prodotto_id;
        const left = document.createElement('div');
        left.className = 'cart-item-left';
        const leftTop = document.createElement('div');
        leftTop.className = 'cart-item-left-top';
        const btnAdd = document.createElement('button');
        btnAdd.className = 'cart-item-btn-add';
        btnAdd.textContent = '+';
        btnAdd.onclick = addToCartHandler;
        leftTop.appendChild(btnAdd);
        const qtyDiv = document.createElement('div');
        qtyDiv.className = 'cart-item-quantity';
        const qtySpan = document.createElement('span');
        qtySpan.textContent = item.quantita;
        qtyDiv.appendChild(qtySpan);
        qtyDiv.appendChild(document.createTextNode('x'));
        leftTop.appendChild(qtyDiv);
        left.appendChild(leftTop);
        const btnRm = document.createElement('button');
        btnRm.className = 'cart-item-btn-rm';
        btnRm.textContent = 'x';
        btnRm.onclick = removeFromCartHandler;
        left.appendChild(btnRm);
        cartItem.appendChild(left);
        const center = document.createElement('div');
        center.className = 'cart-item-center';
        const nameDiv = document.createElement('div');
        nameDiv.className = 'cart-item-name';
        nameDiv.textContent = item.nome;
        center.appendChild(nameDiv);
        const descDiv = document.createElement('div');
        descDiv.className = 'cart-item-description';
        descDiv.textContent = item.descrizione;
        center.appendChild(descDiv);
        cartItem.appendChild(center);
        const right = document.createElement('div');
        right.className = 'cart-item-right';
        const priceSpan = document.createElement('span');
        priceSpan.className = 'cart-item-price';
        priceSpan.textContent = '€' + (Number(item.prezzo)).toFixed(2).replace('.', ',');
        right.appendChild(priceSpan);
        cartItem.appendChild(right);
        cartCollection.appendChild(cartItem);
    });
    document.getElementById('totale').textContent = totale.toFixed(2).replace('.', ',') + ' €';
}

function addToCartHandler(e) {
    const cartItem = e.target.closest('.cart-item');
    const prodottoId = cartItem.dataset.prodotto_id || cartItem.dataset.prodotto || '';
    if (prodottoId) {
        fetch('../php/add_to_cart.php?id=' + encodeURIComponent(prodottoId))
            .then(() => reloadCart());
    }
}

function removeFromCartHandler(e) {
    const cartItem = e.target.closest('.cart-item');
    const prodottoId = cartItem.dataset.prodotto_id || cartItem.dataset.prodotto || '';
    if (prodottoId) {
        fetch('../php/remove_from_cart.php?id=' + encodeURIComponent(prodottoId))
            .then(() => reloadCart());
    }
}

function reloadCart() {
    fetch('../php/api_cart.php')
        .then(r => r.json())
        .then(data => renderCart(data));
}

reloadCart();