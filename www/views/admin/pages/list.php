<style>
	table#skeleton tr td{
		vertical-align: top;;
	}
	table.page-list{
		border: 1px solid;
	}
	table.page-list tr th {
		background-color: #f0f0f0;
	}
	table.page-list tr:nth-child(even) td{
		background-color: #f0f8f0;
	}

	table.tax-list{
		border: 1px solid;
		border-spacing: 0;
		border-collapse: collapse;
	}
	table.tax-list tr th:nth-child(1),table.tax-list tr td:nth-child(1)  {
		width: 200px;
		padding:0;
		border-spacing: 0;
	}
	table.tax-list tr td:nth-child(1) a{
		text-decoration: none;
		display: block;
		width: 100%;
		height: 26px;
	}
	table.tax-list tr td a:hover{
		background-color: #fee;
	}
	table.tax-list tr th {
		background-color: #ffffff;
	}
	table.tax-list tr:nth-child(even) td{
		background-color: #f0f0f0;
	}

	div#add-sub-panel{
		position: absolute;
		background-color: #fff;
		border: 1px solid #eee;
		display: none;
		width: 400px;
		height: 150px;
	}
	div#add-sub-panel input[type="text"]{
		width: 350px;
		margin: 15px 25px 15px 25px;
	}
	div#add-sub-panel button{
		width: 100px;
		margin: 0 25px 0 25px;
	}
	table.tax-list tr.tax-current td{
		background-color: #fee;
	}
	table.tax-list tr.tax-current td:nth-child(1){
		font-weight: bold;
	}
	table.tax-list tr td:nth-child(1){
		border-spacing: 0;
	}
</style>

<script type="text/javascript">

</script>

<table id="skeleton">
	<tr>
		<td>
			<table class="tax-list" style="min-width: 300px;" border="1" >
				<tr>
					<th>
						Name
					</th>
					<th>Actions</th>
				</tr>
				<?foreach($sections as $sec):?>
				<tr  class="<?=($sec->id == $current->id ? 'tax-current' : '')?>">
					<td>
						<a href="/<?=(tpl::url('admin', 'pages', array($sec->id)))?>">
						<span style="margin-left: <?=($sec->deep * 20 + 4)?>px;" >
							|-<?=$sec->title?>
						</span>
						</a>
					</td>
					<td>
						<?if($sec->id != 1):?>
						<a class="text-btn edit-btn" href="/<?=(tpl::url('admin', 'page', array('create', 'form', 'parent' => $sec->id)))?>">add page</a>
						<a class="text-btn add-sub-btn" id="add-page-<?=$sec->id?>"><?=$sec->id?></a>
						<?endif?>
					</td>
				</tr>
				<?endforeach?>
			</table>
		</td>
		<td>
			<table class="page-list" style="min-width: 600px;" border="1" >
				<tr>
					<th>
						ID
					</th>
					<th>
						Name
					</th>
					<th>Actions</th>
				</tr>
				<?foreach($pages as $page):?>
				<tr>
					<td><?=$page->id?></td>
					<td><?=$page->title?></td>
					<td>
						<a class="text-btn edit-btn" href="/<?=(tpl::url('admin', 'page', array('edit', 'form')))?>" id="edit-<?=$page->id?>">edit</a>
						<a class="text-btn edit-btn" href="/<?=(tpl::url('admin', 'page', array('view')))?>" id="view-<?=$page->id?>">view</a>
						<a class="text-btn del-btn" id="del-<?=$page->id?>">delete</a>
					</td>
				</tr>
				<?endforeach?>
			</table>
		</td>
	</tr>
</table>