<form method="post" action="/<?=$action?>">
	<div><input type="text" name="title" placeholder="title" value="<?=(isset($formData['title'])? $formData['title'] : '')?>" />
		* <span class="input-info">Title of node</span>
		<span class="warning"><?=(isset($warnings['login'])? $warnings['login'] : '')?></span>
	</div>
	<div><input type="text" name="url_name" placeholder="Url name" value="<?=(isset($formData['url_name'])? $formData['url_name'] : '')?>" />
		* <span class="input-info">Url name (alphanumeric and '-_' characters)</span>
		<span class="warning"><?=(isset($warnings['url_name'])? $warnings['url_name'] : '')?></span>
	</div>
</form>