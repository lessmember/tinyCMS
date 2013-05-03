<?foreach($pages as $page):?>
	<a class="context-menu" href="/<?=(tpl::url('page', ($isSection? 'section' : 'content'), array($page->url_name)))?>"><?=$page->title?></a>
<?endforeach?>