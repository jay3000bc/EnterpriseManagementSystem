<?php
include_once('settings/config.php');
class DBManager {
    var $records;
    var $conn;
    var $mysqlConnectError;
    var $checkTableExist;
    function __construct() {
        
        $this->conn = mysqli_connect($GLOBALS['host'], $GLOBALS['databaseUser'], $GLOBALS['databasePassword'], $GLOBALS['databaseName']);
           
        if (mysqli_connect_errno())
        {
          $this->mysqlConnectError = "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $this->checkTableExist = mysqli_query($this->conn, 'select 1 from `ems_admin`');
    }

    function execute($sqlStr) {
        
        $execute = mysqli_query($this->conn, $sqlStr) or die(mysqli_error($this->conn));
        return $execute;
    }
    
    //function to get a record
    function getARecord($sqlStr) {
        $result = mysqli_query($this->conn, $sqlStr)or die(mysqli_error($this->conn));
        $aRow = mysqli_fetch_assoc($result);
        return $aRow;
    }

    function getAllRecords($sqlStr) {
        $this->records = mysqli_query($this->conn, $sqlStr) or die(mysqli_error($this->conn));
        //echo "string"; die();
    }

    //function to get next row
    function getNextRow() {
        $aRow = mysqli_fetch_assoc($this->records);
        return $aRow;
    }

    //Function to get total number of rows
    function getNumRow($sqlStr) {
        $result = mysqli_query($this->conn, $sqlStr) or die(mysqli_error($this->conn));
        $num = mysqli_num_rows($result);
        return $num;
    }

    function getAllRecordsRow($sqlStr) {
        $result = mysqli_query($this->conn, $sqlStr) or die(mysqli_error($this->conn));
        return $result;
        //echo "string"; die();
    }
}
?>