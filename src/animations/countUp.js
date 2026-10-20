/**
 * Count-up for [data-count]. Optional data-count-suffix and data-count-group (vi-VN grouping).
 */
export function initCountUp() {
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  document.querySelectorAll('[data-count]').forEach((el) => {
    const target = Number(el.getAttribute('data-count')) || 0;
    const suffix = el.getAttribute('data-count-suffix') || '';
    const grouped = el.hasAttribute('data-count-group');
    const format = (n) =>
      (grouped ? new Intl.NumberFormat('vi-VN').format(n) : String(n)) + suffix;

    if (reduce) {
      el.textContent = format(target);
      return;
    }

    const observer = new IntersectionObserver(
      (entries) => {
        if (!entries[0].isIntersecting) return;
        observer.disconnect();
        const duration = 1200;
        const start = performance.now();
        const step = (now) => {
          const p = Math.min((now - start) / duration, 1);
          const eased = 1 - (1 - p) ** 3;
          el.textContent = format(Math.round(target * eased));
          if (p < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
      },
      { threshold: 0.45 },
    );
    observer.observe(el);
  });
}
