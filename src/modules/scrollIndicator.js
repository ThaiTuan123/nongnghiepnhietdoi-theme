/**
 * Scroll indicator: click the hero arrow to smoothly scroll to the next section.
 *
 * @param {import('lenis').default|null} lenis Optional Lenis instance for smooth scroll.
 */
export function initScrollIndicator(lenis) {
  const button = document.querySelector('[data-scroll-indicator]');
  if (!button) return;

  const getHeaderOffset = () => {
    const header = document.querySelector('[data-header]');
    return header ? header.offsetHeight : 0;
  };

  const getTarget = () => {
    const section = button.closest('section');
    let next = section ? section.nextElementSibling : null;
    while (next && next.tagName !== 'SECTION') {
      next = next.nextElementSibling;
    }
    return next;
  };

  button.addEventListener('click', () => {
    const target = getTarget();
    if (!target) return;

    const offset = -getHeaderOffset();

    if (lenis && typeof lenis.scrollTo === 'function') {
      lenis.scrollTo(target, { offset });
      return;
    }

    const top = target.getBoundingClientRect().top + window.scrollY + offset;
    window.scrollTo({
      top,
      behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth',
    });
  });
}
