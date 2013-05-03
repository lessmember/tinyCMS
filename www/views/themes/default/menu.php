<?foreach($units as $unit):?>
<a href="<?=(tpl::url('page', 'section', array($unit->url_name)))?>"><?=$unit->title?></a>
<?endforeach?>