<?php

class Login extends Controller{

	private $pregRules = array(
		'login' => '#^[\w]{3,12}$#',
		'password' => '#^[\w\!\.\,\+\=\-]+$#',
		'email' => '#^[\w\-\.]+@(?:[\w\-]+\.){1,3}[a-z]{2,4}$#'
	);

	function __construct(){
		parent::__construct();
		$this->regularPage();
	}

	function index(){
		$redirect = get('redirect');
	//	p( tpl::url('login', 'check', array('Vasya', 'Pupkin')));
		$this->form();
	}

	function form($msg = null){
	//	$ref = Core::context()->referer;
		$ref = get('redirect');
		/*if ($ref AND strpos($ref, Core::conf('host.name'))){
			Session::set('referer', $ref);
		}*/
		if($ref)
			Session::set('referer', urldecode($ref));
		Core::view('login/form', array(
			'action'	=> tpl::url('login', 'check', array()),
			'msg'		=> $msg
		))->render(1);
	//	p($_SESSION);
	}

	function check(){
		$login = post('login');
		$pass = post('pass');
		if(empty($login) OR empty($pass)){
			sleep(1);
			return $this->form('Empty login or password');
		}
		$model = Core::model('users');
		$data = $model->checkLoginPass($login, $pass);
		if(!$data){
			sleep(1);
			return $this->form('Invalid login or password');
		}

		$ref = Session::get('referer');
		Session::clear();

		// Init user instance in session
		Session::set('user', $data);
		setcookie('user_hash', $data->hash, time() + Core::conf('auth.cookie.period'), '/', Core::conf('host.name'));

		if(!$ref)
			$ref = tpl::fullUrl();
	//	p($_SESSION);
		return header('location: ' . $ref);
	}

	function regForm($data = null, $warnings=null){
		$formData = array();
		if($data){
			$formData = $data;
		}
		Core::view('login/reg.form', array('action' => tpl::url('login', 'regAction'),
			'formData' => $formData,
			'warnings'	=>	$warnings
		))->render(1);
	}

	function regAction(){
		$login = post('login');
		$pass = post('pass');
		$pass2 = post('pass2');
		$email = post('email');
		$valid = true;
		$formData = array(
			'login'	=> $login,
			'email'	=> $email
		);
		$formWarning = array();

		// check login
		if(!$login){
			$formWarning['login'] = 'Can not be empty';
			$valid = false;
		}
		if($login AND !preg_match($this->pregRules['login'], $login)){
			$formWarning['login'] = 'Not valid character set';
			$valid = false;
		}

		// check pass
		if(!$pass){
			$formWarning['pass'] = 'Can not be empty';
			$valid = false;
		}else if(strlen($pass) < 2){
			$formWarning['pass'] = 'Too short pass';
			$valid = false;
		} else if($pass AND $pass !== $pass2){
			$formWarning['pass2'] = 'Confirmation string not equal';
			$valid = false;
		} else if(!preg_match($this->pregRules['password'], $pass)){
			$formWarning['pass'] = 'Not valid character set';
			$valid = false;
		}

		// check email
		if($email AND !preg_match($this->pregRules['email'], $email)){
			$formWarning['email'] = 'Not valid character set';
			$valid = false;
		}

		$model = Core::model('users');

		if($login AND !$model->checkUnique('login', $login)){
			$formWarning['login'] = 'Same login already existed';
			$valid = false;
		}

		if($email AND !$model->checkUnique('email', $email)){
			$formWarning['email'] = 'Same email already was used';
			$valid = false;
		}

		if(!$valid){
			return $this->regForm($formData, $formWarning);
		}

		$useData = $model->add($login, $pass, $email);

		header("location: http://" . Core::conf('host.name') . '/' . tpl::url('login'));
	}

	function logout(){
		Session::close();
		setcookie('user_hash', 0, 0, '/', Core::conf('host.name'));
		header('location: ' . tpl::fullUrl('login'));
	}

}
