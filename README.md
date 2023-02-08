# Каталог книг

Необходимо сделать на фреймворке Yii2 + MySQL каталог книг. Книга может иметь несколько авторов.

1. Книга - название, год выпуска, описание, isbn, фото главной страницы.
2. Авторы - ФИО.

Права на доступ:
1. Гость - только просмотр + подписка на новые книги автора.
2. Юзер - просмотр, добавление, редактирование, удаление.

Отчет - ТОП 10 авторов выпустившие больше книг за какой-то год.

ПЛЮСОМ БУДЕТ
Уведомление о поступлении книг из подписки должно отправляться на смс гостю.

https://smspilot.ru/
там "Для тестирования можно использовать ключ эмулятор (реальной отправки SMS не происходит)."

INSTALLATION
------------

Start the container

    docker-compose up -d
    
    docker compose run --rm php /app/yii migrate/up
    
You can then access the application through the following URL:

    http://127.0.0.1:8000

CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=library',
    'username' => 'user',
    'password' => 'pass',
    'charset' => 'utf8',
];
```
