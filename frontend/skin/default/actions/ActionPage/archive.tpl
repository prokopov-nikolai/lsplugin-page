{**
 * Отображение страницы
 *}

{extends file='layouts/layout.base.tpl'}

{block name='layout_options' prepend}
	{$layoutNoSidebar = !Config::Get('plugin.page.show_block_structure')}
	{include 'blocks.tpl' group='right' assign=layoutSidebarBlocks}
	{$classes = 'archive'}
{/block}

{block name='layout_page_title'}
	{$oPage->getTitle()|escape}
{/block}

{block name='layout_content'}
	<h2>Пресс-центр</h2>

	<div id="content">
		<div class="release">
			<h3>Архив пресс-релизов за <span></span> года</h3>
			{$sMonth = ''}
			{foreach $aPress as $oPP}
				{if $sMonth != $oPP->getDateAdd()|date_format:'%Y%m'}
					{$sMonth = $oPP->getDateAdd()|date_format:'%Y%m'}
					{if $oPP@first}
						<ul class="{$sMonth} opened">
					{else}
						</ul>
						<ul class="{$sMonth}">
					{/if}
				{/if}
				<li class="release">

					<h4><a href="{$oPP->getFileWebPath()}" target="_blank">{$oPP->getTitle()}</a></h4>
					<span class="date">{$oPP->getDateAdd()|date_format:'%d.%m.%Y'}</span>
					{$oPP->getText()}
				</li>
			{/foreach}
			</ul>
			<p class="back"><a href="/press/">назад</a></p>
		</div>
	</div>
{/block}