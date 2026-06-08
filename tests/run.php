<?php
declare(strict_types=1);

$testStoragePath = sys_get_temp_dir() . '/liga_tests_' . bin2hex(random_bytes(8)) . '.json';

putenv('APP_SKIP_ENV_FILE=1');
putenv('APP_STORAGE_PATH=' . $testStoragePath);
putenv('DATABASE_URL');
putenv('SUPABASE_DB_DSN');
putenv('SUPABASE_DB_USER');
putenv('SUPABASE_DB_PASSWORD');

unset(
    $_ENV['DATABASE_URL'],
    $_ENV['SUPABASE_DB_DSN'],
    $_ENV['SUPABASE_DB_USER'],
    $_ENV['SUPABASE_DB_PASSWORD'],
);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/models/league_model.php';
require_once __DIR__ . '/../includes/services/league_service.php';
require_once __DIR__ . '/../includes/controllers/auth_controller.php';
require_once __DIR__ . '/../includes/views/layout.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION = [];

$tests = [];

function test(string $id, string $name, callable $callback): void
{
    global $tests;

    $tests[] = ['id' => $id, 'name' => $name, 'callback' => $callback];
}

function assertSameValue(mixed $expected, mixed $actual, string $message = ''): void
{
    if ($expected !== $actual) {
        throw new RuntimeException(
            ($message !== '' ? $message . ': ' : '')
            . 'expected ' . var_export($expected, true)
            . ', received ' . var_export($actual, true),
        );
    }
}

