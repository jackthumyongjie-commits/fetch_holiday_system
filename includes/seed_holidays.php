<?php

declare(strict_types=1);

/**
 * Cuti MY holiday seed data for 2024, 2025 and 2026.
 *
 * To add another year later:
 * 1. Add the date into the matching holiday "dates" list below.
 * 2. Run install.php or install_cli.php again (duplicates are ignored).
 */

function cuti_my_get_seed_rows(): array
{
    $ms = require dirname(__DIR__) . '/sql/desc_ms_map.php';
    $en = cuti_my_desc_en();
    $zh = cuti_my_desc_zh();

    $rows = [];
    foreach (cuti_my_holiday_templates() as $item) {
        $key = $item['key'];
        foreach ($item['dates'] as $date) {
            $rows[] = [
                'holiday_date' => $date,
                'year' => (int) substr($date, 0, 4),
                'name_en' => $item['name_en'],
                'name_zh' => $item['name_zh'],
                'name_ms' => $item['name_ms'],
                'type' => $item['type'],
                'states' => $item['states'],
                'description_en' => $en[$key] ?? null,
                'description_zh' => $zh[$key] ?? null,
                'description_ms' => $ms[$key] ?? null,
                'is_birthday' => $item['is_birthday'] ? 1 : 0,
            ];
        }
    }

    return $rows;
}

