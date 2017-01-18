<?php

require_once("AppApi.php");
require_once(__ROOT__ . "/application/services/AuthenticationIdentifierMiddleware.php");

class Example extends AppApi {

    public function __construct($request) {
        // call parent constructor to define defult routes
        // Optional if you don't want the default behavior
        parent::__construct($request);

        $this->routes['GET']['/\/example\/([^\/]+)\/([^\/]+)\/?/'] = 'testAction';
    }

    /**
     * GET /api/<classname>/
     * query all instance
     *
     * required by default behavior
     * */
    public function query() {
        return "query ". $this->request['middleware'];
    }
    
    /**
     * POST /api/<classname>
     * create new instance
     *
     * required by default behavior
     * */
    public function create() {
        return "create";
    }
    
    /**
     * GET /api/<classname>/id/
     * get an instance
     *
     * required by default behavior
     * */
    public function retrieve($pk) {
        return "retrieve " . $pk ." ". $this->request['middleware'];
    }
    
    /**
     * PUT /api/<classname>/id/
     * update an instance
     *
     * required by default behavior
     * */
    public function update($pk) {
        return "update " . $pk;
    }
    
    /**
     * DELETE /api/<classname>/id/
     * remove an instance
     *
     * required by default behavior
     * */
    public function delete($pk) {
        return "delete " . $pk;
    }

    public function testAction ($arg1, $arg2) {
        return "testAction " . $arg1 . ' - ' . $arg2;
    }
}
