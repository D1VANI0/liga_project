# System Liga - prototyp aplikacji

Aplikacja webowa dla zadania "Lab 5 - 8 Implementacja w chmurze".
Aplikacja jest przygotowana w PHP i korzysta z bazy PostgreSQL w Supabase.
Projekt ma strukturę wielostronicową, a dane są zapisywane w tabelach aplikacji.
JSON pozostaje tylko awaryjnym źródłem danych, gdy nie ustawiono połączenia z bazą.

## Zaimplementowane funkcje

- panel startowy z podsumowaniem ligi,
- osobne podstrony: tabela, mecze, drużyny, zawodnicy, raporty i administracja,
- tabela ligowa liczona automatycznie z wyników meczów,
- terminarz i wyniki spotkań,
- klasyfikacja strzelców,
- raport najlepszego zawodnika przeciw wybranej drużynie,
- lista drużyn i zawodników,
- logowanie administratora oparte o sesję PHP,
- panel administratora zapisujący zmiany w PostgreSQL,
- dodawanie drużyn, zawodników, meczów, wyników i bramek w bazie danych,
- responsywny interfejs w `styles.css`.

## Model logiczny

Prototyp odwzorowuje encje z dokumentacji projektu:

- liga,
- terminarz,
- mecz,
- drużyna,
- zawodnik,
- bramka,
- wynik,
- tabela drużyn,
- lokalizacja.

W aktualnej wersji model danych startowych znajduje się w `includes/models/league_model.php`,
a po uruchomieniu aplikacji dane są przechowywane w tabelach Supabase z prefiksem `app_`.
Funkcje `buildStandings`, `buildScorers` i `findBestPlayerAgainstTeam`
pełnią rolę prostej warstwy usług.

## Baza Danych

Połączenie z Supabase jest czytane ze zmiennych środowiskowych:

- `SUPABASE_DB_DSN`,
- `SUPABASE_DB_USER`,
- `SUPABASE_DB_PASSWORD`.

Lokalnie można je ustawić w pliku `.env`. Plik `.env` jest dodany do `.gitignore`,
żeby hasło do bazy nie trafiło do repozytorium.

## Logowanie

Panel administratora działa z bazą danych. Uwierzytelnianie jest oparte o
sesję PHP i stałe konto demonstracyjne:

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
- `includes/app.php` - plik startowy aplikacji,
- `includes/models/league_model.php` - dane startowe, zapis JSON i obsługa Supabase,
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

## Plan Wdrożenia

Najprostsza docelowa architektura:

- usługa aplikacji w chmurze dla aplikacji PHP,
- PostgreSQL w Supabase,
- magazyn plików na kopie zapasowe,
- monitorowanie działania aplikacji.

Kolejny krok implementacyjny to wydzielenie warstwy dostępu do danych i
dalsze rozbudowanie modelu SQL.
