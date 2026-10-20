/**
 * Gallery lightbox — fullscreen viewer with prev/next (Flatsome-style).
 *
 * Markup: any [data-lightbox-gallery] containing buttons/links with
 *   data-lightbox-src (full image URL)
 *   data-lightbox-alt (optional)
 */
export function initLightbox() {
  const galleries = document.querySelectorAll('[data-lightbox-gallery]');
  if (!galleries.length) return;

  const ui = createLightboxUI();
  document.body.appendChild(ui.root);

  let items = [];
  let index = 0;
  let open = false;

  const show = (i) => {
    if (!items.length) return;
    index = ((i % items.length) + items.length) % items.length;
    const item = items[index];
    ui.img.src = item.src;
    ui.img.alt = item.alt || '';
    ui.counter.textContent = `${index + 1} / ${items.length}`;
    ui.prev.hidden = items.length < 2;
    ui.next.hidden = items.length < 2;
  };

  const openAt = (list, i) => {
    items = list;
    open = true;
    ui.root.classList.add('is-open');
    ui.root.setAttribute('aria-hidden', 'false');
    document.body.classList.add('lx-lightbox-open');
    show(i);
    ui.close.focus({ preventScroll: true });
  };

  const close = () => {
    if (!open) return;
    open = false;
    ui.root.classList.remove('is-open');
    ui.root.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('lx-lightbox-open');
    ui.img.removeAttribute('src');
    ui.img.alt = '';
  };

  galleries.forEach((gallery) => {
    gallery.addEventListener('click', (e) => {
      const trigger = e.target.closest('[data-lightbox-src]');
      if (!trigger || !gallery.contains(trigger)) return;
      e.preventDefault();

      const triggers = [...gallery.querySelectorAll('[data-lightbox-src]')];
      const list = triggers.map((el) => ({
        src: el.getAttribute('data-lightbox-src'),
        alt: el.getAttribute('data-lightbox-alt') || '',
      }));
      const i = triggers.indexOf(trigger);
      if (i < 0 || !list[i]?.src) return;
      openAt(list, i);
    });
  });

  ui.close.addEventListener('click', close);
  ui.backdrop.addEventListener('click', close);
  ui.prev.addEventListener('click', () => show(index - 1));
  ui.next.addEventListener('click', () => show(index + 1));

  document.addEventListener('keydown', (e) => {
    if (!open) return;
    if (e.key === 'Escape') close();
    if (e.key === 'ArrowLeft') show(index - 1);
    if (e.key === 'ArrowRight') show(index + 1);
  });
}

function createLightboxUI() {
  const root = document.createElement('div');
  root.className = 'lx-lightbox';
  root.setAttribute('role', 'dialog');
  root.setAttribute('aria-modal', 'true');
  root.setAttribute('aria-label', 'Xem ảnh');
  root.setAttribute('aria-hidden', 'true');

  root.innerHTML = `
    <div class="lx-lightbox__backdrop" data-lightbox-backdrop></div>
    <button type="button" class="lx-lightbox__close" aria-label="Đóng">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
        <path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/>
      </svg>
    </button>
    <div class="lx-lightbox__stage">
      <img class="lx-lightbox__img" alt="">
    </div>
    <div class="lx-lightbox__bar">
      <button type="button" class="lx-lightbox__nav lx-lightbox__nav--prev" aria-label="Ảnh trước">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 6l-6 6 6 6"/>
        </svg>
      </button>
      <span class="lx-lightbox__counter" aria-live="polite"></span>
      <button type="button" class="lx-lightbox__nav lx-lightbox__nav--next" aria-label="Ảnh sau">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6"/>
        </svg>
      </button>
    </div>
  `;

  return {
    root,
    backdrop: root.querySelector('[data-lightbox-backdrop]'),
    close: root.querySelector('.lx-lightbox__close'),
    img: root.querySelector('.lx-lightbox__img'),
    prev: root.querySelector('.lx-lightbox__nav--prev'),
    next: root.querySelector('.lx-lightbox__nav--next'),
    counter: root.querySelector('.lx-lightbox__counter'),
  };
}
