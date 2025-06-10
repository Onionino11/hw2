function parseJson(response) {
  return response.json();
}

function renderCheckoutSummary(data) {
  const list = document.getElementById('checkout-summary-list');
  const totaleSpan = document.getElementById('checkout-summary-totale');
  list.innerHTML = '';
  let totale = 0;
  
  if(data && Array.isArray(data.items)) {
    for (const item of data.items) {
      const li = document.createElement('li');
      const spanNome = document.createElement('span');
      spanNome.textContent = item.quantita + ' x ' + item.nome;
      const spanPrezzo = document.createElement('span');
      spanPrezzo.textContent = '€' + Number(item.prezzo).toFixed(2).replace('.', ',');
      li.appendChild(spanNome);
      li.appendChild(spanPrezzo);
      list.appendChild(li);
      totale += item.prezzo * item.quantita;
    }
  }
  
  totaleSpan.textContent = totale.toFixed(2).replace('.', ',') + ' €';
}

fetch('/hw2/laravel_app/public/api/cart')
  .then(parseJson)
  .then(renderCheckoutSummary);
