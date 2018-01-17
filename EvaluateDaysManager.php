<?php
include_once 'DBManager.php';

class EvaluateDaysManager { 
	public function calculateAvailableCalenderDays($month, $year) {
		$availableCalenderdays = cal_days_in_month(CAL_GREGORIAN,$month, $year);
		return $availableCalenderdays;
	}
	public function working_days($day_count, $month, $year, $sun, $sat) {
		//loop through all days
		for ($i = 1; $i <= $day_count; $i++) {
			$date = $year.'/'.$month.'/'.$i; //format date
	        $get_name = date('l', strtotime($date)); //get week day
	        $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars

	        //if not a weekend add day to array
	        if($day_name != $sun && $day_name != $sat){
	            $workdays[] = $i;
	        } 

		}
		return $workdays;
	}
	public function count_days($available_calender_days, $month , $year, $db_day_name) {
		//loop through all days
		for ($i = 1; $i <= $available_calender_days; $i++) {
			$date = $year.'/'.$month.'/'.$i; //format date
	        $get_name = date('l', strtotime($date)); //get week day
	        $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars

	        //if a weekend holiday add day to array
	        if($day_name == $db_day_name){
	            $days_result[] = $i;
	        } 

		}
		$count_days = count($days_result);
		return $count_days;
	}
	public function getWeeklyDaySelected() {
		$db = new DBManager();
        $sql = "SELECT * from ems_weekly_holidays";
        $data = $db->getAllRecords($sql);
        $total = $db->getNumRow($sql);
        while ($row = $db->getNextRow()) {
            $this->id[] = $row['id'];
            $this->day_name[] = $row['day_name'];
        }
        return $total;
	}
	public function getCutOffStatus() {
		$db = new DBManager();
        $sql = "SELECT * from ems_pay_cut_off";
        $pay_cut_off_result = $db->getARecord($sql);
        return $pay_cut_off_result;
	}
	public function deleteWeeklyDaySelected() {
		$db = new DBManager();
		$delete ="DELETE FROM ems_weekly_holidays";
		$deleteResult = $db->execute($delete);
		return $deleteResult;
	}
	public function saveWeeklyDaySelected($value) {
		$db = new DBManager();
		$sql = "INSERT into ems_weekly_holidays(day_name) Value ('$value')";
        $result = $db->execute($sql);
        return $result;
	}
	public function savePayCutoffStatus($status) {
		$db = new DBManager();
        $sql = "UPDATE ems_pay_cut_off set status = '$status'";
        $result = $db->execute($sql);
        return $result;
	}
}