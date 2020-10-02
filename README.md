# RX Orders
Order and Hospital management app for BermRX Pharmacy

## Installation

#### Composer packages
```bash 
composer install
php artisan migrate
php artisan db:seed
php artisan passport:install
```

#### Install NodeJS packages
```bash
yarn install
```

#### Watch For Component Changes
```bash
yarn run watch
```

#### Build For Production
```bash
yarn run production
```

## Server Config
post_max_size = 500
upload_max_filesize = 500
