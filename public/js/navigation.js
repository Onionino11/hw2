const navigationSelect = document.getElementById('navigazione-select');

if (navigationSelect) {
    const categoryItems = document.querySelectorAll('.tipo3');
    
    // Nascondi inizialmente le categorie su mobile
    if (window.innerWidth <= 770) {
        for (const item of categoryItems) {
            item.classList.add('hidden');
        }
    }
    
    function toggleCategoryItems() {
        if (window.innerWidth <= 770) {
            const firstItem = categoryItems[0];
            const isHidden = firstItem.classList.contains('hidden');
              for (const item of categoryItems) {
                if (isHidden) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            }
  
        }
    }
    
    navigationSelect.addEventListener('click', toggleCategoryItems);
    
    // Gestisci il ridimensionamento della finestra
    window.addEventListener('resize', function() {
        if (window.innerWidth <= 770) {
            // Su mobile, nascondi le categorie
            for (const item of categoryItems) {
                item.classList.add('hidden');
            }
        } else {
            // Su desktop, mostra le categorie
            for (const item of categoryItems) {
                item.classList.remove('hidden');
            }
        }
    });
}
