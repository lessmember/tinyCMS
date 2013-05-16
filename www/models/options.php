<?php

class OptionsModel extends MysqlModel{
	protected $table = 'options';
	protected $insertFields = array('name', 'value', 'type');
	protected $infoFields = array('id', 'name', 'value', 'type');

	function all(){
		return $this->db->select("SELECT * FROM `{$this->table}` ORDER BY `name` ");
	}

	/**
	 * @param $data - array ( array(id => A, value => B), ...)
	 */
	function multiSave($data){
		if(empty($data))
			return 0;
		$sql = "INSERT INTO `{$this->table}` (`id`, `value`) VALUES ";
		$values = array();
		foreach($data as $unit){
			$sql .= "(?, ?),";
			$values = array_merge($values, array($unit['id'], $unit['value']));
		}
		$sql = substr($sql, 0, -1) . ' ON DUPLICATE KEY UPDATE `value` = VALUES(`value`);';
		return $this->db->update($sql, $values);
	}

	function val($name){
		$res = $this->db->selectOne("SELECT `value` FROM `{$this->table}` WHERE `name` = ? ", array($name));
		return $res ? $res->value : null;
	}

}