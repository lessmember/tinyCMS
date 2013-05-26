<?php

class AdminPages  extends Admin_BaseController {

	function __construct(){
		parent::__construct();
	}

	function index(){
		return $this->listView();
	}


	function listView($parentId=1){
		$pmodel = Core::model('pages');
		$pdata = $pmodel->namesByParent($parentId, false);

		$tmodel = Core::model('taxonomy');
		$parent = $tmodel->infoById($parentId);
		$tlist = $tmodel->all();
		Core::extLib('TaxonomyTree');
		$tax = new TaxonomyTree($tlist);

		$content = Core::view('admin/pages/list', array(
			'uriActivate'		=> '/' . tpl::url(array('admin', 'pages'), 'activate', array('on')),
			'uriDeactivate'		=> '/' . tpl::url(array('admin', 'pages'), 'activate', array('off')),
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

	function view($id){
		print "view page $id";
	}

	function createForm($formData=null, $warnings=null){
		$parent = !$formData ? intval(get('parent')) : $formData['parent'];

		$formData = array();
		$content = Core::view('admin/pages/create.form', array(
			'action'	=>	tpl::url(array('admin', 'pages'), 'createRecord'),
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

	function createRecord(){
		$title = post('title');
		$urlName = post('url_name');
		$content = post('page_content');
		$parentId = intval(post('parent'));
		//check data
		$warnings = $this->pageValidation();
		$valid = empty($warnings);

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
		header('location: ' . tpl::fullUrl(array('admin', 'pages'), 'listView', array($parentId)));
	}

	private function pageValidation(){
		$title = post('title');
		$urlName = post('url_name');
		$warnings = array();
		if(!$title){
			$warnings['title'] = 'Empty name.';
		}else if($title AND !preg_match('#^[\w .,;:/()\#]+$#u', $title)){
			$warnings['title'] = 'Invalid character set.';
		}
		if(!$urlName){
			$warnings['url_name'] = 'Empty name.';
		}else if(!preg_match('#^[\w\-]+$#', $urlName)){
			$warnings['url_name'] = 'Invalid character set.';
		}
		return $warnings;
	}

	function editForm($formData=null, $warnings=null){
		$id = intval(get('id'));

		$model = Core::model('pages');
		$pageData = get_object_vars( $model->infoById($id));

		if($formData){
			$pageData = array_replace ($pageData, $formData);
		}

		$tmodel = Core::model('taxonomy');
		$tlist = $tmodel->all();
		Core::extLib('TaxonomyTree');
		$tax = new TaxonomyTree($tlist);

		$content = Core::view('admin/pages/edit.form', array(
			'action'	=>	tpl::url(array('admin', 'pages'), 'editRecord'),
			'formData'	=>	$pageData,
			'sections'	=> array_slice($tax->makeList(), 1),
			'warnings'	=> $warnings
		))->render();

		Core::view('admin/main',
			array(
				'title'		=> 'add page',
				'content'	=> $content
			))->render(1);

	}

	function editRecord(){
		$title = post('title');
		$urlName = post('url_name');
		$content = post('content');
		$id = intval(post('id'));

		$warnings = $this->pageValidation();
		$valid = empty($warnings);

		$formData = array(
			'title' => $title,
			'url_name' => $urlName,
			'content' => $content
		);
		if(!$valid){
			$formData['id']= $id;
			return $this->pageEditForm($formData, $warnings);
		}

		$parent = post('parent');
		if ($parent AND preg_match('#^\d+$#', $parent)){
			$formData['parent'] = intval($parent);
		}
		$model = Core::model('pages');
		$model->updateById(
			$formData
			, $id);
		$page = $model->infoById($id);
		header('location: ' . tpl::fullUrl(array('admin', 'pages'), 'listView', array($page->parent)));
	}

	function activate($act){
		$actVal = ($act == 'on');
		$id = post('id');
		$model = Core::model('pages');
		$updated = $model->activate($id, $actVal);
		return print json_encode(array('success' => true, 'updated' => $updated));
	}

	function remove($id){
		$model = Core::model('pages');
		$data = $model->infoById($id);
		$model->delById($id);
		return header('location:' . tpl::fullUrl('admin', 'pages', array($data->parent)));
	}
}