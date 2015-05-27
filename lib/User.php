<?php

class User {

	private $id;
	private $username;
	private $password;
	
	public function __construct($id = null, $username = null) {
		$this->setId($id);
		$this->setUsername($username);
	}
	
	private function trigger_error_access($method, $trace) {
		trigger_error(
			'Undefined property via ' . $method . '(): ' . $name .
			' in ' . $trace[0]['file'] .
			' on line ' . $trace[0]['line'],
			E_USER_NOTICE);
	}
	
	public function __set($attr, $value) {
		switch($attr) {
			case "id":
				$this->setId($value);
				break;
			case "username":
				$this->setUsername($value);
				break;
		}
		$this->trigger_error_access(__METHOD__, debug_backtrace());
	}
	
	public function __get($attr){
		switch($attr) {
			case "id":
				return $this->getId();
				break;
			case "username":
				return $this->getUsername();
				break;
		}
		
		$this->trigger_error_access(__METHOD__, debug_backtrace());
		return null;
	}
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setUsername($username) {
		$this->username = $username;
	}
	
	public function getUsername() {
		return $this->username;
	}
	
	public function setPassword($password) {
		$this->password = crypt($password);
		echo $this->password;
	}
	
	public function validatePassword($password) {
		return crypt($password, $this->password) == $this->password;
	}

}
