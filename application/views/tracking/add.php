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
                    <h2>ADD <small></small></h2>
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
                 
<?php echo form_open('tracking/add',array("class"=>"form-horizontal")); ?>

	<div class="form-group">
		<label for="tracking_logi" class="col-md-4 control-label">Tracking Logi</label>
		<div class="col-md-8">
			<input type="text" name="tracking_logi" value="<?php echo $this->input->post('tracking_logi'); ?>" class="form-control" id="tracking_logi" />
		</div>
	</div>
	<div class="form-group">
		<label for="tracking_lati" class="col-md-4 control-label">Tracking Lati</label>
		<div class="col-md-8">
			<input type="text" name="tracking_lati" value="<?php echo $this->input->post('tracking_lati'); ?>" class="form-control" id="tracking_lati" />
		</div>
	</div>
	<div class="form-group">
		<label for="tracking_trip_id" class="col-md-4 control-label">Tracking Trip Id</label>
		<div class="col-md-8">
			<input type="text" name="tracking_trip_id" value="<?php echo $this->input->post('tracking_trip_id'); ?>" class="form-control" id="tracking_trip_id" />
		</div>
	</div>
	<div class="form-group">
		<label for="tracking_bus_id" class="col-md-4 control-label">Tracking Bus Id</label>
		<div class="col-md-8">
			<input type="text" name="tracking_bus_id" value="<?php echo $this->input->post('tracking_bus_id'); ?>" class="form-control" id="tracking_bus_id" />
		</div>
	</div>
	<div class="form-group">
		<label for="tracking_time_stamp" class="col-md-4 control-label">Tracking Time Stamp</label>
		<div class="col-md-8">
			<input type="text" name="tracking_time_stamp" value="<?php echo $this->input->post('tracking_time_stamp'); ?>" class="form-control" id="tracking_time_stamp" />
		</div>
	</div>
	<div class="form-group">
		<label for="tracking_time_stamp_device" class="col-md-4 control-label">Tracking Time Stamp Device</label>
		<div class="col-md-8">
			<input type="text" name="tracking_time_stamp_device" value="<?php echo $this->input->post('tracking_time_stamp_device'); ?>" class="form-control" id="tracking_time_stamp_device" />
		</div>
	</div>
	<div class="form-group">
		<label for="tracking_battery_status" class="col-md-4 control-label">Tracking Battery Status</label>
		<div class="col-md-8">
			<input type="text" name="tracking_battery_status" value="<?php echo $this->input->post('tracking_battery_status'); ?>" class="form-control" id="tracking_battery_status" />
		</div>
	</div>
	<div class="form-group">
		<label for="tracking_data_type" class="col-md-4 control-label">Tracking Data Type</label>
		<div class="col-md-8">
			<input type="text" name="tracking_data_type" value="<?php echo $this->input->post('tracking_data_type'); ?>" class="form-control" id="tracking_data_type" />
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<button type="submit" class="btn btn-success">Save</button>
        </div>
	</div>

<?php echo form_close(); ?>
                  </div>
                </div>
              </div>

            

             

 

             
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
    <script src="<?php echo base_url()."public/";?>vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url()."public/";?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
   
    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url()."public/";?>build/js/custom.min.js"></script>

   
  </body>
</html> 