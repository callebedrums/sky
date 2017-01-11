<?php

class Users extends API {
    public function __construct() {
        $this->routes = array(
            'GET' => array(
                $this->regex_endpoint() => 'query',
                $this->regex_endpoint(true) => 'retrieve',
                '/\/users\/([^\/]+)\/([^\/]+)\/?/' => 'test'
            )
            // ,
            // 'POST' => array(
            //     $this->regex_endpoint() => 'create',
            //     $this->regex_endpoint(true) => 'update'
            // ),
            // 'PUT' => array(
            //     $this->regex_endpoint() => 'create',
            //     $this->regex_endpoint(true) => 'update'
            // ),
            // 'DELETE' => array(
            //     $this->regex_endpoint(true) => 'delete'
            // ),
            // 'HEAD' => array(),
            // 'OPTIONS' => array(
            //     $this->regex_endpoint() => 'options'
            // )
        );
    }

    public function query () {
        return "query all";
    }

    public function retrieve($pk) {
        return "retrieve one " . $pk;
    }

    public function test($arg1, $arg2) {
        return "test " . $arg1 . ' - ' . $arg2;
    }
}
