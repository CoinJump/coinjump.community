# CoinJump

## Crowdsourced crypto price jump explanations

A community site, built in [Laravel](https://laravel.com/), to track & explain sudden crypto currency price jumps. The goal is to determine the root cause(s) of each jump, so we can learn from those events.

Get the online version here: [coinjump.community](http://coinjump.community).

## Running CoinJump

It's a Laravel (PHP) based application, after a fork you'll need;

A fresh database with some basic info;

```
$ php artisan migrate:fresh --seed
```

The Laravel scheduler to fetch all available coins, get their prices & detect price jumps. Run this every minute.

```
$ php artisan schedule:run
```

If you'd prefer to run the schedule manually, it involves these 2 tasks. Run these in this order too, to first fetch all available coins & update their prices. The second to detect price jumps.

```
$ php artisan coin:get-prices
$ php artisan coin:detect-price-jumps
```

From then on, prices are fetched every 10 minutes and graphed on the homepage.
