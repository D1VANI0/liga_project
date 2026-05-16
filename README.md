# System Liga - prototyp aplikacji

Aplikacja webowa dla zadania "Lab 5 - 8 Implementacja w chmurze".
Aplikacja jest przygotowana w PHP i na tym etapie działa bez bazy danych.
Projekt ma strukturę wielostronicową, a dane są zapisywane w pliku JSON.
Pozwala to pokazać logikę systemu przed podłączeniem relacyjnej bazy danych.

## Zaimplementowane funkcje

- panel startowy z podsumowaniem ligi,
- osobne podstrony: tabela, mecze, drużyny, zawodnicy, raporty i administracja,
- tabela ligowa liczona automatycznie z wyników meczów,
- terminarz i wyniki spotkań,
- klasyfikacja strzelców,
- raport najlepszego zawodnika przeciw wybranej drużynie,
- lista drużyn i zawodników,
- logowanie administratora oparte o sesję PHP, bez bazy danych,
- panel administratora zapisujący zmiany w pliku JSON,
- dodawanie drużyn, zawodników, meczów, wyników i bramek bez bazy danych,
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
a po uruchomieniu aplikacji dane są przechowywane w `data/league.json`.
Funkcje `buildStandings`, `buildScorers` i `findBestPlayerAgainstTeam`
pełnią rolę prostej warstwy usług.

## Logowanie

Panel administratora działa bez bazy danych. Uwierzytelnianie jest oparte o
sesję PHP i stałe konto demonstracyjne:

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
- `includes/app.php` - plik startowy aplikacji,
- `includes/models/league_model.php` - dane startowe i zapis JSON,
- `includes/services/league_service.php` - statystyki i raporty,
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

## Plan wdrożenia

Najprostsza docelowa architektura:

- usługa aplikacji w chmurze dla aplikacji PHP,
- relacyjna baza danych MySQL albo PostgreSQL,
- magazyn plików na kopie zapasowe,
- monitorowanie działania aplikacji.

Kolejny krok implementacyjny to wydzielenie warstwy dostępu do danych i
podmiana tablic demonstracyjnych na zapytania SQL.