function cuti_my_holiday_templates(): array
{
    $exceptEast = 'Melaka, Negeri Sembilan, Pahang, Pulau Pinang, Perak, Sabah, Sarawak, Selangor, Kuala Lumpur, Labuan, Putrajaya';
    $cnyDay2 = 'Johor, Kedah, Melaka, Negeri Sembilan, Pahang, Pulau Pinang, Perak, Perlis, Sabah, Sarawak, Selangor, Kuala Lumpur, Labuan, Putrajaya';
    $thaipusam = 'Johor, Negeri Sembilan, Pulau Pinang, Perak, Selangor, Kuala Lumpur, Putrajaya';
    $nuzul = 'Kelantan, Pahang, Pulau Pinang, Perak, Perlis, Selangor, Terengganu, Kuala Lumpur, Labuan, Putrajaya';
    $deepavali = 'Johor, Kedah, Kelantan, Melaka, Negeri Sembilan, Pahang, Pulau Pinang, Perak, Perlis, Sabah, Selangor, Terengganu, Kuala Lumpur, Labuan, Putrajaya';
    $israk = 'Kedah, Negeri Sembilan, Perlis, Terengganu';
    $haji2 = 'Kedah, Kelantan, Perlis, Terengganu';

    return [
        ['key' => 'new_year', 'dates' => ['2024-01-01', '2025-01-01', '2026-01-01'], 'name_en' => "New Year's Day", 'name_zh' => '元旦', 'name_ms' => 'Hari Tahun Baharu', 'type' => 'state', 'states' => $exceptEast, 'is_birthday' => 0],
        ['key' => 'nsb_birthday', 'dates' => ['2024-01-14', '2025-01-14', '2026-01-14'], 'name_en' => 'Birthday of the Yang di-Pertuan Besar of Negeri Sembilan', 'name_zh' => '森美兰州最高统治者华诞', 'name_ms' => 'Hari Keputeraan Yang di-Pertuan Besar Negeri Sembilan', 'type' => 'state', 'states' => 'Negeri Sembilan', 'is_birthday' => 1],
        ['key' => 'thaipusam', 'dates' => ['2024-01-25', '2025-02-11', '2026-02-01'], 'name_en' => 'Thaipusam', 'name_zh' => '大宝森节', 'name_ms' => 'Hari Thaipusam', 'type' => 'state', 'states' => $thaipusam, 'is_birthday' => 0],
        ['key' => 'israk', 'dates' => ['2024-02-08', '2025-01-27', '2026-01-17'], 'name_en' => 'Israk and Mikraj', 'name_zh' => '夜行登霄', 'name_ms' => 'Israk dan Mikraj', 'type' => 'state', 'states' => $israk, 'is_birthday' => 0],
        ['key' => 'cny1', 'dates' => ['2024-02-10', '2025-01-29', '2026-02-17'], 'name_en' => 'Chinese New Year', 'name_zh' => '农历新年', 'name_ms' => 'Tahun Baharu Cina', 'type' => 'federal', 'states' => null, 'is_birthday' => 0],
        ['key' => 'cny2', 'dates' => ['2024-02-11', '2025-01-30', '2026-02-18'], 'name_en' => 'Chinese New Year (Second Day)', 'name_zh' => '农历新年第二天', 'name_ms' => 'Tahun Baharu Cina (Hari Kedua)', 'type' => 'federal', 'states' => $cnyDay2, 'is_birthday' => 0],
        ['key' => 'cny_replacement', 'dates' => ['2024-02-12'], 'name_en' => 'Chinese New Year (Replacement)', 'name_zh' => '农历新年（补假）', 'name_ms' => 'Tahun Baharu Cina (Cuti Ganti)', 'type' => 'federal', 'states' => $exceptEast, 'is_birthday' => 0],
        ['key' => 'ft_day', 'dates' => ['2024-02-01', '2025-02-01', '2026-02-01'], 'name_en' => 'Federal Territory Day', 'name_zh' => '联邦直辖区日', 'name_ms' => 'Hari Wilayah Persekutuan', 'type' => 'state', 'states' => 'Kuala Lumpur, Labuan, Putrajaya', 'is_birthday' => 0],
        ['key' => 'melaka_independence', 'dates' => ['2024-02-20', '2025-02-20', '2026-02-20'], 'name_en' => 'Declaration of Independence Day (Melaka)', 'name_zh' => '马六甲独立宣言日', 'name_ms' => 'Hari Pengisytiharan Tarikh Kemerdekaan Melaka', 'type' => 'state', 'states' => 'Melaka', 'is_birthday' => 0],
        ['key' => 'awal_ramadan', 'dates' => ['2024-03-12', '2025-03-02', '2026-02-19'], 'name_en' => 'Awal Ramadan', 'name_zh' => '斋月首日', 'name_ms' => 'Awal Ramadan', 'type' => 'state', 'states' => 'Johor, Kedah', 'is_birthday' => 0],
        ['key' => 'awal_ramadan_johor', 'dates' => ['2025-03-03'], 'name_en' => 'Awal Ramadan Holiday (Johor)', 'name_zh' => '斋月首日（柔佛补假）', 'name_ms' => 'Cuti Awal Ramadan (Johor)', 'type' => 'state', 'states' => 'Johor', 'is_birthday' => 0],
        ['key' => 'terengganu_installation', 'dates' => ['2024-03-04', '2025-03-04', '2026-03-04'], 'name_en' => 'Anniversary of the Installation of the Sultan of Terengganu', 'name_zh' => '登嘉楼苏丹登基纪念日', 'name_ms' => 'Ulang Tahun Pertabalan Sultan Terengganu', 'type' => 'state', 'states' => 'Terengganu', 'is_birthday' => 0],
        ['key' => 'nuzul', 'dates' => ['2024-03-28', '2025-03-18', '2026-03-07'], 'name_en' => 'Nuzul Al-Quran', 'name_zh' => '古兰经降临日', 'name_ms' => 'Hari Nuzul Al-Quran', 'type' => 'state', 'states' => $nuzul, 'is_birthday' => 0],
        ['key' => 'sultan_johor', 'dates' => ['2024-03-23', '2025-03-23', '2026-03-23'], 'name_en' => 'Birthday of the Sultan of Johor', 'name_zh' => '柔佛苏丹华诞', 'name_ms' => 'Hari Keputeraan Sultan Johor', 'type' => 'state', 'states' => 'Johor', 'is_birthday' => 1],
        ['key' => 'raya1', 'dates' => ['2024-04-10', '2025-03-31', '2026-03-21'], 'name_en' => 'Hari Raya Aidilfitri', 'name_zh' => '开斋节', 'name_ms' => 'Hari Raya Aidilfitri', 'type' => 'federal', 'states' => null, 'is_birthday' => 0],
        ['key' => 'raya2', 'dates' => ['2024-04-11', '2025-04-01', '2026-03-22'], 'name_en' => 'Hari Raya Aidilfitri (Second Day)', 'name_zh' => '开斋节第二天', 'name_ms' => 'Hari Raya Aidilfitri (Hari Kedua)', 'type' => 'federal', 'states' => null, 'is_birthday' => 0],
        ['key' => 'raya3_melaka', 'dates' => ['2025-04-02', '2026-03-23'], 'name_en' => 'Hari Raya Aidilfitri (Third Day)', 'name_zh' => '开斋节第三天', 'name_ms' => 'Hari Raya Aidilfitri (Hari Ketiga)', 'type' => 'state', 'states' => 'Melaka', 'is_birthday' => 0],
        ['key' => 'good_friday', 'dates' => ['2024-03-29', '2025-04-18', '2026-04-03'], 'name_en' => 'Good Friday', 'name_zh' => '耶稣受难日', 'name_ms' => 'Good Friday', 'type' => 'state', 'states' => 'Sabah, Sarawak', 'is_birthday' => 0],
        ['key' => 'melaka_heritage', 'dates' => ['2024-04-15', '2025-04-15'], 'name_en' => 'Declaration of Melaka as a Historical City', 'name_zh' => '马六甲历史城市宣言日', 'name_ms' => 'Hari Pengisytiharan Melaka sebagai Bandaraya Bersejarah', 'type' => 'state', 'states' => 'Melaka', 'is_birthday' => 0],
        ['key' => 'sultan_terengganu', 'dates' => ['2024-04-26', '2025-04-26', '2026-04-26'], 'name_en' => 'Birthday of the Sultan of Terengganu', 'name_zh' => '登嘉楼苏丹华诞', 'name_ms' => 'Hari Keputeraan Sultan Terengganu', 'type' => 'state', 'states' => 'Terengganu', 'is_birthday' => 1],
        ['key' => 'labour', 'dates' => ['2024-05-01', '2025-05-01', '2026-05-01'], 'name_en' => 'Labour Day', 'name_zh' => '劳动节', 'name_ms' => 'Hari Pekerja', 'type' => 'federal', 'states' => null, 'is_birthday' => 0],
        ['key' => 'wesak', 'dates' => ['2024-05-22', '2025-05-12', '2026-05-31'], 'name_en' => 'Wesak Day', 'name_zh' => '卫塞节', 'name_ms' => 'Hari Wesak', 'type' => 'federal', 'states' => null, 'is_birthday' => 0],
        ['key' => 'wesak_replacement', 'dates' => ['2026-06-02'], 'name_en' => 'Wesak Day (Replacement)', 'name_zh' => '卫塞节（补假）', 'name_ms' => 'Hari Wesak (Cuti Ganti)', 'type' => 'federal', 'states' => null, 'is_birthday' => 0],
        ['key' => 'raja_perlis', 'dates' => ['2024-05-17', '2025-05-17', '2026-05-17'], 'name_en' => 'Birthday of the Raja of Perlis', 'name_zh' => '玻璃市拉惹华诞', 'name_ms' => 'Hari Keputeraan Raja Perlis', 'type' => 'state', 'states' => 'Perlis', 'is_birthday' => 1],
        ['key' => 'hol_pahang', 'dates' => ['2024-05-07', '2025-05-22', '2026-05-22'], 'name_en' => 'Pahang Hol Day', 'name_zh' => '彭亨王室忌辰', 'name_ms' => 'Hari Hol Pahang', 'type' => 'state', 'states' => 'Pahang', 'is_birthday' => 0],
        ['key' => 'arafah', 'dates' => ['2024-06-16', '2025-06-06', '2026-05-26'], 'name_en' => 'Arafah Day', 'name_zh' => '阿拉法日', 'name_ms' => 'Hari Arafah', 'type' => 'state', 'states' => 'Kelantan, Terengganu', 'is_birthday' => 0],
        ['key' => 'haji1', 'dates' => ['2024-06-17', '2025-06-07', '2026-05-27'], 'name_en' => 'Hari Raya Aidiladha', 'name_zh' => '哈芝节', 'name_ms' => 'Hari Raya Aidiladha', 'type' => 'federal', 'states' => null, 'is_birthday' => 0],
        ['key' => 'haji2', 'dates' => ['2024-06-18', '2025-06-08', '2026-05-28'], 'name_en' => 'Hari Raya Aidiladha (Second Day)', 'name_zh' => '哈芝节第二天', 'name_ms' => 'Hari Raya Aidiladha (Hari Kedua)', 'type' => 'state', 'states' => $haji2, 'is_birthday' => 0],
        ['key' => 'kaamatan1', 'dates' => ['2024-05-30', '2025-05-30', '2026-05-30'], 'name_en' => 'Pesta Kaamatan', 'name_zh' => '丰收节（第一天）', 'name_ms' => 'Pesta Kaamatan', 'type' => 'state', 'states' => 'Sabah, Labuan', 'is_birthday' => 0],
        ['key' => 'kaamatan2', 'dates' => ['2024-05-31', '2025-05-31', '2026-05-31'], 'name_en' => 'Pesta Kaamatan (Second Day)', 'name_zh' => '丰收节（第二天）', 'name_ms' => 'Pesta Kaamatan (Hari Kedua)', 'type' => 'state', 'states' => 'Sabah, Labuan', 'is_birthday' => 0],
        ['key' => 'gawai1', 'dates' => ['2024-06-01', '2025-06-01', '2026-06-01'], 'name_en' => 'Gawai Dayak', 'name_zh' => '加瓦伊节', 'name_ms' => 'Hari Gawai Dayak', 'type' => 'state', 'states' => 'Sarawak', 'is_birthday' => 0],
        ['key' => 'gawai2', 'dates' => ['2024-06-02', '2025-06-02', '2026-06-02'], 'name_en' => 'Gawai Dayak (Second Day)', 'name_zh' => '加瓦伊节第二天', 'name_ms' => 'Hari Gawai Dayak (Hari Kedua)', 'type' => 'state', 'states' => 'Sarawak', 'is_birthday' => 0],
        ['key' => 'agong', 'dates' => ['2024-06-03', '2025-06-02', '2026-06-01'], 'name_en' => "Yang di-Pertuan Agong's Birthday", 'name_zh' => '最高元首华诞', 'name_ms' => 'Hari Keputeraan Yang di-Pertuan Agong', 'type' => 'federal', 'states' => null, 'is_birthday' => 1],
        ['key' => 'awal_muharram', 'dates' => ['2024-07-07', '2025-06-27', '2026-06-17'], 'name_en' => 'Awal Muharram (Maal Hijrah)', 'name_zh' => '伊斯兰新年', 'name_ms' => 'Awal Muharam (Maal Hijrah)', 'type' => 'federal', 'states' => null, 'is_birthday' => 0],
        ['key' => 'sultan_kedah', 'dates' => ['2024-06-30', '2025-06-15', '2026-06-21'], 'name_en' => 'Birthday of the Sultan of Kedah', 'name_zh' => '吉打苏丹华诞', 'name_ms' => 'Hari Keputeraan Sultan Kedah', 'type' => 'state', 'states' => 'Kedah', 'is_birthday' => 1],
        ['key' => 'penang_heritage', 'dates' => ['2024-07-07', '2025-07-07', '2026-07-07'], 'name_en' => 'George Town World Heritage Day', 'name_zh' => '乔治市世界遗产日', 'name_ms' => 'Hari Ulang Tahun Perisytiharan Tapak Warisan Dunia', 'type' => 'state', 'states' => 'Pulau Pinang', 'is_birthday' => 0],
        ['key' => 'penang_ydp', 'dates' => ['2024-07-13', '2025-07-12', '2026-07-11'], 'name_en' => 'Birthday of the Yang di-Pertua Negeri of Pulau Pinang', 'name_zh' => '槟城州元首华诞', 'name_ms' => 'Hari Jadi Yang di-Pertua Negeri Pulau Pinang', 'type' => 'state', 'states' => 'Pulau Pinang', 'is_birthday' => 1],
        ['key' => 'hol_iskandar' , 'dates' => ['2024-08-11', '2025-08-12', '2026-07-21'], 'name_en' => 'Hari Hol Almarhum Sultan Iskandar', 'name_zh' => '苏丹依斯干达忌辰', 'name_ms' => 'Hari Hol Almarhum Sultan Iskandar', 'type' => 'state', 'states' => 'Johor', 'is_birthday' => 0],
        ['key' => 'sarawak_day', 'dates' => ['2024-07-22', '2025-07-22', '2026-07-22'], 'name_en' => 'Sarawak Day', 'name_zh' => '砂拉越日', 'name_ms' => 'Hari Sarawak', 'type' => 'state', 'states' => 'Sarawak', 'is_birthday' => 0],
        ['key' => 'sultan_pahang', 'dates' => ['2024-07-30', '2025-07-30', '2026-07-31'], 'name_en' => 'Birthday of the Sultan of Pahang', 'name_zh' => '彭亨苏丹华诞', 'name_ms' => 'Hari Keputeraan Sultan Pahang', 'type' => 'state', 'states' => 'Pahang', 'is_birthday' => 1],
        ['key' => 'melaka_ydp', 'dates' => ['2024-08-24', '2025-08-24', '2026-08-24'], 'name_en' => 'Birthday of the Yang di-Pertua Negeri of Melaka', 'name_zh' => '马六甲州元首华诞', 'name_ms' => 'Hari Jadi Yang di-Pertua Negeri Melaka', 'type' => 'state', 'states' => 'Melaka', 'is_birthday' => 1],
        ['key' => 'maulidur', 'dates' => ['2024-09-16', '2025-09-05', '2026-08-25'], 'name_en' => "Prophet Muhammad's Birthday (Maulidur Rasul)", 'name_zh' => '先知诞辰', 'name_ms' => 'Maulidur Rasul', 'type' => 'federal', 'states' => null, 'is_birthday' => 0],
        ['key' => 'merdeka', 'dates' => ['2024-08-31', '2025-08-31', '2026-08-31'], 'name_en' => 'National Day', 'name_zh' => '国庆日', 'name_ms' => 'Hari Kebangsaan', 'type' => 'federal', 'states' => null, 'is_birthday' => 0],
        ['key' => 'merdeka_replacement', 'dates' => ['2025-09-01'], 'name_en' => 'National Day (Replacement)', 'name_zh' => '国庆日（补假）', 'name_ms' => 'Hari Kebangsaan (Cuti Ganti)', 'type' => 'federal', 'states' => null, 'is_birthday' => 0],
        ['key' => 'malaysia_day', 'dates' => ['2024-09-16', '2025-09-16', '2026-09-16'], 'name_en' => 'Malaysia Day', 'name_zh' => '马来西亚日', 'name_ms' => 'Hari Malaysia', 'type' => 'federal', 'states' => null, 'is_birthday' => 0],
        ['key' => 'sultan_kelantan1', 'dates' => ['2024-09-29', '2025-09-29', '2026-09-29'], 'name_en' => 'Birthday of the Sultan of Kelantan', 'name_zh' => '吉兰丹苏丹华诞', 'name_ms' => 'Hari Keputeraan Sultan Kelantan', 'type' => 'state', 'states' => 'Kelantan', 'is_birthday' => 1],
        ['key' => 'sultan_kelantan2', 'dates' => ['2024-09-30', '2025-09-30', '2026-09-30'], 'name_en' => 'Birthday of the Sultan of Kelantan (Second Day)', 'name_zh' => '吉兰丹苏丹华诞第二天', 'name_ms' => 'Hari Keputeraan Sultan Kelantan (Hari Kedua)', 'type' => 'state', 'states' => 'Kelantan', 'is_birthday' => 1],
        ['key' => 'sabah_ydp', 'dates' => ['2024-10-05', '2025-10-04', '2026-03-30'], 'name_en' => 'Birthday of the Yang di-Pertua Negeri of Sabah', 'name_zh' => '沙巴州元首华诞', 'name_ms' => 'Hari Jadi Yang di-Pertua Negeri Sabah', 'type' => 'state', 'states' => 'Sabah', 'is_birthday' => 1],
        ['key' => 'sarawak_ydp', 'dates' => ['2024-10-12', '2025-10-11', '2026-10-10'], 'name_en' => 'Birthday of the Yang di-Pertua Negeri of Sarawak', 'name_zh' => '砂拉越州元首华诞', 'name_ms' => 'Hari Jadi Yang di-Pertua Negeri Sarawak', 'type' => 'state', 'states' => 'Sarawak', 'is_birthday' => 1],
        ['key' => 'deepavali', 'dates' => ['2024-10-31', '2025-10-20', '2026-11-08'], 'name_en' => 'Deepavali', 'name_zh' => '屠妖节', 'name_ms' => 'Deepavali', 'type' => 'federal', 'states' => $deepavali, 'is_birthday' => 0],
        ['key' => 'deepavali_replacement', 'dates' => ['2026-11-09'], 'name_en' => 'Deepavali (Replacement)', 'name_zh' => '屠妖节（补假）', 'name_ms' => 'Deepavali (Cuti Ganti)', 'type' => 'federal', 'states' => $deepavali, 'is_birthday' => 0],
        ['key' => 'sultan_perak', 'dates' => ['2024-11-01', '2025-11-07', '2026-11-06'], 'name_en' => 'Birthday of the Sultan of Perak', 'name_zh' => '霹雳苏丹华诞', 'name_ms' => 'Hari Keputeraan Sultan Perak', 'type' => 'state', 'states' => 'Perak', 'is_birthday' => 1],
        ['key' => 'sultan_selangor', 'dates' => ['2024-12-11', '2025-12-11', '2026-12-11'], 'name_en' => 'Birthday of the Sultan of Selangor', 'name_zh' => '雪兰莪苏丹华诞', 'name_ms' => 'Hari Keputeraan Sultan Selangor', 'type' => 'state', 'states' => 'Selangor', 'is_birthday' => 1],
        ['key' => 'christmas_eve', 'dates' => ['2024-12-24', '2025-12-24', '2026-12-24'], 'name_en' => 'Christmas Eve', 'name_zh' => '圣诞夜', 'name_ms' => 'Christmas Eve', 'type' => 'state', 'states' => 'Sabah', 'is_birthday' => 0],
        ['key' => 'christmas', 'dates' => ['2024-12-25', '2025-12-25', '2026-12-25'], 'name_en' => 'Christmas Day', 'name_zh' => '圣诞节', 'name_ms' => 'Hari Krismas', 'type' => 'federal', 'states' => null, 'is_birthday' => 0],
        ['key' => 'valentine', 'dates' => ['2024-02-14', '2025-02-14', '2026-02-14'], 'name_en' => "Valentine's Day", 'name_zh' => '情人节', 'name_ms' => 'Hari Valentine', 'type' => 'observance', 'states' => null, 'is_birthday' => 0],
        ['key' => 'chap_goh_mei', 'dates' => ['2024-02-24', '2025-02-12', '2026-03-03'], 'name_en' => 'Chap Goh Mei', 'name_zh' => '元宵节', 'name_ms' => 'Chap Goh Mei', 'type' => 'observance', 'states' => null, 'is_birthday' => 0],
        ['key' => 'womens_day', 'dates' => ['2024-03-08', '2025-03-08', '2026-03-08'], 'name_en' => "International Women's Day", 'name_zh' => '国际妇女节', 'name_ms' => 'Hari Wanita Antarabangsa', 'type' => 'observance', 'states' => null, 'is_birthday' => 0],
        ['key' => 'qing_ming', 'dates' => ['2024-04-04', '2025-04-04', '2026-04-05'], 'name_en' => 'Qing Ming Festival', 'name_zh' => '清明节', 'name_ms' => 'Festival Qing Ming', 'type' => 'observance', 'states' => null, 'is_birthday' => 0],
        ['key' => 'mothers_day', 'dates' => ['2024-05-12', '2025-05-11', '2026-05-10'], 'name_en' => "Mother's Day", 'name_zh' => '母亲节', 'name_ms' => 'Hari Ibu', 'type' => 'observance', 'states' => null, 'is_birthday' => 0],
        ['key' => 'teachers_day', 'dates' => ['2024-05-16', '2025-05-16', '2026-05-16'], 'name_en' => "Teachers' Day", 'name_zh' => '教师节', 'name_ms' => 'Hari Guru', 'type' => 'observance', 'states' => null, 'is_birthday' => 0],
        ['key' => 'fathers_day', 'dates' => ['2024-06-16', '2025-06-15', '2026-06-21'], 'name_en' => "Father's Day", 'name_zh' => '父亲节', 'name_ms' => 'Hari Bapa', 'type' => 'observance', 'states' => null, 'is_birthday' => 0],
        ['key' => 'dragon_boat', 'dates' => ['2024-06-10', '2025-05-31', '2026-06-19'], 'name_en' => 'Dragon Boat Festival', 'name_zh' => '端午节', 'name_ms' => 'Festival Perahu Naga', 'type' => 'observance', 'states' => null, 'is_birthday' => 0],
        ['key' => 'hungry_ghost', 'dates' => ['2024-08-18', '2025-09-06', '2026-08-27'], 'name_en' => 'Hungry Ghost Festival', 'name_zh' => '中元节', 'name_ms' => 'Festival Hungry Ghost', 'type' => 'observance', 'states' => null, 'is_birthday' => 0],
        ['key' => 'mid_autumn', 'dates' => ['2024-09-17', '2025-10-06', '2026-09-25'], 'name_en' => 'Mid-Autumn Festival', 'name_zh' => '中秋节', 'name_ms' => 'Festival Pertengahan Musim Luruh', 'type' => 'observance', 'states' => null, 'is_birthday' => 0],
        ['key' => 'halloween', 'dates' => ['2024-10-31', '2025-10-31', '2026-10-31'], 'name_en' => 'Halloween', 'name_zh' => '万圣节前夜', 'name_ms' => 'Halloween', 'type' => 'observance', 'states' => null, 'is_birthday' => 0],
        ['key' => 'nye', 'dates' => ['2024-12-31', '2025-12-31', '2026-12-31'], 'name_en' => "New Year's Eve", 'name_zh' => '除夕', 'name_ms' => 'Malam Tahun Baharu', 'type' => 'observance', 'states' => null, 'is_birthday' => 0],
    ];
}

