<?php

$db = mysqli_connect('localhost','username','password','database_name');

if(mysqli_connect_errno())
{
	echo 'failed connnection'.mysqli_connect_error() ;
	die();
}

?>