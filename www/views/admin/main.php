<!DOCTYPE html>
<html>
<header>
	<title>Admin: <?=$title?></title>
	<link rel="shortcut icon" href="/media/img/logo.ico" />
	<style type="text/css">
		form div{
			margin-top: 2px;
		}
		form div input {
			width: 180px;
			padding-left: 10px;
		}
		form span.warning{
			color: red;
		}
		.input-info{
			color: #888;
		}
		.text-btn{
			display: inline-block;
			padding: 1px 4px 1px 4px;
			text-align: center;
			min-width: 30px;
			border: 1px solid;
			cursor: pointer;
		}
		div#top-menu{
			background-color: #eee;
			display: table-cell;
			vertical-align: middle;
			padding-left: 5px;
			padding-right: 5px;
			height: 30px;
			border-radius: 5px;
		}
		div#top-menu a{
			color: #800;
			text-decoration: none;
			display: inline-block;
			padding: 1px 5px 1px 5px;
			margin: 2px 2px 2px 2px;
			border: 1px solid #f88;
			border-radius: 5px;
		}
		div#top-menu a:hover{
			background-color: #ecc;
		}
	</style>
	<script type="text/javascript" src="/media/scripts/jquery-1.9.1.min.js" ></script>
	<script type="text/javascript" src="/media/scripts/common.js" ></script>
</header>
<body>
<div id="top-menu">
	<a href="/<?=tpl::url('admin', 'taxonomy')?>">taxonomy</a>
	<a href="/<?=tpl::url('admin', 'pages')?>">pages</a>
	<a href="/<?=tpl::url('admin', 'users')?>">users</a>
</div>
<h3><?=$title?></h3>
<?=$content?>
</body>
</html>