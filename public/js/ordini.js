/**
 * Script per la gestione della pagina degli ordini
 */

document.addEventListener('DOMContentLoaded', function() {
    // Gestione bottoni "Riordina"
    const riordinaButtons = document.querySelectorAll('.btn-reorder, #riordina');
    
    riordinaButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const orderId = this.getAttribute('data-order-id');
            
            // Disabilitiamo il bottone durante il caricamento
            this.textContent = 'Caricamento...';
            this.style.opacity = '0.7';
            this.style.pointerEvents = 'none';
            
            // Chiamata AJAX per aggiungere i prodotti dell'ordine al carrello
            fetch(`/api/cart/reorder/${orderId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mostra notifica di successo
                    showNotification('Prodotti aggiunti al carrello!', 'success');
                    
                    // Aggiorna icona del carrello se necessario
                    // ...
                    
                    // Reindirizza al carrello dopo un breve delay
                    setTimeout(() => {
                        window.location.href = '/checkout';
                    }, 1500);
                } else {
                    // Mostra notifica di errore
                    showNotification('Si è verificato un errore. Riprova più tardi.', 'error');
                    
                    // Ripristina il bottone
                    this.textContent = 'Riordina';
                    this.style.opacity = '1';
                    this.style.pointerEvents = 'auto';
                }
            })
            .catch(error => {
                console.error('Errore:', error);
                showNotification('Si è verificato un errore. Riprova più tardi.', 'error');
                
                // Ripristina il bottone
                this.textContent = 'Riordina';
                this.style.opacity = '1';
                this.style.pointerEvents = 'auto';
            });
        });
    });
    
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
    `;
    document.head.appendChild(style);
});
