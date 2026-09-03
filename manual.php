<?php
require_once __DIR__ . '/includes/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Manual – Cuti MY</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&family=Unbounded:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/manual.css">
</head>
<body class="is-manual" data-title-key="pageManual">
    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="index.php">
                <span class="brand-mark" aria-hidden="true"></span>
                <span class="brand-text" data-i18n="brand">Cuti MY</span>
            </a>
            <nav class="site-nav" aria-label="Main">
                <a href="index.php" data-i18n="navHome">Holidays</a>
                <a href="manual.php" aria-current="page" data-i18n="navManual">User Manual</a>
            </nav>
            <div class="lang-switch" role="group" data-i18n-aria="langLabel" aria-label="Language">
                <button type="button" class="lang-btn" data-lang="en" aria-pressed="false">EN</button>
                <button type="button" class="lang-btn" data-lang="ms" aria-pressed="false">BM</button>
                <button type="button" class="lang-btn" data-lang="zh" aria-pressed="false">中文</button>
            </div>
        </div>
    </header>

    <main class="manual-wrap">
        <article class="manual-doc" data-manual-lang="en">
            <p class="eyebrow">Guide</p>
            <h1>Cuti MY User Manual</h1>
            <p class="lede">This page explains how beginners can view Malaysian public holidays, change language, and install the system on shared hosting.</p>
            <nav class="toc" aria-label="Contents">
                <a href="#en-what">What it is</a>
                <a href="#en-year">Year</a>
                <a href="#en-month">Month</a>
                <a href="#en-type">Type</a>
                <a href="#en-search">Search</a>
                <a href="#en-lang">Language</a>
                <a href="#en-details">Details</a>
                <a href="#en-install">Install</a>
                <a href="#en-req">Requirements</a>
            </nav>
            <h2 id="en-what">What Cuti MY is</h2>
            <p>Cuti MY is a Malaysian Public Holiday Viewer. It shows federal holidays, state holidays, official birthday holidays, and selected observances for 2024, 2025 and 2026.</p>
            <h2 id="en-year">How to select a year</h2>
            <p>Open the homepage and use the Year list. Choose 2024, 2025, 2026, or All years. The calendar and statistics update without reloading the page.</p>
            <h2 id="en-month">How to select a month</h2>
            <p>Use the Month list to show one month or All months. This is useful when you only need dates for a trip or a school term.</p>
            <h2 id="en-type">How to filter holiday types</h2>
            <p>Holiday type can be All, Federal, State, Birthday or Observance. Federal days apply nationwide (or nearly nationwide). State days belong to one or more states. Birthday days mark a ruler or governor. Observances are cultural dates that are not gazetted public holidays.</p>
            <h2 id="en-search">How to search</h2>
            <p>Type part of a holiday name, a state such as Johor or 柔佛, or a word from the description. Search waits a short moment before updating so it does not query the server on every keystroke.</p>
            <h2 id="en-lang">How to change language</h2>
            <p>Use EN, BM or 中文 in the header. The choice is saved in this browser with localStorage, so it remains after refresh. Language changes navigation, filters, calendar names, statistics, modal text and this manual.</p>
            <h2 id="en-details">How to view holiday details</h2>
            <p>Click a highlighted date in the calendar. A dialog shows the name, date, weekday, type, states and description. If several holidays fall on the same date, all of them appear. Press Escape, click ×, or click outside the panel to close it. Keyboard users can tab through the dialog.</p>
            <h2 id="en-install">Installation instructions</h2>
            <ol>
                <li>Create an empty MySQL database.</li>
                <li>Edit <code>config/db.php</code> and enter host, database name, username and password.</li>
                <li>Upload all project files to <code>public_html/</code>.</li>
                <li>Open <code>install.php</code> in a browser, or run <code>php install_cli.php</code>.</li>
                <li>When installation succeeds, open <code>index.php</code>.</li>
            </ol>
            <p>The installer will not insert the same holiday twice. If you need to run it again, delete <code>config/install.lock</code> first. Command line users may also pass <code>--force</code>.</p>
            <h2 id="en-req">System requirements</h2>
            <ul>
                <li>PHP 8.0 or newer</li>
                <li>MySQL or MariaDB</li>
                <li>PDO MySQL extension</li>
                <li>A browser with JavaScript enabled</li>
            </ul>
            <p>No Node.js, Composer, Laravel or other frameworks are required. The site is meant for ordinary shared hosting such as iFastNet or cPanel.</p>
        </article>

        <article class="manual-doc" data-manual-lang="ms" hidden>
            <p class="eyebrow">Panduan</p>
            <h1>Manual Pengguna Cuti MY</h1>
            <p class="lede">Halaman ini menerangkan cara melihat cuti umum Malaysia, menukar bahasa, dan memasang sistem pada hosting biasa.</p>
            <nav class="toc" aria-label="Kandungan">
                <a href="#ms-what">Apa itu</a>
                <a href="#ms-year">Tahun</a>
                <a href="#ms-month">Bulan</a>
                <a href="#ms-type">Jenis</a>
                <a href="#ms-search">Carian</a>
                <a href="#ms-lang">Bahasa</a>
                <a href="#ms-details">Butiran</a>
                <a href="#ms-install">Pemasangan</a>
                <a href="#ms-req">Keperluan</a>
            </nav>
            <h2 id="ms-what">Apa itu Cuti MY</h2>
            <p>Cuti MY ialah pemapar cuti umum Malaysia. Ia memaparkan cuti persekutuan, cuti negeri, cuti keputeraan rasmi, dan hari pemerhatian terpilih untuk 2024, 2025 dan 2026.</p>
            <h2 id="ms-year">Cara pilih tahun</h2>
            <p>Di halaman utama, gunakan senarai Tahun. Pilih 2024, 2025, 2026 atau Semua tahun. Kalendar dan statistik dikemas kini tanpa memuat semula halaman.</p>
            <h2 id="ms-month">Cara pilih bulan</h2>
            <p>Gunakan senarai Bulan untuk satu bulan atau Semua bulan. Ini membantu apabila anda hanya perlukan tarikh untuk percutian atau penggal sekolah.</p>
            <h2 id="ms-type">Cara tapis jenis cuti</h2>
            <p>Jenis cuti boleh jadi Semua, Persekutuan, Negeri, Keputeraan atau Pemerhatian. Cuti persekutuan merangkumi seluruh negara. Cuti negeri milik satu atau beberapa negeri. Cuti keputeraan menandai raja atau Yang di-Pertua Negeri. Hari pemerhatian ialah tarikh budaya yang bukan cuti umum rasmi.</p>
            <h2 id="ms-search">Cara mencari</h2>
            <p>Taip sebahagian nama cuti, nama negeri seperti Johor atau 柔佛, atau perkataan dalam penerangan. Carian menunggu seketika sebelum dikemas kini supaya tidak menghantar permintaan pada setiap huruf.</p>
            <h2 id="ms-lang">Cara tukar bahasa</h2>
            <p>Gunakan EN, BM atau 中文 di pengepala. Pilihan disimpan dalam pelayar melalui localStorage, jadi ia kekal selepas muat semula. Bahasa menukar navigasi, penapis, nama cuti, statistik, tetingkap butiran dan manual ini.</p>
            <h2 id="ms-details">Cara lihat butiran cuti</h2>
            <p>Klik tarikh yang berwarna pada kalendar. Dialog memaparkan nama, tarikh, hari, jenis, negeri dan penerangan. Jika beberapa cuti jatuh pada tarikh sama, semuanya dipaparkan. Tekan Escape, klik ×, atau klik di luar panel untuk tutup. Pengguna papan kekunci boleh tab dalam dialog.</p>
            <h2 id="ms-install">Arahan pemasangan</h2>
            <ol>
                <li>Cipta pangkalan data MySQL yang kosong.</li>
                <li>Sunting <code>config/db.php</code> dan masukkan host, nama pangkalan data, nama pengguna dan kata laluan.</li>
                <li>Muat naik semua fail projek ke <code>public_html/</code>.</li>
                <li>Buka <code>install.php</code> dalam pelayar, atau jalankan <code>php install_cli.php</code>.</li>
                <li>Selepas berjaya, buka <code>index.php</code>.</li>
            </ol>
            <p>Pemasang tidak akan memasukkan cuti yang sama dua kali. Jika perlu jalankan semula, padam <code>config/install.lock</code> dahulu. Pengguna baris perintah boleh guna <code>--force</code>.</p>
            <h2 id="ms-req">Keperluan sistem</h2>
            <ul>
                <li>PHP 8.0 atau lebih baharu</li>
                <li>MySQL atau MariaDB</li>
                <li>Sambungan PDO MySQL</li>
                <li>Pelayar dengan JavaScript dihidupkan</li>
            </ul>
            <p>Node.js, Composer, Laravel atau rangka kerja lain tidak diperlukan. Laman ini sesuai untuk hosting biasa seperti iFastNet atau cPanel.</p>
        </article>

        <article class="manual-doc" data-manual-lang="zh" hidden>
            <p class="eyebrow">指南</p>
            <h1>Cuti MY 使用手册</h1>
            <p class="lede">本页说明如何查看马来西亚公共假期、切换语言，以及在普通虚拟主机上安装本系统。</p>
            <nav class="toc" aria-label="目录">
                <a href="#zh-what">简介</a>
                <a href="#zh-year">年份</a>
                <a href="#zh-month">月份</a>
                <a href="#zh-type">类型</a>
                <a href="#zh-search">搜索</a>
                <a href="#zh-lang">语言</a>
                <a href="#zh-details">详情</a>
                <a href="#zh-install">安装</a>
                <a href="#zh-req">系统要求</a>
            </nav>
            <h2 id="zh-what">Cuti MY 是什么</h2>
            <p>Cuti MY 是马来西亚公共假期一览应用。它显示联邦假期、州属假期、官方华诞假期，以及部分文化观察日，覆盖 2024、2025 和 2026 年。</p>
            <h2 id="zh-year">如何选择年份</h2>
            <p>在首页使用“年份”下拉菜单，选择 2024、2025、2026 或全部年份。日历和统计会在不刷新整页的情况下更新。</p>
            <h2 id="zh-month">如何选择月份</h2>
            <p>使用“月份”列表显示单月或全部月份。适合只想查看旅行或学期相关日期时使用。</p>
            <h2 id="zh-type">如何筛选假期类型</h2>
            <p>类型可以是全部、联邦、州属、华诞或观察日。联邦假期全国适用（或几乎全国）。州属假期属于一个或多个州。华诞假期标记统治者或州元首。观察日是未被列为公共假期的文化日期。</p>
            <h2 id="zh-search">如何搜索</h2>
            <p>输入假期名称的一部分、州属名称（例如 Johor 或 柔佛），或说明中的词语。搜索会稍等片刻再更新，避免每按一个键就向服务器查询。</p>
            <h2 id="zh-lang">如何切换语言</h2>
            <p>点击页眉中的 EN、BM 或 中文。选择会通过 localStorage 保存在本浏览器中，刷新后仍然有效。语言会改变导航、筛选、假期名称、统计、详情弹窗和本手册。</p>
            <h2 id="zh-details">如何查看假期详情</h2>
            <p>点击日历中高亮的日期。对话框会显示名称、日期、星期、类型、适用州属和说明。若同一天有多个假期，会全部列出。按 Escape、点击 ×，或点击面板外即可关闭。键盘用户可以用 Tab 在对话框内移动。</p>
            <h2 id="zh-install">安装步骤</h2>
            <ol>
                <li>新建一个空的 MySQL 数据库。</li>
                <li>编辑 <code>config/db.php</code>，填入主机、数据库名、用户名和密码。</li>
                <li>把全部项目文件上传到 <code>public_html/</code>。</li>
                <li>在浏览器打开 <code>install.php</code>，或运行 <code>php install_cli.php</code>。</li>
                <li>安装成功后打开 <code>index.php</code>。</li>
            </ol>
            <p>安装程序不会重复插入同一条假期。若要重新安装，先删除 <code>config/install.lock</code>。命令行也可以加上 <code>--force</code>。</p>
            <h2 id="zh-req">系统要求</h2>
            <ul>
                <li>PHP 8.0 或更新版本</li>
                <li>MySQL 或 MariaDB</li>
                <li>PDO MySQL 扩展</li>
                <li>已启用 JavaScript 的浏览器</li>
            </ul>
            <p>不需要 Node.js、Composer、Laravel 或其他框架。本站适合 iFastNet、cPanel 等普通虚拟主机。</p>
        </article>
    </main>

    <?php require __DIR__ . '/includes/footer.php'; ?>
    <script src="assets/js/i18n.js"></script>
    <script src="assets/js/manual.js"></script>
</body>
</html>
