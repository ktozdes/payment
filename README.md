<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>


# Как установить

- клонировать. `git clone git@github.com:ktozdes/payment.git`
- зайти в папку payment через терминал 
- запустить команду `composer install` 
- запустить команду `npm install` 
- запустить команду `./vendor/bin/sail up` 

### Допольнительно
Для создания docker контейнеров использовалась библиотека laravel sails. https://laravel.com/docs/master/sail

Для сайта используется url http://localhost:8090. Если этот порт не свободен, тогда открыть файл docker-compose.yml и поменять порт

То же самое относится к mysql

Не забываем запустить `npm run dev`

## миграция и сидеры

Чтобы запусить миграции и сидеры надо зайти в контейнер. Для определения нужного контейнера запустить команду `docker ps -a`. Использовать номер контейнера __sail-8.0/app__

пример:

c2b762d1b0d1 |----| sail-8.0/app |----| "start-container" |----| 10 hours ago |----| Exited (137) 5 minutes ago |----| payment_laravel.test_1 

на данном примере номер контейнера `c2b762d1b0d1`

после этого запустить команду `docker exec -it c2b762d1b0d1 sh`

Зайдя в контейнер можно запускать php artisan комманды
