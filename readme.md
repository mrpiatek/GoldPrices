## Gold Prices Application

Shows how one could have invested in gold in past 10 years based on data provided by NBP WEB API.

## Dependencies

- GuzzleHttp.

## Installation

```
git clone git@github.com:mrpiatek/GoldPrices.git ~/GoldPrices
cd ~/GoldPrices
composer install
cp .env.example .env
php artisan key:generate
php artisan:serv
```

## Usage

```
curl http://localhost:8000/api/last-ten-years
```

## Licence
This software is licenced under the [MIT Licence](http://opensource.org/licenses/MIT).