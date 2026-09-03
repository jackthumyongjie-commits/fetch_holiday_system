(function () {
  var i18n = window.CutiI18n;
  var searchTimer = null;
  var lastFocus = null;
  var state = {
    lang: 'en',
    year: String(new Date().getFullYear()),
    month: 'all',
    type: 'all',
    keyword: '',
    holidays: [],
    stats: { total: 0, federal: 0, state: 0, next: null },
    years: [2024, 2025, 2026]
  };

  function $(id) {
    return document.getElementById(id);
  }

  function init() {
    state.lang = i18n.detect();
    if (state.years.indexOf(parseInt(state.year, 10)) === -1) {
      state.year = '2026';
    }

    bindFilters();
    bindLanguage();
    bindModal();
    i18n.apply(state.lang);
    syncLanguageButtons();
    fillYearOptions();
    fillMonthOptions();
    $('yearFilter').value = state.year;
    loadHolidays();
  }

  function bindFilters() {
    $('yearFilter').addEventListener('change', function (e) {
      state.year = e.target.value;
      loadHolidays();
    });
    $('monthFilter').addEventListener('change', function (e) {
      state.month = e.target.value;
      loadHolidays();
    });
    $('typeFilter').addEventListener('change', function (e) {
      state.type = e.target.value;
      loadHolidays();
    });
    $('keywordFilter').addEventListener('input', function (e) {
      state.keyword = e.target.value;
      clearTimeout(searchTimer);
      searchTimer = setTimeout(loadHolidays, 300);
    });
  }

  function refreshStatusText() {
    var status = $('status');
    if (status.hidden) return;
    if (status.classList.contains('is-error')) {
      status.textContent = i18n.t(state.lang, 'error');
    } else if (status.classList.contains('is-empty')) {
      status.textContent = i18n.t(state.lang, 'empty');
    } else if (status.classList.contains('is-loading')) {
      status.textContent = i18n.t(state.lang, 'loading');
    }
  }

  function bindLanguage() {
    document.querySelectorAll('.lang-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        state.lang = btn.getAttribute('data-lang');
        i18n.save(state.lang);
        i18n.apply(state.lang);
        syncLanguageButtons();
        fillYearOptions();
        fillMonthOptions();
        refreshStatusText();
        renderAll();
      });
    });
  }

  function syncLanguageButtons() {
    document.querySelectorAll('.lang-btn').forEach(function (btn) {
      var active = btn.getAttribute('data-lang') === state.lang;
      btn.setAttribute('aria-pressed', active ? 'true' : 'false');
      btn.classList.toggle('is-active', active);
    });
  }

  function fillYearOptions() {
    var select = $('yearFilter');
    var current = state.year;
    select.innerHTML = '';
    addOption(select, 'all', i18n.t(state.lang, 'allYears'));
    state.years.forEach(function (year) {
      addOption(select, String(year), String(year));
    });
    select.value = current;
  }

  function fillMonthOptions() {
    var select = $('monthFilter');
    var current = state.month;
    var months = i18n.t(state.lang, 'months');
    select.innerHTML = '';
    addOption(select, 'all', i18n.t(state.lang, 'allMonths'));
    months.forEach(function (name, index) {
      addOption(select, String(index + 1), name);
    });
    select.value = current;
  }

  function addOption(select, value, label) {
    var option = document.createElement('option');
    option.value = value;
    option.textContent = label;
    select.appendChild(option);
  }

  function loadHolidays() {
    var calendar = $('calendar');
    var status = $('status');
    calendar.setAttribute('aria-busy', 'true');
    status.hidden = false;
    status.className = 'status is-loading';
    status.textContent = i18n.t(state.lang, 'loading');

    var params = new URLSearchParams({
      year: state.year,
      month: state.month,
      type: state.type,
      keyword: state.keyword
    });

    fetch('api/holidays.php?' + params.toString())
      .then(function (res) {
        return res.json().then(function (data) {
          return { ok: res.ok, data: data };
        });
      })
      .then(function (result) {
        if (!result.data || !result.data.success) {
          throw new Error((result.data && result.data.error) || i18n.t(state.lang, 'error'));
        }
        state.holidays = result.data.holidays || [];
        state.stats = result.data.stats || state.stats;
        if (Array.isArray(result.data.years) && result.data.years.length) {
          state.years = result.data.years;
          fillYearOptions();
        }
        status.hidden = state.holidays.length > 0;
        if (state.holidays.length === 0) {
          var totalAll = typeof result.data.total_all === 'number' ? result.data.total_all : 0;
          status.className = 'status is-empty';
          if (totalAll === 0) {
            status.innerHTML = '';
            status.appendChild(document.createTextNode(i18n.t(state.lang, 'needInstall') + ' '));
            var link = document.createElement('a');
            link.href = 'install.php';
            link.textContent = 'install.php';
            status.appendChild(link);
          } else {
            status.textContent = i18n.t(state.lang, 'empty');
          }
        }
        renderAll();
      })
      .catch(function () {
        state.holidays = [];
        state.stats = { total: 0, federal: 0, state: 0, next: null };
        status.hidden = false;
        status.className = 'status is-error';
        status.textContent = i18n.t(state.lang, 'error');
        renderStats();
        calendar.innerHTML = '';
      })
      .finally(function () {
        calendar.setAttribute('aria-busy', 'false');
      });
  }

  function renderAll() {
    renderStats();
    renderCalendar();
  }

  function renderStats() {
    $('statTotal').textContent = String(state.stats.total);
    $('statFederal').textContent = String(state.stats.federal);
    $('statState').textContent = String(state.stats.state);

    var nextValue = $('statNext');
    var nextMeta = $('statNextMeta');
    if (state.stats.next) {
      nextValue.textContent = i18n.holidayName(state.stats.next, state.lang);
      nextMeta.textContent = i18n.formatDate(state.stats.next.date, state.lang);
    } else {
      nextValue.textContent = '—';
      nextMeta.textContent = i18n.t(state.lang, 'nextNone');
    }
  }

  function holidaysByDate() {
    var map = {};
    state.holidays.forEach(function (holiday) {
      if (!map[holiday.date]) map[holiday.date] = [];
      map[holiday.date].push(holiday);
    });
    return map;
  }

  function monthsToRender() {
    var years = state.year === 'all' ? state.years.slice() : [parseInt(state.year, 10)];
    var months = state.month === 'all' ? [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12] : [parseInt(state.month, 10)];
    var list = [];
    years.forEach(function (year) {
      months.forEach(function (month) {
        list.push({ year: year, month: month });
      });
    });
    return list;
  }

  function renderCalendar() {
    var calendar = $('calendar');
    calendar.innerHTML = '';
    if (!state.holidays.length) return;

    var grouped = holidaysByDate();
    var today = toDateKey(new Date());
    var monthNames = i18n.t(state.lang, 'months');
    var weekdayShort = i18n.t(state.lang, 'weekdaysShort');

    monthsToRender().forEach(function (item, index) {
      var article = document.createElement('article');
      article.className = 'month-block';
      article.style.animationDelay = (index % 12) * 40 + 'ms';

      var heading = document.createElement('h3');
      heading.textContent = monthNames[item.month - 1] + ' ' + item.year;
      article.appendChild(heading);

      var grid = document.createElement('div');
      grid.className = 'month-grid';
      grid.setAttribute('role', 'grid');
      grid.setAttribute('aria-label', heading.textContent);

      weekdayShort.forEach(function (label) {
        var cell = document.createElement('div');
        cell.className = 'dow';
        cell.textContent = label;
        cell.setAttribute('aria-hidden', 'true');
        grid.appendChild(cell);
      });

      var first = new Date(item.year, item.month - 1, 1);
      var startPad = first.getDay();
      var daysInMonth = new Date(item.year, item.month, 0).getDate();
      var i;

      for (i = 0; i < startPad; i++) {
        var empty = document.createElement('div');
        empty.className = 'day is-empty';
        empty.setAttribute('aria-hidden', 'true');
        grid.appendChild(empty);
      }

      for (i = 1; i <= daysInMonth; i++) {
        var dateKey = item.year + '-' + pad(item.month) + '-' + pad(i);
        var dayHolidays = grouped[dateKey] || [];
        var isToday = dateKey === today;
        var node;

        if (dayHolidays.length) {
          node = document.createElement('button');
          node.type = 'button';
          node.className = 'day is-holiday is-' + dayHolidays[0].display_type;
          node.setAttribute('data-date', dateKey);
          var names = dayHolidays.map(function (h) {
            return i18n.holidayName(h, state.lang);
          });
          node.setAttribute('aria-label', names.join(', ') + ', ' + i18n.formatDate(dateKey, state.lang));
          node.addEventListener('click', function (date) {
            return function () { openModal(date); };
          }(dateKey));

          var num = document.createElement('span');
          num.className = 'day-num';
          num.textContent = String(i);
          node.appendChild(num);

          var label = document.createElement('span');
          label.className = 'day-name';
          label.textContent = names[0];
          node.appendChild(label);

          if (names.length > 1) {
            var extra = document.createElement('span');
            extra.className = 'day-more';
            extra.textContent = i18n.t(state.lang, 'moreCount').replace('{n}', String(names.length - 1));
            node.appendChild(extra);
          }
        } else {
          node = document.createElement('div');
          node.className = 'day';
          node.innerHTML = '<span class="day-num">' + i + '</span>';
        }

        if (isToday) {
          node.classList.add('is-today');
          node.title = i18n.t(state.lang, 'today');
        }
        grid.appendChild(node);
      }

      article.appendChild(grid);
      calendar.appendChild(article);
    });
  }

  function openModal(dateKey) {
    var holidays = state.holidays.filter(function (item) {
      return item.date === dateKey;
    });
    if (!holidays.length) return;

    lastFocus = document.activeElement;
    var dialog = $('holidayModal');
    var body = $('modalBody');
    body.innerHTML = '';

    holidays.forEach(function (holiday) {
      var block = document.createElement('article');
      block.className = 'modal-holiday is-' + holiday.display_type;

      var title = document.createElement('h3');
      title.textContent = i18n.holidayName(holiday, state.lang);
      block.appendChild(title);

      block.appendChild(metaRow(i18n.t(state.lang, 'modalDate'), i18n.formatDate(holiday.date, state.lang)));
      block.appendChild(metaRow(i18n.t(state.lang, 'modalWeekday'), i18n.t(state.lang, 'weekdays')[holiday.weekday]));
      block.appendChild(metaRow(i18n.t(state.lang, 'modalType'), i18n.typeLabel(state.lang, holiday.display_type)));
      block.appendChild(metaRow(i18n.t(state.lang, 'modalStates'), i18n.translateStates(holiday.states, state.lang)));

      var desc = document.createElement('p');
      desc.className = 'modal-desc';
      desc.textContent = i18n.holidayDesc(holiday, state.lang);
      block.appendChild(desc);

      body.appendChild(block);
    });

    dialog.hidden = false;
    document.body.classList.add('modal-open');
    $('modalClose').focus();
  }

  function metaRow(label, value) {
    var p = document.createElement('p');
    p.className = 'modal-meta';
    var dt = document.createElement('span');
    dt.textContent = label;
    var dd = document.createElement('strong');
    dd.textContent = value;
    p.appendChild(dt);
    p.appendChild(dd);
    return p;
  }

  function closeModal() {
    var dialog = $('holidayModal');
    if (dialog.hidden) return;
    dialog.hidden = true;
    document.body.classList.remove('modal-open');
    if (lastFocus && typeof lastFocus.focus === 'function') {
      lastFocus.focus();
    }
  }

  function bindModal() {
    $('modalClose').addEventListener('click', closeModal);
    $('holidayModal').addEventListener('click', function (e) {
      if (e.target === $('holidayModal')) closeModal();
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') closeModal();
      if ($('holidayModal').hidden) return;
      if (e.key !== 'Tab') return;
      var focusable = $('holidayModal').querySelectorAll('button, [href], input, select, textarea');
      if (!focusable.length) return;
      var first = focusable[0];
      var last = focusable[focusable.length - 1];
      if (e.shiftKey && document.activeElement === first) {
        e.preventDefault();
        last.focus();
      } else if (!e.shiftKey && document.activeElement === last) {
        e.preventDefault();
        first.focus();
      }
    });
  }

  function pad(n) {
    return n < 10 ? '0' + n : String(n);
  }

  function toDateKey(date) {
    return date.getFullYear() + '-' + pad(date.getMonth() + 1) + '-' + pad(date.getDate());
  }

  document.addEventListener('DOMContentLoaded', init);
})();
