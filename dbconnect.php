<?php
class DBManager { 
    var $conn;
    function __construct() {

        $this->conn = mysqli_connect("localhost", "mukesh", "MKUghy49", "mukesh");
        
        if (mysqli_connect_errno())
        {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
    }
}    
   
?>