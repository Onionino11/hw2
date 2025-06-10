function initOrdiniPage() {
    function showNotification(message, type) {
        let notification = document.querySelector('.notification');
        
        if (!notification) {
            notification = document.createElement('div');
            notification.className = 'notification';
            document.body.appendChild(notification);
        }
        
        notification.className = 'notification ' + type;
        notification.textContent = message;
        
        notification.style.display = 'block';
        
        function addShowClass() {
            notification.classList.add('show');
        }
        
        setTimeout(addShowClass, 10);
        
        setTimeout(function() {
            notification.classList.remove('show');
            
            setTimeout(function() {
                notification.style.display = 'none';
            }, 300);
        }, 3000);
    }
    
    function handleOrdineDetails() {
        const detailButtons = document.querySelectorAll('.visualizza-dettagli');
        
        for (const button of detailButtons) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const ordineId = this.getAttribute('data-ordine');
                  function handleResponse(response) {
                    if (!response.ok) {
                        throw new Error('Errore nella richiesta');
                    }
                    return response.json();
                }
                
                function processData(data) {
                    if (data.success) {
                        window.location.href = `/hw2/laravel_app/public/ordini/${ordineId}`;
                    } else {
                        showNotification('Errore nel caricamento dei dettagli dell\'ordine', 'error');
                    }
                }
                
                function handleError() {
                    showNotification('Si è verificato un errore nella comunicazione con il server', 'error');
                }
                
                fetch(`/hw2/laravel_app/public/api/ordini/${ordineId}`)
                    .then(handleResponse)
                    .then(processData)
                    .catch(handleError);
            });
        }
    }
    
    handleOrdineDetails();
}

// Esegui direttamente la funzione poiché lo script ha l'attributo defer
initOrdiniPage();
