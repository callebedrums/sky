<?php

require_once(__ROOT__ . "/application/services/AuthenticationIdentifierMiddleware.php");

class AppApi extends API {

    public function __construct($request) {
        // call parent constructor to define defult routes
        // Optional if you don't want the default behavior
        parent::__construct($request);

        $this->middlewares = array(
            'all' => array(Middleware::instance())
        );
    }

}