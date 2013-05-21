<?php

class PagesModel extends MysqlModel{
	protected $table = 'pages';
	protected $insertFields = array('parent', 'title', 'url_name', 'content', 'active');
	protected $infoFields = array('id', 'parent', 'title', 'url_name', 'content', 'active');

	function namesByParent($parent, $active=true){
		if(!$parent)
			return array();
		$fields = '`' . implode('`,`', array_diff($this->infoFields, array('content'))) . '`';
		return $this->db->select("SELECT {$fields} FROM `$this->table` WHERE `parent` = ? " . ($active ? "AND `active` = true " : ""), array($parent));
	}

	function countByParent($id){
		$res = $this->db->selectOne("SELECT COUNT(`id`) as `pages_num` FROM `{$this->table}` WHERE `parent` = ? ", array($id));
		if(is_object($res))
			return $res->pages_num;
		return false;
	}

	function contentByParent($parent, $active=true){
		if(!$parent)
			return array();
		$fields = '`' . implode('`,`', $this->infoFields) . '`';
		return $this->db->select("SELECT {$fields} FROM `$this->table` WHERE `parent` = ? ". ($active ? "AND `active` = true " : ""), array($parent));
	}

	function add($data){
		foreach($data as $key => $val){
			if(!in_array($key, $this->insertFields)){
				throw new Exception('model: incorrect field in page creation');
			}
		}
		return $this->insert($data);
	}

	function getBy($index, $field='id'){
		if(!in_array($field, array('id', 'url_name')))
			throw new Exception('pages model: incorrect identifier name');
		$sql = "SELECT * FROM `{$this->table}` WHERE `$field` = ? ";
		return $this->db->selectOne($sql, array($index));
	}

	function activate($id, $val){
		return $this->updateById(array('active' => $val), $id);
	}

}