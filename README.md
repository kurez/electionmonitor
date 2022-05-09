# electionmonitor
Monitor elections to ensure vote integrity.

## An Election Monitor App with Laravel and Vue.JS

## get it up and running.

After you clone this project, do the following:

```bash
# go into the project
cd electionmonitor

# create a .env file
cp .env.example .env

# install composer dependencies
composer update
composer install

# install npm dependencies
npm install

# generate a key for your application
php artisan key:generate

# create a local MySQL database (make sure you have MySQL up and running)
mysql -u root

> create database electionmonitor;
> exit;

# add the database connection config to your .env file
DB_CONNECTION=mysql
DB_DATABASE=electionmonitor
DB_USERNAME=root
DB_PASSWORD=XXXXXXXXX

# run the migration files to generate the schema
php artisan migrate

# visit https://prsp.jambopay.co.ke/client-home and create an account. then copy the bearer token in your API authorization.

I used jambo pay SMS API for sending OTP for user authentication.

# seed your databse with some users and messages
php artisan db:migrate

php artisan db:seed

# run webpack and watch for changes
npm run watch
```

## Setup jambopay SMS

- Visit [Jambopay SMS dashboard](https://prsp.jambopay.co.ke/client-home), sign up and create your first app (it's free).

Good Luck :)
