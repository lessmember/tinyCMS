<style type="text/css">
	.content-block{
		border: 1px solid #eee;
		border-radius: 5px;
		margin: 10px;
	}
	table#theme-list{

	}
	.warning-1{
		color: #f00;
	}
	form.upload input{
		width: 300px;
	}
</style>

<script type="text/javascript">
	var themesPanel = {
		existedThemes:<?=json_encode($simpleList)?>,
		themesMap: <?=json_encode($listMap)?>,
		init: function(){
			$('form#upload-unit').submit(function(){
				return themesPanel.checkUpload();
			});
			log(this.existedThemes)
			$('input.saved-chk').change(function(e){
				return themesPanel.addExisted(this);
			})
		},
		checkUpload: function(){
			var name = $('input[name="theme-name"]').val();
		//	log(name)
			if(! /^[a-zA-Z][a-zA-Z0-9\-\_]{2,15}$/.test(name)){
				this.alert("Incorrect name of theme! \n Use alphanumeric symbols, '-', '_'.\n First should be letter. ");
				return false;
			}
			if($.inArray(name, this.existedThemes) >= 0){
				log($.inArray(name, this.existedThemes))
				this.alert("Same theme already exists");
				return false;
			}
			var filename = $('input:file[name="zipped-theme"]',$('form#upload-unit')).val();
		//	log(filename)
			if(!filename){
				this.alert("File no selected");
				return false;
			}
		//	log('correct')
			return true;
		},
		addExisted: function(elemLnk){
			var elem = $(elemLnk);
			var elid = elem.attr('id'); // TODO: add theme to list
			if(! /^theme\-name\-.+/.test(elid)){
				return this.alert('incorrect name');
			}
			var name = elid.substr('theme-name-'.length);
			var stat = elem.is(':checked');
			this.sendChanges({name: name, stat: stat});
		},
		sendChanges: function(changes){
			$.ajax({
				type: "post",
				url: "<?=$saveUrl?>",
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
		alert: function(msg){
			alert(msg)
		}
	}
	$(window).load(function(){
		themesPanel.init();
	})
</script>

<div class="content-block">
<table id="theme-list">
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Actions</th>
	</tr>
	<?foreach($themes as $theme):?>
	<tr>
		<td><?=$theme->id?></td>
		<td><?=$theme->value?></td>
		<td>
			<input class="saved-chk" type="checkbox" <?=($theme->saved ? 'checked="checked" ' : '')?> id="theme-name-<?=$theme->value?>" />
			<?=(!$theme->saved ? '<span class="warning-1">New!</span>' : '')?>
		</td>
	</tr>
	<?endforeach?>
</table>
</div>

<div class="content-block">
	<div>You can upload your theme through form below.</div>
<form method="post" action="<?=$uploadUrl?>" class="upload" id="upload-unit" enctype="multipart/form-data">
	<div><input type="text" name="theme-name" placeholder="Name of Theme (alphanumeric)" /></div>
	<div><input type="file" name="zipped-theme" /></div>
	<div><input type="submit" value="Upload theme" /></div>
</form>
</div>