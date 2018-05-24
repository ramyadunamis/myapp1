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
 <script>
            function gettrip(id)
            {
              // alert('this id value :'+id);
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

    <body class="nav-md">
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

<!--              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>-->
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>TRACKING LIST <small></small></h2>
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
                 <?php echo form_open('tracking/search',array("class"=>"form-horizontal",'method'=>"get")); ?>    
                    Date: <input type="text" id="datepicker" name="date" value="<?php echo $this->input->get('date'); ?>">
<!--                     Bus Name:<select name="bus" id="bus" onChange="gettrip(this.value)">-->
                     Bus Name:<select name="bus" id="bus">
                         <option value="">...select Bus Name...</option>
                          <option value="1" <?php if($this->input->get('bus')==1){?> selected  <?php } ?> ><?php echo 4;?></option>
                        <?php //foreach($bus as $B){ ?> 
<!--                      <option value="<?php echo $B['bus_id'];?>" <?php  //if( $this->input->post('bus')==$B['bus_id']){;?>  <?php //} ?>><?php echo $B['bus_name'];?></option>-->
                    <?php // } ?>
                    </select>
                     Trip Number: <select name="trip" >
                        <option selected="selected">...Select Trip Number...</option>
                        <?php  foreach($trip_num as $T){ ?>

                        <option value="<?php echo $T['trip_id'];?>" <?php if( $this->input->get('trip')==$T['trip_id']) {?> selected <?php } ?>><?php echo $T['trip_no'];?></option>
                        <?php } ?>
                       </select>
                     
                     
<!--                    Trip Number:<select name="trip" id="trip_val">
                        <option value="">...Select Bus Name...</option>
                        <?php if($this->input->post('trip')){?>
                        <option <?php if($this->input->post('trip')){?> selected  <?php } ?>><?php echo $this->input->get('trip'); ?></option>
                        <?php } ?>
                    </select>-->
                     
                     
                    <button type="submit" class="btn btn-success">Search</button>
</div>
    <?php 

                        //print_r($search);
    ?>
    
<table class="table table-striped table-bordered">
    <tr>
		<th>#</th>
		<th>Tracking Logi</th>
		<th>Tracking Lati</th>
		<th>Tracking Trip Id</th>
		<th>Tracking Bus Id</th>
		<th>Tracking Time Stamp</th>
		<th>Tracking Time Stamp Device</th>
		<th>Tracking Battery Status</th>
		<th>Tracking Data Type</th>
		<th>Actions</th>
    </tr>

	<?php $i=$list_num; foreach($tracking as $T){ ?>
    <tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $T['tracking_logi']; ?></td>
		<td><?php echo $T['tracking_lati']; ?></td>
		<td><?php echo $T['tracking_trip_id']; ?></td>
		<td><?php echo $T['tracking_bus_id']; ?></td>
		<td><?php echo $T['tracking_time_stamp']; ?></td>
		<td><?php echo $T['tracking_time_stamp_device']; ?></td>
		<td><?php echo $T['tracking_battery_status']; ?></td>
		<td><?php echo $T['tracking_data_type']; ?></td>
		<td>
<!--            <a href="<?php echo site_url('tracking/edit/'.$T['tracking_id']); ?>" class="btn btn-info">Edit</a> -->
            <a onClick="javascript: return confirm('Are you sure you want to delete this record?');" href="<?php echo site_url('tracking/remove/'.$T['tracking_id']); ?>" class="btn btn-danger">Delete</a>
        </td>
    </tr>
	<?php $i++; } ?>
</table>
                      <div style=" text-align:center;"><?php echo $links; ?></div> 

       

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
    <!-- jQuery -->
<!--    <script src="<?php echo base_url()."public/";?>vendors/jquery/dist/jquery.min.js"></script>-->
    <!-- Bootstrap -->
    <script src="<?php echo base_url()."public/";?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url()."public/";?>build/js/custom.min.js"></script>

   
  </body>
</html> 