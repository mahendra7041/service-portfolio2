<?php

class DB {

    // connection variable 
    private $dbhost = 'localhost';
    private $dbuser = 'root';
    private $dbpass = '';
    private $dbname = 'mysite';

    // connection object 
    private static $mysqli;

    // table name 
    private static $tableName;

    // mysql query 
    private static $query;
    
    private static $select = "*";
    private static $where = "";
    private static $set = "SET ";
    private static $orderby= "";
    private static $limit;
    private static $lastInsertedId;
    private static $rows;
    private static $fatchData = [];
    public static $isInsert = false;

    private static $requestFile;

    private static $join = '';
    private static $leftJoin = '';
    private static $rightJoin = '';
    private static $innerJoin = '';
    private static $fullJoin = '';

    // create connection 
    public function __construct(){
        static::$mysqli = new mysqli($this->dbhost,$this->dbuser,$this->dbpass,$this->dbname);
        if (static::$mysqli->error) {
            echo static::$mysqli->error;
        }
    }

    // select table name 
    public static function table($tableName){
        static::$tableName = $tableName;
        return new static;
    }

    // insert method 
    public static function insert($data){

        $values = ''; 
        foreach(array_values($data) as $value){
            if (is_int($value)) {
                $values .= $value.",";
            }else{
                $values .= "'".$value."',";
            }
        }

        $keys = "`".implode("`,`",array_keys($data))."`";
        $values = substr_replace($values,"",-1);
        static::$query = "INSERT INTO `".static::$tableName."`(".$keys.") VALUES(".$values.")";
        static::$isInsert = static::$mysqli->query(static::$query);
        static::$lastInsertedId = static::$mysqli->insert_id;
        static::$mysqli->close();

        return new static;
    }

    public static function isInsert(){
        return static::$isInsert;
    }
    // return result method 
    public static function getInsertedId(){
        return static::$lastInsertedId;
    }
    
    // return result method 
    public static function check(){
        if(static::$query === null || static::$query === ''){
            return false;
        }else{
            return true;
        }
    }

    public static function select($coll = "*"){
        static::$select = $coll;
        return new static;
    }

    // fetching all record in table 
    public static function all(){
        static::$query = "SELECT * FROM `". static::$tableName."`";
        $result = static::$mysqli->query(static::$query);
        if ($result->num_rows < 1) {
            return static::$fatchData = [];
        }
        while ($row = $result->fetch_assoc()) {
            static::$fatchData[] = $row;
        }
        static::$mysqli->close();
        return static::$fatchData;
    }

    // fetching first record in table 
    public static function first(){
        static::$query = "SELECT ".static::$select." FROM ". static::$tableName." LIMIT 1";
        $result = static::$mysqli->query(static::$query);
        if ($result->num_rows < 1) {
            return static::$fatchData = [];
        }
        static::$fatchData = $result->fetch_assoc();
        static::$mysqli->close();
        return static::$fatchData;
    }

    // fetchin last record in table 
    public static function last(){
        static::$query = "SELECT ".static::$select." FROM ". static::$tableName." order by id DESC LIMIT 1";
        $result = static::$mysqli->query(static::$query);
        if ($result->num_rows < 1) {
            return static::$fatchData = [];
        }
        static::$fatchData = $result->fetch_assoc();
        static::$mysqli->close();
        return static::$fatchData;
    }

    public static function limit($limit){
        static::$limit = "limit ".$limit;
        return new static;
    }

    public static function orderby($orderby){
        static::$orderby = "order by".$orderby;
        return new static;
    }

    public static function where($where){
        static::$where .= "where ".$where;
        return new static;    
    }

    public static function find($id){
        static::$query = "SELECT ".static::$select." FROM ". static::$tableName." where id =".$id." LIMIT 1";
        $result = static::$mysqli->query(static::$query);
        if ($result->num_rows < 1) {
            return static::$fatchData = [];
        }
        static::$fatchData = $result->fetch_assoc();
        static::$mysqli->close();
        return static::$fatchData;
    }

    public static function delete($id){
        static::$query = "DELETE FROM ". static::$tableName. " where id = ".$id;
        $result = static::$mysqli->query(static::$query);
        static::$mysqli->close();
        return $result;
    }

    public static function update($updateData){
        foreach($updateData as $key => $value){
            if(is_int($value)){
                static::$set .= $key ."=". $value.",";
            }else{
                static::$set .= $key. "='".$value."',";
            }
        }
        static::$query = "UPDATE ". static::$tableName." ".substr_replace(static::$set,"",-1)." ".static::$where;
        $result = static::$mysqli->query(static::$query);
        static::$mysqli->close();
        return $result;
    }

    public static function file($file){
        static::$requestFile = $file;
        return new static;
    }

    public static function store($path){
        $extention = explode('/',static::$requestFile['type'])[1];
        $tmppath = static::$requestFile['tmp_name'];
        $hashName = sha1(uniqid());
        $file = "$path/$hashName.$extention";
        if (!file_exists($path) && !is_dir($path)) {
            mkdir($path);
        }
        if (file_exists($file)) {
            static::store($path);
        }
        if (move_uploaded_file($tmppath,$file)) {
            return $file;
        }
    }

    public static function join($table,$col1,$col2){
        static::$join = "JOIN {$table} ON {$col1} = {$col2}";

        return new static;
    }
    public static function innerJoin($table,$col1,$col2){
        static::$join = "INNER JOIN {$table} ON {$col1} = {$col2}";

        return new static;
    }
    public static function leftJoin($table,$col1,$col2){
        static::$join = "LEFT JOIN {$table} ON {$col1} = {$col2}";

        return new static;
    }
    public static function rightJoin($table,$col1,$col2){
        static::$join = "RIGHT JOIN {$table} ON {$col1} = {$col2}";

        return new static;
    }

    // return result method 
    public static function get(){
        static::$query = "SELECT ".static::$select." FROM ". static::$tableName." ".static::$join." ".static::$where." ".static::$orderby." ".static::$limit;
        // return static::$query;
        $result = static::$mysqli->query(static::$query);
        if ($result->num_rows < 1) {
            return static::$fatchData = [];
        }
        while ($row = $result->fetch_assoc()) {
            static::$fatchData[] = $row;
        }
        static::$mysqli->close();
        return static::$fatchData;
    }
}