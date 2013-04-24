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
	</style>
	<script type="text/javascript" src="/media/scripts/jquery-1.9.1.min.js" ></script>
	<script type="text/javascript" src="/media/scripts/common.js" ></script>
</header>
<body>
<h3><?=$title?></h3>
<?=$content?>
</body>
</html>