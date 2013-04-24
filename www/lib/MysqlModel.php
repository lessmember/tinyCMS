<?php

/**
 * Base class for MySQL DB models.
 * Abstract because needs name of table for using part of methods.
 */

abstract class MysqlModel{

	protected $db = null;
	protected $table = null;
	protected $names = array();
	protected $infoFields = array();

	function __construct($confName=null){
		if(!$confName)
			$confName = 'db.connection.default';
		$this->db = new MysqlDriver(Core::conf($confName));
	}

	function insert($data){
		$fields = '`'.implode('`,`', array_keys($data)).'`';
		$valMask = substr(str_repeat('?,', count($data)), 0, -1);
		$sql = "INSERT INTO `{$this->table}` ({$fields}) VALUES ({$valMask});";
		return $this->db->insert($sql, array_values($data));
	}

	function checkUnique($field, $value){
		if(!in_array($field, $this->names))
			throw new Exception("Invalid field name of {$this->table}");
		$sql = "SELECT id FROM {$this->table} WHERE `{$field}` = ? ;";
		$res = $this->db->select($sql, array($value));
		return empty($res);
	}

	protected function fieldList(){
		return '`' . implode('`,`', $this->infoFields) . '`';
	}

	function updateByCon($data, $condition){
		if(empty($data)
			or !isset($condition['query'])
			or !isset($condition['data']))
			return null;
		$sql = "UPDATE `{$this->table}` SET ";
		$qdata = array();
		foreach($data as $field => $val){
			$sql .= "`{$field}` = ?, ";
			$qdata[] = $val;
		}
		$sql = substr($sql, 0, -2);
		$sql .= " WHERE ".$condition['query'];
		$qdata = array_merge($qdata, $condition['data']);
		return $this->db->update($sql, $qdata);
	}

	function updateAll($data){
		return $this->updateByCon($data, array('query' => '1', 'data' => array()));
	}

	function updateById($data, $id){
		return $this->updateByCon($data, array('query' => '`id` = ?', 'data' => array($id)));
	}

	function infoById($id){
		$fields = $this->fieldList();
		return $this->db->selectOne("SELECT {$fields} FROM `{$this->table}` WHERE `id` = ? ;", array($id));
	}



	function timeRandom($length = 64){
		return substr(
			str_replace(array(' ', '.'), array('_', '_'), microtime(1))
			. '_' . hash_hmac('sha512', mt_rand(),
				substr(md5(mt_rand()), 0, 16)
			) ,
			0, $length);
	}

	/**
	 * Making html table by 2D array
	 * @param $data - array [][] exam: [ [name:jonny, age:20], [name: bobby, age: 30]. [name: barbara, age: 40]  ]
	 * @return string
	 */
	function html_table($data, $tabStyle=''){
		if(empty($data))
			return '';
		$tbody = '';
		$header = '';
		if(is_object($data))
			$data = array($data);
		foreach($data as $i => $row){
			$tbody .= "\n".'<tr>';
			if(!$i){
				$header .= '<tr>';
			}
			$rowArr = get_object_vars($row);
			foreach($rowArr as $key => $val){
				if(!$i){
					$header .= '<th>' . $key . '</th>';
				}
				$tbody .= '<td>' . $val . '</td>' ;
			}
			if(!$i){
				$header .= '</tr>';
			}
			$tbody .= '</tr>';
		}
		return "<table border='1' style='{$tabStyle}'>" . "\n" .$header . $tbody . "\n" . '</table>';
	}

}