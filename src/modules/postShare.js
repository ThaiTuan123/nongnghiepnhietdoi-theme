/**
 * Post share: copy link + native share when available.
 */

export function initPostShare() {
  const root = document.querySelector('[data-lx-share]');
  if (!root) return;

  root.querySelectorAll('[data-lx-copy]').forEach((btn) => {
    btn.addEventListener('click', async () => {
      const url = btn.getAttribute('data-lx-copy') || window.location.href;
      try {
        await navigator.clipboard.writeText(url);
        btn.classList.add('is-copied');
        window.setTimeout(() => btn.classList.remove('is-copied'), 1800);
      } catch {
        const input = document.createElement('input');
        input.value = url;
        input.setAttribute('readonly', '');
        input.style.position = 'absolute';
        input.style.left = '-9999px';
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        btn.classList.add('is-copied');
        window.setTimeout(() => btn.classList.remove('is-copied'), 1800);
      }
    });
  });

  const nativeBtn = root.querySelector('[data-lx-native-share]');
  if (nativeBtn && typeof navigator.share === 'function') {
    nativeBtn.hidden = false;
    nativeBtn.addEventListener('click', async () => {
      try {
        await navigator.share({
          title: nativeBtn.getAttribute('data-title') || document.title,
          url: nativeBtn.getAttribute('data-url') || window.location.href,
        });
      } catch {
        // User cancelled or share failed — ignore.
      }
    });
  }
}
