const navCampanella = document.querySelector('#nav-campanella');
function displayletterbox() {
    const element = document.querySelector('#letterbox');
    if (element.classList.contains('hidden')) {
        element.classList.remove('hidden');
    } else {
        element.classList.add('hidden');
    }
}

function hideletterbox() {
    const element = document.querySelector('#letterbox');
    element.classList.add('hidden');
}
navCampanella.addEventListener('click', displayletterbox);
navCampanella.addEventListener('blur',  hideletterbox);
