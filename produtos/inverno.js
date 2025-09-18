// script.js
document.addEventListener('DOMContentLoaded', function() {
    // Configuração comum para todos os carrosséis
    const swiperConfig = {
        // Slides visíveis
        slidesPerView: 1,
        // Espaço entre slides
        spaceBetween: 20,
        // Loop infinito
        loop: true,
        // Botões de navegação
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        // Responsividade
        breakpoints: {
            // >= 480px
            480: {
                slidesPerView: 2,
            },
            // >= 768px
            768: {
                slidesPerView: 3,
            },
            // >= 1024px
            1024: {
                slidesPerView: 4,
            }
        }
    };

    // Inicialização dos carrosséis
    const frutasSwiper = new Swiper('.frutas-swiper', swiperConfig);
    const verdurasSwiper = new Swiper('.verduras-swiper', swiperConfig);
    const legumesSwiper = new Swiper('.legumes-swiper', swiperConfig);

    // Toggle menu mobile (opcional - implementar conforme necessidade)
    const menuBtn = document.querySelector('.menu-btn');
    menuBtn.addEventListener('click', function() {
        // Implementar lógica do menu mobile aqui
        alert('Menu mobile - Implementar conforme necessidade');
    });
});