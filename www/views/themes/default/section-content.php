<?foreach($subSections as $unit):?>
<div class="section-head"><a href="<?=tpl::url('page','section',array($unit->url_name))?>"><?=$unit->title?></a></div>
<?endforeach?>

<?foreach($subPages as $unit):?>
<div class="page-head">
	<h4><a href="<?=tpl::url('page','content',array($unit->url_name))?>"><?=$unit->title?></a></h4>
	<div><?=substr(preg_replace('#<[^>]*>#', '', $unit->content), 0, 200)?> ...</div>
</div>
<?endforeach?>