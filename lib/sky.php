<?php

require_once("controller.php");
require_once("api.php");

class Sky {

	private static $instance;
	
	private $config;
	public $endpoint;
	public $isApiCall;
	public $controller;
	public $action;
	public $path;
	
	private function __construct() {
		$this->config = array(
			'indexController' => 'Index',
			'indexAction' => 'action',
			'apiEndpoint' => 'api'
		);
		$this->endpoint = (isset($_GET["ep"]) ? $_GET["ep"] : "");
		$this->isApiCall = false;
		$this->controller = '';
		$this->action = '';
		$this->path = array(null, null);
	}
	
	public function indexRoute() {
		return $this->config['indexController'] . "/" . $this->config['indexAction'];
	}
	
	public static function instance() {
		if (!isset(self::$instance)) {
			self::$instance = new Sky();
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
	
	public function loadController($controller = null, $api = false) {
		$controller = ($controller != null ? ucfirst($controller) : $this->config['indexController']);
		$path = 'application/controllers/';
		if($api) {
			$path = 'application/api/';
		}
		
		if (file_exists($path . strtolower($controller) . ".php")) {
			require_once($path . strtolower($controller) . ".php");
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
			echo $controller->$action();
		} else {
			echo "Controller not found";
		}
	}
	
	public function callApi($controller = null) {
		if ($controller != null) {
			if($controller = $this->loadController($controller, true)) {
				$ep = substr($this->endpoint, strlen($this->config['apiEndpoint']));
				
				$data = json_decode(file_get_contents('php://input'), true);
				$data = json_encode($controller->run($ep, $data));
				
				header('Content-Type: application/json');
				echo $data;
			} else {
				echo "Controller not found";
			}
		} else {
			echo "controller not found";
		}
	}
	
	public function start() {
		$ep = (isset($_GET["ep"]) ? $_GET["ep"] : $this->indexRoute());
		$this->path = array_replace_recursive($this->path, explode("/", $ep));
		
		if ($this->path[0] === $this->config['apiEndpoint']){
			$this->callApi($this->path[1]);
		} else {
			$this->callController($this->path[0], $this->path[1]);
		}
	}
}
