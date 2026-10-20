/**
 * Nút về đầu trang: hiện sau khi cuộn, bấm thì trượt lên trên.
 */
export function initBackToTop(lenis) {
  const btn = document.querySelector('[data-back-to-top]');
  if (!btn) return;

  const showAfter = 480;

  const onScroll = () => {
    const y = lenis ? lenis.scroll : window.scrollY;
    const visible = y > showAfter;
    btn.classList.toggle('is-visible', visible);
    btn.tabIndex = visible ? 0 : -1;
    btn.setAttribute('aria-hidden', visible ? 'false' : 'true');
  };

  btn.addEventListener('click', () => {
    if (lenis) {
      lenis.scrollTo(0);
      return;
    }
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  onScroll();
  if (lenis) {
    lenis.on('scroll', onScroll);
  } else {
    window.addEventListener('scroll', onScroll, { passive: true });
  }
  window.addEventListener('resize', onScroll, { passive: true });
}
