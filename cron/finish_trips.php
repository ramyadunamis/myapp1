<?php
$username = "safety";
$password = "yWq8LF675+MU";
$hostname = "localhost"; 
$db="safety_db";
$dbhandle = new mysqli($hostname, $username, $password, $db);
if($dbhandle->connect_errno > 0){
    die('Unable to connect to database [' . $dbhandle->connect_error . ']');exit();
}
$running_buses= $dbhandle->query("select * from Bus where bus_running_satus='running'");  
while($value=$running_buses->fetch_assoc())
{
      $insert_finish_trip_table=   $dbhandle->query("insert into Finish_trip_details(`finish_trip_id`, `finish_bus_id`) VALUES ('".$value['bus_current_trip_id']."','".$value['bus_id']."')"); 
      $change_status_running_buses=  $dbhandle->query("UPDATE `Bus` SET bus_running_satus='not running' where bus_id='".$value['bus_id']."'");
}
?>