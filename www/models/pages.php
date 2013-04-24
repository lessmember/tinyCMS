<?php

class Pages extends MysqlModel{
	protected $table = 'pages';

	function byParent($parent){
		if(!$parent)
			return array();
		return $this->db->select("SELECT * FROM `$this->table` WHERE `parent` =? ", array($parent));
	}

}