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
class PluginPage_ActionPage extends ActionPlugin
{

    public function Init()
    {
        /**
         * Получаем текущего пользователя
         */
        $this->oUserCurrent = $this->User_GetUserCurrent();
    }

    /**
     * Регистрируем евенты
     *
     */
    protected function RegisterEvent()
    {
	    $this->AddEvent('pressreleases', 'PressReleases');
        $this->AddEventPreg('/^[\w\-\_]*$/i', 'EventShowPage');
    }

    /**
     * Обработка детального вывода страницы
     */
    protected function EventShowPage()
    {
        /**
         * Составляем полный URL страницы для поиска по нему в БД
         */
	    $sUrlFull = trim(join('/', array_merge(array(Router::GetAction(), Router::GetActionEvent()), $this->GetParams())), '/');
	    /**
         * Ищем страничку в БД
         */
        if (!($oPage = $this->PluginPage_Main_GetPageByFilter(array('url_full' => $sUrlFull, 'active' => 1)))) {
            return $this->EventNotFound();
        }
        /**
         * Заполняем HTML теги и SEO
         */
        $this->Viewer_AddHtmlTitle($oPage->getTitle());
        if ($oPage->getSeoKeywords()) {
            $this->Viewer_SetHtmlKeywords($oPage->getSeoKeywords());
        }
        if ($oPage->getSeoDescription()) {
            $this->Viewer_SetHtmlDescription($oPage->getSeoDescription());
        }

        $this->Viewer_Assign('oPage', $oPage);
        $this->Viewer_Assign('sMenuHeadItemSelect', 'page_' . $oPage->getUrl());
//        /**
//         * Добавляем блок
//         */
//        if (Config::Get('plugin.page.show_block_structure')) {
//            $this->Viewer_AddBlock('right', 'structure',
//                array('plugin' => Plugin::GetPluginCode($this), 'current_page' => $oPage));
//        }
	    /**
	     * Под страницы
	     */
	    if ($oPage->getPid() > 0) {
		    $this->Viewer_Assign('aPageChild', $this->PluginPage_Main_GetPageItemsByPid($oPage->getPid()));
	    }
	    /**
	     * press
	     */
	    if ($sUrlFull == 'press') {
		   $aPress = $this->PluginPage_Main_GetPageItemsByFilter(array(
			    '#order' => array('t.date_add' => 'desc'),
			    '#limit' => 2,
			    '#where' => array('pid = ?d' => array(8)),
//			    '#where' => array('t.date_add > ? AND t.date_add < ? AND pid = ?d' => array(date("Y-m-01 00:00:00"), date('Y-m-t 23:59:59'), 8)),
			    'active' => 1
		    ));
		    $this->Viewer_Assign('aPress', $aPress);
	    }
	    /**
         * Устанавливаем шаблон для вывода
         */
        $this->SetTemplateAction('view');
    }

	public function PressReleases()
	{
		$aPress = $this->PluginPage_Main_GetPageItemsByFilter(array(
			'#order' => array('t.date_add' => 'desc'),
			'#where' => array('pid = ?d' => array(8)),
//			    '#where' => array('t.date_add > ? AND t.date_add < ? AND pid = ?d' => array(date("Y-m-01 00:00:00"), date('Y-m-t 23:59:59'), 8)),
			'active' => 1
		));
		$this->Viewer_Assign('aPress', $aPress);
		$this->Viewer_Assign('oPage', Engine::GetEntity('PluginPage_Main_Page', array('pid' => 8)));
		$this->SetTemplateAction('archive');
	}
}