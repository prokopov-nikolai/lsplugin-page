{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_options'}
	{$sMenuSelect = 'page'}
{/block}

{block name='layout_content'}
	{**
	 * Добавление/редактирование страницы
	 *
	 * @param array $oPage Объект редактируемой страницы
	 *}



	<h3 class="page-sub-header">
		{if $oPage}
			Редактирование страницы
		{else}
			Добавление страницы
		{/if}
	</h3>

	<form id="form-page-create" enctype="multipart/form-data" action="" method="post" onsubmit="{if $oPage}ls.plugin.page.admin.updatePage('form-page-create');{else}ls.plugin.page.admin.createPage('form-page-create');{/if} return false;">


		{$aCategoriesList[] = [
			'value' => '',
			'text' => ''
		]}
		{foreach $aPageItems as $aPageItem}
			{$aCategoriesList[] = [
				'text' => ''|str_pad:(2*$aPageItem.level):'-'|cat:$aPageItem['entity']->getTitle(),
				'value' => $aPageItem['entity']->getId()
			]}
		{/foreach}
		{component 'field' template='select'
			name    = 'page[pid]'
			label   = 'Вложить в'
			classes = 'width-200'
			items   = $aCategoriesList
			selectedValue= ($oPage) ? $oPage->getPid() : '' }



		{component 'field' template='text'
				 name  = 'page[title]'
				 value = (($oPage) ? $oPage->getTitle() : '')|escape
				 label = 'Название'}


		{component 'field' template='text'
				name  = 'page[url]'
				value = ($oPage) ? $oPage->getUrl() : ''
				label = 'URL'}


		{*{component 'field' template='textarea'*}
				{*name    = 'page[text]'*}
				{*value   = (($oPage) ? $oPage->getText() : '')|escape*}
				{*label   = 'Текст'*}
				{*rows    = 20}*}


		{component 'editor'
				set             = 'light'
				mediaTargetType = 'topic'
				name            = 'page[text]'
				rules           = [ 'required' => true, 'length' => '[10,5000]' ]
				inputClasses    = 'js-editor-default'
				label           = 'Текст'
				value           = (($oPage) ? $oPage->getText() : '')|escape}

		{component 'field' template='text'
				name  = 'page[seo_keywords]'
				value = (($oPage) ? $oPage->getSeoKeywords() : '')|escape
				label = 'SEO Keywords'}


		{component 'field' template='text'
				name  = 'page[seo_description]'
				value = (($oPage) ? $oPage->getSeoDescription() : '')|escape
				label = 'SEO Description'}


		{component 'field' template='text'
				name  = 'page[sort]'
				value = ($oPage) ? $oPage->getSort() : ''
				label = 'Сортировка'}

		{component 'field' template='file'
				name  = 'file'
				label = "Файл <span id='page_file_path'>{$oPage->getFile()}</span>"}

		{component 'field' template='checkbox'
				name  = 'page[auto_br]'
				checked = ($oPage) ? $oPage->getAutoBr() : 0
				label = 'Делать автопереносы строк'}


		{component 'field' template='checkbox'
				name  = 'page[active]'
				checked = ($oPage) ? $oPage->getActive() : 0
				label = 'Показывать'}


		{component 'field' template='checkbox'
				name  = 'page[main]'
				checked = ($oPage) ? $oPage->getMain() : 0
				label = 'Выводить на главную'}

		<br/>

		{* Кнпоки *}
		{if $oPage}
			{component 'field' template='hidden' name='page[id]' value=$oPage->getId()}
			{component 'button'
					 name  = 'page[submit]'
					 mods = 'primary'
					 text  = 'Сохранить'}
		{else}
			{component 'button'
					 name  = 'page[submit]'
					 mods = 'primary'
					 text  = 'Добавить'}
		{/if}
	</form>
{/block}
