<?php

class TaxonomyModel extends MysqlModel{
	protected $table = 'taxonomy';
	protected $infoFields = array('id', 'parent', 'title', 'url_name', 'parent_id_chain');

	function all(){
		return $this->db->select("SELECT * FROM `{$this->table}` ORDER BY `parent`, `id` ");
	}

	function add($title, $urlName, $parent){
		return $this->insert(
			array(
				'title'		=> $title,
				'url_name'	=> $urlName,
				'parent'	=> $parent
			));
	}

	function namesByParent($parent){
		if(!$parent)
			return array();
		return $this->db->select("SELECT `id`, `title`, `url_name` FROM `{$this->table}` WHERE `parent` =? ", array($parent));
	}

	function namesByChain($chain){
		if(!preg_match('#(\d+\;)*\d#', $chain))
			throw new Exception('taxonomy model: incorrect chain: '.$chain);
		$ids = explode(';', $chain);
		if(count($ids) < 2)
			return array();
		if( intval($ids[0] == 1))
			array_shift($ids);
		$mask = substr(str_repeat('?,', count($ids)), 0, -1);
		$sql = "SELECT `id`, `title`, `url_name`, `parent_id_chain` FROM `{$this->table}` WHERE `id` IN ({$mask}) ";
		return $this->db->select($sql, $ids);
	}

	function denormalize(){
		$source = $this->all();
		if(count($source) == 0)
			return 0;
		$map = array();
		$chains = array();
		$debug = array();
		foreach($source as $i => $row ){
			$map[$row->id]	= $i;
			$parentChain = arrval($chains, $row->parent);
			$chain = ( $parentChain ? $parentChain . ';'  : ''). $row->parent;
			$chains[$row->id] = $chain;
			$debug[] = (object) array('id' => $row->id, 'chain' => $chain);
		}
		$updated = 0;
		foreach($chains as $id => $chain){
			if($source[$map[$row->id]]->parent_id_chain == $chain)
				continue;
			$updated += $this->updateById(array('parent_id_chain' => $chain), $id);
		}
		return $updated;
	}

	function getBy($index, $field='id'){
		if(!in_array($field, array('id', 'url_name')))
			throw new Exception('pages model: incorrect identifier name');
		$sql = "SELECT * FROM `{$this->table}` WHERE `$field` = ? ";
		return $this->db->selectOne($sql, array($index));
	}

}