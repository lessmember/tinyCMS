<?php

class MysqlDriver extends PDO {

	private $lastResult = null;

	function __construct($options){
		$dns = "mysql:dbname={$options['name']};host={$options['host']}";
		if (isset($options['port']))
			$dns .= ";port={$options['port']}";
		parent::__construct($dns, $options['user'], $options['password']);
	}

	function do_query($sql, $data=null){
		if (!is_array($data))
			$data = array($data);
		$stat = $this->prepare($sql); // returns PDOSatement
		$stat->execute($data);
		$this->lastResult = $stat;
		$errorInfo = $stat->errorInfo();
		if($errorInfo[0] != '00000')
			throw new Exception('Database driver error:'.$errorInfo[2]. ' <br /> ' . $stat->queryString);
		return $stat;
	}

	function query($sql, $options=null){
		$this->do_query($sql, $options);
	}

	function select($sql, $options=null){
		$stat = $this->do_query($sql, $options);
		return $stat->fetchAll(PDO::FETCH_CLASS);
	}

	function insert($sql, $options){
		$stat = $this->do_query($sql, $options);
		return $this->lastInsertId();
	}

	function update($sql, $options){
		$stat = $this->do_query($sql, $options);
		return $stat->rowCount();
	}

	function delete($sql, $options){
		$stat = $this->do_query($sql, $options);
		return $stat->rowCount();
	}



}