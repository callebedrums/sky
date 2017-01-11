<?php

class Controller {

	protected $view;

    protected $request;
	
	public function __construct($request, $view = null) {
        $this->request = $request;
		$this->view = $view;
	}

	public function __call($name, $arguments) {
		return "Method $name not found";
	}
}
