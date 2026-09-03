(function () {
  var i18n = window.CutiI18n;

  function applyLang(lang) {
    i18n.save(lang);
    i18n.apply(lang);
    document.querySelectorAll('[data-manual-lang]').forEach(function (article) {
      article.hidden = article.getAttribute('data-manual-lang') !== lang;
    });
    document.querySelectorAll('.lang-btn').forEach(function (btn) {
      var active = btn.getAttribute('data-lang') === lang;
      btn.setAttribute('aria-pressed', active ? 'true' : 'false');
      btn.classList.toggle('is-active', active);
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    applyLang(i18n.detect());
    document.querySelectorAll('.lang-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        applyLang(btn.getAttribute('data-lang'));
      });
    });
  });
})();
