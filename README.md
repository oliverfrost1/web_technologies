# Initial

1. `cp .env.example .env`
   Husk at erstatte `DB_DATABASE=` med din abseloute path til filen
2. `php artisan key:generate`
3. `composer update`
4. Lav `database.db` fil i database-mappen
   Kan køres med følgende kommando i terminalen: `touch database/database.db`
5. `php artisan migrate`

# Start

`php artisan serve`
