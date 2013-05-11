<?foreach($units as $unit):?>
<a href="<?=(tpl::url('page', 'section', array($unit->url_name)))?>"><?=ucfirst($unit->title)?></a>
<?endforeach?>