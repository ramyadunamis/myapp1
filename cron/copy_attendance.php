<?php
$username = "safety";
$password = "yWq8LF675+MU";
$hostname = "localhost"; 
$db="safety_db";
$dbhandle = new mysqli($hostname, $username, $password, $db);
if($dbhandle->connect_errno > 0){
    die('Unable to connect to database [' . $dbhandle->connect_error . ']');exit();
}
$insert_cp_attendance=  $dbhandle->query("insert into copy_attendance  SELECT * FROM `Attendance` WHERE date(`at_time_stamp`) < date(DATE_SUB(date(now()),INTERVAL 7 DAY))"); 
$delete_attendance= $dbhandle->query("   DELETE FROM `Attendance` WHERE date(`at_time_stamp`) < date(DATE_SUB(date(now()),INTERVAL 7 DAY))"); 

?>