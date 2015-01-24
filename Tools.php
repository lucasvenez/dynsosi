<?php
/*
 * Created on 20/07/2010
 * Author Lucas Venezian Povoa
 */
 
class Tools {
	
	/**
	 * Use this method to convert a date in dd/mm/yyyy format to a date in yyyy-mm-dd format.
	 * @author Lucas Venezian Povoa
	 * @since 20/07/2010
	 * @param $date is the value that will be conveted.
	 * @return a string with new date value formated as yyyy-mm-dd if date param be valid, or
	 * false if date param not be valid. 
	 */
	static function toMySQLFormat( $date ) {
		
		$result = false;
		
		$regularExpression = "/([0-9]|[0,1,2][0-9]|3[0,1])\/([0]?[\d]|1[0,1,2])\/[0-9]{4}/";

		if ( preg_match( $regularExpression, $date ) ) {

			$array = explode( "/", $date );
		
			$result = $array[2] . "-" . $array[1] . "-" . $array[0];
		}
		
		return $result;
	}
	
	/**
	 * Method used to validate a registration number from Unesp.
	 * Enter description here ...
	 * @param Integer $registrationNumber
	 * @return true if the registration number was validate or false otherwise.
	 */
	static function validRegistrationNumber( $registrationNumber ) {
		
		$result = false;
		
		return $result;
	}
}
?>