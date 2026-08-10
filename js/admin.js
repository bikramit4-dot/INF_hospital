/* ============================================================
   HOME HOSPITAL — ADMIN PANEL INTERACTIONS
   (external file so it complies with the site Content-Security-Policy)
   ============================================================ */
(function () {
  'use strict';

  // ---- Confirmation dialogs for action forms ----
  document.querySelectorAll('form.js-confirm').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      var msg = form.getAttribute('data-confirm') || 'Are you sure?';
      if (!window.confirm(msg)) e.preventDefault();
    });
  });

  // ---- Confirmation for per-field "Reset to default" buttons ----
  document.querySelectorAll('button.js-reset-confirm').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      var msg = btn.getAttribute('data-confirm') || 'Reset this field to its default value?';
      if (!window.confirm(msg)) e.preventDefault();
    });
  });

  // ---- Auto-dismiss success/error alerts after a few seconds ----
  document.querySelectorAll('.alert-dismissible').forEach(function (el) {
    setTimeout(function () {
      el.style.transition = 'opacity .4s ease, transform .4s ease';
      el.style.opacity = '0';
      el.style.transform = 'translateY(-6px)';
      setTimeout(function () {
        if (el.parentNode) el.parentNode.removeChild(el);
      }, 420);
    }, 5200);
  });
})();
