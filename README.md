# System Liga - aplikacja PHP z Supabase

Aplikacja webowa dla zadania "Lab 5 - 8 Implementacja w chmurze".
<<<<<<< HEAD
Aplikacja jest przygotowana w PHP i korzysta z bazy PostgreSQL w Supabase.
Projekt ma strukturę wielostronicową, a dane są zapisywane w tabelach aplikacji.
JSON pozostaje tylko awaryjnym źródłem danych, gdy nie ustawiono połączenia z bazą.
=======
Projekt działa w PHP, a dane są przechowywane w bazie Supabase PostgreSQL.
Panel administracyjny wykonuje operacje `insert` i `update` bezpośrednio w bazie,
a raporty korzystają z widoków i funkcji SQL.
>>>>>>> 1c95d67abd59be267ccc96fde4b746c11bbb116b

## Zaimplementowane funkcje

- panel startowy z podsumowaniem ligi,
- osobne podstrony: tabela, mecze, drużyny, zawodnicy, raporty i administracja,
- tabela ligowa liczona przez widok SQL `standings_view`,
- terminarz i wyniki spotkań pobierane z PostgreSQL,
- klasyfikacja strzelców liczona przez widok SQL `scorers_view`,
- raport najlepszego zawodnika przeciw wybranej drużynie przez funkcję SQL `best_player_against_team`,
- lista drużyn i zawodników,
- logowanie administratora oparte o sesję PHP,
<<<<<<< HEAD
- panel administratora zapisujący zmiany w PostgreSQL,
- dodawanie drużyn, zawodników, meczów, wyników i bramek w bazie danych,
=======
- panel administratora zapisujący drużyny, zawodników, mecze, wyniki i bramki w Supabase,
>>>>>>> 1c95d67abd59be267ccc96fde4b746c11bbb116b
- responsywny interfejs w `styles.css`.

## Konfiguracja Supabase

1. W Supabase otwórz `SQL Editor`.
2. Dla nowej pustej bazy wklej i uruchom cały plik `database/schema.sql`.
3. Dla bazy, w której tabele już istnieją, uruchom `database/add_league_relations.sql`.
4. Skopiuj `.env.example` do `.env`.
5. Wpisz hasło bazy danych w `SUPABASE_DB_PASSWORD`.

Przykład konfiguracji:

<<<<<<< HEAD
W aktualnej wersji model danych startowych znajduje się w `includes/models/league_model.php`,
a po uruchomieniu aplikacji dane są przechowywane w tabelach Supabase z prefiksem `app_`.
Funkcje `buildStandings`, `buildScorers` i `findBestPlayerAgainstTeam`
pełnią rolę prostej warstwy usług.

## Logowanie

Panel administratora działa z bazą danych. Uwierzytelnianie jest oparte o
sesję PHP i stałe konto demonstracyjne:
=======
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
>>>>>>> 1c95d67abd59be267ccc96fde4b746c11bbb116b

- login: `admin`,
- hasło: `Liga2026!`.

## Baza danych

Połączenie z Supabase jest czytane ze zmiennych środowiskowych:

- `SUPABASE_DB_DSN`,
- `SUPABASE_DB_USER`,
- `SUPABASE_DB_PASSWORD`.

Lokalnie można je ustawić w pliku `.env`. Plik `.env` jest dodany do `.gitignore`,
żeby hasło do bazy nie trafiło do repozytorium.

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
- `database/add_league_relations.sql` - migracja dodająca powiązania `leagues` z `teams` i `games`,
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

<<<<<<< HEAD
Najprostsza docelowa architektura:

- usługa aplikacji w chmurze dla aplikacji PHP,
- PostgreSQL w Supabase,
- magazyn plików na kopie zapasowe,
- monitorowanie działania aplikacji.

Kolejny krok implementacyjny to wydzielenie warstwy dostępu do danych i
podmiana tablic demonstracyjnych na zapytania SQL.
=======
Na serwerze produkcyjnym ustaw te same zmienne środowiskowe co w `.env`.
Nie commituj pliku `.env` i nie wklejaj hasła bazy danych do kodu.
>>>>>>> 1c95d67abd59be267ccc96fde4b746c11bbb116b
