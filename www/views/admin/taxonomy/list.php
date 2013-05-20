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
		min-height: 150px;
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
		display: block;
		float: left;
		border-radius: 4px;
		width: 16px;
		height: 16px;
		margin-right: 2px;
	}
	.act-icon{
		background-color: #f80;
	}
	.deact-icon{
		background-color: #eee;
	}
	#tax-denorm-mode{
		color: #88a;
		font-size: 0.8em;
	}
	.clear{
		clear:both;
	}
	#sub-panel-warning{
		color: red;
		margin: 1px 10px 1px 10px;
	}
</style>

<script type="text/javascript">
	var subPanel = {
		parentId:0,
		currentId:0,
		actionType:null,
		ui:null,
		uriPull:{
			createRecord:	'<?=$uriCreate?>',
			editRecord:		'<?=$uriEdit?>',
			activate:		'<?=$uriActivate?>',
			deactivate:		'<?=$uriDeactivate?>'
		},
		unitData:{},
		initUI: function(){
			this.ui = $('#add-sub-panel');
			$('.edit-btn').click(function(e){
				var id = this.id.substr('edit-'.length);
				log('edit, id = '+id)
				var pos = {x :e.clientX + 100, y:e.clientY - 20}
				subPanel.initEdit(id).show(pos);
			});
			$('.add-sub-btn').click(function(e){
				var id = this.id.substr('add-sub-'.length);
				log('add sub: ' + id);
				log(e)
				var pos = {x :e.clientX + 100, y:e.clientY - 20}
				subPanel.initCreate(id).show(pos);
			});
			$('.act-btn').click(function(){
				var id = this.id.substr('active-'.length);
				subPanel.activate(id, 'deactivate');
			});
			$('.deact-btn').click(function(){
				var id = this.id.substr('active-'.length);
				subPanel.activate(id, 'activate');
			});

			$('button#send').click(function(){subPanel.send()});
			$('button#close').click(function(){subPanel.hide()});
			return this;
		},
		initData: function(data){
			this.unitData = data;
		},
		initCreate: function(id){
			this.currentId = id;
			this.actionType = 'createRecord';
			$('input#sub-name').val('');
			$('input#sub-url-name').val('');
			return this;
		},
		initEdit: function(id){
			this.currentId = id;
			this.actionType = 'editRecord';
			var unit = this.unitData[id];
			// error check,
			// TODO: doing something
			if(!unit)
				return;
			$('input#sub-name').val(unit.title);
			$('input#sub-url-name').val(unit.url_name);
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
		activate: function(id, act){
			log(id)
			$.ajax({
				type: 'post',
				url: this.uriPull[act],
				data: {
					id: id
				},
				success: function(data){
					//log(data)
					if(data.success && data.updated){
						document.location.reload();
					} else {
					}
				},
				error: function(){},
				dataType:'json'
			})
		},
		send: function(){
			var name = $('input#sub-name').val();
			var urlName = $('input#sub-url-name').val();
			log(this.uriPull[this.actionType])
			$.ajax({
				type: 'post',
				url: this.uriPull[this.actionType],
				data: {
					name: name,
					urlName: urlName,
					id: this.currentId
				},
				success: function(data){
					log(data)
					if(data.success){
						document.location.reload();
					} else {
						var msg = 'unknown error';
						if(data.warnings !== undefined){
							log(data.warnings)
							msg = '';
							$.each(data.warnings, function(x, y){msg += x + ':' + y + '<br>'})
						}
						subPanel.error(msg);
					}
				},
				error: function(){
					subPanel.error('request error');
				},
				dataType:'json'
			})
		},
		error: function(msg){
		//	log('error')
			$('#sub-panel-warning').html(msg);
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
		subPanel.initUI();
		subPanel.initData(<?=$jsUnitData?>);
		taxOptimization.init();
	})
</script>

<div id="add-sub-panel">
	<input type="text" id="sub-name" placeholder="name of node" />
	<input type="text" id="sub-url-name" placeholder="url name" />
	<button id="send">send</button>
	<button id="close">close</button>
	<div id="sub-panel-warning"></div>
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
		<td>
			<div style="margin-left: <?=($sec->deep * 20)?>px; padding-left: 4px;">
			<div class="rounded-block <?=($sec->active ? '' : 'de')?>act-icon"></div> <?=$sec->title?></div><div class="clear"></div>
		</td>
		<td>
			<span class="text-btn add-sub-btn" id="add-sub-<?=$sec->id?>">+ add sub node</span>
			<?if($sec->id != 1):?>
			<span class="text-btn edit-btn" id="edit-<?=$sec->id?>">edit</span>
			<span class="text-btn del-btn" id="del-<?=$sec->id?>">- remove</span>
			<span class="text-btn <?=($sec->active ? '' : 'de')?>act-btn"
				  id="active-<?=$sec->id?>"><?=($sec->active ? 'de' : '')?>activate</span>
			<?endif?>
		</td>
	</tr>
		<?endforeach?>
</table>

<div class="gui-panel">
	<a class="text-btn" id="tax-denorm" title="Speed optimization of treelike structure">Denormalize Taxonomy</a>
	<span id="tax-denorm-mode"></span>
</div>