# Description
Four teams in the league with different strengths. 
Application able to work with any even number of the teams.
Championship prediction is available before 2 weeks from the end.


# Installation
* PHP 8.0+
* Vue 3

Please use stable version of vue-devtools [https://github.com/vuejs/router/issues/1338](https://github.com/vuejs/router/issues/1338)

```composer install``` 

```cp .env.example .env``` 

Specify DB connection in .env file. The easiest way is to use sqlite.

```touch database/database.sqlite```

Add absolute path to .env file DB_DATABASE

```php artisan key:generate``` 

```php artisan migrate:refresh --seed```

# Tests

```php artisan test```

# Run
```php artisan serve```

Open [http://localhost:8000/](http://localhost:8000/)
