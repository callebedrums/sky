<?php

class Controller {

	protected $view;
	
	public function __construct($view) {
		$this->view = $view;
	}

	public function __call($name, $arguments) {
		echo "Method $name not found";
	}
}
