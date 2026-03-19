# Gulp Setup

Frontend в проекте собирается через `Gulp`, но runtime сайта остается Laravel/PHP.

## Команды

Установка зависимостей:

```bash
npm install
```

Сборка production-ассетов:

```bash
npm run build
```

Режим разработки с watch:

```bash
npm run dev
```

Запуск gulp напрямую:

```bash
npm run gulp
```

## Что собирается

- `resources/scss/app.scss` -> `public/build/css/app.css`
- `resources/js/app.js` -> `public/build/js/app.js`

## Как это используется

Laravel layout подключает собранные файлы из:

- `public/build/css/app.css`
- `public/build/js/app.js`

## Особенности

- Node.js нужен только для сборки ассетов.
- Для runtime приложения Node.js не нужен.
- В продакшене можно деплоить уже собранный `public/build`.
