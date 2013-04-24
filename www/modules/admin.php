<?php

class Admin extends Controller {

	function __construct(){
		parent::__construct();
		$user = Session::get('user');
		if(!$user){
			return header('location: '. tpl::fullUrl('login','form',array('redirect' => Core::context()->uri)));
		}
		if(!$user->is_admin){
			die("You are not administrator");
		}
	}

	function index(){
		Core::view('admin/start')->render(1);
	}

	private function validateAction($action, $step){
		$validActions = array('list','create', 'edit', 'view');
		$validSteps = array('form','record', 'view');
		return (in_array($action, $validActions) AND in_array($step, $validSteps));
	}

	private function methodName($section, $action, $step){
		return $section . ucfirst($action) . ucfirst($step);
	}

	function taxonomy($action='list', $step=''){ //
		if($action == 'list')
			$step = 'view';
		if(!$this->validateAction($action, $step)){
			die('Incorrect action');
		}
		$fun = $this->methodName('taxonomy', $action, $step);
		$this->$fun();
	}

	private function taxonomyListView(){
		// root id=0
		$model = Core::model('taxonomy');
		$data = $model->all();
		//p($data);
		//print $model->html_table($data, "min-width: 600px;");
		$codeList = Core::view('admin/taxonomy/list', array(
			'sections' => $data,
			'addSubUrl'	=> '/' . tpl::url('admin', 'taxonomy', array('create', 'record'))
		))->render();
		Core::view('admin/main',
			array(
				'title'		=> 'taxonomy list',
				'content'	=> $codeList
			))->render(1);
	}

	private function taxonomyCreateForm(){

	}

	private function taxonomyCreateRecord(){
		$model = Core::model('taxonomy');
		$name = post('name');
		$urlName = post('urlName');
		$parent = intval(post('parent'));

		$valid = true;
		$warnings = array();
		// checking data
		if(!$name){
			$warnings['name'] = 'Empty name.';
			$valid = false;
		}else if($name AND !preg_match('#^[\w .,;:/()\#]+$#', $name)){
			$warnings['name'] = 'Invalid character set.';
			$valid = false;
		}
		if(!$urlName){
			$warnings['url-name'] = 'Empty name.';
			$valid = false;
		}else if(!preg_match('#^[\w\-]+$#', $urlName)){
			$warnings['url-name'] = 'Invalid character set.';
			$valid = false;
		}

		if(!$valid){
			return print json_encode(array('success'=> false, 'list' => $warnings));
		}

		$id = $model->add($name, $urlName, $parent);
		return print json_encode(array('success' => true, 'id' => $id));
	}

	private function taxonomyEditForm(){

	}

	private function taxonomyEditRecord(){
		$model = Core::model('taxonomy');}


	function page($action, $step='form'){
		if(!$this->validateAction($action, $step)){
			die('Incorrect action');
		}
		$fun = $this->methodName('taxonomy', $action, $step);
	}

	function pages($parentId=null){
		if(!$parentId)
			$parentId = 1;

		$pmodel = Core::model('pages');
		$pdata = $pmodel->byParent($parentId);

		$tmodel = Core::model('taxonomy');
		$parent = $tmodel->infoById($parentId);
		$tlist = $tmodel->all();

		$content = Core::view('admin/pages/list', array(
			'pages'		=> $pdata,
			'sections'	=> $tlist,
			'current'		=> $parent
		))->render();

		Core::view('admin/main',
			array(
				'title'		=> 'pages',
				'content'	=> $content
			))->render(1);
	}

	private function pageCreateForm(){

	}

	private function pageCreateRecord(){

		$model = Core::model('pages');
	}

	private function pageEditForm(){


	}

	private function pageEditRecord(){

		$model = Core::model('pages');
	}

	function users(){

	}

}