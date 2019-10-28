
## Install application

### Copy config
 ``cp .env.example .env``
 
### Start application
 ``docker-compose up -d``

### Stop application
 ``docker-compose down -v``

### Install dependencies
``docker-compose exec app composer install``

### Run migrations
``docker-compose exec app php artisan migrate``

### Run migrations with seeds
``docker-compose exec app php artisan migrate --seed``

### Laravel IDE Helpers
``docker-compose exec app php artisan ide-helper:generate``

``docker-compose exec app php artisan ide-helper:meta``

### Open app
``http://localhost``


Создайте файл `docker-compose.override.yml` о содержимым
```
version: '2'
services:

  app:
    build:
      args:
        PUID: "1000"
        PHP_INSTALL_XDEBUG: "true"
        PHP_XDEBUG_PORT: "9000"
    environment:
      PHP_IDE_CONFIG: "serverName=localhost"
    extra_hosts:
      - "dockerhost:10.0.75.1"
```
, где
- `PUID` - Только для nix* систем, id вашего пользователя, обычно в linux=1000, mac=500. Узнать его можно командой `id -u`. Для windows параметр не имеет смысла
- `PHP_INSTALL_XDEBUG` нужно ли включить xdebug для php (по умолчанию "false") 
- `PHP_XDEBUG_PORT` порт для xdebug (по умолчанию "9000")
- `PHP_IDE_CONFIG` специальная переменая для PHPStorm, со значением `"serverName=localhost"`, где  `localhost` это название сервера, которое вы дали в настройках PHPStorm

для Windows пользователей добавить в ``docker-compose.override.yml``

```$xslt
  app:
    build:
        volumes:
              - .docker/php/xdebug_custom.ini:/usr/local/etc/php/conf.d/51-xdebug-custom.ini
```



### TEST APP
 ``fill APILAYER_KEY in  .env``


```$xslt
POST    localhost:8080/transfer/

BODY(JSON)   
    {
    	"sender_id" : 3,
    	"reciever_id" : 1,
    	"amount" : 0
    }

```
```
!!!NOTE!!!
CHECK DB FIRST! SEEDS MAKING RANDOM IDS AND VALUES 
```
