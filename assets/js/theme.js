import { animate, inView, stagger } from "motion";
import Swiper from "swiper/bundle";

/**
 * Global frontend behavior for the Mosalam theme: header mega menu, mobile
 * menu, search toggle, methodology tabs (click + drag-scroll), the home
 * sticky side nav, and Framer Motion scroll reveals. Blocks only ship
 * render.php/block.json/index.js, so all page interactivity lives here in
 * one shared, theme-wide script instead of per-block view scripts.
 */

document.addEventListener("DOMContentLoaded", () => {
  initScrollReveal();
  initMegaMenu();
  initMobileMenu();
  initSearch();
  initMethodologyTabs();
  initScrollNextButtons();
  initHomeSideNav();
  initContactForm();
  initOutsideClose();
  initDerwazaSwiper();
  initDerwazaFloatingSwiper();
  initProjectGallery();
});

/**
 * Scroll-reveal animations, powered by Motion's `inView` + `animate`.
 * Elements are hidden by CSS as soon as `html.js` is present (see
 * assets/css/tailwind-input.css) and revealed here the first time they
 * enter the viewport, so the effect degrades to "always visible" with no
 * JS and is skipped entirely for prefers-reduced-motion.
 *
 * Markup contract:
 *   data-animate="fade-up|fade-down|fade-left|fade-right|fade-in|zoom-in"
 *     on a single element to reveal it on its own.
 *   data-animate-group="<variant>" on a container plus data-animate-item on
 *     its (possibly nested) children to reveal them together with a stagger.
 */
function initScrollReveal() {
  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;

  const EASE = [0.22, 1, 0.36, 1];
  const VARIANTS = {
    "fade-up": { y: [40, 0], opacity: [0, 1] },
    "fade-down": { y: [-40, 0], opacity: [0, 1] },
    "fade-left": { x: [40, 0], opacity: [0, 1] },
    "fade-right": { x: [-40, 0], opacity: [0, 1] },
    "fade-in": { opacity: [0, 1] },
    "zoom-in": { scale: [0.92, 1], opacity: [0, 1] },
  };
  const getVariant = (name) => VARIANTS[name] || VARIANTS["fade-up"];
  const viewOptions = { amount: "some", margin: "0px 0px -5% 0px" };

  document.querySelectorAll("[data-animate]").forEach((el) => {
    const variant = getVariant(el.dataset.animate);
    const delay = (parseInt(el.dataset.animateDelay, 10) || 0) / 1000;
    const stop = inView(
      el,
      () => {
        animate(el, variant, { duration: 0.7, delay, easing: EASE });
        stop();
      },
      viewOptions,
    );
  });

  document.querySelectorAll("[data-animate-group]").forEach((group) => {
    const items = Array.from(group.querySelectorAll("[data-animate-item]"));
    if (!items.length) return;
    const variant = getVariant(group.dataset.animateGroup);
    const stop = inView(
      group,
      () => {
        animate(items, variant, {
          duration: 0.6,
          delay: stagger(0.08),
          easing: EASE,
        });
        stop();
      },
      viewOptions,
    );
  });
}

function initMegaMenu() {
  const toggle = document.getElementById("mega-menu-toggle");
  const panel = document.getElementById("mega-menu-panel");
  const chevron = document.getElementById("mega-menu-chevron");
  if (!toggle || !panel) return;

  let activeAnimation = null;

  const open = () => {
    if (activeAnimation) activeAnimation.cancel();
    panel.classList.remove("hidden");
    panel.style.overflow = "hidden";

    const targetHeight = panel.scrollHeight + "px";
    activeAnimation = animate(
      panel,
      { opacity: [0, 1], height: ["0px", targetHeight] },
      { duration: 0.35, easing: [0.25, 1, 0.5, 1] },
    );

    activeAnimation.finished
      .then(() => {
        panel.style.height = "auto";
        panel.style.overflow = "visible";
        activeAnimation = null;
      })
      .catch(() => {});

    toggle.setAttribute("aria-expanded", "true");
    if (chevron) chevron.classList.add("rotate-180");
  };

  const close = () => {
    if (activeAnimation) activeAnimation.cancel();
    panel.style.overflow = "hidden";

    const currentHeight = panel.offsetHeight + "px";
    activeAnimation = animate(
      panel,
      { opacity: [1, 0], height: [currentHeight, "0px"] },
      { duration: 0.25, easing: [0.25, 1, 0.5, 1] },
    );

    activeAnimation.finished
      .then(() => {
        panel.classList.add("hidden");
        activeAnimation = null;
      })
      .catch(() => {});

    toggle.setAttribute("aria-expanded", "false");
    if (chevron) chevron.classList.remove("rotate-180");
  };

  toggle.addEventListener("click", (event) => {
    event.stopPropagation();
    const isOpen = toggle.getAttribute("aria-expanded") === "true";
    isOpen ? close() : open();
  });

  window.addEventListener("resize", () => {
    if (toggle.getAttribute("aria-expanded") === "true") {
      if (window.innerWidth < 1024) {
        close();
      } else {
        panel.style.height = "auto";
      }
    }
  });

  window.mosalamCloseMegaMenu = close;
}

