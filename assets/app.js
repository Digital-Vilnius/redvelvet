import 'lightgallery.js/dist/js/lightgallery.min';

import Swiper, {Autoplay, Pagination} from 'swiper';
import 'swiper/swiper-bundle.css';

import './scss/style.scss';

lightGallery(document.getElementById('lightgallery'));

Swiper.use([Autoplay, Pagination]);
const swiper = new Swiper('.swiper-container', {
    pagination: {
        el: '.swiper-pagination',
    },
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
});