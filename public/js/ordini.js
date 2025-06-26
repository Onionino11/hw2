fetchOrdini();

function fetchOrdini() {
    fetch(`/hw2/laravel_app/public/api/ordini`)
        .then(onSuccess)
        .then(renderOrdiniData);
}

function clearContainer(container) {
    while (container.firstChild) {
        container.removeChild(container.firstChild);
    }
}

function renderOrdiniData(data) {
    const container = document.getElementById('ordini-content');
    console.log(data);
    let ordini = data.ordini;
    clearContainer(container);
    
    if (!ordini || ordini.length === 0) {
        renderEmptyState(container);
        return;
    }
    
    renderOrdiniHeader(container);
    
    const ordiniList = document.createElement('div');
    ordiniList.classList.add('ordini-list');

    let i= 0;
    for (const ordine of ordini) {
        i++;
        if (i > 10) break; 
        const ordineCard = createOrdineCard(ordine);
        ordiniList.appendChild(ordineCard);
    }
    
    container.appendChild(ordiniList);
}

function renderEmptyState(container) {
    const emptyState = document.createElement('div');
    emptyState.classList.add('no-ordini');
    
    const emptyIcon = document.createElement('img');
    emptyIcon.src = `/hw2/laravel_app/public/img/empty-order.svg`;
    emptyIcon.alt = 'Nessun ordine';
    emptyIcon.classList.add('empty-icon');
    
    const title = document.createElement('h3');
    title.textContent = 'Non hai ancora effettuato ordini';
    
    const description = document.createElement('p');
    description.textContent = 'Esplora i nostri prodotti e fai il tuo primo ordine!';
    
    const button = document.createElement('a');
    button.href = '/hw2/laravel_app/public';
    button.classList.add('btn-primary');
    button.textContent = 'Sfoglia il menu';
    
    emptyState.appendChild(emptyIcon);
    emptyState.appendChild(title);
    emptyState.appendChild(description);
    emptyState.appendChild(button);
    
    container.appendChild(emptyState);
}

function renderOrdiniHeader(container) {
    const header = document.createElement('div');
    header.classList.add('ordini-header');
    
    const title = document.createElement('h2');
    title.textContent = 'Storico dei tuoi ordini';
    
    const subtitle = document.createElement('p');
    subtitle.textContent = 'Visualizza i dettagli di tutti i tuoi ordini precedenti';
    
    header.appendChild(title);
    header.appendChild(subtitle);
    
    container.appendChild(header);
}

function createOrdineCard(ordine) {
    const card = document.createElement('div');
    card.classList.add('ordine-card');
    
    const header = createOrdineCardHeader(ordine);
    const body = createOrdineCardBody(ordine);
    const footer = createOrdineCardFooter(ordine);
    
    card.appendChild(header);
    card.appendChild(body);
    card.appendChild(footer);
    
    return card;
}

function createOrdineCardHeader(ordine) {
    const header = document.createElement('div');
    header.classList.add('ordine-header');
    
    const info = document.createElement('div');
    info.classList.add('ordine-info');
    
    const title = document.createElement('h3');
    title.textContent = 'Ordine #' + ordine.id;
    
    const date = document.createElement('span');
    date.classList.add('ordine-data');
    date.textContent = formatDate(ordine.created_at || ordine.data);
    
    info.appendChild(title);
    info.appendChild(date);
    
    const status = document.createElement('div');
    status.classList.add('ordine-status');
    
    const badge = document.createElement('span');
    badge.classList.add('status-badge', (ordine.stato || 'completed').toLowerCase());
    badge.textContent = ordine.stato || 'Completato';
    
    status.appendChild(badge);
    
    header.appendChild(info);
    header.appendChild(status);
    
    return header;
}

function createOrdineCardBody(ordine) {
    const body = document.createElement('div');
    body.classList.add('ordine-body');
    
    const summary = document.createElement('div');
    summary.classList.add('ordine-summary');
    
    const preview = createProdottiPreview(ordine.prodotti || []);
    const totale = createTotaleSection(ordine);
    
    summary.appendChild(preview);
    summary.appendChild(totale);
    body.appendChild(summary);
    
    return body;
}

function createProdottiPreview(prodotti) {
    const container = document.createElement('div');
    container.classList.add('prodotti-preview');
    
    const maxPreview = 3;
    const previewCount = Math.min(prodotti.length, maxPreview);
    
    for (let i = 0; i < previewCount; i++) {
        const prodotto = prodotti[i];
        const preview = document.createElement('div');
        preview.classList.add('prodotto-preview', `z-index-${i}`);
        
        if (prodotto.immagine) {
            const img = document.createElement('img');            
            if (prodotto.immagine.startsWith('http')) {
                img.src = prodotto.immagine;
            } else {
                img.src = `/hw2/laravel_app/public/img/prodotti/${prodotto.immagine}`;
            }
            img.alt = prodotto.nome;
            preview.appendChild(img);
        } else {
            const noImg = document.createElement('div');
            noImg.classList.add('no-image');
            noImg.textContent = '?';
            preview.appendChild(noImg);
        }
        
        container.appendChild(preview);
    }
    
    if (prodotti.length > maxPreview) {
        const more = document.createElement('div');
        more.classList.add('prodotto-preview', 'more');
        more.textContent = '+' + (prodotti.length - maxPreview);
        container.appendChild(more);
    }
    
    return container;
}

function createTotaleSection(ordine) {
    const container = document.createElement('div');
    container.classList.add('ordine-totale');
    
    const label = document.createElement('span');
    label.classList.add('totale-label');
    label.textContent = 'Totale';
    
    const value = document.createElement('span');
    value.classList.add('totale-value');
    value.textContent = '€' + formatNumber(ordine.totale);
    
    container.appendChild(label);
    container.appendChild(value);
    
    return container;
}

function createOrdineCardFooter(ordine) {
    const footer = document.createElement('div');
    footer.classList.add('ordine-footer');
    
    const button = document.createElement('a');
    button.href = `/hw2/laravel_app/public/ordini/${ordine.id}`;
    button.classList.add('btn-details');
    button.textContent = 'Visualizza dettagli';
    
    footer.appendChild(button);
    
    return footer;
}

function formatDate(dateString) {
    if (!dateString) return '';
    
    const date = new Date(dateString);
    const day = date.getDate().toString().padStart(2, '0');
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const year = date.getFullYear();
    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');
    
    return `${day}/${month}/${year} ${hours}:${minutes}`;
}

function formatNumber(number) {
    return (parseFloat(number) || 0).toFixed(2);
}



