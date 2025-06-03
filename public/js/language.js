// language.js
// Gestione selezione lingua

const languageSelector = document.querySelector('#nav-flag');
const menu = document.querySelector('#language-menu');
function displayLanguageMenu() {
    const element = document.querySelector('#language-menu');
    if (element.classList.contains('hidden')) {
        element.classList.remove('hidden');
        console.log('Menu lingua mostrato');
    } else {
        element.classList.add('hidden');
        console.log('Menu lingua nascosto da click');
    }
}

function hideLanguageMenu() {
    const element = document.querySelector('#language-menu');
    element.classList.add('hidden');
    console.log('Menu lingua nascosto da blur');
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
        languageSelector.querySelector('img').src = '../assets/img/Flag_of_Italy.svg';
    } else if (linguaAttuale === 'English') {
        let linguaAttiva = menu.querySelector('#English');
        linguaAttiva.classList.add('linguaattuale');
        languageSelector.querySelector('img').src = '../assets/img/Flag_of_the_United_Kingdom.svg';
    }
}
setLinguaAttuale();

const lingue = menu.querySelectorAll('.lingua'); 
for (const lingua of lingue) {
    lingua.addEventListener('click', cambiaLingua);
    console.log(lingua.dataset.value);
}

function cambiaLingua(event) {
    const linguaSelezionata = event.currentTarget.dataset.value; 
    console.log("cambiaLingua:", linguaSelezionata);
    let linguaAttiva = menu.querySelector('#'+linguaAttuale);
    linguaAttiva.classList.remove('linguaattuale');

    if (linguaSelezionata === 'Italiano') {
        linguaAttuale = 'Italiano';
        console.log(linguaAttuale);
        setLinguaAttuale();
    } else if (linguaSelezionata === 'English') {
        linguaAttuale = 'English';
        console.log(linguaAttuale);
        setLinguaAttuale();
    }
}
