document.addEventListener("DOMContentLoaded", () => {
  initDerwazaSwiper();
  initDerwazaFloatingSwiper();
});

/**
 * Initialize the DerwazaMall Hero Slider.
 */
function initDerwazaSwiper() {
  const swiperEl = document.querySelector(".derwaza-swiper");
  if (!swiperEl) return;

  const autoplaySpeed = parseInt(swiperEl.dataset.autoplay, 10) || 5000;

  new Swiper(swiperEl, {
    loop: true,
    autoplay: {
      delay: autoplaySpeed,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".derwaza-swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".derwaza-swiper-btn-next",
      prevEl: ".derwaza-swiper-btn-prev",
    },
    speed: 800,
  });
}

/**
 * Initialize the DerwazaMall Floating Product Slider.
 */
function initDerwazaFloatingSwiper() {
  const swiperEl = document.querySelector(".derwaza-floating-swiper");
  if (!swiperEl) return;

  const autoplaySpeed = parseInt(swiperEl.dataset.autoplay, 10) || 5000;

  new Swiper(swiperEl, {
    loop: true,
    autoplay: {
      delay: autoplaySpeed,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".derwaza-floating-swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".derwaza-floating-swiper-next",
      prevEl: ".derwaza-floating-swiper-prev",
    },
    speed: 800,
  });
}
