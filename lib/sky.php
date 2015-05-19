<?php

require_once("controller.php");

class Sky {

	private static $instance;
	
	private $config;
	
	private function __construct() {
		$this->config = array(
			'indexController' => 'Index',
			'indexAction' => 'index'
		);
	}
	
	public function indexRoute() {
		return $this->config['indexController'] . "/" . $this->config['indexAction'];
	}
	
	public static function instance() {
		if (!isset(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		
		return self::$instance;
	}
	
	public function config($config) {
		if(!$config) {
			$arr = new ArrayObject($this->config);
			return $arr->getArrayConpy();
		}
		
		if($new_config = array_replace_recursive($this->config, $config)) {
			$this->config = $new_config;
		}
	}
	
	public function loadController($controller = null) {
		$controller = ($controller != null ? ucfirst($controller) : $this->config['indexController']);
		
		if (file_exists("controllers/" . strtolower($controller) . ".php")) {
			require_once("controllers/" . strtolower($controller) . ".php");
		}
		
		if (class_exists($controller)) {
			return new $controller();
		}
		
		return null;
	}
	
	public function callController($controller = null, $action = null) {
		$controller = ($controller != null ? ucfirst($controller) : $this->config['indexController']);
		$action = ($action != null ? $action : $this->config['indexAction']);
		
		if($controller = $this->loadController($controller)) {
			$controller->$action();
		} else {
			echo "Controller not found";
		}
	}
	
	public function start() {
		$ep = (isset($_GET["ep"]) ? $_GET["ep"] : $this->indexRoute());
		$path = array_replace_recursive(array(null, null), explode("/", $ep));
		
		$this->callController($path[0], $path[1]);
	}
}
