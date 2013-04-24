<?php

class Test1{
	function index(){
		Core::view('test/test1',array('msg' => 'testing, index'))->render(1);
	}

	function act1(){
		print Core::view('test/test1',array('msg' => 'testing, action 1'))->render();
	}

	function testdb(){
		$this->index();
		$model = Core::model('test');
		//p($model);
		$model->createTable();
		$model->fillTable();
		$model->find();
		$model->dropTable();
	}

	function user(){
		$model = Core::model('users');
		// make user
		$login = 'user'. time() . substr(md5(mt_rand()), 0, 4);
		$pass = '1111';
		$added = $model->add($login, $pass);
	//	var_dump($added	);
		// check user
		$tabStyle = "min-width: 800px; margin-top: 10px; border: 2px solid #800;";
		$userData = $model->checkLoginPass($login, $pass);
	//	var_dump($userData);
		print $model->html_table(array($userData), $tabStyle);
		// check user's hash: by server, by cookies
		$userData2 = $model->checkHash($added->hash);
	//	var_dump($userData2);
		print $model->html_table(($userData2), $tabStyle);
		// update user
		$model->change($added->id, array('email' => $login.'@mail.boo', 'is_moderator' => 1));

		$userData3 = $model->infoById($added->id);
		print $model->html_table($userData3, $tabStyle);

	}
}