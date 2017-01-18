<?php

require_once("AppApi.php");
require_once(__ROOT__ . "/application/services/DataBase.php");

class Users extends AppApi {
    
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
        $result = DataBase::instance()->query("select * from user where username = 'callebe.gomes'");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return "user: " . $row['username'];
        }
        return "no results";
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
