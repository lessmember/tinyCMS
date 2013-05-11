<?php
/**
 * possible values of known options:
 * list of installed themes (?),
 */

class OptionsModel extends MysqlModel{
	protected $table = 'option_values';
	protected $insertFields = array('value', 'option_id');
	protected $infoFields = array('id', 'option_id','value');

	function all(){
		return $this->db->select("SELECT * FROM `{$this->table}` ORDER BY `option_id`, `value` ");
	}

	function byOption($optionId){
		return $this->db->select("SELECT * FROM `{$this->table}` ORDER BY `value` WHERE `option_id` = ? ", array($optionId));
	}

}