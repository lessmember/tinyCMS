<style>
	table.tax-list{
		border: 1px solid;
		padding:0;
		border-spacing: 0;
	}
	table.tax-list tr th {
		background-color: #e0e0e0;
	}
	table.tax-list tr:nth-child(even) td{
		background-color: #ffc;
	}
	table.tax-list tr:hover td{
		background-color: #fea;
	}
	table.tax-list tr td{
		border:0;
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
	.text-btn{
		border-color: #888;
	}
	.text-btn:hover{
		background-color: #f88;
	}
	.rounded-block{
		border: 1px solid #888;
		background-color: #f80;
		display: block;
		float: left;
		border-radius: 4px;
		width: 16px;
		height: 16px;
		margin-right: 2px;
	}
	#tax-denorm-mode{
		color: #88a;
		font-size: 0.8em;
	}
	.clear{
		clear:both;
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
	var taxOptimization = {
		init: function(){
			$('a#tax-denorm').click(function (){taxOptimization.run()});
		},
		run: function(){
			$('#tax-denorm-mode').html('applying');
			$.ajax({
				type: 'post',
				url:'<?=$denormSubUrl?>',
				dataType:'json',
				success: function(data){
					log(data); taxOptimization.done(data)
				},
				error: function(data){log('error'); log(data)}
			})
		},
		done: function(data){
			if(data && data.success && typeof(data.changed) != 'undefined'){
				$('#tax-denorm-mode').html('done, changed '+data.changed+' units');
			}
		}
	}
	$(window).load(function(){
		subPanel.init();
		taxOptimization.init();
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
		<td><div style="margin-left: <?=($sec->deep * 20)?>px; padding-left: 4px;"><div class="rounded-block"></div> <?=$sec->title?></div><div class="clear"></div></td>
		<td>
			<span class="text-btn add-sub-btn" id="add-sub-<?=$sec->id?>">+ add sub node</span>
			<?if($sec->id != 1):?>
			<span class="text-btn edit-btn" id="edit-<?=$sec->id?>">edit</span>
			<span class="text-btn del-btn" id="del-<?=$sec->id?>">- remove node</span>
			<?endif?>
		</td>
	</tr>
		<?endforeach?>
</table>

<div class="gui-panel">
	<a class="text-btn" id="tax-denorm" title="Speed optimization of treelike structure">Denormalize Taxonomy</a>
	<span id="tax-denorm-mode"></span>
</div>