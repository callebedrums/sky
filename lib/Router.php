<?php

class Router {

	private static $instance;
	private $routes;
	
	private function __construct() {
		$this->routes = array();
	}
	
	public static function instance() {
		if (!isset(self::$instance)) {
			self::$instance = new Router();
		}
		
		return self::$instance;
	}
	
	public function addRoute($pattern, $controller, $action) {
		if(!array_key_exists($pattern, $this->routes)) {
			$this->routes[$pattern] = array('controller' => $controller, 'action' => $action);
		}
	}
	
	public function matchRoute($endpoint) {
		foreach($this->routes as $pattern => $action) {
			$params = array();
			if (preg_match($pattern, $endpoint, $params)) {
				return array(
					'controller' => $action['controller'],
					'action' => $action['action'],
					'params' => array_slice($params, 1)
				);
			};
		}
		
		return false;
	}
}
