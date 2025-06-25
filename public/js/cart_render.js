function VisualizzaCarrellovuoto(cartCollection){
     const vuotoDiv = document.createElement('div');
        vuotoDiv.classList.add('cart-item', 'vuoto');
        vuotoDiv.textContent = 'Il carrello è vuoto';
        cartCollection.appendChild(vuotoDiv);
        document.getElementById('totale').textContent = '0,00 €';
}

function resetcartcollection(cartCollection)
{
    while (cartCollection.firstChild) {
        cartCollection.removeChild(cartCollection.firstChild);
    }
}

function renderCart(cartData) {
    const cartCollection = document.getElementById('cart-collection');
    var btn = document.getElementById('ConcludiOrdine');
    let totale = 0;
    resetcartcollection(cartCollection);

    
    if (!cartData || !Array.isArray(cartData.items) || cartData.items.length === 0) {
        VisualizzaCarrellovuoto(cartCollection);
        btn.classList.add('hidden');
        return;
    }
    else{
        if(btn.classList.contains('hidden')) btn.classList.remove('hidden');
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
                    btnAdd.addEventListener('click',addToCartHandler);
                    leftTop.appendChild(btnAdd);

                    const qtyDiv = document.createElement('div');
                    qtyDiv.classList.add('cart-item-quantity');

                        const qtySpan = document.createElement('span');
                        qtySpan.textContent = 'x' + item.quantita;
                        qtyDiv.appendChild(qtySpan);
                    leftTop.appendChild(qtyDiv);

                    const btnRemove = document.createElement('button');
                    btnRemove.classList.add('cart-item-btn-remove');
                    btnRemove.textContent = '-';
                    btnRemove.addEventListener('click',removeFromCartHandler);
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
                remove.addEventListener('click', removeItemFromCartHandler);
                right.appendChild(remove);

            cartItem.appendChild(right);
            cartCollection.appendChild(cartItem);
        }
        document.querySelector('#totale').textContent = totale.toFixed(2).replace('.', ',') + ' €';
    }
}


function parseResponse(response) {
    return response.json();
}

function handleData(data) {
    if (data.success) reloadCart();
}


function addToCartHandler(event) {
    const button = event.target;
    const cartItem = button.closest('.cart-item');
    const prodottoId = cartItem.dataset.prodotto;
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
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

function removeFromCartHandler(event) {
    const button = event.target;
    const cartItem = button.closest('.cart-item');
    const prodottoId = cartItem.dataset.prodotto;
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch('/hw2/laravel_app/public/api/cart/remove', {
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

function removeItemFromCartHandler(event) {
    const button = event.target;
    const cartItem = button.closest('.cart-item');
    const prodottoId = cartItem.dataset.prodotto;
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch('/hw2/laravel_app/public/api/cart/remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            id: prodottoId,
            remove_all: 1
        })
    })
    .then(parseResponse)
    .then(handleData);
}

function reloadCart() {
    fetch('/hw2/laravel_app/public/api/cart')
    .then(parseResponse)
    .then(renderCart);
}

reloadCart();