function cuti_my_desc_en(): array
{
    return [
        'new_year' => "Marks the first day of the Gregorian calendar. Observed as a public holiday in most states, but not in Johor, Kedah, Kelantan, Perlis and Terengganu.",
        'nsb_birthday' => 'Official birthday of the Yang di-Pertuan Besar of Negeri Sembilan. A state public holiday in Negeri Sembilan only.',
        'thaipusam' => 'Hindu festival honouring Lord Murugan. A public holiday in Johor, Negeri Sembilan, Pulau Pinang, Perak, Selangor, Kuala Lumpur and Putrajaya.',
        'ft_day' => 'Commemorates the establishment of the Federal Territories. Observed in Kuala Lumpur, Labuan and Putrajaya.',
        'israk' => "Commemorates the Prophet Muhammad's night journey. A public holiday in Kedah, Negeri Sembilan, Perlis and Terengganu.",
        'cny1' => 'First day of the Lunar New Year. A federal public holiday throughout Malaysia.',
        'cny2' => 'Second day of the Lunar New Year. Observed nationwide except Kelantan and Terengganu.',
        'cny_replacement' => 'Replacement holiday when Chinese New Year falls on a weekend rest day.',
        'melaka_independence' => "Commemorates Melaka's declaration of independence. A state holiday in Melaka.",
        'awal_ramadan' => 'First day of the fasting month of Ramadan. A public holiday in Johor and Kedah.',
        'awal_ramadan_johor' => 'Additional Johor holiday when Awal Ramadan falls on the state weekend.',
        'terengganu_installation' => 'Anniversary of the installation of the Sultan of Terengganu. A state holiday in Terengganu.',
        'nuzul' => 'Commemorates the revelation of the Quran. Observed in several Peninsular states and the Federal Territories.',
        'sultan_johor' => 'Official birthday of the Sultan of Johor, held on 23 March each year. A state holiday in Johor.',
        'raya1' => 'First day of Hari Raya Aidilfitri, marking the end of Ramadan. A federal public holiday nationwide.',
        'raya2' => 'Second day of Hari Raya Aidilfitri. A federal public holiday nationwide.',
        'raya3_melaka' => 'Additional Melaka holiday linked to Hari Raya Aidilfitri.',
        'good_friday' => 'Christian holy day observed as a public holiday in Sabah and Sarawak.',
        'melaka_heritage' => 'Commemorates the declaration of Melaka as a Historical City. A state holiday in Melaka.',
        'sultan_terengganu' => 'Official birthday of the Sultan of Terengganu on 26 April. A state holiday in Terengganu.',
        'labour' => 'Labour Day is a federal public holiday on 1 May throughout Malaysia.',
        'wesak' => 'Wesak Day commemorates the birth, enlightenment and passing of Buddha. A federal public holiday.',
        'wesak_replacement' => 'Replacement holiday when Wesak Day falls on a rest day or coincides with another holiday.',
        'raja_perlis' => 'Birthday of the Raja of Perlis on 17 May. A state holiday in Perlis.',
        'hol_pahang' => 'Pahang Hol Day commemorates a late Sultan of Pahang. A state holiday in Pahang.',
        'arafah' => 'Arafah Day, the day before Hari Raya Aidiladha. A public holiday in Kelantan and Terengganu.',
        'haji1' => 'Hari Raya Aidiladha commemorates the sacrifice of Prophet Ibrahim. A federal public holiday.',
        'haji2' => 'Second day of Hari Raya Aidiladha. Observed in Kedah, Kelantan, Perlis and Terengganu.',
        'kaamatan1' => 'Kaamatan is the harvest festival of the Kadazan-Dusun community. A holiday in Sabah and Labuan.',
        'kaamatan2' => 'Second day of the Kaamatan harvest festival in Sabah and Labuan.',
        'gawai1' => 'Gawai Dayak is the harvest festival of the Dayak community. A state holiday in Sarawak.',
        'gawai2' => 'Second day of Gawai Dayak in Sarawak.',
        'agong' => "Official birthday of the Yang di-Pertuan Agong. A federal public holiday throughout Malaysia.",
        'awal_muharram' => 'Islamic New Year (Maal Hijrah). A federal public holiday nationwide.',
        'sultan_kedah' => 'Official birthday of the Sultan of Kedah. A state holiday in Kedah.',
        'penang_heritage' => 'Marks the UNESCO World Heritage listing of George Town. A state holiday in Pulau Pinang.',
        'penang_ydp' => 'Birthday of the Yang di-Pertua Negeri of Pulau Pinang. A state holiday in Pulau Pinang.',
        'hol_iskandar' => 'Hari Hol Almarhum Sultan Iskandar. A state holiday in Johor.',
        'sarawak_day' => 'Sarawak Day on 22 July commemorates Sarawak self-government. A state holiday in Sarawak.',
        'sultan_pahang' => 'Official birthday of the Sultan of Pahang. A state holiday in Pahang.',
        'melaka_ydp' => 'Birthday of the Yang di-Pertua Negeri of Melaka on 24 August. A state holiday in Melaka.',
        'maulidur' => "Maulidur Rasul commemorates the birthday of Prophet Muhammad. A federal public holiday.",
        'merdeka' => 'National Day marks Malaya independence on 31 August 1957. A federal public holiday.',
        'merdeka_replacement' => 'Replacement holiday when National Day falls on a weekly rest day.',
        'malaysia_day' => 'Malaysia Day on 16 September commemorates the formation of Malaysia in 1963.',
        'sultan_kelantan1' => 'First day of the Sultan of Kelantan official birthday. A state holiday in Kelantan.',
        'sultan_kelantan2' => 'Second day of the Sultan of Kelantan official birthday. A state holiday in Kelantan.',
        'sabah_ydp' => 'Birthday of the Yang di-Pertua Negeri of Sabah. A state holiday in Sabah.',
        'sarawak_ydp' => 'Birthday of the Yang di-Pertua Negeri of Sarawak. A state holiday in Sarawak.',
        'deepavali' => 'Deepavali, the Hindu festival of lights. A federal holiday except in Sarawak.',
        'deepavali_replacement' => 'Replacement holiday when Deepavali falls on a weekend rest day.',
        'sultan_perak' => 'Official birthday of the Sultan of Perak. A state holiday in Perak.',
        'sultan_selangor' => 'Official birthday of the Sultan of Selangor on 11 December. A state holiday in Selangor.',
        'christmas_eve' => 'Christmas Eve is a state public holiday in Sabah.',
        'christmas' => 'Christmas Day on 25 December is a federal public holiday throughout Malaysia.',
        'valentine' => "Valentine's Day is an international observance for love and friendship. Not a public holiday.",
        'chap_goh_mei' => 'Chap Goh Mei is the 15th day of Chinese New Year. A cultural observance, not a public holiday.',
        'womens_day' => "International Women's Day on 8 March. An observance, not a Malaysian public holiday.",
        'qing_ming' => 'Qing Ming is a Chinese ancestral remembrance day. A cultural observance.',
        'mothers_day' => "Mother's Day is observed on the second Sunday of May. Not a public holiday.",
        'teachers_day' => "Malaysia Teachers' Day is observed on 16 May. An education observance, not a public holiday.",
        'fathers_day' => "Father's Day is observed on the third Sunday of June. Not a public holiday.",
        'dragon_boat' => 'Dragon Boat Festival (Duanwu) is a Chinese cultural observance.',
        'hungry_ghost' => 'Hungry Ghost Festival / Zhongyuan is a Chinese cultural observance.',
        'mid_autumn' => 'Mid-Autumn Festival is a Chinese cultural observance celebrated with mooncakes.',
        'halloween' => 'Halloween on 31 October is a popular observance, not a Malaysian public holiday.',
        'nye' => "New Year's Eve on 31 December is widely celebrated but is not a public holiday.",
    ];
}

