const navigationSelect = document.getElementById('navigazione-select');

if (navigationSelect) {
    const categoryItems = document.querySelectorAll('.tipo3');    function toggleCategoryItems() {
        const firstItem = categoryItems[0];
        const isShown = firstItem.classList.contains('show');
        
        for (const item of categoryItems) {
            if (isShown) {
                item.classList.remove('show');
            } else {
                item.classList.add('show');
            }
        }
    }
    
    navigationSelect.addEventListener('click', toggleCategoryItems);
}
