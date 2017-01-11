<?php

class Users extends API {
    
    public function __construct($request) {
        parent::__construct($request);

        $this->routes = array(
            'GET' => array(
                $this->regex_endpoint() => 'query',
                $this->regex_endpoint(true) => 'retrieve',
                '/\/users\/([^\/]+)\/([^\/]+)\/?/' => 'test'
            )
            ,
            'POST' => array(
                $this->regex_endpoint() => 'create',
                $this->regex_endpoint(true) => 'update'
            )
        );
    }

    public function query () {
        return "query all";
    }

    public function retrieve ($pk) {
        return "retrieve one " . $pk;
    }

    public function test ($arg1, $arg2) {
        return "test " . $arg1 . ' - ' . $arg2;
    }

    public function create () {
        return array('data'=> 'aaa', 'test' => $this->request['BODY_JSON']['test']);
    }

    public function update ($pk) {
        return "update ". $pk;
    }
}
