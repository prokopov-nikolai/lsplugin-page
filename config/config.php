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

return $config;
