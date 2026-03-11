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

const heroSwiper = document.querySelectorAll(".swiper-container.hero");
Array.prototype.forEach.call(heroSwiper, function (slider) {
  const sliderID = slider.getAttribute("id");
  const sliderPrev = "#hero-swiper-prev" + slider.getAttribute("data-id");
  const sliderNext = "#hero-swiper-next" + slider.getAttribute("data-id");
  const sliderPagination = "#hero-swiper-pagination" + slider.getAttribute("data-id");

  const heroSwiperInstance = new Swiper("#" + sliderID, {
    spaceBetween: 0,
    direction: "horizontal",
    // CSSWidthAndHeight: true,
    speed: 2000,
    // height: "auto",
    keyboard: {
      enabled: true,
      onlyInViewport: true,
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
    // pagination: {
    //   el: sliderPagination,
    //   type: "bullets",
    //   clickable: true,
    // },
    pagination: {
      el: ".swiper-pagination",
      type: "progressbar",
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

const multipleSwiper = document.querySelectorAll(
  ".swiper-container.multiple, .swiper-container.perso-cfa"
);
Array.prototype.forEach.call(multipleSwiper, function (slider) {
  const sliderID = slider.getAttribute("id");
  const sliderPrev = "#multiple-swiper-prev" + slider.getAttribute("data-id");
  const sliderNext = "#multiple-swiper-next" + slider.getAttribute("data-id");
  const gap = parseFloat(window.getComputedStyle(slider).lineHeight);

  const generalSwiperInstance = new Swiper("#" + sliderID, {
    spaceBetween: gap,
    freeMode: true,
    slidesPerView: "auto",
    speed: 1000,
    // loop: true,
    autoplay: {
      delay: 3000,
      disableOnInteraction: true,
    },
    keyboard: {
      enabled: true,
      onlyInViewport: true,
    },
    navigation: {
      nextEl: sliderNext,
      prevEl: sliderPrev,
    },
    breakpoints: {
      980: {
        spaceBetween: gap * 2,
      },
    }
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

const testimonialSwiper = document.querySelectorAll(
  ".swiper-container.testimonial"
);
Array.prototype.forEach.call(testimonialSwiper, function (slider) {
  const sliderID = slider.getAttribute("id");
  const testimonialPagination = "#testimonial-swiper-pagination" + slider.getAttribute("data-id");
  const testimonialSwiperInstance = new Swiper("#" + sliderID, {
    spaceBetween: 100, // $text-size times $lineheight
    slidesPerView: 1, // Change to 1 when using fade effect
    speed: 1600,
    // loop: true,
    autoplay: {
      delay: 6000,
      disableOnInteraction: true,
    },
    keyboard: {
      enabled: true,
      onlyInViewport: true,
    },
    effect: "fade", // Add fade effect
    fadeEffect: {
      crossFade: true, // Enable cross fade
    },
    pagination: {
      el: testimonialPagination,
      type: "bullets",
      clickable: true
    }
  });
  testimonialSwiperInstance.autoplay.stop();
  const observerOptions = {
    root: null,
    rootMargin: "0px",
    threshold: 0.1,
  };
  const observerCallback = (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        testimonialSwiperInstance.autoplay.start();
      } else {
        testimonialSwiperInstance.autoplay.stop();
      }
    });
  };
  const observer = new IntersectionObserver(observerCallback, observerOptions);
  if (slider) {
    observer.observe(slider);
  }
});

const instafeedSwiper = document.querySelectorAll(".swiper-container.instafeed");
Array.prototype.forEach.call(instafeedSwiper, function (slider) {
  const sliderID = slider.getAttribute("id");
  const sliderPrev = "#insta-swiper-prev" + slider.getAttribute("data-id");
  const sliderNext = "#insta-swiper-next" + slider.getAttribute("data-id");
  const gap = parseFloat(window.getComputedStyle(slider).lineHeight);
  const instafeedSwiperInstance = new Swiper("#" + sliderID, {
    spaceBetween: gap,
    freeMode: true,
    slidesPerView: "auto",
    speed: 1000,
    // loop: true,
    autoplay: {
      delay: 1000,
      disableOnInteraction: true,
    },
    keyboard: {
      enabled: true,
      onlyInViewport: true,
    },
    breakpoints: {
      980: {
        spaceBetween: gap * 2,
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

const instafeedVerticalSwiper = document.querySelectorAll(
  ".swiper-container.swiper-v"
);
Array.prototype.forEach.call(instafeedVerticalSwiper, function (slider) {
  const sliderID = slider.getAttribute("id");
  const sliderVerticalPagination = "#insta-vertical-swiper-pagination" + slider.getAttribute("data-id");
  const gap = parseFloat(window.getComputedStyle(slider).lineHeight);
  const instafeedVerticalSwiperInstance = new Swiper("#" + sliderID, {
    direction: "vertical",
    spaceBetween: gap * 2,
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

const logoSwiper = document.querySelectorAll('.swiper-container.logo');
Array.prototype.forEach.call(logoSwiper, function (slider) {
  const sliderID = slider.getAttribute('id');
  const logoSwiperInstance = new Swiper ('#'+sliderID, {
    freeMode: true,
    slidesPerView: 'auto',
    speed: 5000,
    loop: true,
    spaceBetween: 0,
    direction: 'horizontal',
    autoplay: {
      delay: 0,
      disableOnInteraction: true,
      reverseDirection: true,
    },
    keyboard: {
      enabled: true,
      onlyInViewport: true,
    }
  });
});
