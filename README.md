# System Liga - prototyp SaaS

Prototyp aplikacji webowej dla zadania "Lab 5 - 8 Implementacja w Cloud".
Aplikacja jest przygotowana w PHP i na tym etapie dziala bez bazy danych.
Projekt ma strukture wielostronicowa, a dane sa zapisywane w pliku JSON.
Pozwala to pokazac logike systemu przed podlaczeniem relacyjnej bazy danych w Azure.

## Zaimplementowane funkcje

- panel startowy z podsumowaniem ligi,
- osobne podstrony: tabela, mecze, druzyny, zawodnicy, raporty i admin,
- tabela ligowa liczona automatycznie z wynikow meczow,
- terminarz i wyniki spotkan,
- klasyfikacja strzelcow,
- raport najlepszego zawodnika przeciw wybranej druzynie,
- lista druzyn i zawodnikow,
- panel administratora zapisujacy zmiany w pliku JSON,
- dodawanie druzyn, zawodnikow, meczow, wynikow i bramek bez bazy danych,
- responsywny interfejs w `styles.css`.

## Model logiczny

Prototyp odwzorowuje encje z dokumentacji projektu:

- `League`
- `Schedule`
- `Game`
- `Team`
- `Player`
- `Goal`
- `Score`
- `TeamStanding`
- `Location`

W aktualnej wersji tablice w pliku `index.php` pelnia role danych startowych,
a po uruchomieniu aplikacji dane sa przechowywane w `data/league.json`.
Funkcje `buildStandings`, `buildScorers` i `findBestPlayerAgainstTeam`
pelnia role prostej warstwy uslug.

## Struktura plikow

- `index.php` - panel glowny,
- `standings.php` - tabela ligowa,
- `matches.php` - terminarz i wyniki,
- `teams.php` - druzyny,
- `players.php` - zawodnicy i strzelcy,
- `reports.php` - raporty,
- `admin.php` - formularze administracyjne,
- `includes/app.php` - dane, zapis JSON, logika i wspolny layout,
- `styles.css` - interfejs aplikacji.

## Uruchomienie lokalne

```powershell
php -S 127.0.0.1:8000 -t .
```

Nastepnie otworz:

```text
http://127.0.0.1:8000
```

## Plan wdrozenia w Azure

Najprostsza docelowa architektura:

- Azure App Service dla aplikacji PHP,
- Azure Database for MySQL albo PostgreSQL dla danych,
- Storage Account na backupy lub pliki,
- Application Insights do monitorowania.

Kolejny krok implementacyjny to wydzielenie warstwy dostepu do danych i
podmiana tablic demonstracyjnych na zapytania SQL.
