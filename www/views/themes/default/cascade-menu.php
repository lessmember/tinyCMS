<a href="<?=(tpl::fullUrl())?>"><?=$mainTitle?></a> /
<?foreach($units as $unit):?>
	<?if($unit->id == 1) continue;?>
<a href="<?=(tpl::url('page', 'section', array($unit->url_name)))?>"><?=$unit->title?></a> /
<?endforeach?>