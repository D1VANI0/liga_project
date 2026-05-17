# System Liga - aplikacja PHP z Supabase

Aplikacja webowa dla zadania "Lab 5 - 8 Implementacja w chmurze".
Aplikacja jest przygotowana w PHP i korzysta z bazy PostgreSQL w Supabase.
Dane widoczne na stronie są pobierane z tabel Supabase z prefiksem `app_`.
Plik JSON jest tylko awaryjnym źródłem danych, gdy nie ustawiono połączenia z bazą.

## Zaimplementowane funkcje

- panel startowy z podsumowaniem ligi,
- osobne podstrony: tabela, mecze, drużyny, zawodnicy, raporty i administracja,
- tabela ligowa liczona automatycznie na podstawie wyników meczów,
- terminarz i wyniki spotkań pobierane z PostgreSQL,
- klasyfikacja strzelców,
- raport najlepszego zawodnika przeciw wybranej drużynie,
- lista drużyn i zawodników,
- logowanie administratora oparte o sesję PHP,
- panel administratora zapisujący zmiany w PostgreSQL,
- dodawanie drużyn, zawodników, meczów, wyników i bramek w bazie danych,
- responsywny interfejs w `styles.css`.

## Baza Danych

Połączenie z Supabase jest czytane ze zmiennych środowiskowych:

- `SUPABASE_DB_DSN`,
- `SUPABASE_DB_USER`,
- `SUPABASE_DB_PASSWORD`.

Aplikacja używa tabel:

- `app_league_settings`,
- `app_teams`,
- `app_players`,
- `app_locations`,
- `app_games`,
- `app_goals`.

Dane na stronie mogą wyglądać tak samo jak wcześniej, ponieważ baza została zasilona tym samym zestawem demonstracyjnym. Różnica jest techniczna: odczyt i zapis idą teraz przez PostgreSQL w Supabase, a nie przez `data/league.json`.

## Logowanie

Panel administratora działa z bazą danych. Uwierzytelnianie jest oparte o sesję PHP i stałe konto demonstracyjne:

- login: `admin`,
- hasło: `Liga2026!`.

## Struktura Plików

- `index.php` - panel główny,
- `standings.php` - tabela ligowa,
- `matches.php` - terminarz i wyniki,
- `teams.php` - drużyny,
- `players.php` - zawodnicy i strzelcy,
- `reports.php` - raporty,
- `admin.php` - formularze administracyjne,
- `login.php` - logowanie administratora,
- `logout.php` - wylogowanie administratora,
- `includes/config.php` - ładowanie zmiennych środowiskowych,
- `includes/models/league_model.php` - odczyt i zapis danych w Supabase,
- `includes/services/league_service.php` - statystyki i raporty,
- `includes/controllers/` - kontrolery aplikacji, administracji i logowania,
- `includes/views/layout.php` - wspólny układ,
- `styles.css` - interfejs aplikacji.

## Uruchomienie Lokalne

```powershell
php -S 127.0.0.1:8000 -t .
```

Następnie otwórz:

```text
http://127.0.0.1:8000
```

## Wdrożenie

Docelowa architektura:

- aplikacja PHP uruchomiona w usłudze aplikacyjnej,
- PostgreSQL w Supabase,
- zmienne środowiskowe ustawione po stronie hostingu,
- monitorowanie działania aplikacji.
