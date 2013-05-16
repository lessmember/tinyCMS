<?php

class AdminOptions  extends Admin_BaseController {

	function __construct(){
		parent::__construct();
	}

	function index(){
		return $this->form();
	}

	function form(){
		$model = Core::model('options');
		$data = $model->all();
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
				'optValues'			=> $values
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
		foreach($old as $row){
			$val = post($row->name);
			if($val === null OR $val == $row->value)
				continue;
			$newVal = post($row->name);
			$newData[] = array('id' => $row->id, 'value' => $newVal);
		}
		if(!empty($newData)){
			$model->multiSave($newData);
		}
		return header('location: '. tpl::fullUrl(array('admin', 'options')));
	}

	private function caching(){}
}