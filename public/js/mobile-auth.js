document.addEventListener('DOMContentLoaded', function() {
    // Elementi del DOM
    const mobileAuthBtn = document.getElementById('mobile-auth-btn');
    const mobileAuthModal = document.getElementById('mobile-auth-modal');
    const mobileAuthClose = document.querySelector('.mobile-auth-close');
    
    // Controllo se gli elementi esistono
    if (!mobileAuthBtn || !mobileAuthModal || !mobileAuthClose) {
        return;
    }
    
    // Funzione per aprire il modal
    function openModal() {
        mobileAuthModal.classList.remove('hidden');
        document.body.classList.add('modal-open');
    }
    
    // Funzione per chiudere il modal
    function closeModal() {
        mobileAuthModal.classList.add('hidden');
        document.body.classList.remove('modal-open');
    }
    
    // Evento per aprire il modal
    mobileAuthBtn.addEventListener('click', function(e) {
        e.preventDefault();
        openModal();
    });
    
    // Evento per chiudere il modal
    mobileAuthClose.addEventListener('click', closeModal);
    
    // Chiudi il modal cliccando fuori dal contenuto
    mobileAuthModal.addEventListener('click', function(e) {
        if (e.target === mobileAuthModal) {
            closeModal();
        }
    });
    
    // Chiudi il modal con ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !mobileAuthModal.classList.contains('hidden')) {
            closeModal();
        }
    });
});