function initMobileMenu() {
  const toggle = document.getElementById("mobile-menu-toggle");
  const panel = document.getElementById("mobile-menu-panel");
  const closeBtn = document.getElementById("mobile-menu-close");
  if (!toggle || !panel) return;

  const open = () => {
    panel.classList.remove("hidden");
    animate(
      panel,
      { x: ["100%", "0%"] },
      { duration: 0.4, easing: [0.23, 1, 0.32, 1] },
    );
    document.body.style.overflow = "hidden";
    toggle.setAttribute("aria-expanded", "true");
  };
  const close = () => {
    animate(
      panel,
      { x: ["0%", "100%"] },
      { duration: 0.35, easing: [0.23, 1, 0.32, 1] },
    ).finished.then(() => panel.classList.add("hidden"));
    document.body.style.overflow = "";
    toggle.setAttribute("aria-expanded", "false");
  };

  toggle.addEventListener("click", () => {
    const isOpen = toggle.getAttribute("aria-expanded") === "true";
    isOpen ? close() : open();
  });
  if (closeBtn) closeBtn.addEventListener("click", close);

  window.addEventListener("resize", () => {
    if (
      window.innerWidth >= 1024 &&
      toggle.getAttribute("aria-expanded") === "true"
    )
      close();
  });

  const servicesToggle = document.getElementById("mobile-services-toggle");
  const servicesPanel = document.getElementById("mobile-services-panel");
  const servicesChevron = document.getElementById("mobile-services-chevron");
  if (servicesToggle && servicesPanel) {
    servicesToggle.addEventListener("click", () => {
      const isOpen = servicesToggle.getAttribute("aria-expanded") === "true";
      servicesToggle.setAttribute("aria-expanded", isOpen ? "false" : "true");
      servicesPanel.classList.toggle("hidden");
      servicesPanel.classList.toggle("flex");
      if (servicesChevron) servicesChevron.classList.toggle("rotate-180");
    });
  }

  document.querySelectorAll(".mobile-subcategory-toggle").forEach((button) => {
    button.addEventListener("click", () => {
      const targetId = button.getAttribute("data-target");
      const target = targetId && document.getElementById(targetId);
      if (!target) return;
      const isOpen = button.getAttribute("aria-expanded") === "true";
      button.setAttribute("aria-expanded", isOpen ? "false" : "true");
      target.classList.toggle("hidden");
      target.classList.toggle("flex");
      const chevron = button.querySelector("svg");
      if (chevron) chevron.classList.toggle("rotate-180");
    });
  });
}

function initSearch() {
  const openBtn = document.getElementById("search-open");
  const closeBtn = document.getElementById("search-close");
  const form = document.getElementById("search-form");
  const input = document.getElementById("search-input");
  if (!openBtn || !form) return;

  const open = () => {
    openBtn.classList.add("hidden");
    form.classList.remove("hidden");
    form.classList.add("flex");
    animate(
      form,
      { opacity: [0, 1], scaleX: [0.85, 1] },
      { duration: 0.3, easing: "ease-in-out" },
    );
    if (input) input.focus();
  };
  const close = () => {
    animate(
      form,
      { opacity: [1, 0], scaleX: [1, 0.85] },
      { duration: 0.25, easing: "ease-in-out" },
    ).finished.then(() => {
      form.classList.add("hidden");
      form.classList.remove("flex");
      openBtn.classList.remove("hidden");
    });
    if (input) input.value = "";
  };

  openBtn.addEventListener("click", open);
  if (closeBtn) closeBtn.addEventListener("click", close);

  window.mosalamCloseSearch = close;
}

function initOutsideClose() {
  const header = document.getElementById("site-header");
  if (!header) return;

  document.addEventListener("mousedown", (event) => {
    if (!header.contains(event.target)) {
      if (window.mosalamCloseMegaMenu) window.mosalamCloseMegaMenu();
      if (window.mosalamCloseSearch) window.mosalamCloseSearch();
    }
  });
}

