<?php

class Model {

    public function __construct() {
        $this->db = DB::connect();
    }

    public function __destruct() {
        $this->db = DB::closeConnection();
    }

}
