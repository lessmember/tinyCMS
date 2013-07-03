<?php

class AdminUsers extends Admin_BaseController {

	protected $title = 'Users';

	function __construct(){
		parent::__construct();
		$this->regularPage();
	}

	function index(){
		return $this->listView();
		$content = 'users administration sub class';
		Core::view('admin/main',
			array(
				'title'		=> 'Users',
				'content'	=> $content
			))->render(1);
	}

	function listView($page=1){
		$page = intval($page);
		$model = Core::model('users');
		$limit = 10; // TODO
		$offset = ($page-1) * $limit;
		$data = $model->all($limit, $offset);
	//	p($data[0]);
		foreach($data as $i => $row){
			$role = 'reader';
			if($row->is_admin)
				$role = 'admin';
			else if($row->is_manager)
				$role = 'manager';
			else if($row->is_moderator	)
				$role = 'moderator';
			$data[$i]->highestRole = $role;
		}
		$content = Core::view('admin/users/list', array(
			'changeUrl'		=> '/' . tpl::url(array('admin', 'users'), 'change'),
			'basePageUrl'	=> '/' . tpl::url(array('admin', 'users')),
			'users'			=> $data,
			'currentPage'	=> $page,
			'maxPage'		=> 10 // TODO
		))->render();

		Core::view('admin/main',
			array(
				'title'		=> 'Users',
				'content'	=> $content
			))->render(1);
	}

	function change(){
		$id = post('target_id');
		if(!$id)
			return $this->jsonResponse(array('access'=>false, 'msg' => 'no index'));
		$fields = array('login','email','is_admin','is_manager','is_moderator','banned');
		$changeFields = array_intersect_key($_POST, array_flip($fields));
	//	p($changeFields);
		if(empty($changeFields))
			return $this->jsonResponse(array('access'=>false, 'msg' => 'no changes'));
		$boolStr = array('true', 'false');
		foreach($changeFields as $key => $val){
			if(in_array($val, $boolStr)){
				$changeFields[$key] = $val == 'true';
			}
		}
		$model = Core::model('users');
		$updNum = $model->change($id, $changeFields);
		return $this->jsonResponse(array('access'=> ($updNum > 0), 'updated' => $updNum ));
	}
}