<table>
	<?foreach($list as $unit):?>
	<tr>
		<td>
			<div style="margin-left: <?=($unit->deep * 20)?>px">
			|-"<?=$unit->name?>" id=<?=$unit->id?> par=<?=$unit->parent?>
			</div>
		</td>
	</tr>
	<?endforeach;?>
</table>