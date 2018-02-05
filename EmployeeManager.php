<?php
include_once 'DBManager.php';

class EmployeeManager {

    //function create a new Employee
    function CreateEmployee($employee_id, $name, $designation, $email, $phone_no, $password, $photo, $current_address, $permanent_address, $father_name, $gender, $date_of_joining, $date_of_birth, $pf_account, $policy_no, $lic_id, $pan, $passport_no, $driving_license_no, $bank_account, $ifsc_code) {
        $current_time = time();
        $ip = $_SERVER["REMOTE_ADDR"];
        $db = new DBManager();
        $sql = "INSERT into ems_employees(employee_id, name, designation, email, phone_no, password, photo, current_address, permanent_address, father_name, gender, date_of_joining, date_of_birth, pf_account, policy_no, lic_id, pan, passport_no, driving_license_no, bank_account, ifsc_code, last_logged_in, ip) 

        Values('$employee_id', '$name','$designation', '$email', $phone_no, '$password','$photo','$current_address','$permanent_address','$father_name','$gender','$date_of_joining','$date_of_birth','$pf_account','$policy_no','$lic_id','$pan','$passport_no','$driving_license_no','$bank_account','$ifsc_code', '$current_time', '$ip')";

        $result = $db->execute($sql);
        return $result;
       
    }
    //function edit a new Employee
    function editEmployee($id, $employee_id, $name, $designation, $email, $phone_no, $password, $photo, $current_address, $permanent_address, $father_name, $gender, $date_of_joining, $date_of_birth, $pf_account, $policy_no, $lic_id, $pan, $passport_no, $driving_license_no, $bank_account, $ifsc_code) {
        $db = new DBManager();
        if($password == '') {
            $sql = "UPDATE ems_employees set employee_id='$employee_id', name='$name', designation='$designation', email='$email', phone_no= '$phone_no', photo='$photo', current_address='$current_address', permanent_address='$permanent_address', father_name='$father_name', gender='$gender', date_of_joining='$date_of_joining', date_of_birth='$date_of_birth', pf_account='$pf_account', policy_no='$policy_no', lic_id='$lic_id', pan='$pan', passport_no='$passport_no', driving_license_no='$driving_license_no', bank_account='$bank_account', ifsc_code='$ifsc_code' where id=$id";
        } else {
            $sql = "UPDATE ems_employees set employee_id='$employee_id', name='$name', designation='$designation', email='$email', phone_no= '$phone_no', password='$password', photo='$photo', current_address='$current_address', permanent_address='$permanent_address', father_name='$father_name', gender='$gender', date_of_joining='$date_of_joining', date_of_birth='$date_of_birth', pf_account='$pf_account', policy_no='$policy_no', lic_id='$lic_id', pan='$pan', passport_no='$passport_no', driving_license_no='$driving_license_no', bank_account='$bank_account', ifsc_code='$ifsc_code' where id=$id";
        }    

        $result = $db->execute($sql);
        return $result;
       
    }
    


