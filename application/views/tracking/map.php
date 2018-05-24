<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php include realpath('.').'/application/views/'.'title_inc.php'; ?></title>
         <!-- Bootstrap -->
    <link href="<?php echo base_url()."public/";?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  
    <!-- Custom Theme Style -->
    <link href="<?php echo base_url()."public/";?>build/css/custom.min.css" rel="stylesheet">
<!--    datepicker-->

<link rel="stylesheet" href="<?php echo base_url()."public/";?>vendors/calendar/jquery-ui.css">
<script src="<?php echo base_url()."public/";?>vendors/calendar/jquery-1.10.2.js"></script>
<script src="<?php echo base_url()."public/";?>vendors/calendar/jquery-ui.js"></script>
<script>
$(function() {
$( "#datepicker" ).datepicker();
});
</script>

<!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>-->
        <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAxs2qa3cALVSu4Zz_CyIcaC7P2PtRiww8"></script>
        
<!-- <script src="//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyAxs2qa3cALVSu4Zz_CyIcaC7P2PtRiww8" async="" defer="defer" type="text/javascript"></script>-->
        <style>
            #map-canvas 
            { 
/*            height: 100%; 
            width: 100%;*/
            }
        </style>
        
        <script>
            function gettrip()
            {

              var id=$("#bus").val();
                $.ajax({
                    type: "POST",
                    url: '<?php echo site_url('tracking/ajax_list_index').'/';?>'+id,
                    data: id='cat_id',
                    success: function(data){
                     //  alert(data);
                        $('#trip_val').html(data);
                },
});
            }
            </script>
        <?php
        include realpath('.').'/application/views/'.'head_inc.php'; ?>

    </head>

    <body class="nav-md" onload="initialpointsplotting()">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">                      
                        <!-- left Panel -->
                        <?php //include 'left_menu_inc.php'; 
                        include realpath('.').'/application/views/'.'left_menu_inc.php';
                        ?>
                        <!-- /left panel -->
                    </div>
                </div>
                <!-- top navigation -->
                <?php include realpath('.').'/application/views/'.'top_inc.php'; ?>
                <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main" >
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3> <small</small></h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>MAP <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                 <div class="pull">
                 <?php echo form_open('tracking/map',array("class"=>"form-horizontal")); ?>    
                   Date: <input type="text" id="datepicker" name="date" value="<?php echo $this->input->post('date'); ?>">
                    Bus Name:<select name="bus" id="bus" onChange="gettrip()">
                       
                         <option value="">...select Bus Name...</option>
                         
                        <?php foreach($bus as $B){ ?> 
                      <option value="<?php echo $B['bus_id'];?>" <?php  if( $this->input->post('bus')==$B['bus_id']){;?>  <?php echo 'selected';} ?>><?php echo $B['bus_desc'];?></option>
                    <?php } ?>
                    </select>
                    Trip Number:  <select name="trip" id="trip_val" >
                           <option value="">...Select Trip Number...</option>
                        <?php  foreach($trip_num as $T){ ?>

                        <option value="<?php echo $T['trip_id'];?>" <?php if( $this->input->post('trip')==$T['trip_id']) {?> selected <?php } ?>><?php echo $T['trip_no'];?></option>
                        <?php } ?>
                       </select>
                    <button type="submit" class="btn btn-success">Search</button>
