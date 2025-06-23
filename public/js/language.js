const languageSelector = document.querySelector('#nav-flag');
const menu = document.querySelector('#language-menu');
function displayLanguageMenu() {
    const element = document.querySelector('#language-menu');
    if (element.classList.contains('hidden')) {
        element.classList.remove('hidden');
    } else {
        element.classList.add('hidden');
    }
}

function hideLanguageMenu() {
    const element = document.querySelector('#language-menu');
    element.classList.add('hidden');
}

languageSelector.addEventListener('click',  displayLanguageMenu);
languageSelector.addEventListener('blur', hideLanguageMenu);

menu.addEventListener('mousedown', preventDefault);
function preventDefault(event){
    event.preventDefault();
}

let linguaAttuale = languageSelector.dataset.linguaattuale;
function setLinguaAttuale() {    
    if (linguaAttuale === 'Italiano') {
        let linguaAttiva = menu.querySelector('#Italiano');
        linguaAttiva.classList.add('linguaattuale');
        languageSelector.querySelector('img').src = '/hw2/laravel_app/public/img/Flag_of_Italy.svg';
    } else if (linguaAttuale === 'English') {
        let linguaAttiva = menu.querySelector('#English');
        linguaAttiva.classList.add('linguaattuale');
        languageSelector.querySelector('img').src = '/hw2/laravel_app/public/img/Flag_of_the_United_Kingdom.svg';
    }
}
setLinguaAttuale();

const lingue = menu.querySelectorAll('.lingua'); 
for (const lingua of lingue) {
    lingua.addEventListener('click', cambiaLingua);
}

function cambiaLingua(event) {
    const linguaSelezionata = event.currentTarget.dataset.value; 
    let linguaAttiva = menu.querySelector('#'+linguaAttuale);
    linguaAttiva.classList.remove('linguaattuale');

    if (linguaSelezionata === 'Italiano') {
        linguaAttuale = 'Italiano';
        setLinguaAttuale();
    } else if (linguaSelezionata === 'English') {
        linguaAttuale = 'English';
        setLinguaAttuale();
    }
}
