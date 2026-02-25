# Каталог книг — Yii 1 + MySQL

Тестовое задание: веб-приложение «Каталог книг» на Yii 1.1 с авторизацией, CRUD книг/авторов, подпиской на авторов и SMS-уведомлениями через SmsPilot.

## Требования

- PHP 8+
- MySQL / MariaDB
- Composer
- Apache с mod_rewrite (или nginx с аналогичными правилами)

## Установка и запуск

```bash
# 1. Клонировать репозиторий
git clone <url> book-catalog
cd book-catalog

# 2. Установить зависимости
php composer.phar install

# 3. Создать базу данных
mysql -u root -e "CREATE DATABASE book_catalog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 4. Настроить подключение к БД
#    Отредактировать protected/config/database.php (host, username, password)

# 5. Применить миграции
cd protected
php yiic.php migrate --interactive=0
cd ..

# 6. Настроить API-ключ SmsPilot (опционально)
#    В protected/config/main.php → params → smsPilotApiKey
#    Для тестирования можно использовать ключ-эмулятор XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ

# 7. Убедиться, что директория uploads/ доступна на запись
chmod 777 uploads/

# 8. Направить DocumentRoot на корень проекта (или использовать встроенный сервер)
php -S localhost:8080
```

## Структура проекта

```
├── index.php                              # Точка входа
├── .htaccess                              # Rewrite-правила Apache
├── composer.json                          # Зависимости (yiisoft/yii 1.1.32)
├── uploads/                               # Загруженные обложки книг
├── protected/
│   ├── config/
│   │   ├── main.php                       # Конфигурация приложения
│   │   ├── database.php                   # Подключение к БД
│   │   └── console.php                    # Конфиг консольного приложения
│   ├── controllers/
│   │   ├── SiteController.php             # Авторизация, регистрация, главная
│   │   ├── BookController.php             # CRUD книг + загрузка обложек
│   │   ├── AuthorController.php           # CRUD авторов + подписка
│   │   └── ReportController.php           # Отчёт: ТОП-10 авторов по году
│   ├── models/
│   │   ├── User.php                       # AR-модель пользователя
│   │   ├── Book.php                       # AR-модель книги
│   │   ├── Author.php                     # AR-модель автора
│   │   ├── BookAuthor.php                 # AR-модель связи книга-автор (M:N)
│   │   ├── Subscription.php              # AR-модель подписки
│   │   ├── LoginForm.php                  # Форма входа
│   │   ├── RegisterForm.php               # Форма регистрации
│   │   └── SubscribeForm.php              # Форма подписки на автора
│   ├── components/
│   │   ├── Controller.php                 # Базовый контроллер
│   │   ├── UserIdentity.php               # Аутентификация пользователя
│   │   └── SmsPilotService.php            # Сервис отправки SMS
│   ├── migrations/
│   │   ├── m260224_000001_create_user_table.php
│   │   ├── m260224_000002_create_author_table.php
│   │   ├── m260224_000003_create_book_table.php
│   │   ├── m260224_000004_create_book_author_table.php
│   │   └── m260224_000005_create_subscription_table.php
│   └── views/
│       ├── layouts/                       # Шаблоны (main, column1, column2)
│       ├── site/                          # Страницы: login, register, error
│       ├── book/                          # Список, просмотр, формы книг
│       ├── author/                        # Список, просмотр, формы авторов + подписка
│       └── report/                        # Страница отчёта
```

## Схема базы данных

5 таблиц, созданных через миграции:

| Таблица | Описание | Ключевые поля |
|---|---|---|
| `user` | Пользователи | id, username (unique), password (bcrypt), email (unique), created_at |
| `author` | Авторы | id, full_name |
| `book` | Книги | id, title, year, description, isbn, cover_image, created_at |
| `book_author` | Связь книга-автор (M:N) | PK(book_id, author_id), FK с CASCADE |
| `subscription` | Подписки на авторов | id, author_id (FK), phone, created_at, UNIQUE(author_id, phone) |

