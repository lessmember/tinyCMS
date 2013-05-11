<?php

class Page extends Controller {

	private $pageType = 'common_page';

	private $themeOptions;

	function __construct(){
		parent::__construct();
		$theme = Core::conf('theme');
		if($this->loadTheme($theme)){

		} else if($this->loadTheme()){

		} else {
			$this->themeOptions = array(
				'name'		=> 'default',
				'def' => '1',
				'units'		=> array(
					'main', 'content', 'menu', 'content-menu', 'cascade-menu'
				)
			);
		}
	}

	private function loadTheme($theme='default'){
		$dir = DOC_ROOT . '/views/themes/' . $theme;
		$proFile = $dir.'/'. 'properties.json';
		if(file_exists($proFile)){
			$optionsContent = file_get_contents($proFile);
			$options = json_decode($optionsContent, true);
			if(json_last_error() == JSON_ERROR_NONE){
				$this->themeOptions = $options;
				return true;
			} else {
				return false;
			}
		}
		return false;
	}

	function index(){
		$pageType = Core::conf('default.page.type');
		if($pageType == 'section')
			return $this->section(Core::conf('default.page'));
		return $this->content(Core::conf('default.page')); //TODO: move to DB, add DB part of config to Core
	}

	private function build($data){
		Core::view($this->currentThemeUnit('main'), array(
			'title'		=> $data->title,
			'content'	=> Core::view( $this->currentThemeUnit('content'), array('content' => $data->content))->render(),
			'topMenu'	=> Core::view( $this->currentThemeUnit('menu'), array('units'	=> $data->topMenu) )->render(),
			'contextMenu'	=> Core::view( $this->currentThemeUnit('context-menu'), array(
					'pages' => $data->contextMenu,
					'isSection' => $data->isSection,
					'current'		=> $data->current
				))->render(),
			'cascadeMenu'		=> Core::view( $this->currentThemeUnit('cascade-menu'), array(
					'units' 	=> $data->cascadeMenu,
					'mainTitle'	=> 'Main'
				))->render(),
			'stat'			=> 'generated in ' . ( round(10000*(microtime(true) - GLOBAL_LOG_TIME_START))/10000 ) . ' sec',
			'isSection'		=> $data->isSection
		))->render(1);
	}

	function content($id=null){
	//	p($id);
		if(!$id)
			$id = Core::conf('default.page');
		$field = $this->idName($id);

		$isSection = $this->pageType == 'section';

		$model = Core::model('pages');
		$pageData = $model->getBy($id, $field);
	//	var_dump($pageData);
		if(!$pageData){
			return Core::controller('service')->page404(Core::context()->uri);//, tpl::url('page', 'content' , array(Core::conf('default.page'))));
		}
	//	print tpl::html_table($pageData);

		$parentId = $pageData->parent;


		$taxModel = Core::model('taxonomy');
		$parentData = $taxModel->infoById($parentId);
	//	print tpl::html_table($parentData);

		// context menu
		$contextModel = $isSection ? $taxModel : $model;
		$contextData = $contextModel->namesByParent($parentId);
	//	print tpl::html_table($contextData);

		// cascade menu
		$cascadeData = $taxModel->namesByChain($parentData->parent_id_chain);
		$cascadeData[] = $parentData;

		// top menu
		$topMenuData = $taxModel->namesByParent(1); // id of root
	//	tpl::html_table($topMenuData);


		$data = array(
			'title'			=> $pageData->title,
			'current'		=> $pageData,
			'content'		=> $pageData->content,
			'topMenu'		=> $topMenuData,
			'contextMenu'	=> $contextData,
			'cascadeMenu'	=> $cascadeData,
			'isSection'		=> false
		);

		return $this->build((object) $data);

/*
		Core::view($this->currentThemeUnit( 'main'), array(
			'title'		=> $pageData->title,
			'content'	=> Core::view( $this->currentThemeUnit( 'content'), array('content' => $pageData->content))->render(),
			'topMenu'	=> Core::view( $this->currentThemeUnit( 'menu'), array('units'	=> $topMenuData) )->render(),
			'contextMenu'	=> Core::view( $this->currentThemeUnit( 'context-menu'), array('pages' => $contextData))->render(),
			'cascadeMenu'	=> Core::view( $this->currentThemeUnit( 'cascade-menu'), array('units' => $cascadeData, ))->render(),
			'stat'			=> 'generated in ' . ( round(10000*(microtime(true) - GLOBAL_LOG_TIME_START))/10000 ) . ' sec',
			'isSection'		=> $isSection
		))->render(1);
*/
	}

	function section($id=2){
		$this->pageType = 'section';
		$field = $this->idName($id);

		$model = Core::model('taxonomy');
		$curData = $model->getBy($id, $field);
		if(! $curData){
			return Core::controller('service')->page404(Core::context()->uri);//, tpl::url('page', 'content' , array(Core::conf('default.page'))));
		}

		//*************
	//	p($curData);

		$parentId = $curData->parent;

		$parentData = $model->infoById($parentId);
	//	print tpl::html_table($parentData);

		// context menu
		$contextData = $model->namesByParent($parentId);
	//	print tpl::html_table($contextData);

		// cascade menu
		$cascadeData = $model->namesByChain($parentData->parent_id_chain);
		$cascadeData[] = $parentData;

		// top menu
		$topMenuData = $model->namesByParent(1); // id of root
	//	tpl::html_table($topMenuData);
		//*************

		$subSections = $model->namesByParent($curData->id);

		$pageModel = Core::model('pages');
		$pagesData = $pageModel->contentByParent($curData->id);

		$content = Core::view($this->currentThemeUnit('section-content'), array(
			'subSections'	=> $subSections,
			'subPages'		=> $pagesData
		))->render();

		$data = array(
			'title'			=> $curData->title,
			'current'		=> $curData,
			'content'		=> $content,
			'topMenu'		=> $topMenuData,
			'contextMenu'	=> $contextData,
			'cascadeMenu'	=> $cascadeData,
			'isSection'		=> true
		);

		return $this->build( (object)  $data);
	}

	private function currentThemeUnit($unit){
		$theme = $this->themeOptions['name'];
		$useTheme = (in_array($unit, $this->themeOptions['units'])) ? $theme : 'default';
		return 'themes/'. $useTheme . '/' . $unit;
	}

	private function pageContent($pageId){

	}

	private function sectionContent($sectionId, $model){
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

}