// import Swiper from 'swiper/bundle';

import {
  Swiper,
  Navigation,
  Pagination,
  Autoplay,
  // EffectFade,
  Keyboard,
  Thumbs
} from 'swiper';

Swiper.use([Navigation, Pagination, Autoplay, Keyboard, Thumbs]);

var heroSwiper = document.querySelectorAll('.swiper-container.hero');
Array.prototype.forEach.call(heroSwiper, function (slider) {
  var sliderID = slider.getAttribute('id');
  var sliderPrev = '#hero-swiper-prev' + slider.getAttribute('data-id');
  var sliderNext = '#hero-swiper-next' + slider.getAttribute('data-id');
  var sliderPagination = '#hero-swiper-pagination' + slider.getAttribute('data-id');

  var heroSwiperInstance = new Swiper ('#'+sliderID, {
    spaceBetween: 0,
    direction: 'horizontal',
    CSSWidthAndHeight: true,
    speed: 2000,
    height: 'auto',
    keyboard: {
      enabled: true,
    },
    autoplay: {
      delay: 4500,
      disableOnInteraction: true,
    },
    fadeEffect: {
      crossFade: true
    },
    navigation: {
      nextEl: sliderNext,
      prevEl: sliderPrev
    },
    pagination: {
      el: sliderPagination,
      type: 'bullets',
      clickable: true
    }
  });
});

// scroll animation on arrow home
// $(".scroll").click(function(e) {
// 	$scrollToElement = $(this).closest("div.element").next();
// 	$('html,body').animate({
// 		scrollTop: $($scrollToElement).offset().top -100},
// 	'slow');
// });

var multipleSwiper = document.querySelectorAll('.swiper-container.multiple');
Array.prototype.forEach.call(multipleSwiper, function (slider) {
  var sliderID = slider.getAttribute('id');
  var sliderPrev = '#multiple-swiper-prev' + slider.getAttribute('data-id');
  var sliderNext = '#multiple-swiper-next' + slider.getAttribute('data-id');
  var sliderPagination = '#multiple-swiper-pagination' + slider.getAttribute('data-id');
  var multipleSwiperInstance = new Swiper ('#'+sliderID, {
    spaceBetween: 25, // 18px times (1.41em = $lineheight)
    freeMode: true,
    slidesPerView: 'auto',
    speed: 1000,
    keyboard: {
      enabled: true,
    },
    autoplay: {
      delay: 3000,
      disableOnInteraction: true,
    },
    keyboard: {
      enabled: true,
      onlyInViewport: false,
    }
  });
});
