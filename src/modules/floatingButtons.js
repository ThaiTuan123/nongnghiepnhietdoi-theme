/**
 * Floating contact buttons: chỉ hiển thị sau khi cuộn qua hết Hero section.
 */
export function initFloatingButtons() {
  const float = document.querySelector('.lx-float');
  if (!float) return;

  const hero = document.querySelector('[data-section="hero"]');

  const threshold = () => {
    if (!hero) return 0;
    // Hiện khi đã cuộn gần hết chiều cao hero.
    return hero.offsetTop + hero.offsetHeight - 120;
  };

  const onScroll = () => {
    const passed = !hero || window.scrollY >= threshold();
    float.classList.toggle('is-visible', passed);
  };

  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll, { passive: true });
}
