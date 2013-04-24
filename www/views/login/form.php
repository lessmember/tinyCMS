<!DOCTYPE html>
<html>
<header>
	<title>Tiny CMS</title>
	<link rel="shortcut icon" href="/media/img/logo.ico" />

	<style type="text/css">
		form div{
			margin-top: 2px;
		}
		form div input {
			width: 200px;
		}
		.warning{
			color: red;
		}
	</style>

</header>
<body>
<?if($msg):?>
	<div class="warning"><?=$msg?></div>
<?endif?>
<form method="post" action="/<?=$action?>">
	<div><input type="text" name="login" /> login</div>
	<div><input type="password" name="pass" /> password</div>
	<div><input type="submit" value="login" /></div>
	</form>
</body>
</html>