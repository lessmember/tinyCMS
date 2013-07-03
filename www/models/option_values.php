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

	function setByName($name, $value){
		return $this->db->insert("INSERT INTO `option_values` (`option`, `value`)
			VALUES ( (SELECT id FROM options WHERE `name` = ?), ? )",
		array($name, $value));
	}

	function unsetById($id){
		return $this->db->delete("DELETE FROM `option_values` WHERE `id` = ? ", array($id));
	}

	function byName($optionName){
		return $this->db->select("SELECT ov.* FROM `option_values` ov
			JOIN `options` op ON ov.option = op.id
			WHERE op.`name` = ? ORDER BY `value` ",
			array($optionName));
	}


}