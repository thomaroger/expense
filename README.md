# expense
Expense API - Gestion des coûts et notes de frais

## [Wiki](Link_to_wiki_conflence_here)

<br>

## Linux install

Update packages & install needed package for php.

```bash
sudo apt update
sudo apt install \
  php8.1 \
  php8.1-bcmath \
  php8.1-common \
  php8.1-curl \
  php8.1-dom \
  php8.1-intl \
  php8.1-mbstring \
  php8.1-pgsql \
  php8.1-soap \
  php8.1-zip
```

Configure your local env by adding following files at project root:
<br>

<details><summary>.php-version (if you are using mutlti-version of PHP on localhost)</summary>

```
8.1
</details>

<details><summary>.env.local</summary>

```
DATABASE_URL="mysql://expense:Put_1_Password_Here@127.0.0.1:3306/expense"
CORS_ALLOW_ORIGIN='^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$'
APP_ENV=dev
</details>

<br>

Install dependencies.

```bash
composer install
```

Create database and setup user and password (can use .env.local file).

run migration (initial data set included in the migration)

```bash
php bin/console doctrine:migrations:migrate
```

<br>

## Postman
<details><summary>Postman routes and data set</summary>

LIST : http://127.0.0.1:8000/expenses/all [GET]

DETAIL : http://127.0.0.1:8000/expenses/expense/1 [GET]

CREATE : http://127.0.0.1:8000/expenses/expense [POST]
[Body/raw/json] : {
    "companyId": 1,
    "typeId": 2,
    "amount": 444.44,
    "expenseDate": "2023-01-17"
}

EDIT : http://127.0.0.1:8000/expenses/expense/1 [PUT]
[Body/raw/json] : {
    "companyId": 2,
    "typeId": 1,
    "amount": 555.555,
    "expenseDate": "2023-02-18"
}

DELETE : http://127.0.0.1:8000/expenses/expense/2 [DELETE]


## Unit tests
<details><summary>PhpUnit tests </summary>

Only the ExpenseService is covered by unit tests, Can extend to include complete CRUD Expense endpoints tests.

Setup the test DB (ducplicate the dev DB) and add the user privilleges to DB

<details><summary>.env.test</summary>

```
###> app ###
APP_ENV=test
KERNEL_CLASS='App\Kernel'
APP_SECRET='$ecrvefc0rt3srt'
SYMFONY_DEPRECATIONS_HELPER=999999
PANTHER_APP_ENV=panther
PANTHER_ERROR_SCREENSHOT_DIR=./var/error-screenshots
###< app ###

###> DOCTRINE DATABASE ###
DATABASE_URL="mysql://expense:Put1Password_Here!@127.0.0.1:3306/expense"
###< DOCTRINE DATABASE ###

</details>


Run test suite

```bash
php vendor/bin/simple-phpunit tests/
```

## test results :
Testing ....\expense\tests
......    6 / 6 (100%)
Time: 00:00.324, Memory: 20.00 MB
OK (6 tests, 9 assertions)

## Notes
Issues : #2 installation => Merged into master (https://github.com/phpmontrealconvelio/expense/pull/3)
Issues : #1 Crud Expense => in PR waiting for review : https://github.com/phpmontrealconvelio/expense/pull/5
