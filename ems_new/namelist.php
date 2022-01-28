<?php 
$term = trim(strip_tags($_GET['term'])); 
include_once 'EmployeeManager.php';
$employeeManager = new EmployeeManager();
$result = $employeeManager->listEmployeesName($term);
echo json_encode($result);
?>