## Реализованный функционал

### Права доступа

| Действие | Гость | Авторизованный |
|---|:---:|:---:|
| Просмотр книг и авторов | + | + |
| Подписка на автора (по номеру телефона) | + | + |
| Отчёт ТОП-10 авторов | + | + |
| Добавление / редактирование / удаление книг | - | + |
| Добавление / редактирование / удаление авторов | - | + |
| Регистрация / вход | + | - |

Контроль доступа реализован через `accessRules()` с фильтром `accessControl` в каждом контроллере.

### Книги
- CRUD для авторизованных пользователей.
- Связь «многие ко многим» с авторами через промежуточную таблицу `book_author`.
- Загрузка обложки (jpg/png/gif, до 5 МБ). Файл хранится в `uploads/`, имя генерируется через `uniqid()`.
- При удалении книги файл обложки удаляется автоматически (`beforeDelete`).
- При создании книги срабатывает SMS-уведомление подписчикам авторов.

### Авторы
- CRUD для авторизованных пользователей.
- Связь MANY_MANY с книгами, HAS_MANY с подписками, STAT-связь `bookCount`.
- Форма подписки доступна на странице просмотра автора.

### Подписка и SMS-уведомления
- Гость (неаутентифицированный пользователь) вводит номер телефона в формате `7XXXXXXXXXX`.
- Валидация формата через регулярное выражение.
- Проверка дубликатов: уникальный индекс `(author_id, phone)` + проверка на уровне приложения.
- При создании книги `SmsPilotService::notifySubscribers()` отправляет SMS всем подписчикам авторов книги.
- Дедупликация: если подписчик подписан на нескольких авторов одной книги, SMS отправляется один раз.
- Интеграция с API SmsPilot (`https://smspilot.ru/api.php`). Для тестирования используется ключ-эмулятор.

### Отчёт
- Страница `/report` — ТОП-10 авторов, выпустивших наибольшее количество книг за выбранный год.
- Год выбирается через GET-параметр (по умолчанию — текущий).
- Реализован через `CDbCommand` с JOIN и GROUP BY для эффективности.

### Аутентификация
- Регистрация с валидацией уникальности логина/email, подтверждением пароля, минимальной длиной.
- Пароли хешируются через `CPasswordHelper::hashPassword()` (bcrypt).
- Поиск пользователя по логину — регистронезависимый (`LOWER(username)`).
- Опция «Запомнить меня» (cookie на 30 дней).

## Архитектурные решения

- **Тонкие контроллеры**: бизнес-логика отправки SMS вынесена в отдельный сервис `SmsPilotService`. Контроллеры содержат только обработку запроса, валидацию и перенаправление.
- **Эффективная работа с БД**: eager loading связей через `with('authors')`, STAT-связь для подсчёта книг, параметризованные запросы через `CDbCommand` в отчёте.
- **Безопасность**: хеширование паролей (bcrypt), CSRF-защита форм, экранирование вывода через `CHtml::encode()`, приведение типов ID к `int`, параметризация SQL-запросов.
- **Миграции**: вся структура БД описана в 5 миграциях с `safeUp/safeDown`, внешними ключами и индексами.
- **Валидация данных**: на уровне моделей (AR rules), на уровне форм (CFormModel rules), на уровне БД (unique-индексы, FK-constraints).

## URL-маршруты

```
GET  /books                  — список книг
GET  /book/<id>              — просмотр книги
GET  /book/create            — форма создания книги
GET  /book/<id>/update       — форма редактирования книги
POST /book/<id>/delete       — удаление книги

GET  /authors                — список авторов
GET  /author/<id>            — просмотр автора + форма подписки
GET  /author/create          — форма создания автора
GET  /author/<id>/update     — форма редактирования автора
POST /author/<id>/delete     — удаление автора
POST /author/<id>/subscribe  — оформление подписки

GET  /report                 — отчёт ТОП-10 авторов (?year=2025)
GET  /login                  — вход
GET  /register               — регистрация
GET  /logout                 — выход
```
