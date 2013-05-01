<?php

class TaxonomyTree {

	private $tree = null;
	private $list = null;

	function __construct($data=null){
		$this->init($data);
	}

	/**
	 * @param $data - db selection with sorting by parents, can't be empty
	 * @throws Exception
	 */
	function init($data){
		if(empty($data))
			throw new Exception('taxonomy tree: empty data list');
	//	$this->list = $data;
		$this->tree = null;
		//$this->tree = new TaxUnit($data[0]);
		foreach($data as $nodeVal){
			$node = new TaxUnit($nodeVal);
			if($this->tree === null)
				$this->tree = $node;
			else
				$this->tree->add($node);
		}
	}

	function makeList(){
		$list = $this->makeNodePart($this->tree);
		return $list;
	}
	private function makeNodePart(TaxUnit $node){
	//	p($node->id. ' <- '. $node->parent);
		static $deep = 0;
		$res = array(new ListUnit($node->data, $deep));
		//	$res = array("id:{$node->id}; par:{$node->parent}; deep:{$deep}");
		$node->resetIterator();
		$deep++;
		while($sub = $node->nextChild()){
			$res = array_merge($res, $this->makeNodePart($sub));
		}
		$deep--;
		return $res;
	}

}

class TaxUnit {

	// class info
	private $data;
	private $subunits = array();
	private $currentChildIndex = null;

	// debug info
	public static $counter = 0;

	function __construct($data){
		$this->data = $data;
	}

	function add(TaxUnit $unit){
		if(!$unit->parent)
			return;

	//	p('this = '. $this->id . '; unit parent = ' .$unit->parent);
		$parent = ($this->id == $unit->parent) ? $this : $this->find($unit->parent);
		if($parent){
			$parent->insert($unit);
			$this->currentChildIndex = 0;
			return TRUE;
		}
		return FALSE;
	}

	function insert($node){
		$this->subunits[] = $node;
		$this->currentChildIndex = 0;
		self::$counter++;
	}

	function find($id){
	//	p('find, this= '.$this->id.' id='.$id);
		if($this->id == $id){
			return $this;
		} else {
			foreach($this->subunits as $sub){
				$found = $sub->find($id);
	//			p(' found = '.($found ? $found->id : 'null'));
				if($found){
					return $found;
				}
			}
		}
		return null;
	}

	function firstChild(){
		return !empty($this->subunits) ? $this->subunits[0] : null;
	}

	function currentChild(){
		return ($this->currentChildIndex !== null AND !empty($this->subunits)) ? $this->subunits[$this->currentChildIndex] : null;
	}

	function nextChild(){
	//	p('id='.$this->id. '; index='.(is_int($this->currentChildIndex) ? $this->currentChildIndex : (gettype($this->currentChildIndex))));
		if($this->currentChildIndex === null)
			return null;
		if($this->currentChildIndex < count($this->subunits)){
			return $this->subunits[$this->currentChildIndex ++];
		} else {
			$this->currentChildIndex = 0;
			return false;
		}
	}

	function resetIterator(){
		if(!empty($this->subunits))
			$this->currentChildIndex = 0;
	}

	function __get($name){
		switch($name){
			case 'id':
			case 'parent':	return $this->data->{$name};
			case 'data':	return $this->data;
			default:		return null;
		}
	}

}

class ListUnit{
	private $data = null;
	private $deep = 0;

	function __construct($data, $deep){
		$this->data = $data;
		$this->deep = $deep;
	}

	function __get($name){
		if(isset($this->data->{$name}))
			return $this->data->{$name};
		if(in_array($name, array('deep'))){
			return $this->{$name};
		}
		return null;
	}
}