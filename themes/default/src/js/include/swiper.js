window.Swiper = require('swiper');
// https://github.com/nolimits4web/swiper/issues/273
var heroSwiper = new Swiper.default ('.swiper-container.hero', {
	spaceBetween: 0,
	direction: 'horizontal',
	CSSWidthAndHeight: true,
	speed: 3000,
	autoplay: {
		delay: 6000,
		crossFade: true,
		disableOnInteraction: false,
	},
	keyboard: {
		enabled: true,
		onlyInViewport: false
  }
  // ,
  // navigation: {
  //   nextEl: '.swiper-button-next',
  //   prevEl: '.swiper-button-prev',
  // }
});

// scroll animation on arrow home
$(".scroll").click(function(e) {
	$scrollToElement = $(this).closest("div.element").next();
	$('html,body').animate({
		scrollTop: $($scrollToElement).offset().top -100},
	'slow');
});
