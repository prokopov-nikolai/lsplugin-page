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






				<li class="release">
					<h4><a href="/press/pressreleases/cms_res/MARVEL_Avengers_Age_of_Ultron.doc">Блокбастер «Мстители: Эра Альтрона» поставил рекорд по кассовым сборам для фильмов Disney и MARVEL в российском прокате</a></h4>
					<span class="date">28/04/2015</span>
					Сборы блокбастера MARVEL «Мстители: Эра Альтрона» за первые четыре дня проката в России составили более 850 миллионов рублей (более 16,4 млн долларов США).
				</li>





				<li class="release">
					<h4><a href="/press/pressreleases/cms_res/MARVEL_PressRelease_products.doc">MARVEL представляет широкую коллекцию товаров, вдохновленных супергероями</a></h4>
					<span class="date">20/04/2015</span>
					<p>В преддверии долгожданной премьеры блокбастера MARVEL «Мстители: Эра Альтрона» в магазинах по всей стране можно будет найти широкий ассортимент товаров, посвященных легендарной команде Мстителей, а также другим супергероям!</p>
				</li>

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