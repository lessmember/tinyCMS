<?php

class Page extends Controller {

	function index(){
		return $this->content(Core::conf('default.page')); //TODO: move to DB, add DB part of config to Core
	}

	function content($id=null){
	//	p($id);
		if(!$id)
			$id = Core::conf('default.page');
		$field = $this->idName($id);
		$model = Core::model('pages');
		$pageData = $model->getBy($id, $field);
	//	var_dump($pageData);
		if(!$pageData){
			return Core::controller('service')->page404(Core::context()->uri, tpl::url('page', 'content' , array(Core::conf('default.page'))));
		}
		print tpl::html_table($pageData);

		$taxModel = Core::model('taxonomy');
		$parentData = $taxModel->infoById($pageData->parent);
		print tpl::html_table($parentData);

		$contextData = $model->namesByParent($pageData->parent);
		print tpl::html_table($contextData);

		$cascadeData = $taxModel->namesByChain($parentData->parent_id_chain);
		$cascadeData[] = $parentData;
		$theme = 'default';
		$viewDir = 'themes/'.$theme.'/';

		//$topMenu = Core::view($viewDir.'/menu');

		Core::view($viewDir.'main', array(
			'title'		=> $pageData->title,
			'content'	=> Core::view( $this->currentThemeUnit($theme, 'content'), array('content' => $pageData->content))->render(),
			'topMenu'	=> Core::view( $this->currentThemeUnit($theme, 'menu') )->render(),
			'contextMenu'	=> Core::view( $this->currentThemeUnit($theme, 'context-menu'), array('pages' => $contextData))->render(),
			'cascadeMenu'	=> Core::view( $this->currentThemeUnit($theme, 'cascade-menu'), array('units' => $cascadeData, ))->render(),
			'stat'			=> 'generated in ' . ( round(10000*(microtime(true) - GLOBAL_LOG_TIME_START))/10000 ) . ' sec'
		))->render(1);
	}

	private $themeOptions = array(
		'name'		=> 'default',
		'units'		=> array(
			'main', 'content', 'menu', 'content-menu', 'cascade-menu'
		)
	);

	private function currentThemeUnit($theme, $unit){
		$theme = (isset($this->themeOptions['units'][$unit])) ? $theme : 'default';
		return 'themes/'.$theme . '/' . $unit;
	}

	function section($id){
		if(preg_match('#\d+#', $id)){
			// search by id
		} else {
			//search by url_name
		}
	}

	private function idName($id){
		return preg_match('#^\d+$#', $id) ? 'id' : 'url_name';
	}

	private function topMenu(){}

	private function contextMenu(){}

	/**
	 * @param $data record of parent taxonomy unit
	 */
	private function cascadeMenu(array $list){


	}

	private function pageContent(){}

}