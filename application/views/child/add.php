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
     <script>
            function gettrip(id)
            {
               $.ajax({
                    type: "POST",
                    url: '<?php echo site_url('Child/trip_list').'/';?>'+id,
                    data: id='cat_id',
                    success: function(data){
                     //  alert(data);
                        $('#trip_val').html(data);
                },
});
            }
             function droptrip(id)
            {
               // alert(id);
               $.ajax({
                    type: "POST",
                    url: '<?php echo site_url('Child/trip_list').'/';?>'+id,
                    data: id='cat_id',
                    success: function(data){
                     //  alert(data);
                        $('#trip_val_drop').html(data);
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
                    <h2>ADD CHILD DETAILS <small></small></h2>
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
<?php echo form_open_multipart('child/add',array("class"=>"form-horizontal")); ?>

	<div class="form-group">
            <label for="child_name" class="col-md-4 control-label"> Name<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="child_name" value="<?php echo $this->input->post('child_name'); ?>" class="form-control" id="child_name" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_gender" class="col-md-4 control-label"> Gender<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="radio" name="child_gender" value="Male" value="<?php echo $this->input->post('child_gender'); ?>" id="child_gender" checked="checked"/>Male
                        <input type="radio" name="child_gender" value="Female" value="<?php echo $this->input->post('child_gender'); ?>" id="child_gender" />Female
		</div>
	</div>
	<div class="form-group">
		<label for="child_photo" class="col-md-4 control-label"> Photo</label>
		<div class="col-md-8">
			<input type="file" name="child_photo" value="<?php echo $this->input->post('child_photo'); ?>" class="form-control" id="child_photo" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_class" class="col-md-4 control-label"> Class<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="child_class" value="<?php echo $this->input->post('child_class'); ?>" class="form-control" id="child_class" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_section" class="col-md-4 control-label"> Section<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="child_section" value="<?php echo $this->input->post('child_section'); ?>" class="form-control" id="child_section" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_teacher" class="col-md-4 control-label"> Teacher<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="child_teacher" value="<?php echo $this->input->post('child_teacher'); ?>" class="form-control" id="child_teacher" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_bus_no_pickup" class="col-md-4 control-label"> Bus No Pickup</label>
		<div class="col-md-8">
                   <select name="child_bus_no_pickup" class="form-control" onChange="gettrip(this.value)">
              <option> ..Select Bus..</option>
               <?php foreach($bus_pick_up as $B){ ?> 
              <option value="<?php echo $B['bus_id'];?>" ><?php echo $B['bus_desc'];?></option>
                    <?php } ?>
              
          </select>
                    
		</div>
	</div>
                      
                      	<div class="form-group">
		<label for="child_trip_no_pickup" class="col-md-4 control-label"> Trip No Pickup</label>
		<div class="col-md-8">
<!--			<input type="text" name="child_trip_no_pickup" value="<?php echo $this->input->post('child_trip_no_pickup'); ?>" class="form-control" id="child_trip_no_pickup" />-->
                    <select name="child_trip_no_pickup" id="trip_val" class="form-control">
                        <option value="">...Select Trip Number...</option>
                    </select>
		</div>
	</div>

                      
	<div class="form-group">
		<label for="child_bus_no_drop_off" class="col-md-4 control-label"> Bus No Drop Off</label>
		<div class="col-md-8">
            <select name="child_bus_no_drop_off" class="form-control" onChange="droptrip(this.value)">
              <option> ..Select Bus..</option>
               <?php foreach($bus_drop_off as $D){ ?> 
              <option value="<?php echo $D['bus_id'];?>" ><?php echo $D['bus_desc'];?></option>
                    <?php } ?>
              
          </select>
		</div>
	</div>
                      
                      	<div class="form-group">
		<label for="child_trip_no_drop_off" class="col-md-4 control-label"> Trip No Drop Off</label>
		<div class="col-md-8">
<!--			<input type="text" name="child_trip_no_drop_off" value="<?php echo $this->input->post('child_trip_no_drop_off'); ?>" class="form-control" id="child_trip_no_drop_off" />-->
                         <select name="child_trip_no_drop_off" id="trip_val_drop" class="form-control">
                        <option value="">...Select Trip Number...</option>
                    </select>
		</div>
	</div>
	<div class="form-group">
		<label for="child_drop_off_order" class="col-md-4 control-label"> Drop Off Order</label>
		<div class="col-md-8">
			<input type="text" name="child_drop_off_order" value="<?php echo $this->input->post('child_drop_off_order'); ?>" class="form-control" id="child_drop_off_order" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_pickup_order" class="col-md-4 control-label"> Pickup Order</label>
		<div class="col-md-8">
			<input type="text" name="child_pickup_order" value="<?php echo $this->input->post('child_pickup_order'); ?>" class="form-control" id="child_pickup_order" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_father_name" class="col-md-4 control-label"> Father Name<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="child_father_name" value="<?php echo $this->input->post('child_father_name'); ?>" class="form-control" id="child_father_name" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_mother_name" class="col-md-4 control-label"> Mother Name</label>
		<div class="col-md-8">
			<input type="text" name="child_mother_name" value="<?php echo $this->input->post('child_mother_name'); ?>" class="form-control" id="child_mother_name" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_father_tel" class="col-md-4 control-label"> Father Tel<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="child_father_tel" value="<?php echo $this->input->post('child_father_tel'); ?>" class="form-control" id="child_father_tel" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_mother_tel" class="col-md-4 control-label"> Mother Tel</label>
		<div class="col-md-8">
			<input type="text" name="child_mother_tel" value="<?php echo $this->input->post('child_mother_tel'); ?>" class="form-control" id="child_mother_tel" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_home_tel" class="col-md-4 control-label"> Home Tel</label>
		<div class="col-md-8">
			<input type="text" name="child_home_tel" value="<?php echo $this->input->post('child_home_tel'); ?>" class="form-control" id="child_home_tel" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_father_email_id" class="col-md-4 control-label"> Father Email Id<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="child_father_email_id" value="<?php echo $this->input->post('child_father_email_id'); ?>" class="form-control" id="child_father_email_id" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_mother_email_id" class="col-md-4 control-label"> Mother Email Id</label>
		<div class="col-md-8">
			<input type="text" name="child_mother_email_id" value="<?php echo $this->input->post('child_mother_email_id'); ?>" class="form-control" id="child_mother_email_id" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_blood_group" class="col-md-4 control-label"> Blood Group</label>
		<div class="col-md-8">
			<input type="text" name="child_blood_group" value="<?php echo $this->input->post('child_blood_group'); ?>" class="form-control" id="child_blood_group" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_address" class="col-md-4 control-label"> Address</label>
		<div class="col-md-8">
			<textarea name="child_address" class="form-control" id="child_address"><?php echo $this->input->post('child_address'); ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label for="child_area" class="col-md-4 control-label"> Area</label>
		<div class="col-md-8">
			<input type="text" name="child_area" value="<?php echo $this->input->post('child_area'); ?>" class="form-control" id="child_area" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_city" class="col-md-4 control-label"> City</label>
		<div class="col-md-8">
			<input type="text" name="child_city" value="<?php echo $this->input->post('child_city'); ?>" class="form-control" id="child_city" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_pickup_lati" class="col-md-4 control-label"> Pickup Lati</label>
		<div class="col-md-8">
			<input type="text" name="child_pickup_lati" value="<?php echo $this->input->post('child_pickup_lati'); ?>" class="form-control" id="child_pickup_lati" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_pickup_longi" class="col-md-4 control-label"> Pickup Longi</label>
		<div class="col-md-8">
			<input type="text" name="child_pickup_longi" value="<?php echo $this->input->post('child_pickup_longi'); ?>" class="form-control" id="child_pickup_longi" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_drop_off_lati" class="col-md-4 control-label"> Drop Off Lati</label>
		<div class="col-md-8">
			<input type="text" name="child_drop_off_lati" value="<?php echo $this->input->post('child_drop_off_lati'); ?>" class="form-control" id="child_drop_off_lati" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_drop_off_longi" class="col-md-4 control-label"> Drop Off Longi</label>
		<div class="col-md-8">
			<input type="text" name="child_drop_off_longi" value="<?php echo $this->input->post('child_drop_off_longi'); ?>" class="form-control" id="child_drop_off_longi" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_nfc_id" class="col-md-4 control-label"> Nfc Id<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="child_nfc_id" value="<?php echo $this->input->post('child_nfc_id'); ?>" class="form-control" id="child_nfc_id" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_sms" class="col-md-4 control-label"> Sms</label>
		<div class="col-md-8">
			<input type="radio" name="child_sms" value="Yes" value="<?php echo $this->input->post('child_sms'); ?>" id="child_sms" checked="checked"/>Yes
                        <input type="radio" name="child_sms" value="No" value="<?php echo $this->input->post('child_sms'); ?>" id="child_sms" />No
		</div>
	</div>
	<div class="form-group">
		<label for="child_push_notification" class="col-md-4 control-label"> Push Notification</label>
		<div class="col-md-8">
                        <input type="radio" name="child_push_notification" value="Yes" value="<?php echo $this->input->post('child_push_notification'); ?>" id="child_push_notification" checked="checked"/>Yes
                        <input type="radio" name="child_push_notification" value="No" value="<?php echo $this->input->post('child_push_notification'); ?>" id="child_push_notification" />No
		</div>
	</div>

	<div class="form-group">
		<label for="child_personal_transport_pickup" class="col-md-4 control-label"> Personal Transport Pickup</label>
		<div class="col-md-8">
                    <input type="radio" name="child_personal_transport_pickup" value="Yes" value="<?php echo $this->input->post('child_personal_transport_pickup'); ?>"  id="child_personal_transport_pickup" checked="checked"/>Yes
                        <input type="radio" name="child_personal_transport_pickup" value="No" value="<?php echo $this->input->post('child_personal_transport_pickup'); ?>"  id="child_personal_transport_pickup" />NO
		</div>
	</div>
	<div class="form-group">
		<label for="child_personal_transport_drop_off" class="col-md-4 control-label"> Personal Transport Drop Off</label>
		<div class="col-md-8">
                    <input type="radio" name="child_personal_transport_drop_off" value="Yes" value="<?php echo $this->input->post('child_personal_transport_drop_off'); ?>"  id="child_personal_transport_drop_off" checked="checked"/>Yes
                        <input type="radio" name="child_personal_transport_drop_off" value="No" value="<?php echo $this->input->post('child_personal_transport_drop_off'); ?>" id="child_personal_transport_drop_off" />No
		</div>
	</div>
                      
                      <div class="form-group">
		<label for="pickup_time" class="col-md-4 control-label"> Pickup Time</label>
		<div class="col-md-8">
<!--			<input type="text" name="child_pickup_time" value="<?php echo $this->input->post('child_pickup_time'); ?>" class="form-control" id="child_pickup_time" />-->
                <select id="pickup_hour" name="pickup_hour" class="input-small">
                    <option value="">Hour</option>
                <?php
                for ($i=1; $i<=23; $i++){
                echo "<option value='".$i."'>" . $i ."</option>";
                }
                ?>
                </select>
                    
		:
                
                <select id="minutes" name="pickup_minutes" class="input-small">
                    <option value="0">minute</option>
                <?php

                for ($i=0; $i<=59; $i++){
                echo "<option value='".$i."'>" . $i ."</option>";
                }
                ?>
                </select>
                    </div>
	        </div>
                      
                      
                      <div class="form-group">
		<label for="dropoff_time" class="col-md-4 control-label"> Dropoff Time</label>
		<div class="col-md-8">
<!--			<input type="text" name="child_dropoff_time" value="<?php echo $this->input->post('child_dropoff_time'); ?>" class="form-control" id="child_dropoff_time" />-->
                    
                     <select id="dropoff_hour" name="dropoff_hour" class="input-small">
                    <option value="">Hour</option>
                <?php
                for ($i=1; $i<=23; $i++){
                echo "<option value='".$i."'>" . $i ."</option>";
                }
                ?>
                </select>
                    
		:
                
                <select id="dropoff_minutes" name="dropoff_minutes" class="input-small">
                    <option value="0">minute</option>
                <?php

                for ($i=0; $i<=59; $i++){
                echo "<option value='".$i."'>" . $i ."</option>";
                }
                ?>
                </select>
		</div>
	</div>
                      
        <div class="form-group">
		<label for="child_handicapped_type" class="col-md-4 control-label"> Handicapped Type</label>
		<div class="col-md-8">
                    <input type="radio" name="child_handicapped_type" value="1" value="<?php if($this->input->post('child_handicapped_type')==1) echo "checked"; ?>"  id="child_handicapped_type" checked="checked"/>Do not drop-off child without gaurdian prescence
                        <input type="radio" name="child_handicapped_type" value="2" value="<?php if($this->input->post('child_handicapped_type')==2) echo "checked"; ?>" id="child_handicapped_type" />Child is handicapped
                         <input type="radio" name="child_handicapped_type" value="3" value="<?php if($this->input->post('child_handicapped_type')==3) echo "checked"; ?>" id="child_handicapped_type" />None
		</div>
	</div>              
              
               <div class="form-group">
		<label for="child_reg_no" class="col-md-4 control-label"> Registration Number</label>
		<div class="col-md-8">
			<input type="text" name="child_reg_no" value="<?php echo $this->input->post('child_reg_no'); ?>" class="form-control" id="child_reg_no" />
		</div>
	</div>        
<!--	<div class="form-group">
		<label for="child_status" class="col-md-4 control-label">Child Status</label>
		<div class="col-md-8">
			<input type="text" name="child_status" value="<?php echo $this->input->post('child_status'); ?>" class="form-control" id="child_status" />
		</div>
	</div>-->
	
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<button type="submit" class="btn btn-success">Save</button>
                          <a href="<?php echo site_url('child'); ?>" class=" btn btn-primary">Cancel</a> 
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