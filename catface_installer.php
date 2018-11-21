<!DOCTYPE HTML>
<html>
    <head>
        <title>Установка модуля CatFace</title>
        <link rel="stylesheet" type="text/css" href="http://store.alaev.info/style.css" />
        <style type="text/css">
            #header {width: 100%; text-align: center;}
            .module_image {float: left; margin: 0 15px 15px 0;}
            .box-cnt{width: 100%; overflow: hidden;}
        </style>
    </head>

    <body>
        <div class="wrap">
            <div id="header">
                <h1>CatFace</h1>
            </div>
            <div class="box">
                <div class="box-t">&nbsp;</div>
                <div class="box-c">
                    <div class="box-cnt">
                        <?php

                            $output = module_installer();
                            echo $output;

                        ?>
                    </div>
                </div>
                <div class="box-b">&nbsp;</div>
            </div>
        </div>
    </body>
</html>

<?php

    function module_installer()
    {
        // Стандартный текст
        $output = '<h2>Добро пожаловать в установщик модуля CatFace!</h2>';
        $output .= '<img class="module_image" src="/engine/skins/images/catface.png" />';
        $output .= '<p><strong>Внимание!</strong> После установки модуля <strong>обязательно</strong> удалите файл <strong>catface_installer.php</strong> с Вашего сервера!</p>';

        // Если через $_POST передаётся параметр catface_install, производим инсталляцию, согласно параметрам
        if(!empty($_POST['catface_install']))
        {
            // Подключаем config
            include_once ('engine/data/config.php');

            // Подключаем DLE API
            include ('engine/api/api.class.php');

            // Удаление таблицы с таким же названием (если существует)
            $query = "DROP TABLE IF EXISTS `".PREFIX."_category_face`;";
            $dle_api->db->query($query);

            // Cоздание таблицы для модуля
            $query = "CREATE TABLE `".PREFIX."_category_face` (
                          `category_id` int(11) NOT NULL,
                          `name` varchar(255) NOT NULL,
                          `name_pages` varchar(255) NOT NULL,
                          `description` text NOT NULL,
                          `description_pages` text NOT NULL,
                          `module_placement` enum('nowhere','first_page','all_pages') NOT NULL,
                          `show_name` enum('show','default','hide') NOT NULL,
                          `show_description` enum('show','default','hide') NOT NULL,
                          `name_placement` enum('first_page','all_pages') NOT NULL,
                          `description_placement` enum('first_page','all_pages') NOT NULL,
                          PRIMARY KEY (`category_id`)
                        ) DEFAULT CHARSET=cp1251;";
            $dle_api->db->query($query);

            // Устанавливаем модуль в админку
            $dle_api->install_admin_module('catface', 'CatFace - SEO оптимизация категорий', 'Модуль позволяет прикрепить к категориям и главной странице описание и заголовок, а так же регулировать их вывод на разных страницах', 'catface.png');

            // Вывод
            $output .= '<p>';
            $output .= 'Модуль успешно установлен! Спасибо за Ваш выбор! Приятной работы!';
            $output .= '</p>';
        }

        // Если через $_POST ничего не передаётся, выводим форму для установки модуля
        else
        {
            // Вывод
            $output .= '<p>';
            $output .= '<form method="POST" action="catface_installer.php">';
            $output .= '<input type="hidden" name="catface_install" value="1" />';
            $output .= '<input type="submit" value="Установить модуль" />';
            $output .= '</form>';
            $output .= '</p>';
        }
        
        $output .= '<p>';
        $output .= '<a href="http://alaev.info/blog/post/2086?from=CatFaceInstaller">разработка и поддержка модуля</a>';
        $output .= '</p>';

        // Функция возвращает то, что должно быть выведено
        return $output;
    }

?>
