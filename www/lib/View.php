<?php

class View {

	private $data = array();
	private $file;
	private $tpl;
	private $presetScripts = array();
	private $presetCSS = array();
	private $html = '';

	function __construct($name, $data=array()) {
		$this->data = $data;
		$this->file = DOC_ROOT .'/views/'.$name.'.php';
	}

	function __set($name, $value){
		$this->data[$name] = $value;
	}

	function setCss($url){
		$this->presetCSS[] = $url;
	}

	function setScript($url){
		$this->presetScripts = $url;
	}

	function includes(){
		$html = '';
		foreach($this->presetCSS as $url){
			$html .= "\t\t<link rel='stylesheet' type='text/css' href='{$url}' />\n";
		}
		foreach($this->presetScripts as $url){
			$html .= "\t\t<script type='text/javascript' src='{$url}'></script>\n";
		}
		return $html;
	}

	function render($out=FALSE){
		if (!file_exists($this->file))
			throw new Exception("Tpl file of View not found.");
		$this->tpl = file_get_contents($this->file);
		extract($this->data, EXTR_OVERWRITE);
		if(count($this->presetCSS) OR count($this->presetScripts))
			$this->html = $this->includes();
		ob_start();
		eval('?>'. $this->tpl . '<?');
		$obRes = ob_get_contents();
		ob_end_clean();
		$this->html .= $obRes;
		if ($out)
			print $this->html;
		return $this->html;
	}

}