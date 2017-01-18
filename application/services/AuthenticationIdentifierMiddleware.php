<?php

class AuthenticationIdentifierMiddleware extends Middleware {

    protected static $instance;

    protected function __construct() {

    }

    public static function instance() {
        if (!isset(self::$instance)) {
            self::$instance = new AuthenticationIdentifierMiddleware();
        }
        
        return self::$instance;
    }

    public function run(&$request = null) {
        if ($request) {
            $request['middleware'] = 'implemented';

            // Here comes the middleware implementation.
            // It have to proccess de request and populate $request object
            // with any data generated/retrieved
        }
    }
}