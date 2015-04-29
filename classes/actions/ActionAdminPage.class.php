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
class PluginPage_ActionAdminPage extends PluginAdmin_ActionPlugin
{

    /**
     * Объект УРЛа админки, позволяет удобно получать УРЛы на страницы управления плагином
     */
    public $oAdminUrl;
    public $oUserCurrent;

    public function Init()
    {
	    parent::Init();

	    $this->Viewer_AppendScript(Plugin::GetWebPath(__CLASS__) . 'js/admin.js');

        $this->SetDefaultEvent('index');
	    $this->AppendBreadCrumb(20, 'Страницы', 'page');

	    /**
	     * ИМПОРТ ПРЕССРЕЛИЗОВ

	    set_time_limit(0);
	    $sContent = file_get_contents($this->Fs_GetPathServer('[relative]/123.html'));
	    preg_match_all('/<li class="release">(.*?)<\/li>/s', $sContent, $aM, PREG_SET_ORDER);
	    foreach($aM as $aData){
		    preg_match_all('/<a href="([^"]+).*?>(.*?)<\/a>(.*?)<span class="date">(\d\d.\d\d.\d\d\d\d)<\/span>(\n|\t|\r)+(.*)/s', $aData[1], $aP, PREG_SET_ORDER);
		    if (!$oPage = $this->PluginPage_Main_GetPageByTitle($aP[0][2])){
			    $oPage = Engine::GetEntity('PluginPage_Main_Page');
			    $oPage->setDateAdd(date('Y-m-d 12:00:00', strtotime($aP[0][4])));
			    $oPage->setTitle($aP[0][2]);
			    $oPage->setUrl($this->Text_Transliteration($aP[0][2]));
			    $oPage->setUrlFull('press/'.$this->Text_Transliteration($aP[0][2]));
			    $oPage->setText($aP[0][6]);
			    $oPage->setPid(8);
			    $oPage->setAutoBr(0);
			    $oPage->Add();
			    //Сохраняем файл
			    $sFilePathDest = 'http://www.waltdisney.ru'.$aP[0][1];
			    $sFileName = basename($sFilePathDest);
			    $sFileName = $oPage->getId().'_'.$sFileName;
			    $sDirDest = '/uploads/files/';
			    $this->Fs_SaveFileLocalSmart($sFilePathDest, $sDirDest, $sFileName, 0644);
			    $oPage->setFile('[relative]'.$sDirDest.$sFileName);
			    $oPage->Update();
		    }
	    }

	    prex('123');*/
    }

    /**
     * Регистрируем евенты
     *
     */
    protected function RegisterEvent()
    {
        /**
         * Для ajax регистрируем внешний обработчик
         */
        $this->RegisterEventExternal('Ajax', 'PluginPage_ActionAdmin_EventAjax');
        /**
         * Список страниц, создание и обновление
         */
        $this->AddEvent('index', 'EventIndex');
        $this->AddEvent('create', 'EventCreate');
        $this->AddEventPreg('/^update$/i', '/^\d{1,6}$/i', '/^$/i', 'EventUpdate');
        $this->AddEventPreg('/^sort$/i', '/^up|down$/i', '/^\d{1,6}$/i', '/^$/i', 'EventSort');
        /**
         * Ajax обработка
         */
        $this->AddEventPreg('/^ajax$/i', '/^page-create$/i', '/^$/i', 'Ajax::EventPageCreate');
        $this->AddEventPreg('/^ajax$/i', '/^page-update$/i', '/^$/i', 'Ajax::EventPageUpdate');
        $this->AddEventPreg('/^ajax$/i', '/^page-remove$/i', '/^$/i', 'Ajax::EventPageRemove');
    }

    /**
     *    Вывод списка страниц
     */
    protected function EventIndex()
    {
        /**
         * Получаем список страниц
         */
        $aPages = $this->PluginPage_Main_LoadTreeOfPage(array('#order' => array('sort' => 'desc')));
        $aPages = ModuleORM::buildTree($aPages);
        /**
         * Прогружаем переменные в шаблон
         */
        $this->Viewer_Assign('aPageItems', $aPages);
        /**
         * Устанавливаем шаблон вывода
         */
        $this->SetTemplateAction('index');
    }

    /**
     * Создание страницы. По факту только отображение шаблона, т.к. обработка идет на ajax
     */
    protected function EventCreate()
    {
	    /**
	     * Хлебные крошки
	     */
	    $this->AppendBreadCrumb(30, 'Создать');
	    /**
         * Получаем список страниц
         */
        $aPages = $this->PluginPage_Main_LoadTreeOfPage(array('#order' => array('sort' => 'desc')));
        $aPages = ModuleORM::buildTree($aPages);

        $this->Viewer_Assign('aPageItems', $aPages);
        $this->SetTemplateAction('create');
    }

    /**
     * Редактирование страницы
     */
    protected function EventUpdate()
    {
        /**
         * Проверяем страницу на существование
         */
        if (!($oPage = $this->PluginPage_Main_GetPageById($this->GetParam(0)))) {
            $this->Message_AddErrorSingle('Не удалось найти страницу', $this->Lang_Get('error'));
            return $this->EventError();
        }
	    /**
	     * Хлебные крошки
	     */
	    $this->AppendBreadCrumb(30, 'Редактирование: '.$oPage->getId());

        /**
         * Получаем список страниц
         */
        $aPages = $this->PluginPage_Main_LoadTreeOfPage(array('#order' => array('sort' => 'desc')));
        $aPages = ModuleORM::buildTree($aPages);

        $this->Viewer_Assign('aPageItems', $aPages);
        $this->Viewer_Assign("oPage", $oPage);
        $this->SetTemplateAction('create');
    }

    protected function EventSort()
    {
        $this->Security_ValidateSendForm();
        /**
         * Проверяем страницу на существование
         */
        if (!($oPage = $this->PluginPage_Main_GetPageById($this->GetParam(1)))) {
            $this->Message_AddErrorSingle('Не удалось найти страницу', $this->Lang_Get('error'));
            return $this->EventError();
        }

        $sWay = $this->GetParam(0);
        $iSortOld = $oPage->getSort();
        if ($oPagePrev = $this->PluginPage_Main_GetNextPageBySort($iSortOld, $oPage->getPid(), $sWay)) {
            $iSortNew = $oPagePrev->getSort();
            $oPagePrev->setSort($iSortOld);
            $oPagePrev->Update();
        } else {
            if ($sWay == 'down') {
                $iSortNew = $iSortOld - 1;
            } else {
                $iSortNew = $iSortOld + 1;
            }
        }
        /**
         * Меняем значения сортировки местами
         */
        $oPage->setSort($iSortNew);
        $oPage->Update();

        Router::Location($this->oAdminUrl->get());
    }
}