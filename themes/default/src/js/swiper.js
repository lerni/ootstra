// import Swiper from 'swiper/bundle';

import Swiper from "swiper/core";

import {
  Autoplay,
  EffectFade,
  Keyboard,
  Navigation,
  Pagination
  // Thumbs
} from "swiper/modules";

Swiper.use([Autoplay, EffectFade, Keyboard, Navigation, Pagination]);

var heroSwiper = document.querySelectorAll(".swiper-container.hero");
Array.prototype.forEach.call(heroSwiper, function (slider) {
  var sliderID = slider.getAttribute("id");
  var sliderPrev = "#hero-swiper-prev" + slider.getAttribute("data-id");
  var sliderNext = "#hero-swiper-next" + slider.getAttribute("data-id");
  var sliderPagination = "#hero-swiper-pagination" + slider.getAttribute("data-id");

  var heroSwiperInstance = new Swiper("#" + sliderID, {
    spaceBetween: 0,
    direction: "horizontal",
    CSSWidthAndHeight: true,
    speed: 2000,
    height: "auto",
    keyboard: {
      enabled: true,
    },
    autoplay: {
      delay: 4500,
      disableOnInteraction: true,
    },
    effect: "fade",
    fadeEffect: {
      crossFade: true,
    },
    navigation: {
      nextEl: sliderNext,
      prevEl: sliderPrev,
    },
    pagination: {
      el: sliderPagination,
      type: "bullets",
      clickable: true,
    },
  });
});

// scroll animation on arrow home
// $(".scroll").click(function(e) {
// 	$scrollToElement = $(this).closest("div.element").next();
// 	$('html,body').animate({
// 		scrollTop: $($scrollToElement).offset().top -100},
// 	'slow');
// });

var multipleSwiper = document.querySelectorAll(
  ".swiper-container.teaser, .swiper-container.multiple, .swiper-container.perso-cfa"
);
Array.prototype.forEach.call(multipleSwiper, function (slider) {
  var sliderID = slider.getAttribute("id");
  var sliderPrev = "#multiple-swiper-prev" + slider.getAttribute("data-id");
  var sliderNext = "#multiple-swiper-next" + slider.getAttribute("data-id");
  var generalSwiperInstance = new Swiper("#" + sliderID, {
    spaceBetween: 25, // $text-size times $lineheight
    freeMode: true,
    slidesPerView: "auto",
    speed: 1000,
    // loop: true,
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
    },
  });
  generalSwiperInstance.autoplay.stop();
  const observerOptions = {
    root: null,
    rootMargin: "0px",
    threshold: 0.1,
  };
  const observerCallback = (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        generalSwiperInstance.autoplay.start();
      } else {
        generalSwiperInstance.autoplay.stop();
      }
    });
  };
  const observer = new IntersectionObserver(observerCallback, observerOptions);
  if (slider) {
    observer.observe(slider);
  }
});

var instafeedSwiper = document.querySelectorAll(".swiper-container.instafeed");
Array.prototype.forEach.call(instafeedSwiper, function (slider) {
  var sliderID = slider.getAttribute("id");
  var sliderPrev = "#insta-swiper-prev" + slider.getAttribute("data-id");
  var sliderNext = "#insta-swiper-next" + slider.getAttribute("data-id");
  var instafeedSwiperInstance = new Swiper("#" + sliderID, {
    spaceBetween: 25, // $lineheight in px
    freeMode: true,
    slidesPerView: "auto",
    speed: 1000,
    // loop: true,
    keyboard: {
      enabled: true,
    },
    autoplay: {
      delay: 1000,
      disableOnInteraction: true,
    },
    keyboard: {
      enabled: true,
      onlyInViewport: false,
    },
    breakpoints: {
      1280: {
        spaceBetween: 50,
      },
    },
  });
  instafeedSwiperInstance.autoplay.stop();
  const observerOptions = {
    root: null,
    rootMargin: "0px",
    threshold: 0.1,
  };
  const observerCallback = (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        instafeedSwiperInstance.autoplay.start();
      } else {
        instafeedSwiperInstance.autoplay.stop();
      }
    });
  };
  const observer = new IntersectionObserver(observerCallback, observerOptions);
  if (slider) {
    observer.observe(slider);
  }
});

var instafeedVerticalSwiper = document.querySelectorAll(
  ".swiper-container.swiper-v"
);
Array.prototype.forEach.call(instafeedVerticalSwiper, function (slider) {
  var sliderID = slider.getAttribute("id");
  var sliderVerticalPagination =
    "#insta-vertical-swiper-pagination" + slider.getAttribute("data-id");
  var instafeedVerticalSwiperInstance = new Swiper("#" + sliderID, {
    direction: "vertical",
    spaceBetween: 50,
    slidesPerView: 1,
    pagination: {
      el: sliderVerticalPagination,
      type: "bullets",
      clickable: true,
    },
    keyboard: {
      enabled: true,
      onlyInViewport: true,
    },
  });
});
