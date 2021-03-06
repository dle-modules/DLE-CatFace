## v.2.3.2 — 21.11.2018
- Модуль сконвертирован в UTF-8
- Исправлено отображение админки для DLE 13

## v.2.3 — 23.05.2014
- Полностью обновлен и переработан внешний вид модуля.
- Исправлено переключение редакторов (BBCODES, WYSIWYG) для новых версий DLE.
- Исправлена ошибка на PHP версии 5.4 и выше.

## v.2.2 — 31.10.2013
- Полный отказ от DLE_API — теперь модуль работает намного быстрее и потребляет гораздо меньше ресурсов.
- Исправлена ошибка, когда для раздела не было никаких настроек и модуль посылал каждый раз запрос в БД даже при включенном кешировании.
- Небольшие исправления, оптимизация и улучшения кода модуля.
- За обновление отдельное спасибо Паше ПафНутиЙ.

## v.2.1 — 13.06.2012
- Визуальный редактор теперь подстраивается под версию DLE, то есть работает как в версии DLE 9.6, так и в более ранних версиях.
- Исправлен недочет в анинсталлере, когда при удалении модуля, таблица с данными не удалялась из базы.

## v.2.0 — 03.06.2012
- Добавлено кеширование.
- Добавлены специальные теги для вставки в catface.tpl — [show_name][/show_name] и [show_description][/show_description].
- Обновлён инсталлер и анинсталлер.
- Обновлен внешний вид, заменена иконка модуля.

## v.1.1 — 04.08.2011
- Появилась новая опция «Где активировать модуль», которая позволяет скрыть на страницах категории не только название и описание, но и все остальное содержимое tpl-шаблона.

## v.1.0.10 — 01.08.2011
- Исправлена проблема с отображением пустого тега H1 если выбрана опция «скрывать» для заголовка категории.

## v.1.0.9 — 01.06.2011
- Решена проблема с выводом знаков ??? вместо букв.
- Обновлена таблица в базе данных (добавлен первичный ключ и явно указана кодировка cp1251).

## v.1.0.7 — 16.05.2011
- Исправлена ошибка с WYSIWYG-редактором для версий DLE ниже 9.2.

## v.1.0.6 — 16.05.2011
- Исправлена ошибка из-за которой не работал скрипт, скрывающий описание для остальных страниц при выключенном WYSIWYG-редакторе.

## v.1.0 — 12.05.2011
- Паблик релиз, идентичен девеловерской версии 1.0.5.