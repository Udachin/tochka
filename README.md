docker-compose up -d

docker run --rm -v $(pwd):/app composer install

docker exec app php artisan migrate