# DLE-CatFace
![version](https://img.shields.io/badge/version-2.3.1-red.svg?style=flat-square "Version")
![DLE](https://img.shields.io/badge/DLE-8.[b]2[/b]-green.svg?style=flat-square "DLE Version")
[![MIT License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](https://github.com/dle-modules/DLE-StarterKit/blob/master/LICENSE)

Модуль CatFace — SEO оптимизация категорий для DLE Datalife Engine

## Установка модуля:

- Распакуйте архив с модулем;
- Скопируйте содержимое архива (кроме /templates/) на сервер;
- Содержимое папки /templates/Default/ поместите в папку своего шаблона;
- Запустите файл catface_installer.php и следуйте его инструкциям;
- Удалите файл catface_installer.php с сервера;
- Откройте файл main.tpl своего шаблона и в нужное место добавьте следующий код:`[aviable=cat|main]{include file="engine/modules/catface.php"}[/aviable]`
- Процесс установки завершен, переходите к настройке модуля.

## Удаление модуля

- Загрузите файл catface_uninstaller.php на сервер, в папку где установлен DLE;
- Запустите файл http://site.ru/catface_uninstaller.php и следуйте инструкциям;
- Удалите все файлы модуля, загруженные при установке;
- Не забудьте также удалить файл catface_uninstaller.php.