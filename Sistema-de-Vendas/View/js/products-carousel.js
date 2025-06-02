document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.querySelector('.products-carousel');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const card = carousel ? carousel.querySelector('.product-link') : null;

    function updateButtons() {
        // Só mostra as setas se o conteúdo for "rolável"
        if (!carousel || !card) return;
        if (carousel.scrollWidth > carousel.clientWidth + 10) {
            prevBtn.style.display = "flex";
            nextBtn.style.display = "flex";
        } else {
            prevBtn.style.display = "none";
            nextBtn.style.display = "none";
        }
    }

    function scrollCarousel(direction) {
        if (!carousel || !card) return;
        const scrollAmount = card.offsetWidth + 24; // 24 = gap
        carousel.scrollBy({
            left: direction === 'next' ? scrollAmount : -scrollAmount,
            behavior: 'smooth'
        });
    }

    if (prevBtn && nextBtn) {
        prevBtn.addEventListener('click', () => scrollCarousel('prev'));
        nextBtn.addEventListener('click', () => scrollCarousel('next'));
    }

    // Atualiza ao redimensionar
    window.addEventListener('resize', updateButtons);
    // Atualiza ao carregar
    setTimeout(updateButtons, 200);
});