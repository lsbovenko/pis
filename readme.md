
## Performance Improvement System.

Внутренняя система для внесения идей (сотрудников, руководства, клиентов по результатам опросов и т.д) и контроля за их реализацией - Performance Improvement System.

# Требования:
 - php7.0+
 - apache 2.2+
 - MySql
 - composer
 
 # Команды:
 - php artisan users:update - команда используется для обновления(синхронизации) данных в таблице users на основе таблицы users проекта Auth Velmie
 - php artisan stamp:generate - команда меняет значение переменной окружения APP_VERSION(используется для версионирования assets файлов) в .env файле