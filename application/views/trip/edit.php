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
    
        <?php include realpath('.').'/application/views/'.'head_inc.php'; ?>

    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">                      
                        <!-- left Panel -->
                        <?php  
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
                    <h2>EDIT TRIP <small></small></h2>
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
<?php echo form_open('trip/edit/'.$trip['trip_id'],array("class"=>"form-horizontal")); ?>

	<div class="form-group">
		<label for="trip_title" class="col-md-4 control-label">Trip Title<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="trip_title" value="<?php echo ($this->input->post('trip_title') ? $this->input->post('trip_title') : $trip['trip_title']); ?>" class="form-control" id="trip_title" />
		</div>
	</div>
	<div class="form-group">
		<label for="trip_no" class="col-md-4 control-label">Trip No<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="trip_no" value="<?php echo ($this->input->post('trip_no') ? $this->input->post('trip_no') : $trip['trip_no']); ?>" class="form-control" id="trip_no" />
		</div>
	</div>
	<div class="form-group">
		<label for="trip_desc" class="col-md-4 control-label">Trip Desc<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
                        <textarea name="trip_desc"  class="form-control" id="trip_desc"><?php echo ($this->input->post('trip_desc') ? $this->input->post('trip_desc') : $trip['trip_desc']); ?></textarea>
		</div>
	</div>
   <div class="form-group">
        <label for="bus_names" class="col-md-4 control-label">Bus Name<span style="color: red; font-size: large;">*</span></label>
        <div class="col-md-8">
          <select name="bus" class="form-control">
              <option> ..Select Bus..</option>
               <?php foreach($bus as $B){ ?> 
              <option value="<?php echo $B['bus_id'];?>" <?php  if( $trip['trip_bus_id']==$B['bus_id']){;?> selected <?php } ?>><?php echo $B['bus_name'];?></option>
                    <?php } ?>
              
          </select>
        </div>
        </div>
	 <div class="form-group">
		<label for="type" class="col-md-4 control-label">Type<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
                    <?php //echo $trip['trip_type'];?>
                        <input type="radio" name="type" value="pickup" <?php  if( $trip['trip_type']=='pickup'){ ?> checked='checked' <?php }?> id="user_gender" />Pickup
                        <input type="radio" name="type" value="drop off" <?php if( $trip['trip_type']=='drop off'){ ?> checked='checked' <?php }?> id="user_gender" />Drop off
		</div>
	</div>
                      
                      <?php
$content = $trip['time'];
preg_match_all('/{(.*?)}/', $content, $matches);
$checked=array_map('intval',$matches[1]);

?>
                      
                      
                       <div class="form-group">
		<label for="type" class="col-md-4 control-label">Time<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
                   <?php //for($i=0;$i<count($checked);$i++) {?>
                    <input type="checkbox" name="time[]" value=0 <?php if(in_array(0, $checked)) echo 'checked';?> id="user_gender" />0
                    <input type="checkbox" name="time[]" value=1 <?php if(in_array(1, $checked)) echo 'checked';?> id="user_gender" />1
                     <input type="checkbox" name="time[]" value=2 <?php if(in_array(2, $checked)) echo 'checked';?> id="user_gender" />2
                    <input type="checkbox" name="time[]" value=3 <?php if(in_array(3, $checked)) echo 'checked';?> id="user_gender" />3
                     <input type="checkbox" name="time[]" value=4 <?php if(in_array(4, $checked)) echo 'checked';?> id="user_gender" />4
                    <input type="checkbox" name="time[]" value=5 <?php if(in_array(5, $checked)) echo 'checked';?> id="user_gender" />5
                     <input type="checkbox" name="time[]" value=6 <?php if(in_array(6, $checked)) echo 'checked';?> id="user_gender" />6
                    <input type="checkbox" name="time[]" value=7 <?php if(in_array(7, $checked)) echo 'checked';?> id="user_gender" />7
                    <input type="checkbox" name="time[]" value=8 <?php if(in_array(8, $checked)) echo 'checked';?> id="user_gender" />8
                    <input type="checkbox" name="time[]" value=9 <?php if(in_array(9, $checked)) echo 'checked';?> id="user_gender" />9
                     <input type="checkbox" name="time[]" value=10 <?php if(in_array(10, $checked)) echo 'checked';?> id="user_gender" />10
                    <input type="checkbox" name="time[]" value=11 <?php if(in_array(11, $checked)) echo 'checked';?> id="user_gender" />11
                     <input type="checkbox" name="time[]" value=12 <?php if(in_array(12, $checked)) echo 'checked';?> id="user_gender" />12
                    <input type="checkbox" name="time[]" value=13 <?php if(in_array(13, $checked)) echo 'checked';?> id="user_gender" />13
                     <input type="checkbox" name="time[]" value=14 <?php if(in_array(14, $checked)) echo 'checked';?> id="user_gender" />14
                    <input type="checkbox" name="time[]" value=15 <?php if(in_array(15, $checked)) echo 'checked';?> id="user_gender" />15
                    <input type="checkbox" name="time[]" value=16 <?php if(in_array(16, $checked)) echo 'checked';?> id="user_gender" />16
                    <input type="checkbox" name="time[]" value=17 <?php if(in_array(17, $checked)) echo 'checked';?> id="user_gender" />17
                     <input type="checkbox" name="time[]" value=18 <?php if(in_array(18, $checked)) echo 'checked';?> id="user_gender" />18
                    <input type="checkbox" name="time[]" value=19 <?php if(in_array(19, $checked)) echo 'checked';?> id="user_gender" />19
                     <input type="checkbox" name="time[]" value=20 <?php if(in_array(20, $checked)) echo 'checked';?> id="user_gender" />20
                    <input type="checkbox" name="time[]" value=21 <?php if(in_array(21, $checked)) echo 'checked';?> id="user_gender" />21
                     <input type="checkbox" name="time[]" value=22 <?php if(in_array(22, $checked)) echo 'checked';?> id="user_gender" />22
                    <input type="checkbox" name="time[]" value=23 <?php if(in_array(23, $checked)) echo 'checked';?> id="user_gender" />23
                   <?php //} ?>
		</div>
	</div>
                      
         <div class="form-group">
		<label for="is_stayback" class="col-md-4 control-label">Stayback<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
                        <input type="radio" name="is_stayback" value="Yes" <?php  if( $trip['is_stayback']=='Yes'){ ?> checked='checked' <?php }?> id="is_stayback" />Yes
                        <input type="radio" name="is_stayback" value="No" <?php if( $trip['is_stayback']=='No'){ ?> checked='checked' <?php }?> id="is_stayback" />No
		</div>
	</div>              
                     
                      
            <div class="form-group">
            <label for="is_stayback" class="col-md-4 control-label">Push Notification<span style="color: red; font-size: large;">*</span></label>
            <div class="col-md-8">
            <input type="radio" name="push_noti" value="Yes" <?php  if( $trip['push_notification']=='Yes'){ ?> checked='checked' <?php }?> id="push_noti" />Yes
            <input type="radio" name="push_noti" value="No" <?php if( $trip['push_notification']=='No'){ ?> checked='checked' <?php }?> id="push_noti" />No
            </div>
            </div>    
                      
                      
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<button type="submit" class="btn btn-success">Save</button>
                      <a href="<?php echo site_url('trip/'); ?>" class="btn btn-primary">Cancel</a> 
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