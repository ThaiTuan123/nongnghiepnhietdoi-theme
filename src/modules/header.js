/**
 * Header behaviour: scrolled state + mobile menu toggle + submenu accordion.
 */
export function initHeader() {
  const header = document.querySelector('[data-header]');
  const toggle = document.querySelector('[data-menu-toggle]');
  const menu = document.querySelector('[data-mobile-menu]');

  if (header) {
    // Appearance (transparent vs solid) is driven by the `has-dark-hero` body
    // class in CSS; here we only flip `is-scrolled` once the user scrolls.
    const onScroll = () => {
      header.classList.toggle('is-scrolled', window.scrollY > 40);
    };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  if (toggle && menu) {
    const close = () => {
      toggle.setAttribute('aria-expanded', 'false');
      menu.hidden = true;
      header?.classList.remove('menu-open');
      // Đóng mọi accordion submenu khi đóng panel.
      menu.querySelectorAll('.menu-item-has-children.is-open').forEach((li) => {
        li.classList.remove('is-open');
        li.querySelector(':scope > a')?.setAttribute('aria-expanded', 'false');
      });
    };
    const open = () => {
      toggle.setAttribute('aria-expanded', 'true');
      menu.hidden = false;
      header?.classList.add('is-scrolled', 'menu-open');
    };

    toggle.addEventListener('click', () => {
      const expanded = toggle.getAttribute('aria-expanded') === 'true';
      expanded ? close() : open();
    });

    // Accordion: menu con ẩn mặc định, bấm mục cha mới sổ ra.
    menu.querySelectorAll('.menu-item-has-children').forEach((li) => {
      const link = li.querySelector(':scope > a');
      const sub = li.querySelector(':scope > .sub-menu');
      if (!link || !sub) return;

      link.setAttribute('aria-expanded', 'false');
      link.setAttribute('aria-haspopup', 'true');

      link.addEventListener('click', (e) => {
        const isOpen = li.classList.contains('is-open');

        // Đóng các accordion khác.
        menu.querySelectorAll('.menu-item-has-children.is-open').forEach((other) => {
          if (other === li) return;
          other.classList.remove('is-open');
          other.querySelector(':scope > a')?.setAttribute('aria-expanded', 'false');
        });

        if (!isOpen) {
          // Lần bấm đầu: chỉ sổ menu con, không điều hướng.
          e.preventDefault();
          li.classList.add('is-open');
          link.setAttribute('aria-expanded', 'true');
          return;
        }

        // Đã mở rồi: cho phép vào trang cha, đóng panel.
        close();
      });
    });

    // Link lá (không có menu con): bấm là đóng panel.
    menu.querySelectorAll('.menu-item:not(.menu-item-has-children) > a').forEach((a) => {
      a.addEventListener('click', close);
    });

    // Close on desktop breakpoint resize.
    window.matchMedia('(min-width: 1024px)').addEventListener('change', (e) => {
      if (e.matches) close();
    });
  }
}
