<?php

class Taxonomy extends MysqlModel{
	protected $table = 'taxonomy';

	function all(){
		return $this->db->select("SELECT * FROM `{$this->table}`");
	}

	function add($name, $urlName, $parent){
		return $this->insert(
			array(
				'name'		=> $name,
				'url_name'	=> $urlName,
				'parent'	=> $parent
			));
	}

}