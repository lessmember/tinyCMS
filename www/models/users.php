<?php

class Users extends MysqlModel{

	// common members
	protected $table = 'users';
	protected $names = array('login', 'email');
	protected $infoFields = array('id','login','email','hash','is_admin','is_manager','is_moderator','banned');

	// user's members
	private $secureKey = '12345678987564321';

	function install(){
		$this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			`login` varchar(32) NOT NULL,
			`pass` varchar(64) NOT NULL,
			`email` varchar(64) NOT NULL,
			`hash` char(128),
			`is_admin` boolean NOT NULL DEFAULT '0',
			`is_manager` boolean NOT NULL DEFAULT '0',
			`is_moderator` boolean NOT NULL DEFAULT '0',
			`banned` boolean NOT NULL DEFAULT '0',
			PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; ");
	}

	function add($login, $pass, $email = ''){
		$hash = $this->timeRandom(128);
		$id = $this->insert(array(
			'login'	=> $login,
			'pass'	=> $this->hashPass($pass),
			'email'	=> $email,
			'hash'	=> $hash
		));

		return (object) array(
			'id'	=> $id,
			'login'	=> $login,
			'hash'	=> $hash
		);
	}

	function change($id, $data){
		return $this->updateById($data, $id);
	}

	function checkLoginPass($login, $pass){
		$fields = $this->fieldList();
		return $this->db->selectOne("SELECT {$fields} FROM `{$this->table}` WHERE `login` = ? AND `pass` = ? ;",
			array($login, $this->hashPass($pass)));
	}

	function checkHash($hash){
		$fields = $this->fieldList();
		return $this->db->selectOne("SELECT {$fields} FROM `{$this->table}` WHERE `hash` = ? ;", array($hash));
	}

	function infoById($id){
		$fields = $this->fieldList();
		return $this->db->selectOne("SELECT {$fields} FROM `{$this->table}` WHERE `id` = ? ;", array($id));
	}

	private function hashPass($pass, $len=64){
		return substr (hash_hmac('sha512', $pass, $this->secureKey), 0, $len);
	}


}