function cuti_my_desc_zh(): array
{
    return [
        'new_year' => '公历新年第一天。多数州属放假，但柔佛、吉打、吉兰丹、玻璃市与登嘉楼不放假。',
        'nsb_birthday' => '森美兰州最高统治者官方华诞，仅森美兰放假。',
        'thaipusam' => '印度教大宝森节。柔佛、森美兰、槟城、霹雳、雪兰莪、吉隆坡与布城放假。',
        'ft_day' => '纪念联邦直辖区成立，吉隆坡、纳闽与布城放假。',
        'israk' => '纪念先知穆罕默德夜行登霄。吉打、森美兰、玻璃市与登嘉楼放假。',
        'cny1' => '农历正月初一，马来西亚全国联邦公共假期。',
        'cny2' => '农历正月初二。全国放假，吉兰丹与登嘉楼除外。',
        'cny_replacement' => '农历新年适逢周末休息日时的补假。',
        'melaka_independence' => '纪念马六甲宣布独立日期，马六甲州假期。',
        'awal_ramadan' => '斋月第一天，柔佛与吉打放假。',
        'awal_ramadan_johor' => '斋月首日适逢柔佛周末时的额外假期。',
        'terengganu_installation' => '登嘉楼苏丹登基周年纪念，登嘉楼州假期。',
        'nuzul' => '纪念《古兰经》降临。若干半岛州属与联邦直辖区放假。',
        'sultan_johor' => '柔佛苏丹官方华诞，每年3月23日，仅柔佛放假。',
        'raya1' => '开斋节第一天，斋月结束。全国联邦公共假期。',
        'raya2' => '开斋节第二天，全国联邦公共假期。',
        'raya3_melaka' => '马六甲开斋节额外假期。',
        'good_friday' => '基督教耶稣受难日，沙巴与砂拉越放假。',
        'melaka_heritage' => '纪念马六甲获宣布为历史城市，马六甲州假期。',
        'sultan_terengganu' => '登嘉楼苏丹官方华诞，每年4月26日。',
        'labour' => '劳动节，每年5月1日全国联邦公共假期。',
        'wesak' => '卫塞节纪念佛陀诞生、成道与涅槃，全国联邦公共假期。',
        'wesak_replacement' => '卫塞节适逢休息日或与其他假期重叠时的补假。',
        'raja_perlis' => '玻璃市拉惹华诞，每年5月17日，仅玻璃市放假。',
        'hol_pahang' => '彭亨王室忌辰，仅彭亨放假。',
        'arafah' => '阿拉法日，哈芝节前一天。吉兰丹与登嘉楼放假。',
        'haji1' => '哈芝节纪念先知易卜拉欣的奉献，全国联邦公共假期。',
        'haji2' => '哈芝节第二天。吉打、吉兰丹、玻璃市与登嘉楼放假。',
        'kaamatan1' => '卡达山杜顺族丰收节，沙巴与纳闽放假。',
        'kaamatan2' => '丰收节第二天，沙巴与纳闽放假。',
        'gawai1' => '达雅族加瓦伊丰收节，砂拉越州假期。',
        'gawai2' => '加瓦伊节第二天，砂拉越放假。',
        'agong' => '马来西亚最高元首官方华诞，全国联邦公共假期。',
        'awal_muharram' => '伊斯兰历新年（迁徙纪念日），全国联邦公共假期。',
        'sultan_kedah' => '吉打苏丹官方华诞，仅吉打放假。',
        'penang_heritage' => '纪念乔治市列入联合国教科文组织世界遗产，槟城州假期。',
        'penang_ydp' => '槟城州元首华诞，仅槟城放假。',
        'hol_iskandar' => '苏丹依斯干达忌辰，仅柔佛放假。',
        'sarawak_day' => '砂拉越日（7月22日）纪念砂拉越自治，仅砂拉越放假。',
        'sultan_pahang' => '彭亨苏丹官方华诞，仅彭亨放假。',
        'melaka_ydp' => '马六甲州元首华诞，每年8月24日。',
        'maulidur' => '先知穆罕默德诞辰，全国联邦公共假期。',
        'merdeka' => '国庆日纪念1957年8月31日马来亚独立，全国联邦公共假期。',
        'merdeka_replacement' => '国庆日适逢每周休息日时的补假。',
        'malaysia_day' => '马来西亚日（9月16日）纪念1963年马来西亚成立。',
        'sultan_kelantan1' => '吉兰丹苏丹华诞第一天，仅吉兰丹放假。',
        'sultan_kelantan2' => '吉兰丹苏丹华诞第二天，仅吉兰丹放假。',
        'sabah_ydp' => '沙巴州元首华诞，仅沙巴放假。',
        'sarawak_ydp' => '砂拉越州元首华诞，仅砂拉越放假。',
        'deepavali' => '印度教屠妖节（光明节）。联邦假期，砂拉越除外。',
        'deepavali_replacement' => '屠妖节适逢周末休息日时的补假。',
        'sultan_perak' => '霹雳苏丹官方华诞，仅霹雳放假。',
        'sultan_selangor' => '雪兰莪苏丹官方华诞，每年12月11日。',
        'christmas_eve' => '圣诞夜为沙巴州公共假期。',
        'christmas' => '圣诞节（12月25日）为全国联邦公共假期。',
        'valentine' => '情人节为国际观察日，不是马来西亚公共假期。',
        'chap_goh_mei' => '农历正月十五元宵节，属文化观察日，不是公共假期。',
        'womens_day' => '3月8日国际妇女节，属观察日，不是公共假期。',
        'qing_ming' => '清明节为华人祭祖日，属文化观察日。',
        'mothers_day' => '母亲节为五月第二个星期日，不是公共假期。',
        'teachers_day' => '马来西亚教师节为5月16日，属教育观察日，不是公共假期。',
        'fathers_day' => '父亲节为六月第三个星期日，不是公共假期。',
        'dragon_boat' => '端午节为华人文化观察日。',
        'hungry_ghost' => '中元节为华人文化观察日。',
        'mid_autumn' => '中秋节为华人文化观察日，传统上会吃月饼。',
        'halloween' => '10月31日万圣节前夜属流行观察日，不是马来西亚公共假期。',
        'nye' => '12月31日除夕常有庆祝活动，但不是公共假期。',
    ];
}
