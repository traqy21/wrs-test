<?php
include_once("config.php");

class db {

    public $con;

    public function __construct()
    {
        $this->con = mysqli_connect(DBHOST , DBUSERNAME , DBPASSWORD , DBNAME, DBPORT);
        if (mysqli_connect_errno()) {
            die("Failed to connect to MySQL: " . mysqli_connect_error());
        }
    }

    public function disconnect(){
        mysqli_close($this->con);
    }

    public function execute($query){
        return mysqli_query($this->con, $query);
    }

    public function executeWithId($query){
        mysqli_query($this->con, $query);
        return $this->con->insert_id;
    }
}