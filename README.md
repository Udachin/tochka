# Настройка
git clone https://github.com/Udachin/tochka.git

cd tochka

docker-compose build

docker-compose up -d

docker run --rm -v $(pwd):/app composer install

docker exec --user root app chown -R www-data:www-data /var/www
sudo chmod -R 777 storage

docker exec app php artisan migrate:fresh --seed --force

# Использование
1. Получение списка всех продуктов
Входные данные: GET http://{your_ip}:8080/api/product
Выходные данные:
```json
{
    "data": [
        {
            "id": 2,
            "name": "Marcella Rau",
            "description": "Id eum ex nostrum rem. Reprehenderit est nobis aut vel cupiditate quos ullam accusamus.",
            "price": 6.37,
            "currency": "RUB",
            "count": 59
        },
        {
            "id": 3,
            "name": "Harmon Balistreri",
            "description": "Aliquid neque ut numquam voluptatem adipisci recusandae blanditiis incidunt.",
            "price": 1.29,
            "currency": "RUB",
            "count": 24
        },
    ]
}
```

2. Получение информации по конкретному продукту
Входные данные: GET http://{your_ip}:8080/api/product/2
Выходные данные:
```json
{
    "data": {
        "id": 2,
        "name": "Marcella Rau",
        "description": "Id eum ex nostrum rem. Reprehenderit est nobis aut vel cupiditate quos ullam accusamus.",
        "price": 6.37,
        "currency": "RUB",
        "count": 59
    }
}
```

3. Создание заказа
Входные данные: POST http://{your_ip}:8080/api/create-order
```json
{
    "firstName": "Kirill",
    "lastName": "Udachin",
    "middleName": "Dmitrievich",
    "email": "itsoundslikelove69@gmail.com",
    "phone": "89321115033",
    "orders": [
        {
            "id": 2,
            "count": 10
        }
    ]
}
```
Выходные данные:
```json
{
    "orderId": 1,
    "status": "success"
}
```

Полностью сделаны блоки База данных и API, не сделаны уведомления и отчет т.к. задание довольно объемно, нет доступного времени чтобы качественно выполнить оставшиеся блоки