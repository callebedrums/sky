<?php

class Index extends Controller {
	
	public function action() {
		return file_get_contents('application/templates/index.html');
	}
}
