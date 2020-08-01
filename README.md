sudo chmod -R 777 storage

docker-compose build

docker-compose up -d

docker run --rm -v $(pwd):/app composer install

docker exec app php artisan migrate