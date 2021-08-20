import {
  Swiper,
  Navigation,
  Pagination,
  // Scrollbar,
  // EffectCoverflow
} from 'swiper';

Swiper.use([Navigation, Pagination]);


var heroSwiper = document.querySelectorAll('.swiper-container.hero');
Array.prototype.forEach.call(heroSwiper, function (slider) {
  var sliderID = slider.getAttribute('id');
  var sliderPrev = '#hero-swiper-prev' + slider.getAttribute('data-id');
  var sliderNext = '#hero-swiper-next' + slider.getAttribute('data-id');
  var sliderPagination = '#hero-swiper-pagination' + slider.getAttribute('data-id');

  var articleSwiper = new Swiper ('#'+sliderID, {
    spaceBetween: 0,
    direction: 'horizontal',
    CSSWidthAndHeight: true,
    speed: 2000,
    height: 'auto',
    autoplay: {
      delay: 4500,
      disableOnInteraction: true,
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
