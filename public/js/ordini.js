/**
 * Script per la gestione della pagina degli ordini
 */

document.addEventListener('DOMContentLoaded', function() {
    // Nessun bottone da gestire dopo la rimozione della funzionalità di riordino
    
    // Funzione per mostrare notifiche
    function showNotification(message, type) {
        // Controlla se esiste già un elemento di notifica
        let notification = document.querySelector('.notification');
        
        // Se non esiste, crealo
        if (!notification) {
            notification = document.createElement('div');
            notification.className = 'notification';
            document.body.appendChild(notification);
        }
        
        // Imposta il tipo e il messaggio
        notification.className = 'notification ' + type;
        notification.textContent = message;
        
        // Mostra la notifica
        notification.style.display = 'block';
        
        // Aggiungi la classe per l'animazione
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);
        
        // Nascondi la notifica dopo 3 secondi
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.style.display = 'none';
            }, 300);
        }, 3000);
    }
    
    // Stile CSS inline per le notifiche
    const style = document.createElement('style');
    style.textContent = `
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 4px;
            color: white;
            font-weight: 500;
            z-index: 9999;
            transform: translateY(-20px);
            opacity: 0;
            transition: transform 0.3s, opacity 0.3s;
            display: none;
        }
        
        .notification.show {
            transform: translateY(0);
            opacity: 1;
        }
        
        .notification.success {
            background-color: #4caf50;
        }
        
        .notification.error {
            background-color: #f44336;
        }
        
        .notification.info {
            background-color: #2196f3;
        }
    `;
    document.head.appendChild(style);
});
