import './styles/app.css';

import { createApp } from 'vue';
import { initHeader } from './modules/header.js';
import { initSmoothScroll } from './animations/smoothScroll.js';
import { initScrollIndicator } from './modules/scrollIndicator.js';
import { initFloatingButtons } from './modules/floatingButtons.js';
import { initBackToTop } from './modules/backToTop.js';
import { initContactForms } from './modules/contactForm.js';
import { initLightbox } from './modules/lightbox.js';
import { initReveal } from './animations/reveal.js';
import { initCountUp } from './animations/countUp.js';
import { initParallax } from './animations/parallax.js';
import StatCounter from './components/StatCounter.vue';
import HeroSlider from './components/HeroSlider.vue';
import FeaturedProjectSlider from './components/FeaturedProjectSlider.vue';
import LinhVucCarousel from './components/LinhVucCarousel.vue';

// Vue "islands": any element with data-vue="<ComponentName>" gets hydrated.
const registry = {
  StatCounter,
  HeroSlider,
  FeaturedProjectSlider,
  LinhVucCarousel,
};

function mountIslands() {
  document.querySelectorAll('[data-vue]').forEach((el) => {
    const name = el.getAttribute('data-vue');
    const Component = registry[name];
    if (!Component) return;

    let props = {};
    const raw = el.getAttribute('data-props');
    if (raw) {
      try {
        props = JSON.parse(raw);
      } catch (e) {
        console.warn('[nongnghiepnhietdoi] invalid data-props on', name, e);
      }
    }
    createApp(Component, props).mount(el);
  });
}

function boot() {
  document.querySelectorAll('video.hero-video').forEach((video) => {
    const drop = () => video.remove();
    video.addEventListener('error', drop);
    video.querySelectorAll('source').forEach((source) => source.addEventListener('error', drop));
  });
  initHeader();
  const lenis = initSmoothScroll();
  initScrollIndicator(lenis);
  initFloatingButtons();
  initBackToTop(lenis);
  initContactForms();
  initLightbox();
  initReveal();
  initCountUp();
  initParallax();
  mountIslands();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', boot);
} else {
  boot();
}