</div>
  <?php if(($this->input->post('bus')!='')){ 
           if(($tracking_map)){
         ?>
<div id="map-canvas" style="width: 500px; height: 500px;"></div>
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


//    moveBus( map, marker,0,0,50,50 );
//    moveBus( map, marker,50,50,60,60 );
//    moveBus( map, marker,60,60,70,70 );
//    moveBus( map, marker,70,70,80,80 );
//         alert($('#res').val());
         setInterval(function(){ getServerResponse(); }, 5000);
       



//moveBus( map, marker,24.420421, 54.490582,24.419110, 54.492183 );
//moveBus( map, marker,24.420421, 54.490582,24.419110, 54.492184 );
//moveBus( map, marker,24.420421, 54.490582,24.419110, 54.492185 );
//moveBus( map, marker,24.420421, 54.490582,24.419110, 54.492186 );




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
    for(var i=1 ;i<=size;i++){
        
        var j=i-1;
        if(i==1)
            j=1;
            
var oldLat = $('#id_oldLat'+j).val();

   
if(oldLat==0 || oldLat=='')
{  
     j=j-1;
    var oldLat=$('#id_oldLat'+j).val();
}
else
{
     var oldLat=$('#id_oldLat'+j).val();
}


var oldLog = $('#id_oldLog'+j).val();

if(oldLog==0 || oldLog=='')
{  
  j=j-1;
  var   oldLat=$('#id_oldLat'+j).val();
}
else
{
    var  oldLat=$('#id_oldLat'+j).val();
}

var newLat = $('#id_oldLat'+i).val();
var newLog = $('#id_oldLog'+i).val();
// console.log('here');
 if(newLat=="" || newLat==0 || newLog=="" || newLog==0)
    {
        moveBus( map, marker,oldLat,oldLog,oldLat,oldLog);
     }
    else
    {
    moveBus( map, marker,oldLat,oldLog,newLat,newLog);
    }
    }
}
function getServerResponse(){
//console.log('here yes');
 var size = $('#size').val();
 var size1=size-1;
                $.ajax({
                    type: "POST",
                    url: '<?php echo site_url('tracking/next_lat_lon').'/';?>',
                     data:{oldLat:$("#id_oldLat"+size1).val(),oldLog:$("#id_oldLog"+size1).val(),value_date:$("#value_date").val(),value_bus_id:$("#value_bus_id").val(),value_trip_id:$("#value_trip_id").val(),size:$('#size').val()},
                      success: function(data){
                       var json = JSON.parse(data);
                        document.getElementById("size").value = json['size'];
                       // console.log(json);
                       if(json['newLat']=="" || json['newLat']==0 || json['newLog']=="" || json['newLog']==0)
                       { console.log('11111');
                           
                           if(json['oldLat']!="" || json['oldLat']!=0 || json['oldLog']!="" || json['oldLog']!=0)
                           {
                           // console.log('skip');
                            document.getElementById("zero_old_lat").value=json['oldLat'];
                            document.getElementById("zero_old_long").value=json['oldLog'];
                            }
                       }
                       else if(json['oldLat']=="" || json['oldLat']==0 || json['oldLog']=="" || json['oldLog']==0)
                       {
                            //console.log('22222222222');
                           var old_lat=document.getElementById("zero_old_lat").value;;
                           var old_long=document.getElementById("zero_old_long").value;;
                           
                            moveBus( map, marker,old_lat, old_long,json['newLat'],json['newLog']);
                       }
                       else
                       {
                           //console.log('333333');
                           // console.log(newLat,newLog);
                        moveBus( map, marker,json['oldLat'], json['oldLog'],json['newLat'],json['newLog']);
                       }
                },
});


}





            </script>
            <?php 
//  if($tracking_map){
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
             <input id="value_bus_id" type="hidden" value="<?php echo $this->input->post('bus');?>" />
             <input id="value_trip_id" type="hidden" value="<?php echo $this->input->post('trip');?>" />
             <input id="value_date" type="hidden" value="<?php echo $this->input->post('date'); ?>" />
             <input id="zero_old_lat" type="hidden" value="" />
             <input id="zero_old_long" type="hidden" value="" />
            
   
<?php }  
else {
?>

             <div style="color: crimson; font-weight: bold;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The trip with your child is not running at this time.</div>
  <?php } }  ?>
            
                  </div>
                </div>
              </div>

        <?php echo form_close(); ?>     

             

 

             
            </div>
          </div>
        </div>

              
      
        <!-- /page content -->

            <!-- footer content -->
                <?php include realpath('.').'/application/views/'.'footer_inc.php'; ?>
               <!-- /footer content -->
          
      
    </div>
  </div>
<!--     jQuery 
    <script src="<?php echo base_url()."public/";?>vendors/jquery/dist/jquery.min.js"></script>
     Bootstrap 
-->    <script src="<?php echo base_url()."public/";?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>

     Custom Theme Scripts 
    <script src="<?php echo base_url()."public/";?>build/js/custom.min.js"></script>

  
   
    <!-- /Datatables -->
  </body>
</html> 