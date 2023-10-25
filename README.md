## Развернуть локально
1. Создать .env.local с содержимым:
```env
POSTGRES_DB=app
POSTGRES_USER=app
POSTGRES_PASSWORD=pass

DATABASE_URL="postgresql://app:pass@db:5432/app?serverVersion=15&charset=utf8"
```
2. Запустить проект: `docker compose up -d`
2. Установить зависимости: `docker compose exec php composer install`
