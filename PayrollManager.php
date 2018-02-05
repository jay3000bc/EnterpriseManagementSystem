<?php
include_once 'DBManager.php';

class PayrollManager {

    //function to save payroll
    function savePayroll($employee_id, $basic, $house_rent_allowance, $conveyance_allowance, $special_allowance, $bonus, $overtime, $overtimeAmount, $professional_tax, $income_tax, $provident_fund, $health_insurance, $un_paid_days, $misc, $gross_earnings, $gross_deductions, $net_pay, $pdf_name, $paid_days_count, $un_paid_days_count, $status) {
        
        date_default_timezone_set('Asia/Kolkata');
        $current_date = time();
        $created_at = date("Y-m-d", $current_date);
        $db = new DBManager();
        $sql = "INSERT into ems_payroll (employee_id, basic, house_rent_allowance, conveyance_allowance, special_allowance, bonus, overtime, overtimeAmount, professional_tax, income_tax, provident_fund, health_insurance, un_paid_days, misc, gross_earnings, gross_deductions, net_pay, pdf_name, paid_days_count, un_paid_days_count, status, created_at) 
        Values('$employee_id', '$basic', '$house_rent_allowance', '$conveyance_allowance', '$special_allowance', '$bonus', '$overtime', '$overtimeAmount' ,'$professional_tax', '$income_tax', '$provident_fund', '$health_insurance', '$un_paid_days', '$misc', '$gross_earnings', '$gross_deductions', '$net_pay', '$pdf_name','$paid_days_count', '$un_paid_days_count', '$status', '$created_at')";
        $result = $db->execute($sql);
        return $result;
    }
    
    function getEmployeePayroll($employee_id) {
        $db = new DBManager();
        date_default_timezone_set('Asia/Kolkata');
        $current_date = time();
        $created_at = date("Y-m-d", $current_date);
        //echo $created_at;
        //die();
        if (is_numeric($employee_id)) {
            $sql = "SELECT * from ems_payroll where employee_id=$employee_id and created_at = '$created_at'";
        } else {
            $sql = "SELECT * from ems_payroll where employee_id='$employee_id' and created_at = '$created_at'";
        }
        $payrollDeatils = $db->getARecord($sql);
        return $payrollDeatils;
    }
    function getAllEmployeePayroll($employee_id) {
        $db = new DBManager();
        date_default_timezone_set('Asia/Kolkata');
        $current_date = time();
        $created_at = date("Y-m-d", $current_date);
        //echo $created_at;
        //die();
        if (is_numeric($employee_id)) {
            $sql = "SELECT * from ems_payroll where employee_id=$employee_id";
        } else {
            $sql = "SELECT * from ems_payroll where employee_id='$employee_id'";
        }
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->employee_id[] = $row['employee_id'];
            $this->pdf_name[] = $row['pdf_name'];
            $this->paid_days_count[] = $row['paid_days_count'];
            $this->status[] = $row['status'];
            $this->created_at[] = $row['created_at'];
            $this->net_pay[] = $row['net_pay'];
        }
        return $total;
    }
    // list all payroll
    function listPayroll() {
        $db = new DBManager();
        $sql = "SELECT ems_payroll.employee_id, ems_employees.name, ems_payroll.pdf_name, ems_payroll.net_pay, ems_payroll.status, ems_payroll.created_at  from ems_payroll, ems_employees where ems_payroll.employee_id = ems_employees.employee_id order by  ems_payroll.created_at DESC";
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->employee_id[] = $row['employee_id'];
            $this->name[] = $row['name'];
            $this->pdf_name[] = $row['pdf_name'];
            $this->net_pay[] = $row['net_pay'];
            $this->status[] = $row['status'];
            $this->created_at[] = $row['created_at'];
        }
        return $total;
    }

    //function to preview payroll
    function previewPayroll($employee_id, $basic, $house_rent_allowance, $conveyance_allowance, $special_allowance, $bonus, $overtime, $overtimeAmount, $professional_tax, $income_tax, $provident_fund, $health_insurance, $un_paid_days, $misc, $gross_earnings, $gross_deductions, $net_pay, $pdf_name, $paid_days_count, $un_paid_days_count, $status) {
        
        date_default_timezone_set('Asia/Kolkata');
        $current_date = time();
        $created_at = date("Y-m-d", $current_date);
        $db = new DBManager();
        $sql = "DELETE from ems_preview_payroll";
        $result = $db->execute($sql);
        $sql = "INSERT into ems_preview_payroll (employee_id, basic, house_rent_allowance, conveyance_allowance, special_allowance, bonus, overtime, overtimeAmount, professional_tax, income_tax, provident_fund, health_insurance, un_paid_days, misc, gross_earnings, gross_deductions, net_pay, pdf_name, paid_days_count, un_paid_days_count, status, created_at) 
        Values('$employee_id', '$basic', '$house_rent_allowance', '$conveyance_allowance', '$special_allowance', '$bonus', '$overtime', '$overtimeAmount' ,'$professional_tax', '$income_tax', '$provident_fund', '$health_insurance', '$un_paid_days', '$misc', '$gross_earnings', '$gross_deductions', '$net_pay', '$pdf_name','$paid_days_count', '$un_paid_days_count', '$status', '$created_at')";
        $result = $db->execute($sql);
        return $result;
    }
    // get preview details
    function getPreviewPayroll() {
        $db = new DBManager();
        $sql = "SELECT * from ems_preview_payroll";
        $result = $db->getARecord($sql);
        return $result;
    }
    //check_payroll_already_generated
    public function checkPayrollAlreadyGenerated($employee_id, $currentMonth) {
        $db = new DBManager();
        if(is_numeric($employee_id)) {
            $sql = "SELECT * from ems_payroll where employee_id = $employee_id and Year(updated_at) = Year(CURRENT_TIMESTAMP) 
                 AND Month(updated_at) = Month(CURRENT_TIMESTAMP)";
        } else {
            $sql = "SELECT * from ems_payroll where DATE_FORMAT(created_at, '$currentMonth') and employee_id = '$employee_id'";
        }
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        return $total;
    }
}