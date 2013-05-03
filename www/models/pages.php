<?php

class PagesModel extends MysqlModel{
	protected $table = 'pages';
	protected $insertFields = array('parent', 'title', 'url_name', 'content');

	function namesByParent($parent){
		if(!$parent)
			return array();
		return $this->db->select("SELECT `id`, `title`, `url_name` FROM `$this->table` WHERE `parent` = ? ", array($parent));
	}

	function contentByParent($parent){
		if(!$parent)
			return array();
		return $this->db->select("SELECT `id`, `title`, `url_name`, `content` FROM `$this->table` WHERE `parent` = ? ", array($parent));
	}

	function add($data){
		foreach($data as $key => $val){
			if(!in_array($key, $this->insertFields)){
				throw new Exception('model: incorrect field in page creation');
			}
		}
		return $this->insert($data);
	}

	function getBy($index, $field='id'){
		if(!in_array($field, array('id', 'url_name')))
			throw new Exception('pages model: incorrect identifier name');
		$sql = "SELECT * FROM `{$this->table}` WHERE `$field` = ? ";
		return $this->db->selectOne($sql, array($index));
	}

}