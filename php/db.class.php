<?php

class DB {

    var $connection;    

    public function __construct($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME) 
    {
        $this->connection = $this->connect($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME);
    }

    private function connect($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME)
    {
        $mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

        return $mysqli;
    }

    // doing it like this so that I can use the connection to do any query type
    public function c()
    {
        return $this->connection;
    }
}
