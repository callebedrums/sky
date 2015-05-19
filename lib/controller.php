<?php

class Controller {

	public function __call($name, $arguments) {
		echo "Method $name not found";
	}
}
