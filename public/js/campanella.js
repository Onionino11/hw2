const navCampanella = document.querySelector('#nav-campanella');
const letterbox = document.querySelector('#letterbox');
function displayletterbox(event) {
    event.stopPropagation();
    element=letterbox;
    if (element.classList.contains('hidden')) {
        element.classList.remove('hidden');
    } else {
        element.classList.add('hidden');
    }
}

function hideletterbox() {
    element=letterbox;
    if (!element.classList.contains('hidden')) 
    element.classList.add('hidden');
}
navCampanella.addEventListener('click', displayletterbox);
document.body.addEventListener('click',hideletterbox);

letterbox.addEventListener('click', nonchiudere);

function nonchiudere(event){
    event.stopPropagation();
};