function initMethodologyTabs() {
  const wrapper = document.querySelector(".js-methodology-tabs");
  if (!wrapper) return;

  const tabButtons = document.querySelectorAll(".js-methodology-tab-btn");
  const panels = document.querySelectorAll(".js-methodology-panel");

  const setActive = (index) => {
    tabButtons.forEach((button) => {
      const isActive = Number(button.dataset.stepIndex) === index;
      button.classList.toggle("text-primary", isActive);
      button.classList.toggle("text-on-surface-variant/50", !isActive);
      const underline = button.querySelector(".js-methodology-tab-underline");
      if (underline) underline.classList.toggle("hidden", !isActive);
    });

    let currentPanel = null;
    let targetPanel = null;

    panels.forEach((panel) => {
      if (!panel.classList.contains("hidden")) {
        currentPanel = panel;
      }
      if (Number(panel.dataset.stepIndex) === index) {
        targetPanel = panel;
      }
    });

    if (currentPanel === targetPanel) return;

    if (currentPanel && targetPanel) {
      animate(
        currentPanel,
        { opacity: 0, transform: "translateY(-10px)" },
        { duration: 0.15 },
      ).then(() => {
        currentPanel.classList.add("hidden");
        currentPanel.style.opacity = "1";
        currentPanel.style.transform = "none";

        targetPanel.classList.remove("hidden");
        targetPanel.style.opacity = "0";
        targetPanel.style.transform = "translateY(15px)";
        animate(
          targetPanel,
          { opacity: 1, transform: "translateY(0)" },
          { duration: 0.35, ease: "easeOut" },
        );
      });
    } else if (targetPanel) {
      targetPanel.classList.remove("hidden");
      targetPanel.style.opacity = "0";
      targetPanel.style.transform = "translateY(15px)";
      animate(
        targetPanel,
        { opacity: 1, transform: "translateY(0)" },
        { duration: 0.35, ease: "easeOut" },
      );
    }
  };

  tabButtons.forEach((button) => {
    button.addEventListener("click", () =>
      setActive(Number(button.dataset.stepIndex)),
    );
  });

  const drag = { isDown: false, startX: 0, scrollLeft: 0 };
  const startDrag = (clientX) => {
    drag.isDown = true;
    drag.startX = clientX;
    drag.scrollLeft = wrapper.scrollLeft;
  };
  const moveDrag = (clientX) => {
    if (!drag.isDown) return;
    wrapper.scrollLeft = drag.scrollLeft - (clientX - drag.startX);
  };
  const stopDrag = () => {
    drag.isDown = false;
  };

  wrapper.addEventListener("mousedown", (event) => startDrag(event.clientX));
  wrapper.addEventListener("mousemove", (event) => moveDrag(event.clientX));
  wrapper.addEventListener("mouseup", stopDrag);
  wrapper.addEventListener("mouseleave", stopDrag);
  wrapper.addEventListener("touchstart", (event) =>
    startDrag(event.touches[0].clientX),
  );
  wrapper.addEventListener("touchmove", (event) =>
    moveDrag(event.touches[0].clientX),
  );
  wrapper.addEventListener("touchend", stopDrag);
}

function initScrollNextButtons() {
  document.querySelectorAll(".js-scroll-next").forEach((button) => {
    button.addEventListener("click", () => {
      const targetId = button.getAttribute("data-scroll-target");
      const target = targetId && document.getElementById(targetId);
      if (target) target.scrollIntoView({ behavior: "smooth", block: "start" });
    });
  });
}

function initContactForm() {
  document.querySelectorAll(".js-contact-form").forEach((form) => {
    form.addEventListener("submit", (event) => event.preventDefault());
  });
}

