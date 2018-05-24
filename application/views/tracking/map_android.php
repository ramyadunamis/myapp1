<html >
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mappiing</title>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAxs2qa3cALVSu4Zz_CyIcaC7P2PtRiww8"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <style>
            #map-canvas 
            { 
/*            height: 100%; 
            width: 100%;*/
            }
        </style>
</head>

<body onload="initialpointsplotting()" style="padding: 0;margin: 0;">
    <?php
//    print_r($tracking_map);
    if($tracking_map && $child_trip_id_details){ ?>
<div id="map-canvas"  style="width: 500px;height: 500px;"></div>
<?php 

foreach($tracking_map as  $TR ) { 
  if ($TR === reset($tracking_map))
       { 
       $lat=$TR['tracking_lati'];
       $log=$TR['tracking_logi'];
       }
}

?>
<script type="text/javascript">
var Lat = $('#id_oldLat1').val();
var Log = $('#id_oldLog1').val();
    var myLatLng = new google.maps.LatLng('<?php echo $lat;?>', '<?php echo $log;?>' ),

        myOptions = {
            zoom: 16,
            center: myLatLng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
            },
        map = new google.maps.Map( document.getElementById( 'map-canvas' ), myOptions ),
        marker = new google.maps.Marker( {position: myLatLng, map: map} );
    
    marker.setMap( map );

         setInterval(function(){ getServerResponse(); }, 3000);



function moveBus( map, marker,oldLat,oldLog,newLat,newLog ) {

var new_LatLng = new google.maps.LatLng( newLat, newLog );
 var old_LatLng = new google.maps.LatLng( oldLat, oldLog );
    marker.setPosition( new_LatLng);   
    map.panTo( new_LatLng );       
var line = new google.maps.Polyline({
    path: [
        old_LatLng, 
       new_LatLng
    ],
    strokeColor: "#7473F4",
    strokeOpacity: 1.0,
    strokeWeight: 6,
    map: map
});

};

function initialpointsplotting(){
    var size = $('#size').val();
 console.log(size);
    for(var i=1 ;i<size;i++){
        
        var j=i-1;
        if(i==1)
            j=1;
            
var oldLat = $('#id_oldLat'+j).val();
var oldLog = $('#id_oldLog'+j).val();
var newLat = $('#id_oldLat'+i).val();
var newLog = $('#id_oldLog'+i).val();
console.log(newLat,newLog);
moveBus( map, marker,oldLat,oldLog,newLat,newLog);
    }
}
function getServerResponse(){
 var size = $('#size').val();
 var size1=size-1;
                $.ajax({
                    type: "POST",
                    url: '<?php echo site_url('tracking/next_lat_lon').'/';?>',
                     data:{oldLat:$("#id_oldLat"+size1).val(),oldLog:$("#id_oldLog"+size1).val(),value_date:$("#value_date").val(),value_bus_id:$("#value_bus_id").val(),value_trip_id:$("#value_trip_id").val(),size:$('#size').val()},
                      success: function(data){
                       var json = JSON.parse(data);
                        document.getElementById("size").value = json['size'];
                        console.log(json);
                       moveBus( map, marker,json['oldLat'], json['oldLog'],json['newLat'],json['newLog']  );
                },
});


}
 </script>
            <?php 

                $i=1;
            $count=count($tracking_map);
            foreach($tracking_map as  $TR ) { 
                    ?>
            <input id="id_oldLat<?php echo $i;?>" type="hidden" value="<?php echo $TR['tracking_lati']; ?>" />
            <input id="id_oldLog<?php echo $i;?>" type="hidden" value="<?php echo $TR['tracking_logi'];?>" />
            <input id="map_id<?php echo $i;?>" type="hidden" value="<?php echo $TR['tracking_id'];?>" />
            <?php  $i++; }  ?>
            <input id="size" type="hidden" value="<?php echo $count;?>" />
            <input id="res" type="hidden" value="1" />

             <input id="value_bus_id" type="hidden" value="<?php echo  $bus_id_map;?>" />
             <input id="value_trip_id" type="hidden" value="<?php echo  $trip_id_map;?>" />
             <input id="value_date" type="hidden" value="<?php echo $this->input->post('date'); ?>" />
            <?php }  
else {
?>

            <div style="color: crimson;font-weight: bold;">The trip with your child is not running at this time.</div>
<?php }  ?>

</body>
</html>