    // list all employees
    function listEmployees() {
    	$db = new DBManager();
        $sql = "SELECT * from ems_employees";
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->id[] = $row['id'];
            $this->employee_id[] = $row['employee_id'];
            $this->name[] = $row['name'];
            $this->designation[] = $row['designation'];
            $this->date_of_joining[] = $row['date_of_joining'];
            $this->current_address[] = $row['current_address'];
            $this->status[] = $row['status'];
        }
        return $total;

    }
    // get a particular employee by Id
    function getEmployeeDetails($id) {
        $db = new DBManager();
        $sql = "SELECT * from ems_employees where id=$id";
        $employeeDetails = $db->getARecord($sql);
        return $employeeDetails;

    }
    // get Empoyee by employee_id
    function getEmployeeDetailsByEmployeeId($employee_id) {
        $db = new DBManager();
        if (is_numeric($employee_id)) {
            $sql = "SELECT * from ems_employees where employee_id=$employee_id";
        }
        else {
            $sql = "SELECT * from ems_employees where employee_id='$employee_id'";

        }
        //echo $sql;
        $employeeDetails = $db->getARecord($sql);
        
        return $employeeDetails;

    }
    function checkEmployeeIdExists($checkEmployeeId) {
        $db = new DBManager();
        $sql = "SELECT employee_id from ems_employees";
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            if($row['employee_id'] == $checkEmployeeId) {
                return 1; 
            }
            
        }
    }
    function deleteEmployee($employee_id) {
        $db = new DBManager();
        $sql = "DELETE from ems_employees where employee_id = '$employee_id'";
        $result = $db->execute($sql);
        if($result) {
            return 1; 
        }
    }
    function deletePhoto($db_id) {
        $db = new DBManager();
        $sql = "UPDATE ems_employees set photo = 'defaultuser.png' where id=$db_id";
        $result = $db->execute($sql);
        if($result) {
            return 1; 
        }
    }
    function manageEmployeeId($type, $totalEmployee) {
        $db = new DBManager();
        $sql = "SELECT * from ems_manage_employee_id";
        $total = $db->getNumRow($sql);
        if($total == 0) {
            $sql = "INSERT into ems_manage_employee_id ( type ) Values ( '$type' )";
        }
        else {
           $sql = "UPDATE ems_manage_employee_id set type = '$type'"; 
        }
        $result = $db->execute($sql);
        return $result;
    }
    function listEmployeesName($searchKey) {
        $db = new DBManager();
        $sql = "SELECT * from ems_employees where name LIKE '$searchKey%'";
        $data = $db->getAllRecords($sql);
        $arrayNameList =array();
        $arrayName = array();
        while ($row = $db->getNextRow()) {
            $arrayName['id'] = $row['employee_id'];
            $arrayName['value'] = $row['name'];
            $arrayName['label'] = $row['name'];
            $arrayName['email'] = $row['email'];
            $arrayName['bank_account'] = $row['bank_account'];
            array_push($arrayNameList, $arrayName); 
        }
        return $arrayNameList;
    }
    function changeEmployeeStatus($id, $status) {
        $db = new DBManager();
        if($status == 1) {

            $sql = "UPDATE ems_employees set status = 0 where id='$id'";
        }
        if($status == 0) {
            $sql = "UPDATE ems_employees set status = 1 where id='$id'";
        }
        $result = $db->execute($sql);
        if($result) {
            return 'success'; 
        }
        else {
            return 'fail';
        }
    }

    //function to authenticate employee
    function loginRequest($email, $password) {
        session_start();
        $db = new DBManager();
        $sql = "SELECT * from ems_employees where email='$email'";
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        if($total == 1) {
            while ($row = $db->getNextRow()) {
            $dbid = $row['id'];
            $dbemail = $row['email'];
            $dbpassword = $row['password'];
            $dbemployee_id = $row['employee_id'];
            //$photo = $row['photo'];
            //$db_last_logged_in = $row['last_logged_in'];
            }
            if($dbpassword == $password) {
                $current_time = time();
                $ip = $_SERVER["REMOTE_ADDR"];
                $update_log_in = "UPDATE ems_employees set last_logged_in = '$current_time', ip = '$ip' where email='$email'";
                $result = $db->execute($update_log_in);
                $_SESSION['email'] = $dbemail;
                $_SESSION['id'] = $dbid;
                $_SESSION['employee_id'] = $dbemployee_id;
                //$_SESSION['photo'] = $photo;
                header('Location:employee/home');
            }
            else {
                $_SESSION['loginErrorMsg'] = "Incorrect Username or Password.";
                header('Location:index');
            }
        }
        else {
            $_SESSION['loginErrorMsg'] = "Your are not a vaild user.";
            header('Location:index');
        }
    }
    public function checkUnique($data, $dbfield) {
        $db = new DBManager();
        $sql = "SELECT * from ems_employees where $dbfield='$data'";
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        return $total; 
    }
    public function editCheckUnique($id, $dbfield) {
        $db = new DBManager();
        $sql = "SELECT $dbfield from ems_employees where id=$id";
        $result = $db->getARecord($sql);
        return $result; 
    }
    public function employeeChangePassword($id, $currentPassword, $newPassword) {
        $db = new DBManager();
        $sql = "SELECT * from ems_employees where id=$id";
        $result = $db->getARecord($sql);
        $dbpassword = $result['password'];
        
        if ($currentPassword == $dbpassword) {
            $sql = "UPDATE ems_employees set password = '$newPassword' where id=$id";
            $result = $db->execute($sql);
            $_SESSION['changePasswordSuccessMsg'] = "success";
            header('Location:changePasswordForm');
        }
        else {
            $_SESSION['changePasswordErrorMsg'] = "Your Current Password is incorrect.";
            header('Location:changePasswordForm');
        }

    }
    public function getAutoIncrimentIDEmployee() {
        $databaseName = $GLOBALS['databaseName'];
        $db = new DBManager();
        $sql = "SELECT `AUTO_INCREMENT`
            FROM  INFORMATION_SCHEMA.TABLES
            WHERE TABLE_SCHEMA = '$databaseName'
            AND   TABLE_NAME   = 'ems_employees'";
        $data = $db->getARecord($sql);
        return $data;
 
    }

    public function getEmployeeIdDetails() {
        $db = new DBManager();
        $sql = "SELECT * from ems_employee_auto_id";
        $result = $db->getARecord($sql);
        return $result;
    }
    // check_already_exist_value
    public function check_already_exist_value($value, $field_name) {
        $db = new DBManager();
        $sql = "SELECT * from ems_employees where email = '$value'";
        $total = $db->getNumRow($sql);
        return $total;
    }
    // employee profile update request editProfileRequset
    function editProfileRequset($employee_id, $name, $designation, $email, $phone_no, $password, $photo, $current_address, $permanent_address, $father_name, $gender, $date_of_joining, $date_of_birth, $pf_account, $policy_no, $lic_id, $pan, $passport_no, $driving_license_no, $bank_account, $ifsc_code) {
        date_default_timezone_set('Asia/Kolkata');
        $created_at = date("Y-m-d H:i:s");
        $current_time = time();
        $ip = $_SERVER["REMOTE_ADDR"];
        $db = new DBManager();
        $sql = "INSERT into ems_profile_update_request(employee_id, name, designation, email, phone_no, password, photo, current_address, permanent_address, father_name, gender, date_of_joining, date_of_birth, pf_account, policy_no, lic_id, pan, passport_no, driving_license_no, bank_account, ifsc_code, last_logged_in, ip, created_at) 

        Values('$employee_id', '$name','$designation', '$email', '$phone_no', '$password','$photo','$current_address','$permanent_address','$father_name','$gender','$date_of_joining','$date_of_birth','$pf_account','$policy_no','$lic_id','$pan','$passport_no','$driving_license_no','$bank_account','$ifsc_code','$current_time', '$ip', '$created_at')";

        $result = $db->execute($sql);
        return $result;
       
    }
    // getProfileUpdateRequest
    public function getProfileUpdateRequest() {
        $db = new DBManager();
        $sql = "SELECT * from ems_profile_update_request";
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->request_profile_id[] = $row['id'];
            $this->request_profile_employee_id[] = $row['employee_id'];
            $this->request_profile_name[] = $row['name'];
            $this->request_profile_designation[] = $row['designation'];
            $this->request_profile_date_of_joining[] = $row['date_of_joining'];
            $this->request_profile_current_address[] = $row['current_address'];
            $this->request_profile_status[] = $row['status'];
            $this->request_profile_created_at[] = $row['status'];
        }
        return $total;
    }
    //getRequestProfileEmployeeDetails
    public function getRequestProfileEmployeeDetails($employee_id) {
        $db = new DBManager();
        if(is_numeric($employee_id)) {
            $sql = "SELECT * from ems_profile_update_request where employee_id=$employee_id";
        } else {
            $sql = "SELECT * from ems_profile_update_request where employee_id='$employee_id'";
        }
        
        $employeeDetails = $db->getARecord($sql);
        return $employeeDetails;
    }
    // delete profile update request if profile updated 
    public function deleteProfileUpdateRequest($employee_id) {
        $db = new DBManager();
        if(is_numeric($employee_id)) {
             $sql = "DELETE from ems_profile_update_request where employee_id = $employee_id";
         } else {
            $sql = "DELETE from ems_profile_update_request where employee_id = '$employee_id'";
         }
       
        $result = $db->execute($sql);
        if($result) {
            return 1; 
        }
    }
}
?>