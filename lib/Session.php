<?php

class Session {

	private static $instance;
	
	private function __construct() {
		
	}
	
	public static function instance() {
		if (!isset(self::$instance)) {
			self::$instance = new Session();
		}
		
		return self::$instance;
	}
	
	public function start() {
		session_start();
		session_regenerate_id(true);
	}
	
	public function destroy() {
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
		}
		
		session_destroy();
		session_commit();
	}
}
