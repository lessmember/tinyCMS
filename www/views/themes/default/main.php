<!DOCTYPE html>
<html>
<header>
	<title><?=$title?></title>
	<link rel="shortcut icon" href="/media/img/logo.ico" />
	<script type="text/javascript" src="/media/scripts/jquery-1.9.1.min.js" ></script>
	<script type="text/javascript" src="/media/scripts/common.js" ></script>
	<style type="text/css">
	td.context-menu a{
		display:block;
		width: 192px;
		border: 1px solid #f88;
		background-color: #fee;
		border-radius: 4px;
		color: #800;
		height: 25px;
		line-height: 24px;;
		margin: 2px;
		text-decoration: none;
		text-align: left;
		padding-left: 5px;

	}
	td.context-menu a:hover{
		background-color: #eaa;
	}
	td.content{
		padding: 10px;
	}
	.bott-stat{
		font-size: 0.7em;
		color: #888;
	}
	.content-container{
		font-size: 0.9em;
		color: #444;
	}
	</style>
</header>
<body>
<div id="top-menu">
	<?=$topMenu?>
</div>
<div><a href="/<?(tpl::url('login'))?>"></a></div>
<div id="cascade-menu">
	<?=$cascadeMenu?>
</div>
<h3><?=$title?></h3>

<table style="width: 100%">
	<tr>
		<td style="border:1px solid #eee; width: 200px;" class="context-menu"><?=$contextMenu?></td>
		<td style="border:1px solid #eee;" class="content"><?=$content?></td>
	</tr>
</table>
<div class="bott-stat">
	<?$this->print_val('stat')?>
</div>
<div class="bott-stat">control time(sec) = <?=( round(10000*(microtime(true) - GLOBAL_LOG_TIME_START))/10000 )?></div>
</body>
</html>