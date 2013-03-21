<?php


class Model{
	protected $db = null;
	function __construct($confName='db.connection.default'){
		$this->db = new MysqlDriver(Core::conf($confName));
	}
}