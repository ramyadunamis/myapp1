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
                 <?php echo validation_errors(); ?>
<?php echo form_open('setting/add',array("class"=>"form-horizontal")); ?>

	<div class="form-group">
		<label for="set_sms" class="col-md-4 control-label">Set Sms</label>
		<div class="col-md-8">
                    <input type="radio" name="set_sms" value="Yes" value="<?php echo $this->input->post('set_sms'); ?>" id="set_sms" checked="checked"/>Yes
                    <input type="radio" name="set_sms" value="No" value="<?php echo $this->input->post('set_sms'); ?>" id="set_sms" />No
		</div>
	</div>
	<div class="form-group">
		<label for="set_push_notification" class="col-md-4 control-label">Set Push Notification</label>
		<div class="col-md-8">
		   <input type="radio" name="set_push_notification" value="Yes" value="<?php echo $this->input->post('set_push_notification'); ?>" id="set_push_notification" checked="checked"/>Yes
                    <input type="radio" name="set_push_notification" value="No" value="<?php echo $this->input->post('set_push_notification'); ?>" id="set_push_notification" />No
		</div>
	</div>
	<div class="form-group">
		<label for="set_nfc" class="col-md-4 control-label">Set Nfc</label>
		<div class="col-md-8">
		    <input type="radio" name="set_nfc" value="Yes" value="<?php echo $this->input->post('set_nfc'); ?>" id="set_nfc" checked="checked"/>Yes
                    <input type="radio" name="set_nfc" value="No" value="<?php echo $this->input->post('set_nfc'); ?>" id="set_nfc" />No
		</div>
	</div>
	<div class="form-group">
		<label for="set_calender" class="col-md-4 control-label">Set Calender</label>
		<div class="col-md-8">
                    <input type="radio" name="set_calender" value="Yes" value="<?php echo $this->input->post('set_calender'); ?>" id="set_calender" checked="checked"/>Yes
                    <input type="radio" name="set_calender" value="No" value="<?php echo $this->input->post('set_calender'); ?>" id="set_calender" />No     
               </div>
	</div>
	<div class="form-group">
		<label for="set_notification" class="col-md-4 control-label">Set Notification</label>
		<div class="col-md-8">
		    <input type="radio" name="set_notification" value="Yes" value="<?php echo $this->input->post('set_notification'); ?>" id="set_notification" checked="checked"/>Yes
                    <input type="radio" name="set_notification" value="No" value="<?php echo $this->input->post('set_notification'); ?>" id="set_notification" />No   
		</div>
	</div>
	<div class="form-group">
		<label for="set_attendance" class="col-md-4 control-label">Set Attendance</label>
		<div class="col-md-8">
		    <input type="radio" name="set_attendance" value="Yes" value="<?php echo $this->input->post('set_attendance'); ?>" id="set_attendance" checked="checked"/>Yes
                    <input type="radio" name="set_attendance" value="No" value="<?php echo $this->input->post('set_attendance'); ?>" id="set_attendance" />No   
		</div>
	</div>
	<div class="form-group">
		<label for="set_other_features" class="col-md-4 control-label">Set Other Features</label>
		<div class="col-md-8">
		   <input type="radio" name="set_other_features" value="Yes" value="<?php echo $this->input->post('set_other_features'); ?>" id="set_other_features" checked="checked"/>Yes
                    <input type="radio" name="set_other_features" value="No" value="<?php echo $this->input->post('set_other_features'); ?>" id="set_other_features" />No   
		</div>
	</div>
	<div class="form-group">
		<label for="set_track_school_bus" class="col-md-4 control-label">Set Track School Bus</label>
		<div class="col-md-8">
		    <input type="radio" name="set_track_school_bus" value="Yes" value="<?php echo $this->input->post('set_track_school_bus'); ?>" id="set_track_school_bus" checked="checked"/>Yes
                    <input type="radio" name="set_track_school_bus" value="No" value="<?php echo $this->input->post('set_track_school_bus'); ?>" id="set_track_school_bus" />No   
		</div>
	</div>
	<div class="form-group">
		<label for="set_child_status" class="col-md-4 control-label">Set Child Status</label>
		<div class="col-md-8">
		   <input type="radio" name="set_child_status" value="Yes" value="<?php echo $this->input->post('set_child_status'); ?>" id="set_child_status" checked="checked"/>Yes
                    <input type="radio" name="set_child_status" value="No" value="<?php echo $this->input->post('set_child_status'); ?>" id="set_child_status" />No   
		</div>
	</div>
	<div class="form-group">
		<label for="set_child_status" class="col-md-4 control-label">Set OT student push message </label>
		<div class="col-md-8">
		   <input type="radio" name="set_OT_push" value="Yes" value="<?php echo $this->input->post('set_OT_push'); ?>" id="set_OT_push" checked="checked"/>Yes
                    <input type="radio" name="set_OT_push" value="No" value="<?php echo $this->input->post('set_OT_push'); ?>" id="set_OT_push" />No   
		</div>
	</div>
                      
       <div class="form-group">
		<label for="set_status" class="col-md-4 control-label">School Latitude</label>
		<div class="col-md-8">
			<input type="text" name="school_latitude" value="<?php echo $this->input->post('school_latitude'); ?>" class="form" id="school_latitude" />
		</div>
	</div>
        <div class="form-group">
		<label for="set_status" class="col-md-4 control-label">School Longitude</label>
		<div class="col-md-8">
			<input type="text" name="school_longitude" value="<?php echo $this->input->post('school_longitude'); ?>" class="form" id="school_longitude" />
		</div>
	</div>
        <div class="form-group">
		<label for="set_status" class="col-md-4 control-label">Supervisor Name</label>
		<div class="col-md-8">
			<input type="text" name="supervisor_name" value="<?php echo $this->input->post('supervisor_name'); ?>" class="form" id="supervisor_name" />
		</div>
	</div>
                      
        <div class="form-group">
		<label for="supervisor_phone" class="col-md-4 control-label">Supervisor Phone</label>
		<div class="col-md-8">
			<input type="text" name="supervisor_phone" value="<?php echo $this->input->post('supervisor_phone'); ?>" class="form" id="supervisor_phone" />
		</div>
	</div>
        <div class="form-group">
		<label for="set_auth_code" class="col-md-4 control-label">Authentication code</label>
		<div class="col-md-8">
			<input type="text" name="set_auth_code" value="<?php echo $this->input->post('set_auth_code'); ?>" class="form" id="set_auth_code" />
		</div>
	</div>
        <div class="form-group">
		<label for="set_master_card_id" class="col-md-4 control-label">Master card id for Finish trip</label>
		<div class="col-md-8">
			<input type="text" name="set_master_card_id" value="<?php echo $this->input->post('set_master_card_id'); ?>" class="form" id="set_master_card_id" />
		</div>
	</div>
                      
<!--	<div class="form-group">
		<label for="set_status" class="col-md-4 control-label">Set Status</label>
		<div class="col-md-8">
			<input type="text" name="set_status" value="<?php echo $this->input->post('set_status'); ?>" class="form-control" id="set_status" />
		</div>
	</div>-->
	


            <div class="form-group">
                            <label for="set_child_status" class="col-md-4 control-label">Card Scan Type</label>
                            <div class="col-md-8">
                               <input type="radio" name="card_scan_type" value="text" value="<?php echo $this->input->post('card_scan_type'); ?>" id="card_scan_type" checked="checked"/>Text
                                <input type="radio" name="card_scan_type" value="tag" value="<?php echo $this->input->post('card_scan_type'); ?>" id="card_scan_type" />Tag   
                                <input type="radio" name="card_scan_type" value="reversed_dec" value="<?php echo $this->input->post('card_scan_type'); ?>" id="card_scan_type" />reversed decimal  
                            </div>
              </div>



	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<button type="submit" class="btn btn-success">Save</button>
                         <a href="<?php echo site_url('setting'); ?>" class=" btn btn-primary">Cancel</a> 
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