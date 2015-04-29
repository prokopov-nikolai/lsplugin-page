{**
 * Отображение страницы
 *}

{extends file='layouts/layout.base.tpl'}

{block name='layout_options' prepend}
	{$layoutNoSidebar = !Config::Get('plugin.page.show_block_structure')}
	{include 'blocks.tpl' group='right' assign=layoutSidebarBlocks}
{/block}

{block name='layout_page_title'}
	{$oPage->getTitle()|escape}
{/block}

{block name='layout_content'}
	{if $oPage->getUrl() == 'press'}
		<h2>Пресс-центр</h2>
		<div id ="content">
		<div class="content-part release">
			<h3>Пресс-релизы</h3>

			<ul>
				{foreach $aPress as $oPP}
					<li class="release">
						<h4><a href="{$oPP->getFileWevPath()}">{$oPP->getTitle()}</a></h4>
						<span class="date">{date_format date=$oPP->getDateAdd() format='d/m/Y'}</span>
						{$oPP->getText()}
					</li>
				{/foreach}
			</ul>
			<a class="archive" href="/press/pressreleases/">Архив пресс-релизов</a>
		</div>
	{/if}
	{if !$oPage->getAutoBr() or Config::Get('view.wysiwyg')}
		{$oPage->getText()}
	{else}
		{$oPage->getText()|nl2br}
	{/if}
	{if $oPage->getUrl() == 'press'}</div>{/if}

	{if $oUserCurrent and $oUserCurrent->isAdministrator()}
		<br />
		<a href="{$oPage->getAdminEditWebUrl()}">Редактировать</a>
	{/if}
{/block}