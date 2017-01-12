<?php

class Result {

    private $result;

    private $num_rows;

    public function __construct($result) {
        $this->result = $result;
        $this->num_rows = mysql_num_rows($result);
    }

    private function trigger_error_access($method, $trace) {
        trigger_error(
            'Undefined property via ' . $method . '(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
    }

    public function __get($attr) {
        switch($attr) {
            case "num_rows":
                return $this->num_rows;
        }
        $this->trigger_error_access(__METHOD__, debug_backtrace());
    }

    public function fetch_assoc () {
        return mysql_fetch_assoc($this->result);
    }
}

class DataBase {

    private static $instance;

    private $database;

    private function __construct() {
        $this->connect();
    }

    public static function instance() {
        if (!isset(self::$instance)) {
            self::$instance = new DataBase();
        }
        
        return self::$instance;
    }

    private function connect () {
        $config = Sky::instance()->config();

        $host = $config['database']['host'];
        $user = $config['database']['user'];
        $passwd = $config['database']['password'];
        $db = $config['database']['database'];

        $this->database = @mysql_connect($host, $user, $passwd);

        if (!$this->database) {
            return "error connecting database: ";
        }

        if (!mysql_select_db($db, $this->database)) {
            return "error selecting database";
        }
    }

    public function disconnect () {
        if (isset($this->database)) {
            mysql_close($this->database);
        }
    }

    public function query ($query) {
        $result = mysql_query($query);

        return new Result($result);
    }
}
