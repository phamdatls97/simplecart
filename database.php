<?php

class Database{
    public $host = "localhost";
    public $user = "root";
    public $password = "";
    public $database = "simple_shop";
    public $connect;
    /*
     * Phương thức khởi tạo
     * Database constructor
     */
    public function __construct()
    {
        $this->connect = $this->connectDatabase();
    }
    public function connectDatabase(){
        $connect = mysqli_connect($this->host,$this -> user, $this->password, $this->database);
        return $connect;
    }

    public function runQuery($sql){
        $data = array();
        $result = mysqli_query($this->connect, $sql);
        while ($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        };
        return $data;
    }

    public function numRows($sql){
        $result = mysqli_query($this->connect,$sql);
        $count = mysqli_num_rows($result);
        return $count;
    }
}