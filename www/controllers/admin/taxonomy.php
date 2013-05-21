<?php

class AdminTaxonomy  extends Admin_BaseController {

	function __construct(){
		parent::__construct();
	}

	function index(){
		$content = 'taxonomy administration sub class';
		Core::view('admin/main',
			array(
				'title'		=> 'Content',
				'content'	=> $content
			))->render(1);
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
		return header('location:' . tpl::fullUrl('admin', 'taxonomy'));
	}
}