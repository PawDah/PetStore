Pet Store API Client: Zadanie Rekrutacyjne
Aplikacja kliencka zbudowana w Laravel (PHP), której celem jest demonstracja czystej architektury, zasad Separacji Obowiązków (SoC) oraz efektywnej komunikacji z zewnętrznym API Pet Store (Swagger).

🚀 Funkcjonalności CRUD
Aplikacja implementuje pełne operacje na zasobie /pet API Pet Store (wersja v2):

GET: Pobieranie zwierzaka po ID.

POST: Dodawanie nowego zwierzaka.

PUT: Aktualizacja zwierzaka po ID.

DELETE: Usuwanie zwierzaka po ID.

🛠 Instalacja i Uruchomienie
Wymagania: PHP (>= 8.1), Composer, Laravel.

Klonowanie i instalacja zależności:

Bash

git clone [TWOJE REPO]
cd [NAZWA PROJEKTU]
composer install
Konfiguracja i klucz aplikacji:

Bash

cp .env.example .env
php artisan key:generate
Wyczyszczenie i uruchomienie:

Bash

php artisan optimize:clear
php artisan serve
Aplikacja dostępna pod adresem: http://127.0.0.1:8000/pet

