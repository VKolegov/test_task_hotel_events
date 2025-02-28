
### Первый вопрос

Письменный вопрос: какая в итоге получилась структура БД (включая все вышеописанные сущности, с учётом требований на фронтенде)? Укажите названия таблиц, поля и отношения в human-understandable-формате. Какие поля nullable? Какие ограничения на длины строк?


Структура БД:

- Таблица `hotels`(id, name, slug, address, lat, long, phone, city_name, timezone)

- Таблица `hotel_rooms`(id, hotel_id, name, number) связь с таблицей hotels
    - связь с таблицей `hotels` через `hotel_id`
- Таблица `hotel_guests`(id, first_name, last_name, email, phone, document_type, document_number, user_id, updated_by)
    - связь с таблицей `users` через nullable `user_id`
- Таблица `bookings`(id, hotel_id, room_id, user_id, check_in, check_out, price, status, updated_by)
    - связь с таблицей `hotels` через `hotel_id`
    - связь с таблицей `hotel_rooms` через `room_id`
    - связь с таблицей `users` через nullable `user_id` 
    - связь с таблицей `users` через nullable `updated_by` 
- Таблица `bookings_hotel_guests` (booking_id, guest_id)
    - таблица для осуществления many-to-many отношения, связывает `bookings` и `hotel_guests`
- Таблица `users`(id, name, email, password_hash, role_id)
    - связь с таблицей `user_roles` через `role_id`
- Таблица `user_roles`(id, name, description, permissions (json))
    - хранит разрешения в json-массиве `permissions` (проще поддержка, чем хранить в БД если у нас все разрешения в системе строго определены и могут изменяться только разработчиками)
- Таблица `event_logs` (id, date, entity_type, entity_id, system, data (jsonb))
    - поскольку события с системе которые мы хотим фиксировать у нас могут быть разнообразные, имеет смысл не хранить напрямую связи с сущностями (хотя для разлинчых запросов использовать композитный индекс)
    - для указания связи с сущностями в различных доменах используется комбинация из `entity_type` и `entity_id`
    - `entity_type` и `entity_id` могут быть null, отражая что не все события могут быть привязаны к какой-либо сущности
    - поле `data` для хранения слепка данных в момент события. можно было бы хранить на каждый тип события определенный набор данных в отдельных таблицах, чтобы была нормализация данных и оптимизация БД. Но я рассудил, что если мы хотим часто добавлять новые типы событий и под каждый тип события хранить разные данные, или быстро менять набор данных которые мы хотим фиксировать у событий - лучше хранить их в `jsonb` поле для каждого события. 


### Второй вопрос

Письменный вопрос: укажите библиотеки, которые бы Вы предпочли использовали дополнительно в случае реализации полноценного проекта \- это могут быть инструменты для CSS, линтеры и проч.

`eslint`, `prettier` для контроля качества кода 
`pinia` для управления глобальный состоянием
`date-fns` для работы с данными

НЕ использовал бы базово `axios`, ведь есть нативный метод `fetch()` для выполнения асинхронных HTTP-запросов. Axios только если есть действительная необходимость (например автоматическое отлавливание ошибок или необходимость контролировать запросы, например уставливать таймаут или отменять их, или нужны интерцепторы)

Никаких препроцессоров CSS (типа `scss`, `sass`, `stylus`) и HTML (`pug`) также бы не использовал
На сегодня в 90% случаев это лишний оверхед при сборке и усложнение поддержки при сомнительных выгодах. Многие фичи препроцессоров уже существуют нативно в чистом CSS

Может быть использовал бы пост-процессоры, чтобы например в итоговую сборку не попали неиспользуемые стили