function initHomeSideNav() {
  const nav = document.querySelector(".js-side-nav");
  if (!nav) return;

  const items = Array.from(nav.querySelectorAll(".js-side-nav-item"));
  const darkBarClass = ["bg-primary", "shadow-[0_0_12px_rgba(0,27,53,0.18)]"];
  const lightBarClass = [
    "bg-white",
    "shadow-[0_0_12px_rgba(255,255,255,0.55)]",
  ];
  const darkLabelClass = [
    "text-white",
    "bg-primary/90",
    "backdrop-blur-xl",
    "drop-shadow-[0_2px_10px_rgba(255,255,255,0.15)]",
  ];
  const lightLabelClass = [
    "text-white",
    "bg-primary/80",
    "backdrop-blur-xl",
    "drop-shadow-[0_2px_10px_rgba(0,27,53,0.95)]",
  ];

  const setTone = (isDark) => {
    items.forEach((item) => {
      const bar = item.querySelector(".js-side-nav-bar");
      const label = item.querySelector(".js-side-nav-label");
      if (bar) {
        bar.classList.remove(...darkBarClass, ...lightBarClass);
        bar.classList.add(...(isDark ? darkBarClass : lightBarClass));
      }
      if (label) {
        label.classList.remove(...darkLabelClass, ...lightLabelClass);
        label.classList.add(...(isDark ? darkLabelClass : lightLabelClass));
      }
    });
  };

  const setActive = (activeItem) => {
    items.forEach((item) => {
      const isActive = item === activeItem;
      item.dataset.active = isActive ? "1" : "0";
      item.classList.toggle("mb-16", isActive);
      item.classList.toggle("mt-4", isActive);
      item.classList.toggle("mb-12", !isActive);

      const bar = item.querySelector(".js-side-nav-bar");
      const label = item.querySelector(".js-side-nav-label");
      if (bar) {
        bar.classList.toggle("w-20", isActive);
        bar.classList.toggle("w-10", !isActive);
        bar.classList.toggle("group-hover:w-16", !isActive);
      }
      if (label) {
        label.classList.toggle("opacity-100", isActive);
        label.classList.toggle("translate-y-0", isActive);
        label.classList.toggle("opacity-0", !isActive);
        label.classList.toggle("-translate-y-2", !isActive);
        label.classList.toggle("group-hover:opacity-100", !isActive);
        label.classList.toggle("group-hover:translate-y-0", !isActive);
      }
    });
    setTone(activeItem.dataset.tone === "light");
  };

  const sectionObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const match = items.find(
          (item) => item.dataset.target === entry.target.id,
        );
        if (match) setActive(match);
      });
    },
    { threshold: 0.2, rootMargin: "-10% 0px -40% 0px" },
  );

  items.forEach((item) => {
    const target = document.getElementById(item.dataset.target);
    if (target) sectionObserver.observe(target);
  });

  const footer = document.getElementById("footer");
  if (footer) {
    const footerObserver = new IntersectionObserver(
      ([entry]) => {
        nav.style.display = entry.isIntersecting ? "none" : "";
      },
      { threshold: 0.05 },
    );
    footerObserver.observe(footer);
  }
}

/**
 * Single Project gallery (single-project.php): a native CSS scroll-snap
 * track, dragged with the mouse (touch already swipes natively), with
 * dot pagination and no arrow buttons. Custom code, no slider library.
 */
function initProjectGallery() {
  document.querySelectorAll(".js-project-gallery").forEach((gallery) => {
    const track = gallery.querySelector(".js-project-gallery-track");
    const slides = Array.from(
      gallery.querySelectorAll(".js-project-gallery-slide"),
    );
    const dots = Array.from(
      gallery.querySelectorAll(".js-project-gallery-dot"),
    );
    if (!track || !slides.length) return;

    const drag = { isDown: false, startX: 0, scrollLeft: 0 };
    const startDrag = (clientX) => {
      drag.isDown = true;
      drag.startX = clientX;
      drag.scrollLeft = track.scrollLeft;
    };
    const moveDrag = (clientX) => {
      if (!drag.isDown) return;
      track.scrollLeft = drag.scrollLeft - (clientX - drag.startX);
    };
    const stopDrag = () => {
      drag.isDown = false;
    };

    track.addEventListener("mousedown", (event) => {
      startDrag(event.clientX);
      event.preventDefault();
    });
    window.addEventListener("mousemove", (event) => moveDrag(event.clientX));
    window.addEventListener("mouseup", stopDrag);
    track.addEventListener("mouseleave", stopDrag);

    if (!dots.length) return;

    const setActiveDot = (index) => {
      dots.forEach((dot, i) => {
        dot.classList.toggle("bg-primary", i === index);
        dot.classList.toggle("w-6", i === index);
        dot.classList.toggle("bg-primary/20", i !== index);
      });
    };

    dots.forEach((dot) => {
      dot.addEventListener("click", () => {
        const index = Number(dot.dataset.index);
        slides[index]?.scrollIntoView({
          behavior: "smooth",
          block: "nearest",
          inline: "center",
        });
      });
    });

    const slideObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting || entry.intersectionRatio < 0.6) return;
          const index = slides.indexOf(entry.target);
          if (index !== -1) setActiveDot(index);
        });
      },
      { root: track, threshold: [0.6] },
    );
    slides.forEach((slide) => slideObserver.observe(slide));
    setActiveDot(0);
  });
}

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
