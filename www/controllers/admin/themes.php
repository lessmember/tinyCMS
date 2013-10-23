<?php

class AdminThemes extends Admin_BaseController {

	private $targetDir = '';
	protected $title = 'Themes';
	private $uploadErrors = array();

	function __construct(){
		parent::__construct();
		$this->targetDir = DOC_ROOT . '/views/themes';
	}

	function index(){
		return $this->listView();
		$content = 'Themes administration sub module';
		Core::view('admin/main',
			array(
				'title'		=> 'Themes',
				'content'	=> $content
			))->render(1);
	}

	function listView(){
		$dirs = $this->scan();
		$model = Core::model('option_values');
		$registered = $model->byName('theme');
	//	p($dirs);
	//	print tpl::html_table($registered);
		$regMap = array();
		foreach($registered as $i => $row){
			$regMap[$row->value] = $i;
		}
		$outList = array(); // id, value, saved
		$simpleList = array();
		$listMap = array();
		foreach($dirs as $unit){
			$saved = isset($regMap[$unit]);
			$out = $saved ? $registered[$regMap[$unit]] : ((object) array('id' => 0, 'option' => 0, 'value' => $unit));
			$out->saved = (int)$saved;
			$outList[] = $out;
			$simpleList[] = $out->value;
			$listMap[$out->value] = array('name' => $out->value, 'id' => $out->id);
		}
	//	print tpl::html_table($outList);

		$content = Core::view('admin/themes/list', array(
			'uploadUrl'		=> '/' . tpl::url(array('admin', 'themes'), 'upload'),
			'saveUrl'		=> '/' . tpl::url(array('admin', 'themes'), 'saveThemeStat'),
			'themes'		=> $outList,
			'simpleList'	=> $simpleList,
			'listMap'		=> $listMap
		))->render();

		return $this->mainConten($content);
	}

	/**
	 * Scan dir of themes and return list of files
	 */
	private function scan(){
		$list = scandir($this->targetDir);
		$dirs = array();
		foreach($list as $file){
			if(is_dir($this->targetDir . '/' .$file) AND !preg_match('#\.+#', $file)){
				$dirs[] = $file;
			}
		}
		return $dirs;
	}


	/**
	 * upload new theme in zip archive
	 */
	function upload(){
		$name = post('theme-name');
		//$name .= ' 123';
		if(!preg_match('#^[a-zA-Z][a-zA-Z0-9\-\_\.]{2,15}$#', $name)){
			return $this->warning("Incorrect name of theme: [$name]");
		}
		$uploaded = $this->unpackUploaded('zipped-theme', $name);
		if(!$uploaded){
			return $this->warning(implode("<br />\n", $this->uploadErrors));
		}
	}

	/**
	 * unpack and copy files from uploaded zip to
	 * directory of themes
	 */
	private function unpackUploaded($fileName, $themeName){
		if(!isset($_FILES[$fileName])){
			$this->uploadErrors[] = "Empty FILES entity.";
			return false;
		}

		// Move archive part
		$fileData = $_FILES[$fileName];
		if(!file_exists($fileData['tmp_name'])){
			$this->uploadErrors[] = "Uploaded file was not found.";
			return false;
		}
		$uploadedPath = DOC_ROOT . '/uploads/' . $themeName . '.zip';
		if(! move_uploaded_file($fileData['tmp_name'], $uploadedPath)){
			$this->uploadErrors[] = "Unable copy uploaded archive.";
			return false;
		}
		$targetDir = DOC_ROOT .'/views/themes/' . $themeName;
		mkdir($targetDir, 0777);
		chmod($targetDir, 0777);

		// Unzip part
		$units = array();
		$zip = new ZipArchive();
		if(!$zip->open($uploadedPath)){
			$zip->close();
			$this->uploadErrors[] = "Can't open archive.";
			return false;
		}
		$len = $zip->numFiles;
		$list = array();
		$themeProperties = array(
			'name' 	=> $themeName,
			'units'	=> array()
		);
		for($i=0; $i<$len; ++$i){
			$filePath = $zip->getNameIndex($i);
			//$isDir = preg_match('#.+\/$#', $filePath);
			if(preg_match('#[^\/]+\/$#', $filePath)){
				// something about dir
			} elseif(preg_match('#[^\/]+\/(([a-zA-Z0-9\-\_\.]+)\.php)$#', $filePath, $fileMatch)){
				$fileName = $fileMatch[1];
				$fileContent = $zip->getFromIndex($i, 1024*50);
				$targetFile = $targetDir . '/' . $fileName;
				$noFileError = (FALSE !== file_put_contents($targetFile, $fileContent));
				var_dump($noFileError);
				chmod($targetFile, 0644);
				$themeProperties['units'][] = $fileMatch[2]; //
			}
			$list[] = $filePath;
		}

		// Save properties
		$noFileError = ($noFileError AND
			FALSE !== file_put_contents( $targetDir . '/' . 'properties.json', json_encode($themeProperties)));

		if($noFileError)
			return header('location:' . tpl::fullUrl(array('admin', 'themes')));
		return $this->warning("Some troubles");
	}

	function saveThemeStat(){
		$saveTheme = post('name');
		$id = post('theme_id');
		$stat = post('stat');
	//	p(array($saveTheme, $id, $stat));
		$model = Core::model('option_values');
		if($id === NULL AND $stat == 'true'){
			$id = $model->setByName('theme', $saveTheme);
		//	p('id = ' . $id);
		} else if ($id AND $stat == 'false'){
			$model->unsetById($id);
		}
		// TODO: 'saved' msg
	}
}