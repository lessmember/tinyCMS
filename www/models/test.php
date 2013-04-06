<?php

class Test extends MysqlModel {

	private $table = 'test_users';
	function createTable(){
		$this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			`login` varchar(32) NOT NULL,
			`pass` varchar(16) NOT NULL,
			`email` varchar(64) NOT NULL,
			PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; ");
	}

	function dropTable(){
		$this->db->query("DROP TABLE `{$this->table}` ");
	}

	function fillTable(){
		for ($i=0; $i<5; ++$i){
			$sql = "INSERT INTO `{$this->table}` (`login`, `pass`, `email`) VALUES (?, ?, ?);";
			p('inserted '.$this->db->insert($sql, array('user_'.$i, 'pass_'.str_repeat('z', $i), str_repeat(chr(97+$i), 5).'@mail.com')));
		}
		for($i=5; $i<10; ++$i){
			$this->insert($this->table, array(
				'login' => 'user_'.$i,
				'pass'  => 'pass_'.str_repeat('z', $i),
				'email' => str_repeat(chr(97+$i), 5).'@mail.com')
			);
		}
	}

	function find(){
		$tabStyle = "min-width: 800px; margin-top: 10px; border: 2px solid #800;";
		print $this->html_table($this->db->select("SELECT * FROM `{$this->table}` WHERE `login` LIKE ? ", array('%3%')), $tabStyle);
		print $this->html_table($this->db->select("SELECT * FROM `{$this->table}` WHERE `email` LIKE ? ", array('%ccccc%')), $tabStyle);
		print $this->html_table($this->db->select("SELECT * FROM `{$this->table}` WHERE `id` > 2 AND id < 5 " ), $tabStyle);
		print $this->html_table($this->db->select("SELECT * FROM `{$this->table}` ORDER BY `id` DESC LIMIT 0, 1 " ), $tabStyle);
		print $this->html_table($this->db->select("SELECT * FROM `{$this->table}` LIMIT 0, 50 " ), $tabStyle);
	}


}