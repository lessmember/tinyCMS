<?php

class Pages extends MysqlModel{
	protected $table = 'pages';
	protected $insertFields = array('parent', 'title', 'url_name', 'content');

	function byParent($parent){
		if(!$parent)
			return array();
		return $this->db->select("SELECT * FROM `$this->table` WHERE `parent` =? ", array($parent));
	}

	function add($data){
		foreach($data as $key => $val){
			if(!in_array($key, $this->insertFields)){
				throw new Exception('model: incorrect field in page creation');
			}
		}
		return $this->insert($data);
	}

}