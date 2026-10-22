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

  const file = form.querySelector('input[type="file"]');
  if (file?.files?.[0]) {
    const picked = file.files[0];
    const allowed = ['pdf', 'doc', 'docx', 'zip'];
    const ext = picked.name.split('.').pop()?.toLowerCase() || '';
    if (!allowed.includes(ext)) {
      showToast('Chỉ nhận tệp PDF, DOC, DOCX hoặc ZIP.', 'error');
      return;
    }
    if (picked.size > 20 * 1024 * 1024) {
      showToast('Tệp đính kèm vượt quá 20MB.', 'error');
      return;
    }
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
  // Bỏ qua form Contact Form 7 — CF7 tự xử lý AJAX.
  const forms = document.querySelectorAll(
    '.lx-consult-form:not(.wpcf7-form), .ht-proposal-form:not(.wpcf7-form), .lh-contact-form:not(.wpcf7-form)',
  );
  forms.forEach((form) => {
    if (form.classList.contains('wpcf7-form') || form.closest('.wpcf7')) return;
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

  const htForm =
    document.querySelector('.ht-cf7 .wpcf7-form') ||
    document.querySelector('.ht-proposal-form');
  const subject =
    htForm?.querySelector('select[name="your-subject"]') ||
    document.querySelector('[data-ht-subject]');
  const audienceInput =
    htForm?.querySelector('input[name="your-audience"]') ||
    document.querySelector('[data-ht-audience-input]');
  /** Map key subject → nhãn option CF7 (trùng định nghĩa form). */
  const subjectLabels = {
    capability: 'Yêu cầu Hồ sơ năng lực',
    cfp: 'Gửi Call for Proposal',
    ngo: 'Đề xuất hợp tác — Nhà tài trợ / NGO',
    business: 'Đề xuất hợp tác — Doanh nghiệp / HTX',
    expert: 'Đề xuất hợp tác — Chuyên gia / Nhà khoa học',
  };
  const portal = document.querySelectorAll('[data-ht-audience]');
  portal.forEach((card) => {
    card.addEventListener('click', () => {
      const key = card.getAttribute('data-ht-audience') || '';
      const subjectKey = card.getAttribute('data-ht-subject-value') || '';
      portal.forEach((item) => {
        const on = item === card;
        item.classList.toggle('is-active', on);
        item.setAttribute('aria-pressed', on ? 'true' : 'false');
      });
      if (subject && subjectKey) {
        subject.value = subjectLabels[subjectKey] || subjectKey;
      }
      if (audienceInput) audienceInput.value = key;
      document.getElementById('gui-thong-tin')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });
}
