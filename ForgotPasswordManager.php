<?php
ini_set('display_errors', 1);
include_once 'DBManager.php';
class ForgotPasswordManager {
	// get account details who request for password details
	public function getAccountDetails($email) {
		$db = new DBManager();
        $sql = "SELECT username as name from ems_admin where email = '$email' UNION All SELECT name as name from ems_employees where email = '$email'";
        $accountDetails = $db->getARecord($sql);
        return $accountDetails;
	}
	// save token
	public function saveToken($email, $token) {
		$db = new DBManager();
		$sql = "INSERT into ems_reset_password(email, token) values ('$email', '$token')";
		$result = $db->execute($sql);
        return $result;
	}
	public	function getBrowser()  {
		$u_agent = $_SERVER['HTTP_USER_AGENT']; 
	    $bname = 'Unknown';
	    $platform = 'Unknown';
	    $version= "";

	    //First get the platform?
	    if (preg_match('/linux/i', $u_agent)) {
	        $platform = 'linux';
	    }
	    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
	        $platform = 'mac';
	    }
	    elseif (preg_match('/windows|win32/i', $u_agent)) {
	        $platform = 'windows';
	    }

	    // Next get the name of the useragent yes seperately and for good reason
	    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
	    { 
	        $bname = 'Internet Explorer'; 
	        $ub = "MSIE"; 
	    } 
	    elseif(preg_match('/Firefox/i',$u_agent)) 
	    { 
	        $bname = 'Mozilla Firefox'; 
	        $ub = "Firefox"; 
	    }
	    elseif(preg_match('/OPR/i',$u_agent)) 
	    { 
	        $bname = 'Opera'; 
	        $ub = "Opera"; 
	    } 
	    elseif(preg_match('/Chrome/i',$u_agent)) 
	    { 
	        $bname = 'Google Chrome'; 
	        $ub = "Chrome"; 
	    } 
	    elseif(preg_match('/Safari/i',$u_agent)) 
	    { 
	        $bname = 'Apple Safari'; 
	        $ub = "Safari"; 
	    } 
	    elseif(preg_match('/Netscape/i',$u_agent)) 
	    { 
	        $bname = 'Netscape'; 
	        $ub = "Netscape"; 
	    } 

	    // finally get the correct version number
	    $known = array('Version', $ub, 'other');
	    $pattern = '#(?<browser>' . join('|', $known) .
	    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	    if (!preg_match_all($pattern, $u_agent, $matches)) {
	        // we have no matching number just continue
	    }

	    // see how many we have
	    $i = count($matches['browser']);
	    if ($i != 1) {
	        //we will have two since we are not using 'other' argument yet
	        //see if version is before or after the name
	        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
	            $version= $matches['version'][0];
	        }
	        else {
	            $version= $matches['version'][1];
	        }
	    }
	    else {
	        $version= $matches['version'][0];
	    }

	    // check if we have a number
	    if ($version==null || $version=="") {$version="?";}

	    return array(
	        'userAgent' => $u_agent,
	        'name'      => $bname,
	        'version'   => $version,
	        'platform'  => $platform,
	        'pattern'    => $pattern
	    );
	} 
	public function getResetPasswordDetails($token) {
		$db = new DBManager();
        $sql = "SELECT * from ems_reset_password where token = '$token'";
        $result = $db->getARecord($sql);
        return $result;
	}
	public function saveResetPassword($email, $password) {
		$db = new DBManager();
		$sql = "SELECT * from ems_admin where email = '$email'";
		$accountDetails = $db->getARecord($sql);
		if(count($accountDetails) > 0) {
			$sql = "UPDATE ems_admin set password = '$password' where email = '$email'";
			$result = $db->execute($sql);
			return $result;
		} else {
			$sql = "UPDATE ems_employees set password = '$password' where email = '$email'";
			$result = $db->execute($sql);
			return $result;
		}
	}
}