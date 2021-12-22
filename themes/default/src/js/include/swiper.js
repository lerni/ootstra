// import Swiper from 'swiper/bundle';

import {
  Swiper,
  Navigation,
  Pagination,
  Autoplay,
  EffectFade
} from 'swiper';

Swiper.use([Navigation, Pagination, Autoplay, EffectFade]);

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
$(".scroll").click(function(e) {
	$scrollToElement = $(this).closest("div.element").next();
	$('html,body').animate({
		scrollTop: $($scrollToElement).offset().top -100},
	'slow');
});
