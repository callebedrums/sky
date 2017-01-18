<?php

class Middleware {

    protected static $instance;

    protected function __construct() {

    }

    public static function instance() {
        if (!isset(self::$instance)) {
            self::$instance = new Middleware();
        }
        
        return self::$instance;
    }

    public function run(&$request = null) {
        if ($request) {
            $request['middleware'] = 'not implemented';
        }
    }
}