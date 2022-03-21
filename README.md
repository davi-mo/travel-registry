# Travel Registry

Welcome to the travel registry. This project is responsible to log all your travels and plan the next one.

## Technology

This project was build using Laravel. To learn more about it, check the next section.

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Development

To develop at this project we use [laravel sail](https://laravel.com/docs/8.x/sail) which was based in docker.

Before start development, you should run:
* `cp env.example .env` - for local development
* `cp env.example .env.testing` - for unit tests

**Important Note:** We use a different database for the unit tests. It should be travel_registry_test.

## Debug

To debug with PHPStorm, check the [PHPStorm Configuration section](https://marcuschristiansen.medium.com/setup-xdebug-in-laravel-8-like-a-boss-ea7582ce01ce) of this article.

## Login

To login, we use the `laravel/socialite` package. You can log in using your Google account.

**Important Note:** Ask the author for the Google credentials to be able to log in.

## Commands

We consume two APIs, one to save the countries, and the other to save the correspondent cities. To use that, it was created two commands for that. Check bellow:
* You can run `sail php artisan country:populate {regionName}`. The regionName is optional, if not set the default one is Europe. The others regions can be found [here](https://restcountries.com/) together with the documentation for the API.
* To run the other command, you can do: `sail php artisan city:populate`. The documentation of the other API can be found [here](https://documenter.getpostman.com/view/1134062/T1LJjU52?version=latest#intro). - This command can take a while.

## Frontend

The views are created using [blade](https://laravel.com/docs/8.x/blade). The views, css and javascript files are inside the `resources` folder. After you change something at the frontend, you can run `sail npm run dev` which will copy all corresponding *.css and *.js files to the public folder. 

## Unit Tests

The project is covered by unit tests. To run them, you can use: `sail test`.

To be able to run the unit tests for the first time, you need to manually create the test database. To do that, run `sail mysql` and then:

```mysql
CREATE DATABASE `travel_registry_test`;
```

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Author

Davi Menezes
