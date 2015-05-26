<?php

class View {
	private $controller;
	private $action;
	
	public function __construct($controller = 'Index', $action = 'action') {
		$this->controller = ucfirst($controller);
		$this->action = $action;
	}
	
	public function render($data = null, $action = null, $controller = null) {
		$action = ($action !== null ? $action : $this->action);
		$controller = ($controller !== null ? $controller : $this->controller);
		
		if(file_exists('application/templates/' . $controller . '/' . $action . '.html')) {
			
			include('application/templates/' . $controller . '/' . $action . '.html');
		}
	}
}
