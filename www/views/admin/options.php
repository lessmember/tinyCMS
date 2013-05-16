<style type="text/css">
	table.options{
		min-width: 800px;
		vertical-align: top;
		border-collapse: collapse;
		border: 1px solid #eee;
	}
</style>
<form method="post" action="/<?=$action?>">
	<table class="options">
		<tr>
			<td>Name</td>
			<td>Value</td>
		</tr>
	<?foreach($units as $unit):?>
	<tr>
		<td><?=$unit->name?></td>
		<td>
			<?if(isset($optValues[$unit->name])):?>
				<select name="<?=$unit->name?>">
					<?foreach($optValues[$unit->name] as $val):?>
					<option value="<?=$val?>" <?=($val == $unit->value ? 'selected=selected' : '')?> ><?=$val?></option>
					<?endforeach?>
				</select>
			<?else:?>
			<input type="text" name="<?=$unit->name?>" value="<?=$unit->value?>" />
			<?endif?>
		</td>
	</tr>
	<?endforeach?>
		<tr>
			<td></td>
			<td>
				<input type="submit" value="Save" />
			</td>
		</tr>
	</table>
</form>