<?php

class AdminOptions  extends Admin_BaseController {

	function __construct(){
		parent::__construct();
	}

	function index(){
		return $this->form();
	}

	function form($msg=null){
		$model = Core::model('options');
		$data = $model->all();
		foreach($data as $row){
			$row->formName = str_replace('.', '_', $row->name);
		}
		$optValModel = Core::model('option_values');
		$values = $optValModel->valMap();
/*		$values = array(
			'option' => array(
				'default',
				'red-lake',
				'blue-sky'
			)
		); /**/
		$form = Core::view('admin/options',
			array(
				'units'		=> $data,
				'action'	=> tpl::url(array('admin', 'options'), 'save'),
				'optValues'	=> $values,
				'warning'	=> $msg
			));
		Core::view('admin/main',
			array(
				'title'		=> 'Options',
				'content'	=> $form->render()
			))->render(1);
	}

	function save(){
		$model = Core::model('options');
		$old = $model->all();
		$newData = array();
		$checkingVal = array();
		foreach($old as $row){
			$newVal = post(str_replace('.', '_', $row->name));
			$checkingVal[$row->name] = $newVal ? $newVal : $row->value;
			if($newVal === null OR $newVal == $row->value)
				continue;
			$newData[] = array('id' => $row->id, 'value' => $newVal);
		}
		if(!$this->correctValue($checkingVal)){
			return $this->form('Incorrect values');
		}
		if(!empty($newData)){
			$model->multiSave($newData);
		}
		return header('location: '. tpl::fullUrl(array('admin', 'options')));
	}

	function correctValue($data){
		// section can be 2 or more
		if($data['default.page.type'] == 'section' AND $data['default.page'] < 2)
			return FALSE;
		return TRUE;
	}

	private function caching(){}
}