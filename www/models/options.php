<?php

class OptionsModel extends MysqlModel{
	protected $table = 'options';
	protected $insertFields = array('name', 'value', 'type');
	protected $infoFields = array('id', 'name', 'value', 'type');

	function all(){
		return $this->db->select("SELECT * FROM `{$this->table}` ORDER BY `name` ");
	}

}