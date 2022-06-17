# Symfony currency exchange demo

## Keynotes

* Using a small Symfony installation as possible
* Using SQLite database for simplicity but with price of some caveats
  * There are no real decimal or numeric data type so emulation with harcoded 16,8 precision is used
  * There are no INSERT IGNORE method so unique constraint violation are just skipped
* There is `\App\Services\RatesUpdater::makeReverseRate` method to make reverse exchange rate. However, separate buy and
  sell rates should be used in real life.
* There are two tables for rates: _**rates**_ with provided data and _**pairs**_ with all currencies combinations (
  triangles). Triangulations are implemented in the `\App\Services\RatesTriangulator` service. It's inspired
  by http://www.dpxo.net/articles/fx_rate_triangulation_sql.html
* There was some **date** errors in ECB rates so rates' date are writing to the tables but not using in the finally
  exchange calculation
* There are simple functional tests with fake data from `\App\Providers\FakeRatesProvider` provider

## There are two commands

* _currency:update_ - Update currencies exchange rates
* _currency:exchange_ - Exchange currency

And two installation & usage ways: local PHP and Docker.

## 1. Local-way

### Requirements

* PHP 8.1
    * ext-bcmath
    * ext-ctype
    * ext-iconv
    * ext-intl
    * ext-pdo_sqlite
    * ext-simplexml
    * ext-sqlite3
* Composer

### Installation

```bash
git clone https://github.com/vladimirmartsul/symfony-exchange-demo.git
cd symfony-exchange-demo
composer install --no-dev --no-interaction
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate --no-interaction
```

### Usage

Update currency rates first

```bash
php bin/console currency:update
```

Use

```bash
php bin/console currency:exchange <amount> <from> <to>
```

For example

```bash
php bin/console currency:exchange 2 EUR BTC
```

should output

```bash
[OK] 2 EUR is 0.00005254 BTC
```

### Testing

```bash
cd symfony-exchange-demo
echo APP_ENV=test > .env.local
composer install --no-interaction
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate --no-interaction
vendor/bin/phpunit
```

## 2. Docker-way

### Requirements

Docker Desktop (Windows, MacOS) or docker-cli and docker-compose (Linux)

### Installation

```bash
git clone https://vladimirmartsul@bitbucket.org/vladimirmartsul/symfony-exchange-demo.git
cd symfony-exchange-demo
docker compose build
```

Currency rates will be updated during build.

### Usage

```bash
docker compose run symfony-exchange-demo currency:exchange <amount> <from> <to>
```

For example

```bash
docker compose run symfony-exchange-demo currency:exchange 2 EUR BTC
```

should output

```bash
[OK] 2 EUR is 0.00005254 BTC
```

### Testing

```bash
cd symfony-exchange-demo
echo APP_ENV=test > .env.local
docker compose run symfony-exchange-demo composer install --no-interaction
docker compose run symfony-exchange-demo doctrine:database:create
docker compose run symfony-exchange-demo doctrine:migrations:migrate --no-interaction
docker compose run symfony-exchange-demo vendor/bin/phpunit
```

## Extending

There is ability to add new exchange rates providers.

The new provider must implement `\App\Contracts\RatesProviderInterface` interface with constructor `__construct(\Symfony\Contracts\HttpClient\HttpClientInterface $client, string $url, string $base)` and `__invoke(): App\Dto\Rate[]` method.

However, in many cases it is enough to extend abstract `\App\Providers\RatesProvider` class and
implement `\App\Providers\RatesProvider::transform(array $data): RateDto[]` method.

Additionaly the new provider must be registered in _config/services.yaml_ with its own arguments and `app.rates_provider` tag. Real params such as URL and base currency must be writen in _.env_ file.
