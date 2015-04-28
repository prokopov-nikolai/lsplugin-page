{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_options'}
	{$sMenuSelect = 'page'}
{/block}

{block name='layout_content'}
	{**
	 * Список страниц
	 *
	 * @param array $aPageItems Список страниц
	 *}

	<h3 class="page-sub-header">Список страниц</h3>

	<a href="/{Config::Get('plugin.admin.url')}/page/create/" class="button button-primary">Добавить страницу</a>

	<br>
	<br>
	{if $aPageItems}
		<table class="table">
			<thead>
				<tr>
					<th>Название</th>
					<th>URL</th>
					<th>Активна</th>
					<th>На главной</th>
					<th class="ta-r">Действие</th>
				</tr>
			</thead>

			<tbody>
				{foreach $aPageItems as $aPageItem}
					{$oPageItem=$aPageItem.entity}
					<tr id="article-item-{$oPageItem->getId()}">
						<td>
							<i class="{if $aPageItem.level == 0}icon-folder-close{else}icon-file{/if}" style="margin-left: {$aPageItem.level*20}px;"></i>
							<a href="{$oPageItem->getWebUrl()}">{$oPageItem->getTitle()}</a>
						</td>
						<td>
							{$oPageItem->getUrlFull()}
						</td>
						<td>{($oPageItem->getActive()) ? 'да' : 'нет'}</td>
						<td>{($oPageItem->getMain()) ? 'да' : 'нет'}</td>
						<td class="ta-r">
							<a href="/{Config::Get('plugin.admin.url')}/page/update/{$oPageItem->getId()}/" class="icon-edit" title="Изменить"></a>
							<a href="#" class="icon-remove" onclick="if (confirm('Действительно удалить?')) { ls.plugin.page.admin.removePage({$oPageItem->getId()}); } return false;" title="Удалить"></a>
							<a href="/{Config::Get('plugin.admin.url')}/page/sort/up/{$oPageItem->getId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}" class="icon-arrow-up" title="Поднять вверх"></a>
							<a href="/{Config::Get('plugin.admin.url')}/page/sort/down/$oPageItem->getId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}" class="icon-arrow-down" title="Опустить вниз"></a>
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	{else}
		<h4>Список страниц пуст</h4>
	{/if}

	{component 'pagination' aPaging=$aPaging}
{/block}