<?php

require_once("Session.php");
require_once("View.php");
require_once("Controller.php");
require_once("Api.php");
require_once("Router.php");

class Sky {

	private static $instance;
	
	private $config;

	private $request;

	public $endpoint;
	public $path;
	
	private function __construct() {
		$this->config = array(
			'defaultController' => 'DefaultController',
			'defaultAction' => 'index',
			'apiEndpoint' => 'api'
		);
		$this->endpoint = (isset($_GET["ep"]) ? $_GET["ep"] : "");

		$this->request = array(
			'QUERY_PARAMS' => $_GET,
			'BODY' => file_get_contents('php://input'),
			'POST_PARAMS' => $_POST
		);

		if (isset($_SERVER["CONTENT_TYPE"])) {
			$this->request['CONTENT_TYPE'] = $_SERVER["CONTENT_TYPE"];
		}

		if (isset($_SERVER["CONTENT_TYPE"]) && $_SERVER["CONTENT_TYPE"] == "application/json") {
			$this->request['BODY_JSON'] = json_decode($this->request['BODY'], true);
		}
		
		$ep = ($this->endpoint ? $this->endpoint : $this->defaultRoute());
		$this->path = array_replace_recursive(array(null, null), explode("/", $ep));
	}
	
	public static function instance() {
		if (!isset(self::$instance)) {
			self::$instance = new Sky();
		}
		
		return self::$instance;
	}
	
	public function isApiCall() {
		return strpos($this->endpoint, $this->config['apiEndpoint'] . "/") === 0;
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
	
	public function defaultRoute() {
		return $this->config['defaultController'] . "/" . $this->config['defaultAction'];
	}
	
	public function loadController($controller = null, $api = false) {
		$controller = ($controller != null ? ucfirst($controller) : $this->config['defaultController']);
		$path = 'application/controllers/';
		if($api) {
			$path = 'application/api/';
		}
		
		if (file_exists($path . $controller . ".php")) {
			require_once($path . $controller . ".php");
		}
		
		if (class_exists($controller)) {
			return $controller;
		}
		
		return null;
	}
	
	public function callController($controller = null, $action = null, $params = null) {
		$controller = ($controller != null ? ucfirst($controller) : $this->config['defaultController']);
		$action = ($action != null ? $action : $this->config['defaultAction']);
		$params = ($params != null ? $params : array_slice($this->path, 2));
		
		if($controller = $this->loadController($controller)) {
			$view = new View($controller, $action);
			$controller = new $controller($this->request, $view);
			
			call_user_func_array(array($controller, $action), $params);
			
		} else {
			echo "Controller not found";
		}
	}
	
	public function callApi($controller = null) {
		if ($controller != null) {
			if($controller = $this->loadController($controller, true)) {
				$controller = new $controller($this->request);
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
		if ($this->isApiCall()){
			$this->callApi($this->path[1]);
		} else if(($route = Router::instance()->matchRoute($this->endpoint))) {
			$this->callController($route['controller'], $route['action'], $route['params']);
		} else {
			$this->callController($this->path[0], $this->path[1]);
		}
	}
}
