<?php

class Example extends API {

    public function __construct() {
        // call parent constructor to define defult routes
        // Optional if you don't want the default behavior
        parent::__construct();

        $this->routes['GET']['/\/example\/([^\/]+)\/([^\/]+)\/?/'] = 'testAction';
    }

    /**
     * GET /api/<classname>/
     * query all instance
     *
     * required by default behavior
     * */
    public function query() {
        return "query";
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
        return "retrieve " . $pk;
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
