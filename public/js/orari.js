function orariGiornalieri() {
    fetch('../php/orari.php')
        .then(onSuccess, onError)
        .then(onJsonOrariGiornalieri);
}

function onJsonOrariGiornalieri(data) {
    console.log('Risultato della fetch:', data);
    if (data.elements.length > 0) {
        const place = data.elements[0];
        const openingHours = place.tags.opening_hours; 
        const phone = place.tags.phone;
        const website = place.tags.website;
        console.log('Orari di apertura:', openingHours);
        const giorniSettimana = [ 'Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
        const oggi = new Date().getDay();
        const giornoCorrente = giorniSettimana[oggi]; 
        const orariArray= parseOpeningHours(openingHours);
        console.log(orariArray);
        for (const orario of orariArray) {
            if (orario.giorno.trim() === giornoCorrente.trim()) {
                orarioOggi = orario.orario;
            }
        }
        console.log('Orari di apertura per oggi:',giornoCorrente, orarioOggi);
        const orario = document.querySelector('#orario');
        orario.textContent = orarioOggi;
        const telefono = document.querySelector('#telefono');
        telefono.textContent = phone;
        const sito = document.querySelector('#sito');
        sito.textContent = website;
    } else {
        console.log('Nessun luogo trovato con i criteri specificati.');
    }
}

function parseOpeningHours(openingHours) {
    const giorniSettimana = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
    const result = [];
    const orari = openingHours.split(';');
    for (const orario of orari) {
        const [giorni, ore] = orario.trim().split(' ');
        const giorniEspansi = [];
        if (giorni.includes('-')) {
            const [inizio, fine] = giorni.split('-');
            const startIndex = giorniSettimana.indexOf(inizio);
            const endIndex = giorniSettimana.indexOf(fine);
            for (let i = startIndex, j = 0; i <= endIndex; i++, j++) {
                giorniEspansi[j] = giorniSettimana[i]; 
            }
        } else {
            const giorniSplit = giorni.split(',');
            for (let i = 0; i < giorniSplit.length; i++) {
                giorniEspansi[i] = giorniSplit[i]; 
            }
        }
        for (let i = 0; i < giorniEspansi.length; i++) {
            result[result.length] = { giorno: giorniEspansi[i], orario: ore }; 
        }
    }
    return result;
}

orariGiornalieri();

function onSuccess(response) {
    if (!response.ok) {  
        throw new Error('Errore nella risposta: ' + response.status);
    }
    return response.json();
}

function onError(error) {
    console.error('Errore nella richiesta:', error);
}
