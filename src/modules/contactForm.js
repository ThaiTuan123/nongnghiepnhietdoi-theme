/**
 * AJAX form submit + toast (không reload trang).
 */

function ensureToastHost() {
  let host = document.getElementById('lx-toast-host');
  if (host) return host;

  host = document.createElement('div');
  host.id = 'lx-toast-host';
  host.className = 'lx-toast-host';
  host.setAttribute('aria-live', 'polite');
  host.setAttribute('aria-relevant', 'additions');
  document.body.appendChild(host);
  return host;
}

/**
 * @param {string} message
 * @param {'success'|'error'} type
 * @param {string} [title]
 */
export function showToast(message, type = 'success', title = '') {
  const host = ensureToastHost();
  const el = document.createElement('div');
  el.className = `lx-toast lx-toast--${type}`;
  el.setAttribute('role', 'status');

  const titleText =
    title || (type === 'success' ? 'Gửi thành công' : 'Gửi không thành công');

  el.innerHTML = `
    <p class="lx-toast__title">${titleText}</p>
    <p class="lx-toast__msg"></p>
  `;
  el.querySelector('.lx-toast__msg').textContent = message;

  host.appendChild(el);
  requestAnimationFrame(() => el.classList.add('is-visible'));

  window.setTimeout(() => {
    el.classList.remove('is-visible');
    window.setTimeout(() => el.remove(), 320);
  }, 4200);
}

function setSubmitting(form, on) {
  const btn = form.querySelector('[type="submit"], [data-lx-submit]');
  if (!btn) return;

  btn.disabled = !!on;
  btn.classList.toggle('opacity-80', on);
  btn.classList.toggle('pointer-events-none', on);

  const label = btn.querySelector('.lx-submit-label');
  const loading = btn.querySelector('.lx-submit-loading');
  if (label) label.classList.toggle('hidden', on);
  if (loading) loading.classList.toggle('hidden', !on);
}

function resetFormFields(form) {
  form.reset();
  form.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach((el) => {
    el.checked = false;
  });
}

async function submitForm(form) {
  const cfg = window.nongnghiepnhietdoiContact;
  if (!cfg?.ajaxUrl) {
    showToast('Cấu hình form chưa sẵn sàng. Vui lòng tải lại trang.', 'error');
    return;
  }

  setSubmitting(form, true);

  const body = new FormData(form);
  body.set('action', 'nongnghiepnhietdoi_contact');
  body.set('nongnghiepnhietdoi_contact_submit', '1');
  if (cfg.nonce && !body.get('nongnghiepnhietdoi_contact_nonce')) {
    body.set('nongnghiepnhietdoi_contact_nonce', cfg.nonce);
  }

  try {
    const res = await fetch(cfg.ajaxUrl, {
      method: 'POST',
      body,
      credentials: 'same-origin',
    });

    const data = await res.json().catch(() => null);
    const ok = !!(data && data.success);
    const payload = data?.data || {};
    const message =
      payload.message ||
      (ok
        ? 'Cảm ơn bạn! Chúng tôi đã nhận được thông tin.'
        : 'Gửi không thành công. Vui lòng thử lại.');
    const title = payload.title || '';

    showToast(message, ok ? 'success' : 'error', title);
    if (ok) resetFormFields(form);
  } catch (e) {
    showToast('Không kết nối được máy chủ. Vui lòng thử lại.', 'error');
  } finally {
    setSubmitting(form, false);
  }
}

/**
 * Gắn AJAX cho form tư vấn + form liên hệ.
 */
export function initContactForms() {
  const forms = document.querySelectorAll('.lx-consult-form, .lx-contact-form form');
  forms.forEach((form) => {
    if (form.dataset.lxAjaxBound === '1') return;
    form.dataset.lxAjaxBound = '1';

    form.addEventListener('submit', (e) => {
      e.preventDefault();
      if (form.dataset.lxSubmitting === '1') return;
      form.dataset.lxSubmitting = '1';
      submitForm(form).finally(() => {
        form.dataset.lxSubmitting = '0';
      });
    });
  });
}
