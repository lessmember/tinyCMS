<form method="post" action="/<?=$action?>">
	<div><input type="text" name="title" placeholder="title" value="<?=(isset($formData['title'])? $formData['title'] : '')?>" />
		* <span class="input-info">Title of node</span>
		<span class="warning"><?=(isset($warnings['title'])? $warnings['title'] : '')?></span>
	</div>
	<div><input type="text" name="url_name" placeholder="Url name" value="<?=(isset($formData['url_name'])? $formData['url_name'] : '')?>" />
		* <span class="input-info">Url name (alphanumeric and '-_' characters)</span>
		<span class="warning"><?=(isset($warnings['url_name'])? $warnings['url_name'] : '')?></span>
	</div>
	<div>
		<select id="parent-list">
			<?foreach($sections as $sec):?>
			<option value="<?=$sec->id?>"  <?=($sec->id == $formData['parent'] ? 'selected=selected' : '')?>>
				<?=str_repeat('- ', $sec->deep)?><?=$sec->title?>
			<?endforeach?>		</select>
	</div>
	<div>
		<textarea name="content"><?=(isset($formData['content'])? $formData['content'] : '')?></textarea>
	</div>
	<input type="hidden" name="id" value="<?=$formData['id']?>" />
	<input type="submit" value="Save">
</form>
<script type="text/javascript">
	$(window).load(function(){
		$('select#parent-list').change(function(){$(this).attr('name', 'parent')})
	})
</script>