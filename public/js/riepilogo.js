const riepilogoContainer = document.getElementById('riepilogo-dinamico');
const totaleSpan = document.getElementById('totale-dinamico');

if (!riepilogoContainer || !totaleSpan) throw new Error('Elementi del riepilogo non trovati');

function formatCurrency(number) {
    return number.toFixed(2).replace('.', ',');
}

function renderRiepilogo() {
    if (Array.isArray(riepilogoData) && riepilogoData.length > 0) {        riepilogoData.forEach(item => {
            const itemDiv = document.createElement('div');
            itemDiv.classList.add('ordine-item');
            
            // Aggiungi punto elenco
            const bulletPoint = document.createTextNode('• ');
            itemDiv.appendChild(bulletPoint);
            
            const quantityName = document.createElement('span');
            quantityName.textContent = `${item.quantita} x ${item.nome}`;
            
            const price = document.createElement('span');
            price.textContent = `€${formatCurrency(parseFloat(item.prezzo))}`;
            
            itemDiv.appendChild(quantityName);
            itemDiv.appendChild(price);
            
            riepilogoContainer.appendChild(itemDiv);
        });
    } else {
        const emptyDiv = document.createElement('div');
        emptyDiv.textContent = 'Nessun prodotto nel riepilogo';
        riepilogoContainer.appendChild(emptyDiv);
    }
    
    if (typeof totaleDinamico === 'number') {
        totaleSpan.textContent = `${formatCurrency(totaleDinamico)} €`;
    }
}

renderRiepilogo();
