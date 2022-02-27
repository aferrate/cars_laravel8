# Sample project with Laravel 8 PHP 8 and Docker
### Install

run docker:
```
cd laradock
```
```
docker-compose up -d nginx mysql phpmyadmin elasticsearch mailhog rabbitmq redis
```
if elasticsearch container don't start run this commands:
- windows:
```
wsl -d docker-desktop
```
```
sysctl -w vm.max_map_count=262144
```
- linux:
```
sysctl -w vm.max_map_count=262144
```
install dependencies: (if npm install doesn't work try to install outside docker container)
```
docker-compose exec workspace bash
```
```
composer install
```
```
npm install --no-bin-links
```

create database:
```
docker-compose exec workspace bash
```
```
php artisan db:create laravel_cars
```

add elasticsearch index cars:
```
docker-compose exec workspace bash
```
```
php artisan elasticsearchindexadd:cars
```

run migrations and seeders:
```
docker-compose exec workspace bash
```
```
php artisan migrate
```
```
php artisan db:seed --class=PermissionTableSeeder
```
```
php artisan db:seed --class=CreateAdminUserSeeder
```


### Config repository for read queries

edit cars/.env and change the value of key USE_BACKUP_REPO
if false read queries from mysql if true from elasticsearch


### Start application

access phpmyadmin:
- [http://localhost:8081](http://localhost:8081)

credentials:
```
server mysql
user root
password root
```

access elasticsearch index cars:
- [http://localhost:9200/cars/_search?pretty=true&q=*:*&size=100](http://localhost:9200/cars/_search?pretty=true&q=*:*&size=100)

access mailhog:
- [http://localhost:8025](http://localhost:8025)

access rabbitmq:
- [http://localhost:15672](http://localhost:15672)

credentials:
```
guest
guest
```

call localhost in your browser:
- [http://localhost](http://localhost/)


### Run tests

```
docker-compose exec workspace bash
```
```
phpunit
```


### Access container
get into the container:
```
docker-compose exec workspace bash
```


### Credentials for login as an admin

```
test1@test.com
123456
```


### Delete elasticsearch index cars

```
docker-compose exec workspace bash
```
```
php artisan elasticsearchindexdelete:cars
```