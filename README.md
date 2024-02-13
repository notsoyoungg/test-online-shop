## How to install:
```
git clone git@github.com:notsoyoungg/test-online-shop.git
```
```
composer install
```
Create env file and connect database. After that:
```
php artisan key:generate
```
```
php artisan sail:install
```
```
./vendor/bin/sail up
```
```
./vendor/bin/sail artisan db:seed
```
