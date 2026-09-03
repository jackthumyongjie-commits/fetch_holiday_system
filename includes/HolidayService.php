<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config/db.php';

class HolidayService
{
    private PDO $db;

    /** @var array<string, string> */
    private array $stateAliases = [
        'johor' => 'Johor',
        '柔佛' => 'Johor',
        'kedah' => 'Kedah',
        '吉打' => 'Kedah',
        'kelantan' => 'Kelantan',
        '吉兰丹' => 'Kelantan',
        'melaka' => 'Melaka',
        'malacca' => 'Melaka',
        '马六甲' => 'Melaka',
        'negeri sembilan' => 'Negeri Sembilan',
        '森美兰' => 'Negeri Sembilan',
        'pahang' => 'Pahang',
        '彭亨' => 'Pahang',
        'pulau pinang' => 'Pulau Pinang',
        'penang' => 'Pulau Pinang',
        '槟城' => 'Pulau Pinang',
        'perak' => 'Perak',
        '霹雳' => 'Perak',
        'perlis' => 'Perlis',
        '玻璃市' => 'Perlis',
        'sabah' => 'Sabah',
        '沙巴' => 'Sabah',
        'sarawak' => 'Sarawak',
        '砂拉越' => 'Sarawak',
        '砂越' => 'Sarawak',
        'selangor' => 'Selangor',
        '雪兰莪' => 'Selangor',
        'terengganu' => 'Terengganu',
        '登嘉楼' => 'Terengganu',
        'kuala lumpur' => 'Kuala Lumpur',
        '吉隆坡' => 'Kuala Lumpur',
        'labuan' => 'Labuan',
        '纳闽' => 'Labuan',
        'putrajaya' => 'Putrajaya',
        '布城' => 'Putrajaya',
        'wilayah persekutuan' => 'Kuala Lumpur',
        'federal territory' => 'Kuala Lumpur',
        'federal territories' => 'Kuala Lumpur',
    ];

    public function __construct(?PDO $db = null)
    {
        $this->db = $db ?? cuti_db();
    }

    public function tableExists(): bool
    {
        $stmt = $this->db->query("SHOW TABLES LIKE 'holidays'");
        return $stmt !== false && $stmt->fetch() !== false;
    }

    /**
     * @return array{holidays: array<int, array<string, mixed>>, stats: array<string, mixed>, years: array<int, int>}
     */
    public function getHolidays(array $filters): array
    {
        if (!$this->tableExists()) {
            throw new RuntimeException('The holidays table is missing. Please run install.php.');
        }

        $year = $this->normalizeYear($filters['year'] ?? 'all');
        $month = $this->normalizeMonth($filters['month'] ?? 'all');
        $type = $this->normalizeType($filters['type'] ?? 'all');
        $keyword = $this->normalizeKeyword($filters['keyword'] ?? '');

        $sql = 'SELECT id, holiday_date, year, name_en, name_zh, name_ms, type, states,
                       description_en, description_zh, description_ms, is_birthday
                FROM holidays
                WHERE 1 = 1';
        $params = [];

        if ($year !== null) {
            $sql .= ' AND year = :year';
            $params['year'] = $year;
        }

        if ($month !== null) {
            $sql .= ' AND MONTH(holiday_date) = :month';
            $params['month'] = $month;
        }

        if ($type === 'birthday') {
            $sql .= ' AND is_birthday = 1';
        } elseif ($type !== 'all') {
            $sql .= ' AND type = :type';
            $params['type'] = $type;
        }

        if ($keyword !== '') {
            $stateName = $this->matchStateAlias($keyword);
            $sql .= ' AND (
                name_en LIKE :kw OR name_zh LIKE :kw OR name_ms LIKE :kw
                OR description_en LIKE :kw OR description_zh LIKE :kw OR description_ms LIKE :kw
                OR states LIKE :kw';

            if ($stateName !== null) {
                $sql .= ' OR states LIKE :state_name OR states IS NULL';
                $params['state_name'] = '%' . $stateName . '%';
            }

            $sql .= ')';
            $params['kw'] = '%' . $keyword . '%';
        }

        $sql .= ' ORDER BY holiday_date ASC, name_en ASC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();

        $holidays = [];
        foreach ($rows as $row) {
            $holidays[] = $this->formatHoliday($row);
        }

        return [
            'holidays' => $holidays,
            'stats' => $this->buildStats($holidays),
            'years' => $this->getAvailableYears(),
        ];
    }

