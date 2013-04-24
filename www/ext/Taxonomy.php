<?php

class Taxonomy {

	private $tree = null;
	private $list = null;

	function __construct(){

	}

	function init(){}

	function makeTree(){}

}

class TaxUnit {

//	private $id = null;
//	private $parent = null;
	private $data;
	private $subunits = array();

	function __construct($data){
	//	$this->id = $data->id;
	//	$this->parent = $data->parent;
		$this->data = $data;
	}

	function add(TaxUnit $unit){
		/*if($unit->parent == $this->data->id){
			$this->subunits[] = $unit;
			return TRUE;
		} else {
			foreach($this->subunits as $sub){
				if($sub->add($unit))
					return TRUE;
			}
		}*/
		$node = $this->find($unit->parent);
		if($node){
			$node->add($unit);
			return TRUE;
		}
		return FALSE;
	}

	function find($id){
		if($this->id == $id){
			return $this;
		} else {
			foreach($this->subunits as &$sub){
				if($sub->id == $id){
					return $sub;
				}
			}
		}
		return null;
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