<?php

/*
=============================================================================
 Файл: catface.php (frontend) версия 2.3 
-----------------------------------------------------------------------------
 Автор: Фомин Александр Алексеевич, mail@mithrandir.ru
-----------------------------------------------------------------------------
 Назначение: вывод SEO текстов для категорий и главной страницы
=============================================================================
*/

// Антихакер
if (!defined('DATALIFEENGINE')) {
	die("Hacking attempt!");
}

/*
 * Класс вывода SEO текстов для категорий и главной страницы
 */
class CategoryFace {
	/*
	 * Конструктор класса CategoryFace - задаёт значение свойства dle_config и db
	 */
	public function __construct() {
		global $db, $config;
		$this->dle_config = $config;
		$this->db = $db;
	}


	/*
	 * Главный метод класса CategoryFace
	 */
	public function run() {
		// Подхватываем глобальные переменные
		global $dle_module, $cat_info, $category_id;

		// Создаём дубликат массива $cat_info и переменной $category_id, чтобы иметь возможность их редактировать
		$categoryInfo = $cat_info;
		$categoryId = $category_id;

		// Проверка на просмотр категории (или главной страницы) и на наличие данной категории
		if (($dle_module == 'cat' && $categoryId > 0 && !empty($categoryInfo[$categoryId])) || ($dle_module == 'main')) {
			// Устанавливаем старнадртные значения настроек, если просматриваем главную страницу
			if ($dle_module == 'main') {
				$categoryId = 0;
				$categoryInfo[0]['name'] = $this->dle_config['home_title'];
				$categoryInfo[0]['descr'] = $this->dle_config['description'];
			}

			// Получаем номер страницы
			$page = intval($_REQUEST['cstart']);

			// Пробуем подгрузить содержимое модуля из кэша
			$output = false;

			$output = dle_cache('catface_', md5($categoryId . '_' . $page) . $this->dle_config['skin']);

			// Если значение кэша для данной конфигурации получено, выводим содержимое кэша
			if ($output !== false) {
				$this->showOutput($output);
				return;
			}

			// Ищем соответствующую запись в таблице category_face
			$categoryFace = $this->db->super_query("SELECT * FROM " . PREFIX . "_category_face WHERE category_id = '" . $categoryId . "'");

			// Формируем вывод только в том случае, если запись найдена и модуль активирован на текущей странице
			if (!empty($categoryFace) && $categoryFace['module_placement'] != 'nowhere' && ($categoryFace['module_placement'] == 'all_pages' || $page < 2)) {
				// Вывод заголовка
				if ($categoryFace['name_placement'] == 'all_pages' || $page < 2) {
					switch ($categoryFace['show_name']) {
						case 'show':
							if ($categoryFace['name'] != '') {
								$name = stripslashes($categoryFace['name']);
							}
							break;
						case 'default':
							if ($categoryInfo[$categoryId]['name'] != '') {
								$name = stripslashes($categoryInfo[$categoryId]['name']);
							}
							break;
						case 'hide':
							break;
					}
				}

				// Если указан альтернативный заголовок для остальных страниц, а основной отображается только на первой
				elseif ($page >= 2 && $categoryFace['name_pages'] != '') {
					$name = stripslashes($categoryFace['name_pages']);
				}

				// Вывод описания
				if ($categoryFace['description_placement'] == 'all_pages' || $page < 2) {
					switch ($categoryFace['show_description']) {
						case 'show':
							if ($categoryFace['description'] != '') {
								$description = stripslashes($categoryFace['description']);
							}
							break;
						case 'default':
							if ($categoryInfo[$categoryId]['descr'] != '') {
								$description = stripslashes($categoryInfo[$categoryId]['descr']);
							}
							break;
						case 'hide':
							break;
					}
				}

				// Если указано альтернативное описание для остальных страниц, а основное отображается только на первой
				elseif ($page >= 2 && $categoryFace['description_pages'] != '') {
					$description = stripslashes($categoryFace['description_pages']);
				}

				$output = $this->applyTemplate('catface',
					array(
						'{name}'        => $name,
						'{description}' => $description,
					),
					array(
						"'\[show_name\\](.*?)\[/show_name\]'si"               => !empty($name) ? "\\1" : '',
						"'\[show_description\\](.*?)\[/show_description\]'si" => !empty($description) ? "\\1" : '',
					)
				);
			}

			// Если модуль не активирован на данной странице или запись не найдена, не будем ничего показывать
			else {
				// Исправляем косяк с пустым кешем и (убираем +1 запрос на страницу если нет данных).
				$output = 'empty';
			}
		}


		// Создаём кеш блока
		create_cache('catface_', $output, md5($categoryId . '_' . $page) . $this->dle_config['skin']);


		$this->showOutput($output);
	}


	/*
	 * Метод выводит результат работы модуля в браузер
	 * @param $output - форматированный результат
	 */
	public function showOutput($output) {
		if ($output != 'empty') {
			echo $output;
		}
	}


	/*
	 * Метод подхватывает tpl-шаблон, заменяет в нём теги и возвращает отформатированную строку
	 * @param $template - название шаблона, который нужно применить
	 * @param $vars - ассоциативный массив с данными для замены переменных в шаблоне
	 * @param $vars - ассоциативный массив с данными для замены блоков в шаблоне
	 *
	 * @return string tpl-шаблон, заполненный данными из массива $data
	 */
	public function applyTemplate($template, $vars = array(), $blocks = array()) {
		// Подключаем файл шаблона $template.tpl, заполняем его
		if (!isset($tpl)) {
			$tpl = new dle_template();
			$tpl->dir = TEMPLATE_DIR;
		}
		else {
			$tpl->result[$template] = '';
		}
		$tpl->load_template($template . '.tpl');

		// Заполняем шаблон переменными
		$tpl->set('', $vars);

		// Заполняем шаблон блоками
		foreach ($blocks as $block => $value) {
			$tpl->set_block($block, $value);
		}

		// Компилируем шаблон (что бы это не означало ;))
		$tpl->compile($template);

		// Выводим результат
		return $tpl->result[$template];
	}
}

/*---End Of CategoryFace Class---*/

// Создаём объект класса CategoryFace
$CategoryFace = new CategoryFace;

// Запускаем главный метод класса
$CategoryFace->run();

?>