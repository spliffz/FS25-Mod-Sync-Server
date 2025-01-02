<?php
########################################
## Datum: 31-10-2010 05:39
##
########################################

class db
{
	function connect($sql) {
		$con = new mysqli($sql['host'], $sql['user'], $sql['pass'], $sql['dbase'], $sql['dbport']);

		if ($error = mysqli_connect_error()) {
			echo '<pre>' . print_r($error, TRUE) . '</pre>';
		} else {
			return $con;
		}
	}
	
/* 	function query($query) {
		mysqli_query($query) or die(mysqli_error());
	}
 */	

// END CLASS
}


?>