const promoScopri = document.querySelector('#promo-scopri');
const popup = document.querySelector('#modal-view');

function removePopup(banneroffert) {
    popup.removeChild(banneroffert);
    popup.classList.add('hidden');
    document.body.classList.remove('modal-open');
    promoScopri.addEventListener('click', showPopup);
}

function showPopup() {
    popup.classList.remove('hidden');
    document.body.classList.add('modal-open'); 
    const banneroffert = document.createElement('div');
    banneroffert.classList.add('popup-content');
    const banneroffertTitle = document.createElement('h3');
    banneroffertTitle.textContent = 'Offerta speciale';
    banneroffertTitle.classList.add('popup-title');
    const closeButton = document.createElement('button');
    closeButton.classList.add('close-button');
    const closeIcon = document.createElement('img');    
    closeIcon.src = '/hw2/laravel_app/public/img/xbianca.svg';
    closeIcon.classList.add('close-icon');
    closeButton.appendChild(closeIcon);
    
    function handleCloseClick() {
        removePopup(banneroffert);
    }

    closeButton.addEventListener('click', handleCloseClick);
    banneroffertTitle.appendChild(closeButton);
    banneroffert.appendChild(banneroffertTitle);    const offerte = data.offerte;
    for (const element of offerte) {
        const offertElement = document.createElement('div');
        offertElement.classList.add('offerta-element');
        const offertElementTitle = document.createElement('div');
        offertElementTitle.classList.add('offerta-title');
        offertElementTitle.textContent = element.Titolo;
        offertElement.appendChild(offertElementTitle);
        const offertElementImg = document.createElement('img');
        offertElementImg.classList.add('offerta-img');
        offertElementImg.src = element.link;
        offertElement.appendChild(offertElementImg);
        const offertElementValidity = document.createElement('div');
        offertElementValidity.classList.add('offerta-validity');
        const offertElementValidityText = document.createElement('span');
        offertElementValidityText.classList.add('offerta-validity-text');
        offertElementValidityText.textContent = element.validita;
        offertElementValidity.appendChild(offertElementValidityText);
        offertElement.appendChild(offertElementValidity);
        const offertElementText = document.createElement('div');
        offertElementText.classList.add('offerta-text');
        offertElementText.textContent = element.text;
        offertElement.appendChild(offertElementText);
        const offertElementdisponibile = document.createElement('div');
        offertElementdisponibile.classList.add('offerta-disponibile');
        const offertElementdisponibileText = document.createElement('p');
        offertElementdisponibileText.textContent = 'Disponibile per:';
        offertElementdisponibile.appendChild(offertElementdisponibileText);
        const offertElementdisponibileTag = document.createElement('div');
        offertElementdisponibileTag.classList.add('bestseller');
        const offertElementdisponibileTagText = document.createElement('p');
        offertElementdisponibileTagText.textContent = element.disponibile;
        offertElementdisponibileTag.appendChild(offertElementdisponibileTagText);
        offertElementdisponibile.appendChild(offertElementdisponibileTag);
        offertElement.appendChild(offertElementdisponibile);
        banneroffert.appendChild(offertElement);
    }
    popup.appendChild(banneroffert);
    promoScopri.removeEventListener('click', showPopup);
}
promoScopri.addEventListener('click', showPopup);

errori=document.querySelector('#errori');
document.body.addEventListener('click', svuotaErrori);
function svuotaErrori() {
    errori.textContent = '';
}