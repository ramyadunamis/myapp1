<?php 
if($tracing_values)
{
$result_array=array(
"oldLat"=>$tracing_values_back['tracking_lati'],
"oldLog"=>$tracing_values_back['tracking_logi'],
"newLat"=>$tracing_values['tracking_lati'],
"newLog"=>$tracing_values['tracking_logi'],
"size"=>$size+1
); 
echo $json=json_encode($result_array);
}
else
{
   
}
?>
