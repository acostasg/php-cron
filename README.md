# Cron Application in PHP - DDD

## Objective

Implement a CRON replacement. The application must be able to take a configuration file (crontab style) and run commands on demand

The cron file is in the pah:
```
src/CronBundle/Application/CronFiles
```

# Docker
Add docker for execute PHPUnit, PHPStan, Psalm and PHP-cs-fixer in development time
```
docker-compose up --build
```

Execute Application:
```
docker exec -ti app php bin/App
```
for execute PHPUnit
```
docker exec -ti app php vendor/bin/phpunit
```
execute PHPStan
```
docker exec -ti app php vendor/bin/phpstan
```
execute Psalm
```
docker exec -ti app php vendor/bin/psalm --show-info=true
```
execute PHP-cs-fixer
```
docker exec -ti app php vendor/bin/php-cs-fixer fix src
```
## Patterns Used

* Command Pattern
* Composite Patter
* Factory Pattern
* Decorator Pattern
