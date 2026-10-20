import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { prefersReducedMotion } from './smoothScroll.js';

gsap.registerPlugin(ScrollTrigger);

/**
 * Parallax on [data-parallax="<factor>"]. Factor 0.2 = subtle, 0.5 = strong.
 */
export function initParallax() {
  if (prefersReducedMotion()) return;

  gsap.utils.toArray('[data-parallax]').forEach((el) => {
    const factor = parseFloat(el.getAttribute('data-parallax')) || 0.2;
    gsap.fromTo(
      el,
      { yPercent: -factor * 100 },
      {
        yPercent: factor * 100,
        ease: 'none',
        scrollTrigger: {
          trigger: el.parentElement || el,
          start: 'top bottom',
          end: 'bottom top',
          scrub: true,
        },
      },
    );
  });
}
