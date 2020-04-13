[![Codecov branch](https://img.shields.io/codecov/c/github/wyster/symfony-based-phone-checker/master)](https://codecov.io/gh/wyster/symfony-based-phone-checker)

# Запуск проекта

Проект можно запустить через docker-compose, для этого нужно

* Перейти в директорию `.docker` : `cd .docker`

* Запустить команду `make setup`

* Отредактировать `.env`, а именно порты по которым будет доступен веб сервер

```
HTTP_PORT=80
MYSQL_PORT=3306
````

* Запустить контейнеры

`make up`

Подьём может занят время, устанавливаются пакеты composer, отследить процесс можно через `make logs`

* После установки всех пакетов в корневой директории должен появится файл `.env`, 
в нем нужно указать ключ и секрет от [DaData.ru](https://dadata.ru/) 

```
DADATA_API_KEY=
DADATA_SECRET_KEY=
```

* После того как все контейнеры запущены проверить работу обратившись через браузер по `http://localhost:$HTTP_PORT`

* К базе можно подключиться по `localhost:$DB_PORT`, login: `dev`, password: `dev`

Другие доступные команды можно посмотреть выполнив `make` в директории `.docker`