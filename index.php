<?php
require_once __DIR__ . '/includes/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Cuti MY – Malaysian Public Holiday Viewer for federal, state, birthday and observance dates.">
    <title>Cuti MY – Malaysian Public Holiday Viewer</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&family=Unbounded:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body data-title-key="heroTag">
    <a class="skip-link" href="#calendar-section" data-i18n="skip">Skip to calendar</a>

    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="index.php">
                <span class="brand-mark" aria-hidden="true"></span>
                <span class="brand-text" data-i18n="brand">Cuti MY</span>
            </a>
            <nav class="site-nav" aria-label="Main">
                <a href="index.php" aria-current="page" data-i18n="navHome">Holidays</a>
                <a href="manual.php" data-i18n="navManual">User Manual</a>
            </nav>
            <div class="lang-switch" role="group" data-i18n-aria="langLabel" aria-label="Language">
                <button type="button" class="lang-btn" data-lang="en" aria-pressed="false">EN</button>
                <button type="button" class="lang-btn" data-lang="ms" aria-pressed="false">BM</button>
                <button type="button" class="lang-btn" data-lang="zh" aria-pressed="false">中文</button>
            </div>
        </div>
    </header>

    <section class="hero" aria-labelledby="heroTitle">
        <img class="hero-visual" src="assets/img/skyline.svg" alt="Bright Malaysian coastal morning with sea, palms and skyline">
        <div class="hero-copy">
            <h1 id="heroTitle" data-i18n="heroTitle">Cuti MY</h1>
            <p class="hero-tag" data-i18n="heroTag">Malaysian Public Holiday Viewer</p>
            <p class="hero-desc" data-i18n="heroDesc">See federal and state public holidays across Malaysia in one calm calendar, with birthday holidays and observances in three languages.</p>
            <a class="btn btn-primary" href="#filters" data-i18n="heroCta">Browse the calendar</a>
        </div>
    </section>

    <section id="filters" class="filters" aria-labelledby="filtersTitle">
        <h2 id="filtersTitle" class="section-title" data-i18n="filtersTitle">Find a holiday</h2>
        <form class="filter-bar" onsubmit="return false;">
            <label>
                <span data-i18n="year">Year</span>
                <select id="yearFilter" name="year"></select>
            </label>
            <label>
                <span data-i18n="month">Month</span>
                <select id="monthFilter" name="month"></select>
            </label>
            <label>
                <span data-i18n="type">Holiday type</span>
                <select id="typeFilter" name="type">
                    <option value="all" data-i18n="allTypes">All types</option>
                    <option value="federal" data-i18n="typeFederal">Federal</option>
                    <option value="state" data-i18n="typeState">State</option>
                    <option value="birthday" data-i18n="typeBirthday">Birthday</option>
                    <option value="observance" data-i18n="typeObservance">Observance</option>
                </select>
            </label>
            <label class="filter-search">
                <span data-i18n="search">Search</span>
                <input id="keywordFilter" name="keyword" type="search" autocomplete="off" data-i18n-placeholder="searchPlaceholder" placeholder="Search by name, state or description">
            </label>
        </form>
    </section>

    <section class="stats" aria-label="Holiday statistics">
        <article class="stat">
            <p class="stat-label" data-i18n="statTotal">Total holidays</p>
            <p class="stat-value" id="statTotal">0</p>
        </article>
        <article class="stat">
            <p class="stat-label" data-i18n="statFederal">Federal holidays</p>
            <p class="stat-value is-federal" id="statFederal">0</p>
        </article>
        <article class="stat">
            <p class="stat-label" data-i18n="statState">State holidays</p>
            <p class="stat-value is-state" id="statState">0</p>
        </article>
        <article class="stat">
            <p class="stat-label" data-i18n="statNext">Next holiday</p>
            <p class="stat-value" id="statNext">—</p>
            <p class="stat-meta" id="statNextMeta"></p>
        </article>
    </section>

    <section id="calendar-section" class="calendar-section" aria-labelledby="calendarTitle">
        <div class="calendar-head">
            <h2 id="calendarTitle" class="section-title" data-i18n="calendarTitle">Holiday calendar</h2>
            <ul class="legend" aria-label="Colour key">
                <li><span class="swatch is-federal"></span><span data-i18n="typeFederal">Federal</span></li>
                <li><span class="swatch is-state"></span><span data-i18n="typeState">State</span></li>
                <li><span class="swatch is-birthday"></span><span data-i18n="typeBirthday">Birthday</span></li>
                <li><span class="swatch is-observance"></span><span data-i18n="typeObservance">Observance</span></li>
            </ul>
        </div>
        <p id="status" class="status is-loading" data-i18n="loading">Loading holidays…</p>
        <div id="calendar" class="calendar" aria-live="polite"></div>
    </section>

    <div id="holidayModal" class="modal" hidden role="dialog" aria-modal="true" aria-labelledby="modalHeading" data-i18n-aria="modalTitle">
        <div class="modal-panel">
            <button id="modalClose" class="modal-close" type="button" data-i18n-aria="close" aria-label="Close">×</button>
            <h2 id="modalHeading" class="visually-hidden" data-i18n="modalTitle">Holiday details</h2>
            <div id="modalBody"></div>
        </div>
    </div>

    <?php require __DIR__ . '/includes/footer.php'; ?>

    <script src="assets/js/i18n.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>
