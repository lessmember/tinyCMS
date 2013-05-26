<?php

class AdminTaxonomy  extends Admin_BaseController {

	function __construct(){
		parent::__construct();
		Core::extLib('TaxonomyTree');
	}

	function index(){
		return $this->listView();
	}

	private function listView(){
		// root id=0
		$model = Core::model('taxonomy');
		$data = $model->all();
		$tax = new TaxonomyTree($data);
		$shortMap = array();
		$mapKeys = array_flip(array('title','url_name'));
		foreach($data as $unit){
			$shortMap[$unit->id] = array_intersect_key(get_object_vars($unit), $mapKeys);
		}
		$codeList = Core::view('admin/taxonomy/list', array(
			'sections'		=> $tax->makeList(),
			'uriCreate'		=> '/' . tpl::url(array('admin', 'taxonomy'), 'createRecord'),
			'uriEdit'		=> '/' . tpl::url(array('admin', 'taxonomy'), 'editRecord'),
			'uriActivate'		=> '/' . tpl::url(array('admin', 'taxonomy'), 'activate', array('on')),
			'uriDeactivate'		=> '/' . tpl::url(array('admin', 'taxonomy'), 'activate', array('off')),
			'denormSubUrl'	=> '/' . tpl::url(array('admin', 'taxonomy'), 'denormalize'),
			'jsUnitData'	=> json_encode($shortMap)
		))->render();
		Core::view('admin/main',
			array(
				'title'		=> 'taxonomy list',
				'content'	=> $codeList
			))->render(1);
	}

	function createForm(){
		// not used now, work goes through ajax
	}

	function createRecord(){
		$model = Core::model('taxonomy');
		$name = post('name');
		$urlName = post('urlName');
		$parent = intval(post('id'));

		// checking data
		$warnings = $this->formValidation();
		$valid = empty($warnings);

		$found = $model->getBy($urlName, 'url_name');
		if($found){
			$warnings['url-name'] = 'Duplicate url-name.';
		}
		if(!$valid){
			return print json_encode(array('success'=> false, 'warnings' => $warnings));
		}

		$id = $model->add($name, $urlName, $parent);
		$this->denormalize();
		return print json_encode(array('success' => true, 'id' => $id));
	}

	private function formValidation(){
		$name = post('name');
		$urlName = post('urlName');
		$warnings = array();
		if(!$name){
			$warnings['name'] = 'Empty name.';
		}else if($name AND !preg_match('#^[\w .,;:/()\#]+$#u', $name)){
			$warnings['name'] = 'Invalid character set.';
		}
		if(!$urlName){
			$warnings['url-name'] = 'Empty name.';
		}else if(!preg_match('#^[\w\-]+$#', $urlName)){
			$warnings['url-name'] = 'Invalid character set.';
		}
		return $warnings;
	}

	function editForm($formData, $warnings=null){
		return Core::view('admin/main', array(
			'content'	=> Core::view('admin/taxonomy/edit.form', array(
				'formData'	=> $formData,
				'warnings'	=> $warnings
			))->render()
		))->render(1);
	}

	function editRecord(){
		$model = Core::model('taxonomy');
		$title = post('name');
		$urlName = post('urlName');
		$parent = intval(post('parent'));
		$id = intval(post('id'));

		$valid = preg_match('#^\d+$#', $id);
		if($parent){
			$valid = preg_match('#^\d+$#', $parent);
		}
		// checking data
		$warnings = $this->formValidation();
		$found = $model->getBy($urlName, 'url_name');
		if($found AND $found->id != $id){
			$warnings['url-name'] = 'Duplicate url-name.';
		}
		$valid = (empty($warnings) AND $valid);
		if(!$valid){
			return $this->jsonResponse(array('success' => false, 'warnings' => $warnings));
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
		if($updated){
			return $this->jsonResponse(array('success' => true, 'updated' => $updated));
		}
	}

	function denormalize(){
		$model = Core::model('taxonomy');
		$updated = $model->denormalize();
		$this->contentType('application/json');
		return $this->jsonResponse(array('success'=>true, 'changed'	=> $updated));
	}

	function activate($act){
		$actVal = ($act == 'on');
		$id = post('id');
		$model = Core::model('taxonomy');
		$updated = $model->activate($id, $actVal);
		return print json_encode(array('success' => true, 'updated' => $updated));
	}

	function remove($id){
		$pModel = Core::model('pages');
		$count = $pModel->countByParent($id);
		if(!$count){
			$tModel = Core::model('taxonomy');
			$count = $tModel->countByParent($id);
		}
		//when current tax node is not empty - return warning
		if($count) return Core::view(
			'admin/main',
			array(
				'content'	=> "This part can not be removed because it is not empty.",
				'title'		=> "Administration warning!"
			)
		)->render(1);
		$model = isset($tModel) ? $tModel : Core::model('taxonomy');
		// remove node
		$model->delById($id);
		return header('location:' . tpl::fullUrl(array('admin', 'taxonomy')));
	}
}