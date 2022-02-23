
const swiperMatch = new Swiper('.match-slider', {
    slidesPerView: 'auto',
    slidesPerColumn: 2,
    slidesPerColumnFill: 'row',
    spaceBetween: 30,
    breakpoints: {
        576: {
            spaceBetween: 24,
        },
    }
});

const swiperGames = new Swiper('.games-slider', {
    slidesPerView: 'auto',
    spaceBetween: 16,
    breakpoints: {
        576: {
            spaceBetween: 8,
        },
        768: {
            spaceBetween: 12,
        },
    }
});

const swiperPromotions = new Swiper('.promotions-slider', {
    slidesPerView: 'auto',
    spaceBetween: 16,
    breakpoints: {
        576: {
            spaceBetween: 8,
        },
        768: {
            spaceBetween: 12,
        },
    }
});

const openMobileMenu = document.querySelector('.openMenu');
const closeMobileMenu = document.querySelector('.closeModal');
const openMobileOverlay = document.querySelector('.header-mobile--overlay');
const openMobileNav = document.querySelector('.header-mobile__nav');
const tabMenuMore = document.querySelector('.tabMenuMore');
const tabMenu = document.querySelector('.tab-menu');
const tabInner = document.querySelector('.tabInner');

openMobileMenu.onclick = () => {
    openMobileOverlay.classList.add('active');
    openMobileNav.classList.add('open');
}

closeMobileMenu.onclick = () => {
    openMobileOverlay.classList.remove('active');
    openMobileNav.classList.remove('open');
}

tabMenuMore.onclick = () => {
    tabMenu.classList.toggle('more-view');
    tabInner.classList.toggle('open')
    tabMenuMore.style.display = "none"
}