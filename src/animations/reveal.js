import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { prefersReducedMotion } from './smoothScroll.js';

gsap.registerPlugin(ScrollTrigger);

const DESKTOP_MQ = '(min-width: 768px)';

/**
 * Reveal single elements ([data-reveal]) and staggered groups ([data-reveal-stagger]).
 * Optional variants: data-reveal="left|right|up|image", data-reveal-line, data-reveal-delay.
 * Desktop: full directional / image motion. Mobile: short opacity fade only.
 */
export function initReveal() {
  if (prefersReducedMotion()) return;

  ScrollTrigger.matchMedia({
    [DESKTOP_MQ]: () => {
      initSingleReveals({ rich: true });
      initStaggerReveals({ rich: true });
      initLineReveals();
    },
    '(max-width: 767px)': () => {
      initSingleReveals({ rich: false });
      initStaggerReveals({ rich: false });
      document.querySelectorAll('[data-reveal-line]').forEach((el) => {
        el.classList.add('is-revealed');
        gsap.set(el, { clearProps: 'transform,opacity' });
      });
    },
  });

  // Lenis / late layout can shift trigger positions — refresh after paint.
  requestAnimationFrame(() => ScrollTrigger.refresh());
}

function markRevealed(el) {
  el.classList.add('is-revealed');
  const frame = el.querySelector('[data-reveal-frame]');
  if (frame) frame.classList.add('is-revealed');
}

function initSingleReveals({ rich }) {
  gsap.utils.toArray('[data-reveal]').forEach((el) => {
    if (el.closest('[data-reveal-stagger]')) return;

    const variant = (el.getAttribute('data-reveal') || 'up').trim() || 'up';
    const delay = parseFloat(el.getAttribute('data-reveal-delay')) || 0;

    if (variant === 'image') {
      animateImageReveal(el, delay, rich);
      return;
    }

    const from = rich ? getRichFrom(variant) : { opacity: 0, y: 12 };
    const duration = rich ? 1 : 0.45;

    gsap.fromTo(
      el,
      from,
      {
        opacity: 1,
        x: 0,
        y: 0,
        scale: 1,
        duration,
        delay,
        ease: 'power3.out',
        scrollTrigger: { trigger: el, start: 'top 85%', once: true },
        onComplete: () => {
          markRevealed(el);
          el.style.removeProperty('will-change');
        },
      },
    );
  });
}

function initStaggerReveals({ rich }) {
  gsap.utils.toArray('[data-reveal-stagger]').forEach((group) => {
    const children = group.querySelectorAll(':scope > *, :scope [data-reveal]');
    gsap.fromTo(
      children,
      rich ? { opacity: 0, y: 28 } : { opacity: 0, y: 10 },
      {
        opacity: 1,
        y: 0,
        duration: rich ? 0.8 : 0.4,
        ease: 'power3.out',
        stagger: rich ? 0.12 : 0.06,
        scrollTrigger: { trigger: group, start: 'top 80%', once: true },
        onComplete: () => {
          children.forEach((child) => {
            child.classList.add('is-revealed');
            child.style.removeProperty('will-change');
          });
        },
      },
    );
  });
}

function initLineReveals() {
  gsap.utils.toArray('[data-reveal-line]').forEach((el) => {
    const delay = parseFloat(el.getAttribute('data-reveal-delay')) || 0.15;
    gsap.fromTo(
      el,
      { scaleX: 0, opacity: 1 },
      {
        scaleX: 1,
        duration: 0.8,
        delay,
        ease: 'power3.out',
        transformOrigin: 'center center',
        scrollTrigger: { trigger: el, start: 'top 90%', once: true },
        onComplete: () => {
          el.classList.add('is-revealed');
          el.style.removeProperty('will-change');
        },
      },
    );
  });
}

function getRichFrom(variant) {
  switch (variant) {
    case 'left':
      return { opacity: 0, x: -48, y: 0 };
    case 'right':
      return { opacity: 0, x: 48, y: 0 };
    default:
      return { opacity: 0, y: 28 };
  }
}

/**
 * Image reveal: fade + rise on the frame; soft scale on <img>/<video> when present.
 * Never clearProps opacity on the frame — that was restoring CSS opacity:0.
 */
function animateImageReveal(el, delay, rich) {
  const frame = el.querySelector('[data-reveal-frame]') || el;
  const media = frame.querySelector('img, video');

  const from = rich ? { opacity: 0, y: 36 } : { opacity: 0, y: 12 };
  const duration = rich ? 1 : 0.45;

  gsap.fromTo(
    frame,
    from,
    {
      opacity: 1,
      y: 0,
      duration,
      delay,
      ease: 'power3.out',
      scrollTrigger: { trigger: el, start: 'top 85%', once: true },
      onComplete: () => {
        markRevealed(el);
        // Intentionally keep inline opacity/transform — do not clearProps.
        frame.style.removeProperty('will-change');
        el.style.removeProperty('will-change');
      },
    },
  );

  if (rich && media) {
    gsap.fromTo(
      media,
      { scale: 1.08 },
      {
        scale: 1,
        duration: 1.25,
        delay,
        ease: 'power2.out',
        scrollTrigger: { trigger: el, start: 'top 85%', once: true },
        onComplete: () => {
          markRevealed(el);
          // Safe after is-revealed: resting transform is CSS none, hover can take over.
          gsap.set(media, { clearProps: 'transform' });
          media.style.removeProperty('will-change');
        },
      },
    );
  }
}
