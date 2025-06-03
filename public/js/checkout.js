fetch('../php/api_cart.php')
  .then(r => r.json())
  .then(data => {
    const list = document.getElementById('checkout-summary-list');
    const totaleSpan = document.getElementById('checkout-summary-totale');
    list.innerHTML = '';
    let totale = 0;
    if(data && Array.isArray(data.items)) {
      data.items.forEach(item => {
        const li = document.createElement('li');
        li.innerHTML = `<span>${item.quantita} x ${item.nome}</span><span>€${Number(item.prezzo).toFixed(2).replace('.', ',')}</span>`;
        list.appendChild(li);
        totale += item.prezzo * item.quantita;
      });
    }
    totaleSpan.textContent = totale.toFixed(2).replace('.', ',') + ' €';
  });
