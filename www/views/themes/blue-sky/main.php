<!DOCTYPE html>
<html>
<header>
	<title><?=$title?></title>
	<link rel="shortcut icon" href="/media/img/logo.ico" />
	<script type="text/javascript" src="/media/scripts/jquery-1.9.1.min.js" ></script>
	<script type="text/javascript" src="/media/scripts/common.js" ></script>
	<style type="text/css">
		html,body{
			margin:0;
			padding:0;
		}
		.head{
			background-color: #eff;
			color: #024;
			font-size: 20px;
			font-family: Arial;
		}
		.top-menu{
			padding:0;
		}
		.top-menu a{
			display: inline-block;
			border: 1px solid #48e;
			background-color: #def;
			color: #228;
			text-decoration: none;
			margin-left: 4px;
			padding:0px 4px 0px 4px;
		}
		.top-menu a:hover{
			background-color: #eef;
		}
		table.page-frame tr td{
			vertical-align: top;
		}
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
		td.context-menu a.menu-cur{
			background-color: #eee;
			border-color: #aaa;
			color: #444;
		}
		.cascade-menu{
			color: #a44;
		}
		.cascade-menu a{
			text-decoration: none;
			color: #a00;
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
		.page-head{
			margin: 4px 2px 0px 2px;
			border: 1px solid #eee;
			padding: 4px;
			border-radius: 5px;
		}
		.page-head h4 a{
			color: #008;
			text-decoration: none;
		}
		.section-head{
			margin: 4px 2px 0px 2px;
			border: 1px solid #eee;
			padding: 4px;
			border-radius: 5px;
		}
		.section-head a{
			color: #622;
			text-decoration: none;
			font-size: 1.2em;
		}
	</style>
</header>
<body>
<div class="head"><?=$projectTitle?></div>
<div class="top-menu">
	<?=$topMenu?>
</div>
<div><a href="/<?(tpl::url('login'))?>"></a></div>
<div class="cascade-menu">
	<?=$cascadeMenu?>
</div>
<h3><?=$title?></h3>

<table class="page-frame" style="width: 100%">
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