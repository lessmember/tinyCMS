<style type="text/css">
	a.pagination{
		color: #44a;
		border-color: #44a;
	}
	a.pagination:hover{
		color: #a44;
		border-color: #a44;
		background-color: #fee;
	}
</style>

<script type="text/javascript">
var usersApp = {
	listPage: <?=$currentPage?>,
	init: function(){
		$('.banned-btn').change(function(e){
		//	var id = userApp.getId('banned-btn-');
			usersApp.bane(this);
		});
		$('.edit-btn').change(function(e){

		});
		$('.del-btn').change(function(e){});
		<? // TODO: edit login, email; reset pass?; edit role;  ?>
	},
	getId: function(elem, prefix){
		return elem.parentNode.parentNode.id.substr('list-row-'.length);
	},
	bane: function(elem){
		var id = usersApp.getId(elem, 'banned-btn-');
		var action = $(elem).is(':checked');
	//	log(action)
		log(id)
		this.changeData(id, {banned: action})
	},
	changeData: function(id, data){
		data.target_id = id;
		this.sendChanges(data);
	},
	sendChanges: function(changes){
		$.ajax({
			type: "post",
			url: "<?=$changeUrl?>",
			data: changes,
			dataType: "json",
			success: function(data){
				log('success')
				log(data)
			},
			error: function(data){
				log(data)
			}
		});
	},
	changeSaved: function(){},
	saveError: function(){}
}
$(window).load(function(){
	usersApp.init()
});
</script>

<div>
	<table class="user-list">
		<tr>
			<th>ID</th>
			<th>Login</th>
			<th>Email</th>
			<th>Role</th>
			<th>Banned</th>
			<th>Actions</th>
		</tr>
		<?foreach($users as $user):?>
		<tr id="list-row-<?=$user->id?>">
			<td><?=$user->id?></td>
			<td><?=$user->login?></td>
			<td><?=$user->email?></td>
			<td>
				<?=$user->highestRole?>
			</td>
			<td><input type="checkbox" id="banned-btn-<?=$user->id?>" class="banned-btn" <?=($user->banned ? ' checked="checked" ' : '')?> /></td>
			<td>
				<a class="text-btn edit-btn" id="edit-btn-<?=$user->id?>">edit</a>
				<a class="text-btn del-btn" id="del-btn-<?=$user->id?>">remove</a>
			</td>
		</tr>
		<?endforeach?>
		<tr>
			<td colspan="6">
				<table>
					<tr>
						<?for($p=1; $p < $maxPage ; ++$p):?>
							<?if($p != $currentPage):?>
							<a class="pagination text-btn-tiny" href="<?=('/' . tpl::url(array('admin', 'users'), 'listView', array($p)))?>"><?=$p?></a>
							<?else:?>
							<span class="text-btn-tiny" ><?=$p?></span>
							<?endif?>
						<?endfor?>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>