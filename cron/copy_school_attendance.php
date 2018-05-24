<?php
$username = "safety";
$password = "yWq8LF675+MU";
$hostname = "localhost"; 
$db="safety_db";;
$dbhandle = new mysqli($hostname, $username, $password, $db);
if($dbhandle->connect_errno > 0){
    die('Unable to connect to database [' . $dbhandle->connect_error . ']');exit();
}
$datebefore3months= date("Y-m-d",strtotime("-3 Months"));

$insert_school_attendance=  $dbhandle->query("insert into Copy_school_attendance  SELECT * FROM `School_attendance` WHERE date(`at_time_stamp`) <= '$datebefore3months'"); 

$delete_attendance= $dbhandle->query(" DELETE FROM `School_attendance` WHERE date(`at_time_stamp`) <= '$datebefore3months'"); 

?>