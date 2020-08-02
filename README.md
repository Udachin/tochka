git clone https://github.com/Udachin/tochka.git

cd tochka

docker-compose build

docker-compose up -d

docker run --rm -v $(pwd):/app composer install

docker exec —user root app chown -R www-data:www-data /var/www
sudo chmod -R 777 storage

docker exec app php artisan migrate:fresh --seed --force