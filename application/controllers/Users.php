<?php

class Users extends Controller{

	/* /users/index */
	public function index() {
		$this->view->render();
	}
	
	/* /users/myAction2/<param1> */
	public function myAction2($param1) {
		var_dump($param1);
		$this->view->render();
	}
	
	/* /users/myAction3/<param1>/<param2> */
	public function myAction3($param1, $param2) {
		var_dump($param1);
		var_dump($param2);
		$this->view->render(null, 'myAction2');
	}
}