    /**
     * @return array<int, int>
     */
    public function getAvailableYears(): array
    {
        $stmt = $this->db->query('SELECT DISTINCT year FROM holidays ORDER BY year ASC');
        $years = [];
        foreach ($stmt->fetchAll() as $row) {
            $years[] = (int) $row['year'];
        }
        return $years;
    }

    public function countAll(): int
    {
        $stmt = $this->db->query('SELECT COUNT(*) AS total FROM holidays');
        $row = $stmt->fetch();
        return (int) ($row['total'] ?? 0);
    }

    /**
     * @param array<int, array<string, mixed>> $holidays
     * @return array{total: int, federal: int, state: int, next: ?array<string, mixed>}
     */
    private function buildStats(array $holidays): array
    {
        $total = count($holidays);
        $federal = 0;
        $state = 0;
        $today = date('Y-m-d');
        $next = null;

        foreach ($holidays as $holiday) {
            if ($holiday['type'] === 'federal') {
                $federal++;
            }
            if ($holiday['type'] === 'state') {
                $state++;
            }
            if ($holiday['date'] >= $today && $next === null) {
                $next = [
                    'date' => $holiday['date'],
                    'name_en' => $holiday['name_en'],
                    'name_zh' => $holiday['name_zh'],
                    'name_ms' => $holiday['name_ms'],
                    'type' => $holiday['display_type'],
                ];
            }
        }

        return [
            'total' => $total,
            'federal' => $federal,
            'state' => $state,
            'next' => $next,
        ];
    }

    /**
     * @param array<string, mixed> $row
     * @return array<string, mixed>
     */
    private function formatHoliday(array $row): array
    {
        $timestamp = strtotime((string) $row['holiday_date']);
        $weekday = $timestamp ? (int) date('w', $timestamp) : 0;
        $isBirthday = (int) $row['is_birthday'] === 1;
        $type = (string) $row['type'];

        return [
            'id' => (int) $row['id'],
            'date' => $row['holiday_date'],
            'year' => (int) $row['year'],
            'month' => (int) date('n', $timestamp ?: time()),
            'weekday' => $weekday,
            'name_en' => $row['name_en'],
            'name_zh' => $row['name_zh'],
            'name_ms' => $row['name_ms'],
            'type' => $type,
            'display_type' => $isBirthday ? 'birthday' : $type,
            'states' => $row['states'],
            'description_en' => $row['description_en'],
            'description_zh' => $row['description_zh'],
            'description_ms' => $row['description_ms'],
            'is_birthday' => $isBirthday,
        ];
    }

    private function normalizeYear(mixed $year): ?int
    {
        if ($year === null || $year === '' || $year === 'all') {
            return null;
        }
        if (!is_numeric($year)) {
            throw new InvalidArgumentException('Year must be a number or "all".');
        }
        $value = (int) $year;
        if ($value < 2000 || $value > 2100) {
            throw new InvalidArgumentException('Year is out of range.');
        }
        return $value;
    }

    private function normalizeMonth(mixed $month): ?int
    {
        if ($month === null || $month === '' || $month === 'all') {
            return null;
        }
        if (!is_numeric($month)) {
            throw new InvalidArgumentException('Month must be a number or "all".');
        }
        $value = (int) $month;
        if ($value < 1 || $value > 12) {
            throw new InvalidArgumentException('Month must be between 1 and 12.');
        }
        return $value;
    }

    private function normalizeType(mixed $type): string
    {
        $value = strtolower(trim((string) $type));
        if ($value === '') {
            return 'all';
        }
        $allowed = ['all', 'federal', 'state', 'birthday', 'observance'];
        if (!in_array($value, $allowed, true)) {
            throw new InvalidArgumentException('Invalid holiday type.');
        }
        return $value;
    }

    private function normalizeKeyword(mixed $keyword): string
    {
        $value = trim((string) $keyword);
        $length = function_exists('mb_strlen') ? mb_strlen($value) : strlen($value);
        if ($length > 160) {
            throw new InvalidArgumentException('Search keyword is too long.');
        }
        return $value;
    }

    private function matchStateAlias(string $keyword): ?string
    {
        $key = function_exists('mb_strtolower')
            ? mb_strtolower(trim($keyword))
            : strtolower(trim($keyword));
        return $this->stateAliases[$key] ?? null;
    }
}
