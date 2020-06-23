<!-- <p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p> -->



## О проекте

Контекстно-независимый веб-интерфейс для управления лонгридами, разработанный с помощью фреймворков Laravel и AngularJS


## Возможности

- добавление, перемещение и удаление блоков
- изменение оформления блоков (тени, типографика, слайдер, цвет)
- использование модуля color picker
- использование модуля owl-carousel
- загрузка изображений
- добавление видео
- публикация и предпросмотр


## Установка

Для того, чтобы установить разработанное программное обеспечение необходимо выполнить следующие предложенные шаги. Рассмотрим загрузку проекта на локальный сервер.

- необходимо скопировать ссылку с git репозитория
- воспользоваться командой **git clone <**ссылка на репозиторий**>**;
- в командной строке пишем **composer install**;
- следующим шагом будет создание базы данных и изменение файла .env под конкретную среду;
- генерируем ключ: **php artisan key:generate**;
- для запуска всех необходимых миграций необходимо использовать Artisan-команду migrate: **php artisan migrate**;
- после этого добавляем начальные данные в созданную базу данных с помощью: **php artisan db:seed --class= BlocksTableSeeder**;
- создать ссылку на папку **php artisan storage:link**
- добавляем домен и путь к папке public загруженного проекта. 