function assertTrue(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

function findItemByName(array $items, string $name): ?array
{
    foreach ($items as $item) {
        if (($item['name'] ?? null) === $name) {
            return $item;
        }
    }

    return null;
}

function initializeTestData(): void
{
    resetDemoData();
}

test('F-01', 'Logowanie administratora', static function (): void {
    $_SESSION = [];

    assertTrue(attemptLogin('admin', 'Liga2026!'), 'Poprawne dane logowania zostały odrzucone');
    assertTrue(isLoggedIn(), 'Sesja administratora nie została utworzona');
    assertSameValue('admin', currentUser());
});

test('F-02', 'Dodanie drużyny', static function (): void {
    initializeTestData();
    addTeam('Drużyna Testowa', 'Warszawa', 'Jan Trener', '#112233');

    $team = findItemByName(loadData()['teams'], 'Drużyna Testowa');

    assertTrue($team !== null, 'Drużyna nie została zapisana');
    assertSameValue('Warszawa', $team['city']);
    assertSameValue('Jan Trener', $team['coach']);
});

test('F-03', 'Dodanie zawodnika', static function (): void {
    initializeTestData();
    addPlayer(1, 'Zawodnik Testowy', 'Napastnik');

    $player = findItemByName(loadData()['players'], 'Zawodnik Testowy');

    assertTrue($player !== null, 'Zawodnik nie został zapisany');
    assertSameValue(1, $player['teamId']);
    assertSameValue('Napastnik', $player['position']);
});

test('F-04', 'Dodanie meczu', static function (): void {
    initializeTestData();
    addGame('2026-07-01 18:00', 1, 2, 1);

    $games = loadData()['games'];
    $game = $games[array_key_last($games)];

    assertSameValue('2026-07-01 18:00', $game['date']);
    assertSameValue(1, $game['homeTeamId']);
    assertSameValue(2, $game['visitorTeamId']);
    assertSameValue(null, $game['homeScore']);
    assertSameValue(null, $game['visitorScore']);
});

test('F-05', 'Aktualizacja wyniku meczu', static function (): void {
    initializeTestData();
    updateGameResult(1, 4, 2);

    $game = loadData()['games'][0];

    assertSameValue(4, $game['homeScore']);
    assertSameValue(2, $game['visitorScore']);
});

test('F-06', 'Dodanie bramki', static function (): void {
    initializeTestData();
    $before = count(loadData()['goals']);
    addGoal(1, 1, 18, 55, 'z gry');

    $goals = loadData()['goals'];
    $goal = $goals[array_key_last($goals)];

    assertSameValue($before + 1, count($goals));
    assertSameValue(1, $goal['gameId']);
    assertSameValue(18, $goal['playerId']);
    assertSameValue(55, $goal['minute']);
});

test('F-07', 'Obliczenie najlepszej drużyny', static function (): void {
    initializeTestData();
    $standings = loadStandings();

    assertTrue($standings !== [], 'Tabela ligowa jest pusta');
    assertTrue(isset($standings[0]['team'], $standings[0]['points']), 'Brakuje danych najlepszej drużyny');

    foreach ($standings as $row) {
        assertTrue($standings[0]['points'] >= $row['points'], 'Pierwsza drużyna ma mniej punktów niż kolejna drużyna');
    }
});

test('F-08', 'Obliczenie najlepszego zawodnika', static function (): void {
    initializeTestData();
    $scorers = loadScorers();

    assertTrue($scorers !== [], 'Ranking strzelców jest pusty');
    assertTrue(isset($scorers[0]['player'], $scorers[0]['goals']), 'Brakuje danych najlepszego zawodnika');

    foreach ($scorers as $scorer) {
        assertTrue($scorers[0]['goals'] >= $scorer['goals'], 'Pierwszy zawodnik ma mniej bramek niż kolejny zawodnik');
    }
});

test('F-09', 'Raport najlepszego zawodnika przeciwko wybranej drużynie', static function (): void {
    initializeTestData();
    $bestPlayer = findBestPlayerAgainstTeam(1);

    assertTrue($bestPlayer !== null, 'Raport nie zwrócił zawodnika');
    assertTrue(($bestPlayer['goals'] ?? 0) > 0, 'Raport zwrócił zawodnika bez bramek');

    $data = loadData();
    $selectedTeam = $data['teams'][1];
    assertTrue($bestPlayer['team'] !== $selectedTeam['name'], 'Raport zwrócił zawodnika wybranej drużyny zamiast przeciwnika');
});

test('F-10', 'Próba wejścia do panelu admina bez logowania', static function (): void {
    $_SESSION = [];
    $adminFile = (string) file_get_contents(__DIR__ . '/../admin.php');

    assertTrue(!isLoggedIn(), 'Użytkownik bez sesji został uznany za zalogowanego');
    assertTrue(str_contains($adminFile, "requireLogin('admin.php');"), 'Panel administratora nie wymaga logowania');
});

test('S-01', 'SQL Injection w logowaniu jest odrzucane', static function (): void {
    $_SESSION = [];

    assertTrue(!attemptLogin("admin' OR '1'='1", "' OR '1'='1"), 'Payload SQL Injection został zaakceptowany');
    assertTrue(!isLoggedIn(), 'Sesja administratora została utworzona po próbie SQL Injection');
});

test('S-02', 'Operacje bazodanowe używają prepared statements', static function (): void {
    $model = (string) file_get_contents(__DIR__ . '/../includes/models/league_model.php');

    assertTrue(str_contains($model, '$pdo->prepare('), 'Model nie używa PDO prepare');
    assertTrue(str_contains($model, '$statement->execute('), 'Model nie wykonuje przygotowanych zapytań');
    assertTrue(str_contains($model, 'insert into app_players'), 'Brakuje zapytania dodawania zawodnika');
});

test('S-03', 'Dane HTML są zabezpieczane przed XSS', static function (): void {
    $payload = '<script>alert("xss")</script>';
    $escaped = h($payload);

    assertTrue(!str_contains($escaped, '<script>'), 'Znacznik script nie został zabezpieczony');
    assertSameValue('&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;', $escaped);
});

test('S-04', 'Niepoprawny CSRF token jest odrzucany', static function (): void {
    $_SESSION = [];
    csrfToken();

    assertTrue(!isValidCsrfToken(''), 'Pusty token CSRF został zaakceptowany');
    assertTrue(!isValidCsrfToken(str_repeat('a', 64)), 'Niepoprawny token CSRF został zaakceptowany');
});

test('S-05', 'Poprawny CSRF token jest akceptowany', static function (): void {
    $_SESSION = [];
    $token = csrfToken();

    assertTrue(strlen($token) === 64, 'Token CSRF powinien mieć 64 znaki');
    assertTrue(isValidCsrfToken($token), 'Poprawny token CSRF został odrzucony');
});

test('S-06', 'Zewnętrzne przekierowanie jest blokowane', static function (): void {
    assertSameValue('admin.php', sanitizeLocalPath('https://evil.example/steal'));
    assertSameValue('admin.php', sanitizeLocalPath('//evil.example/steal'));
    assertSameValue('match.php?id=1', sanitizeLocalPath('/match.php?id=1'));
});

test('S-07', 'Wylogowanie wymaga metody POST oraz CSRF tokenu', static function (): void {
    $logoutFile = (string) file_get_contents(__DIR__ . '/../logout.php');
    $layoutFile = (string) file_get_contents(__DIR__ . '/../includes/views/layout.php');

    assertTrue(str_contains($logoutFile, 'REQUEST_METHOD'), 'logout.php nie sprawdza metody żądania');
    assertTrue(str_contains($logoutFile, 'isValidCsrfToken'), 'logout.php nie sprawdza CSRF tokenu');
    assertTrue(str_contains($layoutFile, 'method="post" action="logout.php"'), 'Przycisk wylogowania nie używa POST');
});

test('S-08', 'Hasło administratora jest przechowywane jako hash', static function (): void {
    assertTrue(ADMIN_PASSWORD_HASH !== 'Liga2026!', 'Hasło jest przechowywane jawnym tekstem');
    assertTrue(password_verify('Liga2026!', ADMIN_PASSWORD_HASH), 'Hash hasła nie pasuje do poprawnego hasła');
    assertTrue(password_get_info(ADMIN_PASSWORD_HASH)['algo'] !== 0, 'Stała hasła nie jest poprawnym hashem');
});

$passed = 0;
$failed = 0;

foreach ($tests as $testCase) {
    try {
        $testCase['callback']();
        $passed++;
        echo "[PASS] {$testCase['id']} {$testCase['name']}\n";
    } catch (Throwable $exception) {
        $failed++;
        echo "[FAIL] {$testCase['id']} {$testCase['name']}: {$exception->getMessage()}\n";
    }
}

if (is_file($testStoragePath)) {
    unlink($testStoragePath);
}

echo "\nWynik: {$passed} zaliczonych, {$failed} niezaliczonych, " . count($tests) . " wszystkich testów.\n";

exit($failed === 0 ? 0 : 1);
