const riepilogoContainer = document.getElementById('riepilogo-dinamico');
const totaleSpan = document.getElementById('totale-dinamico');
const riepilogoData = $riepilogo;
const totaleDinamico = $totale ?? 0 ;

if (!riepilogoContainer || !totaleSpan) throw new Error('Elementi del riepilogo non trovati');

function formatCurrency(number) {
    return number.toFixed(2).replace('.', ',');
}

function renderRiepilogo() {
    if ( riepilogoData.length > 0) {        
        for (const item of riepilogoData) {
            const itemDiv = document.createElement('div');
            itemDiv.classList.add('ordine-item');
            
            const bulletPoint = document.createTextNode('• ');
            itemDiv.appendChild(bulletPoint);
            
            const quantityName = document.createElement('span');
            quantityName.textContent = `${item.quantita} x ${item.nome}`;
            
            const price = document.createElement('span');
            price.textContent = `€${formatCurrency(parseFloat(item.prezzo))}`;
            
            itemDiv.appendChild(quantityName);
            itemDiv.appendChild(price);
            
            riepilogoContainer.appendChild(itemDiv);
        }
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
