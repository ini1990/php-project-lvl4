<a href="https://codeclimate.com/github/ini1990/php-project-lvl4/maintainability"><img src="https://api.codeclimate.com/v1/badges/6076b3a9d718ceeca12c/maintainability" /></a>
[![Master workflow](https://github.com/ini1990/php-project-lvl4/workflows/Master%20workflow/badge.svg)](https://github.com/ini1990/php-project-lvl4/actions)

http://task-manager-init.herokuapp.com/

## Install
```
git clone https://github.com/ini1990/php-project-lvl4.git
```

### Setup
```
composer install
```
Create .env file and set up some keys like db connection, mailtrap, rollbar if you need thats
```
cp -n .env.example .env|| true
```

Create database.sqlite or install other db
```
touch database/database.sqlite
```
Keep on
```
php artisan key:gen --ansi
php artisan migrate
php artisan db:seed --class=TaskSeeder
npm install
```
### Launch localhost
```
make run
```

### Run tests
```
make test
```
