<?foreach($pages as $page):?>
	<a class="context-menu" href="/<?=(tpl::url('page', 'content', array($page->url_name)))?>"><?=$page->title?></a>
<?endforeach?>