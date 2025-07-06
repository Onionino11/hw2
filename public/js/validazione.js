function validazione(event) {
    let valid = true;
    let password = null;
    let confirmPassword = null;
    const form = event.target;
    const errori = document.querySelector('#errori');
    let passwordField = null;
    for (let i = 0; i < form.elements.length; i++) {
        const field = form.elements[i];
        if (field.type === 'submit' || field.type === 'hidden' || field.type === 'button') continue;
        if (field.classList.contains('opzionale')) continue;
        if (field.name === 'password') {
            password = field.value;
            passwordField = field;
        }
        if (field.name === 'confirm_password') confirmPassword = field.value;
        if (field.value.trim().length <= 1) {
            if (field.name === 'accept_marketing') continue;
            valid = false;
            var missingField = field;
            break;
        }
    }    if (password !== null) {
        if (password.length < 8) {
            errori.textContent = "La password deve essere lunga almeno 8 caratteri.";
            event.preventDefault();
            return;
        }
        if (!/[A-Z]/.test(password)) {
            errori.textContent = "La password deve contenere almeno una lettera maiuscola.";
            event.preventDefault();
            return;
        }
        if (!/[a-z]/.test(password)) {
            errori.textContent = "La password deve contenere almeno una lettera minuscola.";
            event.preventDefault();
            return;
        }
        if (!/[0-9]/.test(password)) {
            errori.textContent = "La password deve contenere almeno un numero.";
            event.preventDefault();
            return;
        }
        if (!/[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/.test(password)) {
            errori.textContent = "La password deve contenere almeno un simbolo.";
            event.preventDefault();
            return;
        }
    }
    if (!valid) {
        let label = missingField && missingField.name ? missingField.name : '';
        switch(label) {
            case 'email': label = 'Email'; break;
            case 'password': label = 'Password'; break;
            case 'confirm_password': label = 'Conferma password'; break;
            case 'first_name': label = 'Nome'; break;
            case 'last_name': label = 'Cognome'; break;
            case 'birthday': label = 'Data di nascita'; break;
            case 'city': label = 'Città'; break;
            case 'province': label = 'Provincia'; break;
            case 'phone': label = 'Telefono'; break;
            default: label = label.charAt(0).toUpperCase() + label.slice(1);
        }
        errori.textContent = "Compilare il campo: " + label;
        event.preventDefault();
        return;
    }
    if (password !== null && confirmPassword !== null && password !== confirmPassword) {
        errori.textContent = "Le password non coincidono.";
        event.preventDefault();
        return;
    }
}

const forms = document.querySelectorAll('form');
if (forms && forms.length > 0) {
    for (const form of forms) {
        if (form) {
            form.addEventListener('submit', validazione);
        }
    }
}