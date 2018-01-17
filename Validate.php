<?php
class Validate {

    function required($key, $value, $page_name) {
    	if($value) {
    		return $value;
    	} else {
    		$errorMesgForm = $key . "can't be Empty";
    		$_SESSION['inputFieldName'] = $key;
    		$_SESSION['inputFieldNameError'] = $key . "can't be Empty";
    		header('Location:createEmployee.php');
    	}
    }
    function removeComma($value) {
        $result = str_replace( ',', '', $value );
        if( is_numeric( $result) ) {
            return $result;
        }
    }
}
?>