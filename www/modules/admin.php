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
		$validActions = array('list','create', 'edit', 'view', 'denormalize');
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
		Core::extLib('TaxonomyTree');
		$fun = $this->methodName('taxonomy', $action, $step);
		$this->$fun();
	}

	private function taxonomyListView(){
		// root id=0
		$model = Core::model('taxonomy');
		$data = $model->all();
		$tax = new TaxonomyTree($data);
		//p($data);
		//print $model->html_table($data, "min-width: 600px;");
		$taxList = $tax->makeList();
		$shortMap = array();
		$mapKeys = array_flip(array('title','url_name'));
		foreach($data as $unit){
			$shortMap[$unit->id] = array_intersect_key(get_object_vars($unit), $mapKeys);
		}
		$codeList = Core::view('admin/taxonomy/list', array(
			'sections'		=> $tax->makeList(),
			'uriCreate'		=> '/' . tpl::url('admin', 'taxonomy', array('create', 'record')),
			'uriEdit'		=> '/' . tpl::url('admin', 'taxonomy', array('edit', 'record')),
			'denormSubUrl'	=> '/' . tpl::url('admin', 'taxonomy', array('denormalize', 'record')),
			'jsUnitData'	=> json_encode($shortMap)
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
		$parent = intval(post('id'));

		$valid = true;
		$warnings = array();
		// checking data
	/*	if(!$name){
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
		}*/
		$warnings = $this->taxonomyValidation($model);
		$valid = $valid AND empty($warnings);

		if(!$valid){
			return print json_encode(array('success'=> false, 'list' => $warnings));
		}

		$id = $model->add($name, $urlName, $parent);
		return print json_encode(array('success' => true, 'id' => $id));
	}

	private function taxonomyValidation($model){

		$name = post('name');
		$urlName = post('urlName');

		$warnings = array();
		// checking data
		if(!$name){
			$warnings['name'] = 'Empty name.';
		}else if($name AND !preg_match('#^[\w .,;:/()\#]+$#', $name)){
			$warnings['name'] = 'Invalid character set.';
		}
		if(!$urlName){
			$warnings['url-name'] = 'Empty name.';
		}else if(!preg_match('#^[\w\-]+$#', $urlName)){
			$warnings['url-name'] = 'Invalid character set.';
		}
		return $warnings;
	}

	private function taxonomyEditForm($formData, $warnings=null){
		return Core::view('admin/main', array(
			'content'	=> Core::view('admin/taxonomy/edit.form', array(
				'formData'	=> $formData,
				'warnings'	=> $warnings
			))->render()
		))->render(1);
	}

	private function taxonomyEditRecord(){
		$model = Core::model('taxonomy');
		$title = post('name');
		$urlName = post('urlName');
		$parent = intval(post('parent'));
		$id = intval(post('id'));

		$valid = preg_match('#^\d+$#', $id);
		if($parent){
			$valid = preg_match('#^\d+$#', $parent);
		}

		$warnings = $this->taxonomyValidation($model);
		$valid = $valid AND empty($warnings);

		//
		if(!$valid){
			return print json_encode(array('success' => false, 'warnings' => $warnings));
		}
		// save
		$saveData = array(
			'title'		=> $title,
			'url_name'	=> $urlName
		);
		if($parent){
			$saveData['parent']	= $parent;
		}
		$updated = $model->updateById($saveData, $id);
	//	p($updated);
		if($updated){
			return print json_encode(array('success' => true, 'updated' => $updated));
		}
	}

	private function taxonomyDenormalizeRecord(){
		$model = Core::model('taxonomy');
		$updated = $model->denormalize();
		$this->contentType('application/json');
		return print (json_encode(array('success'=>true, 'changed'	=> $updated)));
	}

	function page($action, $step='form'){
		if(!$this->validateAction($action, $step)){
			die('Incorrect action');
		}
		Core::extLib('TaxonomyTree');
		$fun = $this->methodName('page', $action, $step);
		$this->$fun();
	}

	function pages($parentId=null){
		if(!$parentId)
			$parentId = 1;

		$pmodel = Core::model('pages');
		$pdata = $pmodel->namesByParent($parentId);

		$tmodel = Core::model('taxonomy');
		$parent = $tmodel->infoById($parentId);
		$tlist = $tmodel->all();
		Core::extLib('TaxonomyTree');
		$tax = new TaxonomyTree($tlist);

		$content = Core::view('admin/pages/list', array(
			'pages'		=> $pdata,
			'sections'	=> $tax->makeList(),
			'current'		=> $parent
		))->render();

		Core::view('admin/main',
			array(
				'title'		=> 'pages',
				'content'	=> $content
			))->render(1);
	}

	private function pageCreateForm($formData=null, $warnings=null){
		$parent = !$formData ? intval(get('parent')) : $formData['parent'];

		$formData = array();
		$content = Core::view('admin/pages/create.form', array(
			'action'	=>	tpl::url('admin', 'page', array('create', 'record')),
			'parent'	=>	$parent,
			'formData'	=>	$formData,
			'warnings'	=> $warnings
		))->render();

		Core::view('admin/main',
			array(
				'title'		=> 'add page',
				'content'	=> $content
			))->render(1);
	}

	private function pageCreateRecord(){
		$title = post('title');
		$urlName = post('url_name');
		$content = post('page_content');
		$parentId = intval(post('parent'));
		//check data
		$warnings = array();
		$valid = true;

		if(!$title){
			$warnings['title'] = 'Empty name.';
			$valid = false;
		}else if($title AND !preg_match('#^[\w .,;:/()\#]+$#', $title)){
			$warnings['title'] = 'Invalid character set.';
			$valid = false;
		}
		if(!$urlName){
			$warnings['url_name'] = 'Empty name.';
			$valid = false;
		}else if(!preg_match('#^[\w\-]+$#', $urlName)){
			$warnings['url_name'] = 'Invalid character set.';
			$valid = false;
		}

		if(!$valid){
			$formData = array();
			foreach(array('title', 'url_name', 'page_content', 'parent') as $name){
				$formData[$name] = post($name);
			}
			return $this->pageCreateForm(
				$formData,
				$warnings
			);
		}
		$model = Core::model('pages');
		$model->add(array(
			'parent'	=>	$parentId,
			'title'		=> $title,
			'url_name'	=> $urlName,
			'content'	=> $content
		));
		header('location: ' . tpl::fullUrl('admin', 'pages', array($parentId)));
	}

	private function pageEditForm(){


	}

	private function pageEditRecord(){

		$model = Core::model('pages');
	}

	private function pagesDenormalizeRecord(){
		$model = Core::model('pages');
	}

	function users(){

	}

}