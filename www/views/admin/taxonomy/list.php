<style>
	table.tax-list{
		border: 1px solid;
	}
	table.tax-list tr th {
		background-color: #e0e0e0;
	}
	table.tax-list tr:nth-child(even) td{
		background-color: #f8f8a0;
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
</style>

<script type="text/javascript">
	var subPanel = {
		parentId:0,
		ui:null,
		init: function(){
			this.ui = $('#add-sub-panel');
			$('button#send').click(function(){subPanel.send()});
			$('button#close').click(function(){subPanel.hide()});
			return this;
		},
		setParent: function(parent){
			this.parentId = parent;
			return this;
		},
		show: function(pos){
			$(this.ui).css({display:'block', left: pos.x+'px', top: pos.y+'px'});
			return this;
		},
		hide: function(){
			$(this.ui).css({display:'none'});
			return this;
		},
		send: function(){
			var name = $('input#sub-name').val();
			var urlName = $('input#sub-url-name').val();
			$.ajax({
				type: 'post',
				url: '<?=$addSubUrl?>',
				data: {
					name: name,
					urlName: urlName,
					parent: this.parentId
				},
				success: function(data){
					//log(data)
					if(data.success){
						document.location.reload();
					}
				},
				error: function(){},
				dataType:'json'
			})
		}
	}
	$(window).load(function(){
		subPanel.init();
		$('.edit-btn').click(function(){
			log('edit')
			var id = this.id.substr('edit-'.length);
			//log(id)
		});
		$('.add-sub-btn').click(function(e){
			var id = this.id.substr('add-sub-'.length);
			log('add sub: ' + id);
			log(e)
			var pos = {x :e.clientX + 100, y:e.clientY - 20}
			subPanel.setParent(id).show(pos);
		});
	})
</script>

<div id="add-sub-panel">
	<input type="text" id="sub-name" placeholder="name of node" />
	<input type="text" id="sub-url-name" placeholder="name of node" />
	<button id="send">send</button>
	<button id="close">close</button>
</div>

<table class="tax-list" style="min-width: 600px;" border="1" >
	<tr>
		<th>
			Name
		</th>
		<th>Actions</th>
	</tr>
	<?foreach($sections as $sec):?>
	<tr>
		<td><?=$sec->name?></td>
		<td>
			<span class="text-btn edit-btn" id="edit-<?=$sec->id?>">edit</span>
			<span class="text-btn add-sub-btn" id="add-sub-<?=$sec->id?>">add sub node</span>
			<span class="text-btn del-btn" id="del-<?=$sec->id?>">remove node</span>
		</td>
	</tr>
		<?endforeach?>
</table>