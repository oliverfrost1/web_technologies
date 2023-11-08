# Todo List
This is a Todo List application made in the Web Technologies course.

The application is made with the Laravel framework.

<img src="https://github.com/oliverfrost1/web_technologies/assets/112690609/67a8fa93-ced0-441a-8de5-a3210c87a2bc" height="100">


## Initial

Before starting the application ensure you have completed these steps:
1. `$ composer install`
2. `$ cp .env.example .env`
3. `$ php artisan migrate` say yes to creating database file if prompted.
4. Remember to replace `DB_DATABASE=` with your absolute path to the database file

## Start
To start the application run:

`$ php artisan serve`

## Code style
This project uses [Duster](https://github.com/tighten/duster) for ensuring a consistent coding style.

To check everything at once:

`$ ./vendor/bin/duster lint`

To fix everything at once:

`$ ./vendor/bin/duster fix`
