## Getting Started

Download files in your web server directory and extract them or clone repository using git command:

```
git clone https://github.com/plamenpetrov/crm.git
```

### Installing with Docker containers
This app can be deployed on Docker conainers using following instructions:
* Copy env.excample file to .env
* Download app and navigate to root directory. 
* Start terminal/cmd/console and run follwoing command: 
```
docker-compose up
```
This command will build all containers and start services.
* Enter in the container app and run composer to install all necessary dependencies
```
docker-compose exec app composer install
```
* Generate app key
```
docker-compose exec app php artisan key:generate
```
* Open your browser and navigate to http://localhost:8080 to see login page


### Installing

Before you run application you need to have installed 
wamp server or any other web server pack. MySQL is also required.  

Download files in your web server directory and extract them. Create database on MySQL and configure database credentials according to your local environment. Also you will need to install [Composer](https://getcomposer.org/download/) to proper manage project dependencies. 
In main directory create .env file and set:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=YOUR_DATABASE
DB_USERNAME=YOUR_USERNAME
DB_PASSWORD=YOUR_PASSWORD

BROADCAST_DRIVER=pusher
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
SESSION_DOMAIN=

SCOUT_QUEUE=false
SCOUT_DRIVER=mysql
JWT_SECRET=
```

On main project directory start your console and run:

```
composer update
```

After successfully run this command you also need to run:
```
php artisan key:generate
```

You may need to configure and new virtual host on your web server to serve this project. After this configuration restart your server and load your project. 


# RESTFul API

Laravel Framework based RESTFul API. Provade restful interface for thin clients including:

* Manage clients and related persons, related contragents
* Fully trackable changes
* Multiple Languages available
* Manage events (tasks)
* Manage projects
* Export data to excel and pdf

In the process of development are used many of features of Laravel Framework like:
* Dependency injection
* Method injection
* Define Providers
* Services
* Facades
* Routing and route model binding
* Middlewares such as ACL, JWT Token Auth etc.
* Response
* Form Request Validation
* Work with Collections
* Events to log user activities such as create, update, delete
* Mail to notify users when event is changed
* Eloquent ORM
* Mutators and Accessors
* Query scope
* Laravel Scout
* Faker library to generate dummy data

## Built With

* [Laravel Framework](https://laravel.com)
* [JWT Token Auth](https://github.com/tymondesigns/jwt-auth) - JWT-auth provides a simple means of authentication within Laravel using JSON Web Tokens
* [Laravel Scout MySQL Driver](https://github.com/yabhq/laravel-scout-mysql-driver) - Search Eloquent Models
* [Faker](https://github.com/fzaninotto/Faker) - Faker is a PHP library that generates fake data for you


## Author

* **Plamen Petrov** - [PlamenPetrov](https://github.com/plamenpetrov)

## License

This project is licensed under the MIT License.
