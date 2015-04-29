<?php
/**
 * LiveStreet CMS
 * Copyright © 2013 OOO "ЛС-СОФТ"
 *
 * ------------------------------------------------------
 *
 * Official site: www.livestreetcms.com
 * Contact e-mail: office@livestreetcms.com
 *
 * GNU General Public License, version 2:
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * ------------------------------------------------------
 *
 * @link http://www.livestreetcms.com
 * @copyright 2013 OOO "ЛС-СОФТ"
 * @author Maxim Mzhelskiy <rus.engine@gmail.com>
 *
 */

/**
 * Запрещаем напрямую через браузер обращение к этому файлу.
 */
if (!class_exists('Plugin')) {
    die('Hacking attempt!');
}

class PluginPage extends Plugin
{

    public function Init()
    {
	    $aMenu = $this->PluginPage_Main_GetPageItemsByFilter(array(
		    '#where' => array('t.main = ?d' => array(1)),
		    '#order' => array('sort' => 'desc')
	    ));
	    $this->Viewer_Assign('aMenu', $aMenu);
    }

    public function Activate()
    {
        if (!$this->isTableExists('prefix_page')) {
            /**
             * При активации выполняем SQL дамп
             */
            $this->ExportSQL(dirname(__FILE__) . '/install/dump.sql');
        }
        return true;
    }

    public function Deactivate()
    {
        return true;
    }
}