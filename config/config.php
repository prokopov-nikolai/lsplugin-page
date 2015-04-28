<?php
/**
 * Таблица БД
 */
$config['$root$']['db']['table']['page_main_page'] = '___db.table.prefix___page';
/**
 * Роутинг
 */
$config['$root$']['router']['page'][Config::Get('plugin.admin.url').'_page'] = 'PluginPage_ActionAdminPage';
/**
 * Показывать на страницах блок со структурой страниц
 */
$config['show_block_structure'] = true;
/**
 * Меню админки
 */
$config['admin_menu'][] = array(
	'sort' => 100,
	'url' => '/'.Config::Get('plugin.admin.url').'/page/',
	'lang_key' => 'plugin.page.menu_page',
	'menu_key' => 'page'
);
return $config;
