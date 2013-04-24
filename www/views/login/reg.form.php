<!DOCTYPE html>
<html>
<header>
	<title>Tiny CMS: registration</title>
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
	</style>
</header>
<body>
<h3>Registration</h3>
<form method="post" action="/<?=$action?>">
	<div><input type="text" name="login" placeholder="Login" value="<?=(isset($formData['login'])? $formData['login'] : '')?>" />
		* <span class="input-info">Login</span>
		<span class="warning"><?=(isset($warnings['login'])? $warnings['login'] : '')?></span>
	</div>
	<div><input type="password" name="pass" placeholder="Password" value="<?=(isset($formData['pass'])? $formData['pass'] : '')?>" />
		* <span class="input-info">password</span>
		<span class="warning"><?=(isset($warnings['pass'])? $warnings['pass'] : '')?></span>
	</div>
	<div><input type="password" name="pass2" placeholder="Confirmation"  value="<?=(isset($formData['pass2'])? $formData['pass2'] : '')?>" />
		* <span class="input-info">pass confirmation</span>
		<span class="warning"><?=(isset($warnings['pass2'])? $warnings['pass2'] : '')?></span>
	</div>
	<div><input type="text" name="email" placeholder="Email"  value="<?=(isset($formData['email'])? $formData['email'] : '')?>" />
		<span class="input-info">email</span>
		<span class="warning"><?=(isset($warnings['email'])? $warnings['email'] : '')?></span>
	</div>
	<div><input type="submit" value="register" /></div>
</form>
<div style="margin: 10px; color: #88a;">* - necessary fields</div>
</body>
</html>