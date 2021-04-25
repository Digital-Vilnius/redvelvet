import 'lightgallery.js/dist/js/lightgallery.min';

import Swiper, {Autoplay, Navigation, Pagination, Thumbs} from 'swiper';
import 'swiper/swiper-bundle.css';

import './scss/style.scss';
import {setupHeader} from "./js/setupHeader";

lightGallery(document.getElementById('lightgallery'));

setupHeader();

Swiper.use([Autoplay, Pagination, Thumbs, Navigation]);

const slideshow = new Swiper('.slideshow', {
    pagination: {
        el: '.swiper-pagination',
    },
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
});

const galleryThumbs = new Swiper('.gallery-thumbs', {
    spaceBetween: 5,
    slidesPerView: 3,
    loop: true,
    freeMode: true,
    loopedSlides: 3,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
});

const galleryTop = new Swiper('.gallery-top', {
    spaceBetween: 5,
    loop: true,
    loopedSlides: 3,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    thumbs: {
        swiper: galleryThumbs,
    },
});