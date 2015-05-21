<?php

require_once("controller.php");

class API extends Controller {

	protected $routes;
	
	public function __construct() {
		$this->routes = array(
			'GET' => array(
				$this->regex_endpoint() => 'query',
				$this->regex_endpoint(true) => 'retrieve'
			),
			'POST' => array(
				$this->regex_endpoint() => 'create',
				$this->regex_endpoint(true) => 'update'
			),
			'PUT' => array(
				$this->regex_endpoint() => 'create',
				$this->regex_endpoint(true) => 'update'
			),
			'DELETE' => array(
				$this->regex_endpoint(true) => 'delete'
			),
			'HEAD' => array(),
			'OPTIONS' => array(
				$this->regex_endpoint() => 'options'
			)
		);
	}
	
	public function regex_endpoint($instance = false) {
		$endpoint = '/\/' . strtolower(get_class($this));
		if ($instance) {
			
			$endpoint .= '\/(.+)';
		}
		$endpoint .= '\/?/';
		return $endpoint;
	}
	
	public function run($endpoint = null) {
		$method = $_SERVER['REQUEST_METHOD'];
		$params = array();
		$_ep = '';
		$_action = '';
		$pk = null;
		
		foreach($this->routes[$method] as $ep => $action) {
			
			if(preg_match($ep, $endpoint, $params)) {
				if(strlen($ep) > strlen($_ep)) {
					$_ep = $ep;
					$_action = $action;
					if (isset($params[1])) {
						$pk = $params[1];
					} else {
						$pk = null;
					}
				}
			}
		}
		
		if(strlen($_action) > 0) {
			return $this->$_action($pk);
		} else {			
			return "action not found";
		}
	}
	
	/**
	 * OPTIONS /api/<classname>
	 * return the available options
	 * */
	public function options() {
		$options = array();
		
		foreach($this->routes as $method => $routes) {
			$options[$method] = array();
			foreach($routes as $route => $action) {
				$r = substr($route, 1, -1);
				$r = str_replace('\\', '', $r);
				$r = str_replace('?', '', $r);
				$options[$method][$r] = $action;
			}
		}
	}

	/**
	 * GET /api/<classname>/
	 * query all instance
	 * */
	public function query() {
		return "query";
	}
	
	/**
	 * POST /api/<classname>
	 * create new instance
	 * */
	public function create() {
		return "create";
	}
	
	/**
	 * GET /api/<classname>/id/
	 * get an instance
	 * */
	public function retrieve($pk) {
		return "retrieve " . $pk;
	}
	
	/**
	 * PUT /api/<classname>/id/
	 * update an instance
	 * */
	public function update($pk) {
		return "update " . $pk;
	}
	
	/**
	 * DELETE /api/<classname>/id/
	 * remove an instance
	 * */
	public function delete($pk) {
		return "delete " . $pk;
	}
}
