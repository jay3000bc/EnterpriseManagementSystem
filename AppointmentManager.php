<?php
include_once 'DBManager.php';

class AppointmentManager {
	//save probationer appointment
	public function saveProbationerAppointment($employee_id, $appointment_details, $pdf_name)
	{
		$db = new DBManager();
        $sql = "INSERT into ems_probationer_appointment (employee_id, appointment_details, pdf_name) Value ('$employee_id','$appointment_details','$pdf_name')";
        $result = $db->execute($sql);
        return $result;
	}
	public function getProbationAppointment($employee_id)	
	{
		$db = new DBManager();
        date_default_timezone_set('Asia/Kolkata');
        $current_date = time();
        $created_at = date("Y-m-d", $current_date);
        if (is_numeric($employee_id)) {
            $sql = "SELECT * from ems_probationer_appointment where employee_id=$employee_id";
        } else {
            $sql = "SELECT * from ems_probationer_appointment where employee_id='$employee_id'";
        }
        $probationer_appointment_letter = $db->getARecord($sql);
        return $probationer_appointment_letter;
	}
    public  function checkProbationAppointmentExists($checkEmployeeId) {
        $db = new DBManager();
        if (is_numeric($checkEmployeeId)) {
            $sql = "SELECT appointment_details from ems_probationer_appointment where employee_id=$checkEmployeeId";
        } else {
            $sql = "SELECT appointment_details from ems_probationer_appointment where employee_id='$checkEmployeeId'";
        }
        $total = $db->getNumRow($sql);
        if($total == 0) {
            return $total;
        }
        else {
            $probationer_appointment_letter = $db->getARecord($sql);
            return $probationer_appointment_letter;
        }
    }
    public function updateProbationerAppointment($employee_id, $appointment_details)
    {
        $db = new DBManager();
        if (is_numeric($employee_id)) {
            $sql = "UPDATE ems_probationer_appointment set appointment_details ='$appointment_details' where employee_id=$employee_id";
         } else {

            $sql = "UPDATE ems_probationer_appointment set appointment_details ='$appointment_details' where employee_id='$employee_id'";
        }
        $result = $db->execute($sql);
        return $result;
    }
    public function savePermanentAppointment($employee_id, $appointment_details, $pdf_name)
    {
        $db = new DBManager();
        $sql = "INSERT into ems_permanent_appointment (employee_id, appointment_details, pdf_name) Value ('$employee_id','$appointment_details', '$pdf_name')";
        $result = $db->execute($sql);
        return $result;
    }
    public function getPermanentAppointment($employee_id)   
    {
        $db = new DBManager();
        date_default_timezone_set('Asia/Kolkata');
        $current_date = time();
        $created_at = date("Y-m-d", $current_date);
        if (is_numeric($employee_id)) {
            $sql = "SELECT * from ems_permanent_appointment where employee_id=$employee_id";
        } else {
            $sql = "SELECT * from ems_permanent_appointment where employee_id='$employee_id'";
        }
        $permanent_appointment_letter = $db->getARecord($sql);
        return $permanent_appointment_letter;
    }
    public  function checkPermanentAppointmentExists($checkEmployeeId) {
        $db = new DBManager();
        if (is_numeric($checkEmployeeId)) {
            $sql = "SELECT appointment_details from ems_permanent_appointment where employee_id=$checkEmployeeId";
        } else {
            $sql = "SELECT appointment_details from ems_permanent_appointment where employee_id='$checkEmployeeId'";
        }
        $total = $db->getNumRow($sql);
        if($total == 0) {
            return $total;
        }
        else {
            $permanent_appointment_letter = $db->getARecord($sql);
            return $permanent_appointment_letter;
        }
    }
    public function updatePermanentAppointment($employee_id, $appointment_details)
    {
        $db = new DBManager();
        if (is_numeric($employee_id)) {
            $sql = "UPDATE ems_permanent_appointment set appointment_details ='$appointment_details' where employee_id=$employee_id";
         } else {

            $sql = "UPDATE ems_permanent_appointment set appointment_details ='$appointment_details' where employee_id='$employee_id'";
        }
        $result = $db->execute($sql);
        return $result;
    }
    public  function checkExperienceCertificateExists($checkEmployeeId) {
        $db = new DBManager();
        if (is_numeric($checkEmployeeId)) {
            $sql = "SELECT experience_details from ems_experience_certificate where employee_id=$checkEmployeeId";
        } else {
            $sql = "SELECT experience_details from ems_experience_certificate where employee_id='$checkEmployeeId'";
        }
        $total = $db->getNumRow($sql);
        if($total == 0) {
            return $total;
        }
        else {
            $result = $db->getARecord($sql);
            return $result;
        }
    }
    public function updateExperienceCertificate($employee_id, $experience_details)
    {
        $db = new DBManager();
        if (is_numeric($employee_id)) {
            $sql = "UPDATE ems_experience_certificate set experience_details ='$experience_details' where employee_id=$employee_id";
         } else {

            $sql = "UPDATE ems_experience_certificate set experience_details ='$experience_details' where employee_id='$employee_id'";
        }
        $result = $db->execute($sql);
        return $result;
    }
    public function saveExperienceCertificate($employee_id, $experience_details, $pdf_name)
    {
        $db = new DBManager();
        $sql = "INSERT into ems_experience_certificate (employee_id, experience_details, pdf_name) Value ('$employee_id','$experience_details', '$pdf_name')";
        $result = $db->execute($sql);
        return $result;
    }
     public function getExperienceCertificate($employee_id)   
    {
        $db = new DBManager();
        if (is_numeric($employee_id)) {
            $sql = "SELECT * from ems_experience_certificate where employee_id=$employee_id";
        } else {
            $sql = "SELECT * from ems_experience_certificate where employee_id='$employee_id'";
        }
        $result = $db->getARecord($sql);
        return $result;
    }
}