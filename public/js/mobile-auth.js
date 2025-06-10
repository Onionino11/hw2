function initMobileAuth() {
    const mobileAuthBtn = document.getElementById('mobile-auth-btn');
    const mobileAuthModal = document.getElementById('mobile-auth-modal');
    const mobileAuthClose = document.querySelector('.mobile-auth-close');
    
    if (!mobileAuthBtn || !mobileAuthModal || !mobileAuthClose) {
        return;
    }
    
    function openModal() {
        mobileAuthModal.classList.remove('hidden');
        document.body.classList.add('modal-open');
    }
    
    function closeModal() {
        mobileAuthModal.classList.add('hidden');
        document.body.classList.remove('modal-open');
    }
    
    function handleBtnClick(e) {
        e.preventDefault();
        openModal();
    }
    
    function handleModalClick(e) {
        if (e.target === mobileAuthModal) {
            closeModal();
        }
    }
    
    function handleKeyDown(e) {
        if (e.key === 'Escape' && !mobileAuthModal.classList.contains('hidden')) {
            closeModal();
        }
    }
    
    mobileAuthBtn.addEventListener('click', handleBtnClick);
    mobileAuthClose.addEventListener('click', closeModal);
    mobileAuthModal.addEventListener('click', handleModalClick);
    document.addEventListener('keydown', handleKeyDown);
}

initMobileAuth();
