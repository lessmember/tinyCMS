<?php
/**
 * possible values of known options:
 * list of installed themes (?),
 */

class Option_valuesModel extends MysqlModel{
	protected $table = 'option_values';
	protected $insertFields = array('value', 'option');
	protected $infoFields = array('id', 'option','value');

	function all(){
		return $this->db->select("SELECT ov.*, op.name FROM `option_values` ov
			JOIN `options` op ON ov.option = op.id
			ORDER BY `option`, `value` ");
	}

	function byOption($optionId){
		return $this->db->select("SELECT ov.*, op.name FROM `option_values` ov
			JOIN `options` op ON ov.option = op.id
			WHERE `option` = ? ORDER BY `value` ",
			array($optionId));
	}

	function valMap(){
		$data = $this->all();
		$res = array();
		foreach($data as $row){
			if(!isset($res[$row->name])){
				$res[$row->name] = array();
			}
			$res[$row->name][] = $row->value;
		}
		return $res;
	}

}