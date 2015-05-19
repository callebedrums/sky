<?php

class Router {

	private static $instance;
	private $routes;
	
	private function __consturct() {
		$this->routes = array();
	}
	
	public static function instance() {
		if (!isset(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		
		return self::$instance;
	}
	
	public function addRoute($pattern) {
		if(!in_array($pattern, $this->routes)) {
			$this->routes[] = $pattern;
		}
	}
	
	public function matchRoute($endpoint) {
		foreach($this->routes as $pattern) {
			if (preg_match($pattern, $endpoint)) return $pattern;
		}
		
		return false;
	}
}
