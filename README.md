# System Liga - aplikacja PHP z Supabase

Aplikacja webowa dla zadania "Lab 5 - 8 Implementacja w chmurze".
Projekt działa w PHP, a dane są przechowywane w bazie Supabase PostgreSQL.
Panel administracyjny wykonuje operacje `insert` i `update` bezpośrednio w bazie,
a raporty korzystają z widoków i funkcji SQL.

## Zaimplementowane funkcje

- panel startowy z podsumowaniem ligi,
- osobne podstrony: tabela, mecze, drużyny, zawodnicy, raporty i administracja,
- tabela ligowa liczona przez widok SQL `standings_view`,
- terminarz i wyniki spotkań pobierane z PostgreSQL,
- klasyfikacja strzelców liczona przez widok SQL `scorers_view`,
- raport najlepszego zawodnika przeciw wybranej drużynie przez funkcję SQL `best_player_against_team`,
- lista drużyn i zawodników,
- logowanie administratora oparte o sesję PHP,
- panel administratora zapisujący drużyny, zawodników, mecze, wyniki i bramki w Supabase,
- responsywny interfejs w `styles.css`.

## Konfiguracja Supabase

1. W Supabase otwórz `SQL Editor`.
2. Wklej i uruchom cały plik `database/schema.sql`.
3. Skopiuj `.env.example` do `.env`.
4. Wpisz hasło bazy danych w `SUPABASE_DB_PASSWORD`.

Przykład konfiguracji:

```env
SUPABASE_DB_DSN=pgsql:host=aws-1-eu-central-1.pooler.supabase.com;port=5432;dbname=postgres;sslmode=require
SUPABASE_DB_USER=postgres.yafhuowjnxgkcitmsxkp
SUPABASE_DB_PASSWORD=twoje-haslo
```

Można użyć także `DATABASE_URL`, ale przy znakach specjalnych w haśle bezpieczniejsze są trzy osobne zmienne powyżej.

## Pierwsze uruchomienie

Po utworzeniu tabel aplikacja sama doda dane demonstracyjne, jeżeli tabela `leagues`
jest pusta. Te same dane można przywrócić z panelu administratora przez akcję
`Reset danych`.

Do połączenia PHP z Supabase potrzebne jest rozszerzenie `pdo_pgsql`.

## Logowanie

Panel administratora używa sesji PHP i stałego konta demonstracyjnego:

- login: `admin`,
- hasło: `Liga2026!`.

## Struktura plików

- `index.php` - panel główny,
- `standings.php` - tabela ligowa,
- `matches.php` - terminarz i wyniki,
- `teams.php` - drużyny,
- `players.php` - zawodnicy i strzelcy,
- `reports.php` - raporty,
- `admin.php` - formularze administracyjne,
- `login.php` - logowanie administratora,
- `logout.php` - wylogowanie administratora,
- `database/schema.sql` - tabele, indeksy, widoki i funkcja raportowa dla Supabase,
- `includes/config.php` - ładowanie zmiennych środowiskowych,
- `includes/database.php` - połączenie PDO z PostgreSQL,
- `includes/models/league_model.php` - odczyt i zapis danych w bazie,
- `includes/services/league_service.php` - statystyki i raporty z SQL,
- `includes/controllers/` - kontrolery aplikacji, administracji i logowania,
- `includes/views/layout.php` - wspólny układ,
- `styles.css` - interfejs aplikacji.

## Uruchomienie lokalne

```powershell
php -S 127.0.0.1:8000 -t .
```

Następnie otwórz:

```text
http://127.0.0.1:8000
```

## Wdrożenie w chmurze

Na serwerze produkcyjnym ustaw te same zmienne środowiskowe co w `.env`.
Nie commituj pliku `.env` i nie wklejaj hasła bazy danych do kodu.
