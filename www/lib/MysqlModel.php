<?php


class MysqlModel{
	protected $db = null;
	function __construct($confName=null){
		if(!$confName)
			$confName = 'db.connection.default';
		$this->db = new MysqlDriver(Core::conf($confName));
	}

	function insert($table, $data){
		$fields = '`'.implode('`,`', array_keys($data)).'`';
		$valMask = substr(str_repeat('?,', count($data)), 0, -1);
		$sql = "INSERT INTO `{$table}` ({$fields}) VALUES ({$valMask});";
		return $this->db->insert($sql, array_values($data));
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