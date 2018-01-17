<?php
include_once 'DBManager.php';
class AdminManager {

    //function to authenticate admin
    function SubmitForm($username,$password) {
        //echo $username; die();
        $db = new DBManager();
        $sql = "SELECT * from ems_admin";
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $dbusername = $row['username'];
            $dbpassword = $row['password'];
            $photo = $row['photo'];
            $db_last_logged_in = $row['last_logged_in'];
        }
        if($dbusername == $username and $dbpassword == $password) {
            $current_time = time();
            $ip = $_SERVER["REMOTE_ADDR"];
            $update_log_in = "UPDATE ems_admin set last_logged_in = '$current_time', ip = '$ip'";
            $result = $db->execute($update_log_in);
        	$_SESSION['username'] = $dbusername;
            $_SESSION['last_logged_in'] = $db_last_logged_in;
            $_SESSION['photo'] = $photo;
        	header('Location:adminHome.php');
        }
        else {
        	$_SESSION['loginErrorMsg'] = "Incorrect Username or Password.";
        	 header('Location:index.php');
        }
       
    }
    function ChangePassword($currentPassword, $newPassword) {
    	$db = new DBManager();
        $sql = "SELECT * from ems_admin";
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $dbpassword = $row['password'];
        }
        if ($currentPassword == $dbpassword) {
        	$sql = "UPDATE ems_admin set password = '$newPassword'";
        	$result = $db->execute($sql);
        	$_SESSION['changePasswordSuccessMsg'] = "success";
        	header('Location:changePasswordForm.php');
        }
        else {
        	$_SESSION['changePasswordErrorMsg'] = "Your Current Password is incorrect.";
        	header('Location:changePasswordForm.php');
        }

    }
    function ChangePhoto($changePhoto) {
        $db = new DBManager();
        $sql = "UPDATE ems_admin set photo = '$changePhoto'";
        $result = $db->execute($sql);
        unset($_SESSION['photo']);
        $_SESSION['photo'] = $changePhoto;
        $_SESSION['changePhotoSuccessMsg'] = "success";
        header('Location:changePasswordForm.php');
    }
    // get a particular admin
    function getAdminDetails() {
        $db = new DBManager();
        $sql = "SELECT * from ems_admin";
        $adminDetails = $db->getARecord($sql);
        return $adminDetails;

    }
    function deletePhoto($db_id, $db_photo) {
        $db = new DBManager();
        if($db_photo != 'avatar5.png') {
            unlink('uploads/'.$db_photo);
            $sql = "UPDATE ems_admin set photo = 'avatar5.png' where id=$db_id";
            $result = $db->execute($sql);
            if($result) {
                unset($_SESSION['photo']);
                return 1; 
            }    
        }
        else {
            return 2;
        }
    }
    function updateCompanyProfile($company_name, $company_address, $state, $contact_number, $email, $crn, $gstin, $pan, $photo, $company_logo, $signature) {
        $db = new DBManager();
        $sql = "UPDATE ems_admin set company_name='$company_name', company_address='$company_address', state='$state' ,contact_number='$contact_number', email='$email', crn='$crn', gstin='$gstin', pan='$pan', photo='$photo', company_logo='$company_logo', signature='$signature' where id=1";
        $result = $db->execute($sql);
        return $result;
    }
    function getEmployeeTermsConditions() {
        $db = new DBManager();
        $sql = "SELECT * from ems_employee_terms_conditions";
        $employee_terms_conditions = $db->getARecord($sql);
        return $employee_terms_conditions;

    }
    function updateEmployeeTermsConditions($employee_terms_conditions) {
        $db = new DBManager();
        $sql = "UPDATE ems_employee_terms_conditions set file_name='$employee_terms_conditions' where id=1";
        $result = $db->execute($sql);
        return $result;  
    }
    public function getStates() {
        $db = new DBManager();
        $sql = "SELECT * from ems_states";
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->state_id[] = $row['id'];
            $this->state_name[] = $row['state_name'];
            $this->state_gst_code[] = $row['state_gst_code'];
        }
        return $total;
    }
    public function saveSacCode($sac) {
        $db = new DBManager();
        $sql = "INSERT into ems_company_sac(sac) values ('$sac')";
        $result = $db->execute($sql);
        return $result; 
    }
    public function updateSacCode($sac_id, $sac) {
        $db = new DBManager();
        $sql = "UPDATE ems_company_sac set sac = '$sac' where id=$sac_id";
        $result = $db->execute($sql);
        return $result; 
    }
    public function getSac() {
        $db = new DBManager();
        $sql = "SELECT * from ems_company_sac";
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->sac_id[] = $row['id'];
            $this->sac[] = $row['sac'];
        }
        return $total;
    }
    public function getBankDetails() {
        $db = new DBManager();
        $sql = "SELECT * from ems_company_bank_details";
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->bank_id[] = $row['id'];
            $this->bank_name[] = $row['bank_name'];
            $this->bank_account_no[] = $row['bank_account_no'];
            $this->ifsc[] = $row['ifsc'];
        }
        return $total;
    }

    // get a bank details
    public function getABankDetails($bank_id) {
        $db = new DBManager();
        $sql = "SELECT * from ems_company_bank_details where id=$bank_id";
        $result = $db->getARecord($sql);
        return $result;
    }

    public function saveBankDetails($bank_name_clone, $bank_account_no_clone, $ifsc_clone) {
        $db = new DBManager();
        $sql = "INSERT into ems_company_bank_details (bank_name, bank_account_no, ifsc) values ('$bank_name_clone', '$bank_account_no_clone', '$ifsc_clone')";
        $result = $db->execute($sql);
        return $result; 
    }

    public function updateBankDetails($bank_id, $bank_name, $bank_account_no, $ifsc) {
        $db = new DBManager();
        $sql = "UPDATE ems_company_bank_details set bank_name = '$bank_name', bank_account_no ='$bank_account_no', ifsc = '$ifsc' where id=$bank_id";
        $result = $db->execute($sql);
        return $result; 
    }
    public function deleteBankDetails($delete_bank_id) {
        $db = new DBManager();
        $sql = "DELETE from ems_company_bank_details where id='$delete_bank_id'";
        $result = $db->execute($sql);
        if($result) {
            return 1; 
        } else {
            return 2;
        }
    }

    

    // delete sac function
    public function deleteSacDetails($id) {
        $db = new DBManager();
        $sql = "DELETE from ems_company_sac where id='$id'";
        $result = $db->execute($sql);
        if($result) {
            return 1; 
        } else {
            return 2;
        }
    }

    //chechSACDublicate
    public function chechSACDublicate($sac_code_value) {
        $db = new DBManager();
        $sql = "SELECT * from ems_company_sac where sac = $sac_code_value";
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        return $total;
    }
}
?>