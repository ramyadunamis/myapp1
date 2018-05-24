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
                    <h2>LIST <small></small></h2>
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
                 <?php echo form_open('School_attendance/index',array("class"=>"form-horizontal",'method'=>"get")); ?>    
                    Date: <input type="text" id="datepicker" name="date" value="<?php if($this->input->get('date')){echo $this->input->get('date');} else{ echo date("m/d/Y");} ?>">
                 <button type="submit" class="btn btn-success">Search</button>
                 <?php if($this->input->get('date')){ ?>
                 <span style="position: absolute; right: 100px;"> Do you want to download it?(<?php echo $this->input->get('date');?>) <a href="<?php echo site_url('School_attendance/pdf?date='.$this->input->get('date')); ?>" class="btn btn-success">Download</a></span> 
                 <?php } ?>
              </div>

<table class="table table-striped table-bordered">
    <tr>
		<th>#</th>
		<th>Child Name</th>
                <th>Child Class</th>
                <th>Child Section</th>
<!--		<th>At Trip Id</th>-->
		<th>At Time Stamp</th>
<!--		<th>At Time Stamp Device</th>-->
<!--		<th>At Loc Lati</th>
		<th>At Loc Longi</th>
		<th>At Loc Data Type</th>
                <th>At Bus Number</th>-->
		<th>Status</th>
    </tr>
	<?php  $i=$list_num; foreach($attendance as $A){ ?>
    <tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $A['child_name']; ?></td>
		<td><?php echo $A['child_class']; ?></td>
		<td><?php echo $A['child_section']; ?></td>
		<td><?php echo $A['at_time_stamp_device']; ?></td>
<!--		<td><?php echo $A['at_loc_lati']; ?></td>
		<td><?php echo $A['at_loc_longi']; ?></td>
		<td><?php echo $A['at_loc_data_type']; ?></td>
                <td><?php echo $A['at_bus_no']; ?></td>-->
		<td>
                    <?php  if($A['at_in_or_out']=='in')
                    {
                        echo 'IN ';
                    }
                    else {
                        echo 'OUT';
                    }
                        ?>
<!--            <a href="<?php echo site_url('School_attendance/edit/'.$A['at_id']); ?>" class="btn btn-info">Edit</a> -->
<!--            <a href="<?php echo site_url('School_attendance/remove/'.$A['at_id']); ?>" class="btn btn-danger">Delete</a>-->
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