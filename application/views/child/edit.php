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
                //alert(id);
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
                    <h2>EDIT CHILD DETAILS <small></small></h2>
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
<?php echo form_open_multipart('child/edit/'.$child['child_id'],array("class"=>"form-horizontal")); ?>

	<div class="form-group">
		<label for="child_name" class="col-md-4 control-label"> Name<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="child_name" value="<?php echo ($this->input->post('child_name') ? $this->input->post('child_name') : $child['child_name']); ?>" class="form-control" id="child_name" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_gender" class="col-md-4 control-label"> Gender<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="radio" name="child_gender" value="Male" <?php echo ($child['child_gender']=='Male' ? 'checked="checked"' : ''); ?> id='child_gender' checked="checked"/>Male
                        <input type="radio" name="child_gender" value="Female" <?php echo ($child['child_gender']=='Female' ? 'checked="checked"' : ''); ?> id='child_gender' />Female
		</div>
	</div>
	<div class="form-group">
		<label for="child_photo" class="col-md-4 control-label"> Photo</label>
		<div class="col-md-8">
                    <img src="<?php echo base_url()."/uploads/std/";?><?php echo $child['child_photo'];?>" width="100" height="100">
			<input type="file" name="child_photo" value="<?php echo ($this->input->post('child_photo') ? $this->input->post('child_photo') : $child['child_photo']); ?>" class="form-control" id="child_photo" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_class" class="col-md-4 control-label"> Class<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="child_class" value="<?php echo ($this->input->post('child_class') ? $this->input->post('child_class') : $child['child_class']); ?>" class="form-control" id="child_class" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_section" class="col-md-4 control-label"> Section<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="child_section" value="<?php echo ($this->input->post('child_section') ? $this->input->post('child_section') : $child['child_section']); ?>" class="form-control" id="child_section" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_teacher" class="col-md-4 control-label"> Teacher<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="child_teacher" value="<?php echo ($this->input->post('child_teacher') ? $this->input->post('child_teacher') : $child['child_teacher']); ?>" class="form-control" id="child_teacher" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_bus_no_pickup" class="col-md-4 control-label"> Bus No Pickup</label>
		<div class="col-md-8">

                <select name="child_bus_no_pickup" class="form-control" onChange="gettrip(this.value)">
              <option> ..Select Bus..</option>
               <?php foreach($bus_pick_up as $B){ ?> 
              <option value="<?php echo $B['bus_id'];?>" <?php if($child['child_bus_no_pickup']==$B['bus_id']) {?> selected <?php } ?>><?php echo $B['bus_desc'];?></option>
                    <?php } ?>
              
          </select>
                </div>
	</div>
             <div class="form-group">
		<label for="child_trip_no_pickup" class="col-md-4 control-label"> Trip No Pickup</label>
		<div class="col-md-8">
			  <select name="child_trip_no_pickup" id="trip_val" class="form-control">
                        <option value="">...Select Trip Number...</option>
                        <?php  foreach($up as $key => $UP){ ?> 
                        <option value="<?php echo $UP['trip_id'];?>" <?php if($UP['trip_id']==$child['child_trip_no_pickup']) {?> selected <?php } ?> ><?php echo $UP['trip_no'];?></option>
              
                    <?php } ?>
              
                    </select>
                </div>
	</div>
	
	<div class="form-group">
		<label for="child_bus_no_drop_off" class="col-md-4 control-label"> Bus No Drop Off</label>
		<div class="col-md-8">
	<select name="child_bus_no_drop_off" class="form-control" onChange="droptrip(this.value)">
              <option> ..Select Bus..</option>
               <?php foreach($bus_drop_off as $D){ ?> 
              <option value="<?php echo $D['bus_id'];?>" <?php if($child['child_bus_no_drop_off']==$D['bus_id']) {?> selected <?php } ?>><?php echo $D['bus_desc'];?></option>
                    <?php } ?>
              
          </select>
                </div>
	</div>
                      
                      <div class="form-group">
		<label for="child_trip_no_drop_off" class="col-md-4 control-label"> Trip No Drop Off</label>
		<div class="col-md-8">
                <select name="child_trip_no_drop_off" id="trip_val_drop" class="form-control">
                        <option value="">...Select Trip Number...</option>
                        <?php  foreach($drop as $key => $DROP){ ?> 
                        <option value="<?php echo $DROP['trip_id'];?>" <?php if($DROP['trip_id']==$child['child_trip_no_drop_off']) {?> selected <?php } ?> ><?php echo $DROP['trip_no'];?></option>
              
                    <?php } ?>
              
                    </select>
                </div>
	</div>
	<div class="form-group">
		<label for="child_drop_off_order" class="col-md-4 control-label"> Drop Off Order</label>
		<div class="col-md-8">
			<input type="text" name="child_drop_off_order" value="<?php echo ($this->input->post('child_drop_off_order') ? $this->input->post('child_drop_off_order') : $child['child_drop_off_order']); ?>" class="form-control" id="child_drop_off_order" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_pickup_order" class="col-md-4 control-label"> Pickup Order</label>
		<div class="col-md-8">
			<input type="text" name="child_pickup_order" value="<?php echo ($this->input->post('child_pickup_order') ? $this->input->post('child_pickup_order') : $child['child_pickup_order']); ?>" class="form-control" id="child_pickup_order" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_father_name" class="col-md-4 control-label"> Father Name<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="child_father_name" value="<?php echo ($this->input->post('child_father_name') ? $this->input->post('child_father_name') : $child['child_father_name']); ?>" class="form-control" id="child_father_name" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_mother_name" class="col-md-4 control-label"> Mother Name</label>
		<div class="col-md-8">
			<input type="text" name="child_mother_name" value="<?php echo ($this->input->post('child_mother_name') ? $this->input->post('child_mother_name') : $child['child_mother_name']); ?>" class="form-control" id="child_mother_name" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_father_tel" class="col-md-4 control-label"> Father Tel<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="child_father_tel" value="<?php echo ($this->input->post('child_father_tel') ? $this->input->post('child_father_tel') : $child['child_father_tel']); ?>" class="form-control" id="child_father_tel" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_mother_tel" class="col-md-4 control-label"> Mother Tel</label>
		<div class="col-md-8">
			<input type="text" name="child_mother_tel" value="<?php echo ($this->input->post('child_mother_tel') ? $this->input->post('child_mother_tel') : $child['child_mother_tel']); ?>" class="form-control" id="child_mother_tel" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_home_tel" class="col-md-4 control-label"> Home Tel</label>
		<div class="col-md-8">
			<input type="text" name="child_home_tel" value="<?php echo ($this->input->post('child_home_tel') ? $this->input->post('child_home_tel') : $child['child_home_tel']); ?>" class="form-control" id="child_home_tel" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_father_email_id" class="col-md-4 control-label"> Father Email Id<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="child_father_email_id" value="<?php echo ($this->input->post('child_father_email_id') ? $this->input->post('child_father_email_id') : $child['child_father_email_id']); ?>" class="form-control" id="child_father_email_id" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_mother_email_id" class="col-md-4 control-label"> Mother Email Id</label>
		<div class="col-md-8">
			<input type="text" name="child_mother_email_id" value="<?php echo ($this->input->post('child_mother_email_id') ? $this->input->post('child_mother_email_id') : $child['child_mother_email_id']); ?>" class="form-control" id="child_mother_email_id" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_blood_group" class="col-md-4 control-label"> Blood Group</label>
		<div class="col-md-8">
			<input type="text" name="child_blood_group" value="<?php echo ($this->input->post('child_blood_group') ? $this->input->post('child_blood_group') : $child['child_blood_group']); ?>" class="form-control" id="child_blood_group" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_address" class="col-md-4 control-label"> Address</label>
		<div class="col-md-8">
			<textarea name="child_address"><?php echo ($this->input->post('child_address') ? $this->input->post('child_address') : $child['child_address']); ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label for="child_area" class="col-md-4 control-label"> Area</label>
		<div class="col-md-8">
			<input type="text" name="child_area" value="<?php echo ($this->input->post('child_area') ? $this->input->post('child_area') : $child['child_area']); ?>" class="form-control" id="child_area" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_city" class="col-md-4 control-label"> City</label>
		<div class="col-md-8">
			<input type="text" name="child_city" value="<?php echo ($this->input->post('child_city') ? $this->input->post('child_city') : $child['child_city']); ?>" class="form-control" id="child_city" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_pickup_lati" class="col-md-4 control-label"> Pickup Lati</label>
		<div class="col-md-8">
			<input type="text" name="child_pickup_lati" value="<?php echo ($this->input->post('child_pickup_lati') ? $this->input->post('child_pickup_lati') : $child['child_pickup_lati']); ?>" class="form-control" id="child_pickup_lati" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_pickup_longi" class="col-md-4 control-label"> Pickup Longi</label>
		<div class="col-md-8">
			<input type="text" name="child_pickup_longi" value="<?php echo ($this->input->post('child_pickup_longi') ? $this->input->post('child_pickup_longi') : $child['child_pickup_longi']); ?>" class="form-control" id="child_pickup_longi" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_drop_off_lati" class="col-md-4 control-label"> Drop Off Lati</label>
		<div class="col-md-8">
			<input type="text" name="child_drop_off_lati" value="<?php echo ($this->input->post('child_drop_off_lati') ? $this->input->post('child_drop_off_lati') : $child['child_drop_off_lati']); ?>" class="form-control" id="child_drop_off_lati" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_drop_off_longi" class="col-md-4 control-label"> Drop Off Longi</label>
		<div class="col-md-8">
			<input type="text" name="child_drop_off_longi" value="<?php echo ($this->input->post('child_drop_off_longi') ? $this->input->post('child_drop_off_longi') : $child['child_drop_off_longi']); ?>" class="form-control" id="child_drop_off_longi" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_nfc_id" class="col-md-4 control-label"> Nfc Id<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="child_nfc_id" value="<?php echo ($this->input->post('child_nfc_id') ? $this->input->post('child_nfc_id') : $child['child_nfc_id']); ?>" class="form-control" id="child_nfc_id" />
		</div>
	</div>
	<div class="form-group">
		<label for="child_sms" class="col-md-4 control-label"> Sms</label>
		<div class="col-md-8">
			<input type="radio" name="child_sms" value="Yes" <?php echo ($child['child_sms']=='Yes' ? 'checked="checked"' : ''); ?> id='child_sms' />Yes
                        <input type="radio" name="child_sms" value="No" <?php echo ($child['child_sms']=='No' ? 'checked="checked"' : ''); ?> id='child_sms' />No
		</div>
	</div>
	<div class="form-group">
		<label for="child_push_notification" class="col-md-4 control-label"> Push Notification</label>
		<div class="col-md-8">
                <input type="radio" name="child_push_notification" value="Yes" <?php echo ($child['child_push_notification']=='Yes' ? 'checked="checked"' : ''); ?> id='child_push_notification' />Yes
                 <input type="radio" name="child_push_notification" value="No" <?php echo ($child['child_push_notification']=='No' ? 'checked="checked"' : ''); ?> id='child_push_notification' />No
                </div>
	</div>
	
	<div class="form-group">
		<label for="child_personal_transport_pickup" class="col-md-4 control-label"> Personal Transport Pickup</label>
		<div class="col-md-8">
		<input type="radio" name="child_personal_transport_pickup" value="Yes" <?php echo ($child['child_personal_transport_pickup']=='Yes' ? 'checked="checked"' : ''); ?> id='child_personal_transport_pickup' />Yes
                 <input type="radio" name="child_personal_transport_pickup" value="No" <?php echo ($child['child_personal_transport_pickup']=='No' ? 'checked="checked"' : ''); ?> id='child_personal_transport_pickup' />No
               </div>
	</div>
	<div class="form-group">
		<label for="child_personal_transport_drop_off" class="col-md-4 control-label"> Personal Transport Drop Off</label>
		<div class="col-md-8">
			 <input type="radio" name="child_personal_transport_drop_off" value="Yes" <?php echo ($child['child_personal_transport_drop_off']=='Yes' ? 'checked="checked"' : ''); ?> id='child_personal_transport_drop_off' />Yes
                        <input type="radio" name="child_personal_transport_drop_off" value="No" <?php echo ($child['child_personal_transport_drop_off']=='No' ? 'checked="checked"' : ''); ?> id='child_personal_transport_drop_off' />No
                </div>
	</div>
                      
                      
                      
                                            <div class="form-group">
		<label for="pickup_time" class="col-md-4 control-label"> Pickup Time</label>
		<div class="col-md-8">
<!--			<input type="text" name="child_pickup_time" value="<?php echo $child['child_pickup_time']; ?>" class="form-control" id="child_pickup_time" />-->
                    
                    <?php 
                    if($child['child_pickup_time']!='') {
                    $a= explode(':', $child['child_pickup_time']);
                    //print_r($a);
                    $p_hour=(int)$a[0];
                    $p_minute=(int)$a[1];
                    }
 else {
     $p_hour=''; $p_minute='';
 }
                    ?>
                    <select id="pickup_hour" name="pickup_hour" class="input-small">
                    <option value="">Hour</option>
                <?php
                for ($i=1; $i<=23; $i++){ ?>
                 <option value=<?php echo $i;?> <?php if($p_hour==$i) { echo 'selected';} ?>> <?php echo $i;?>  </option>;
                <?php }
                ?>
                </select>
                    
		:
                
                <select id="minutes" name="pickup_minutes" class="input-small">
                    <option value="0">minute</option>
                <?php

                for ($i=0; $i<=59; $i++){
               ?>
                   <option value=<?php echo $i;?> <?php if($p_minute==$i) { echo 'selected';} ?>> <?php echo $i;?>  </option>;
                   <?php
                }
                ?>
                </select>
		</div>
	</div>
                      
                      
                      <div class="form-group">
		<label for="dropoff_time" class="col-md-4 control-label"> Dropoff Time</label>
		<div class="col-md-8">
<!--			<input type="text" name="child_dropoff_time" value="<?php echo $child['child_dropoff_time']; ?>" class="form-control" id="child_dropoff_time" />-->
                     <?php 
                     if($child['child_dropoff_time']!='') {
                    $a= explode(':', $child['child_dropoff_time']);
                    //print_r($a);
                    $p_hour=(int)$a[0];
                    $p_minute=(int)$a[1];
                     }
 else {
     $p_hour='';
     $p_minute='';
 }
                    ?>
                     <select id="dropoff_hour" name="dropoff_hour" class="input-small">
                    <option value="">Hour</option>
                <?php
                for ($i=1; $i<=23; $i++){
               ?>
                 <option value=<?php echo $i;?> <?php if($p_hour==$i) { echo 'selected';} ?>> <?php echo $i;?>  </option>;
                <?php
                }
                ?>
                </select>
                    
		:
                
                <select id="dropoff_minutes" name="dropoff_minutes" class="input-small">
                    <option value="0">minute</option>
                <?php

                for ($i=0; $i<=59; $i++){
              ?>
                   <option value=<?php echo $i;?> <?php if($p_minute==$i) { echo 'selected';} ?>> <?php echo $i;?>  </option>;
               <?php
                }
                ?>
                </select>
		</div>
	</div>
                      
        <div class="form-group">
		<label for="child_handicapped_type" class="col-md-4 control-label"> Handicapped Type</label>
		<div class="col-md-8">
                    <input type="radio" name="child_handicapped_type" value="1" <?php echo ($child['child_handicapped_type']==1 ? 'checked="checked"' : ''); ?> id="child_handicapped_type" />Do not drop-off child without gaurdian prescence
                        <input type="radio" name="child_handicapped_type" value="2" <?php echo ($child['child_handicapped_type']==2 ? 'checked="checked"' : ''); ?> id="child_handicapped_type" />Child is handicapped
                         <input type="radio" name="child_handicapped_type" value="3" <?php echo ($child['child_handicapped_type']==3 ? 'checked="checked"' : ''); ?> id="child_handicapped_type" />None
		</div>
     </div>     
                       <div class="form-group">
		<label for="child_reg_no" class="col-md-4 control-label">Registration Number</label>
		<div class="col-md-8">
			<input type="text" name="child_reg_no" value="<?php echo $child['child_reg_no']; ?>" class="form-control" id="child_reg_no" />
		</div>
	</div>                  
<!--                      <input type="submit" value="" />-->
        
        
        
        
        
<!--	<div class="form-group">
		<label for="child_status" class="col-md-4 control-label">Child Status</label>
		<div class="col-md-8">
			<input type="text" name="child_status" value="<?php echo ($this->input->post('child_status') ? $this->input->post('child_status') : $child['child_status']); ?>" class="form-control" id="child_status" />
		</div>
	</div>-->
<input type="hidden" name="pickup" value="<?php echo $this->input->get('pickup'); ?>">
<input type="hidden" name="dropoff" value="<?php echo $this->input->get('dropoff'); ?>">
<input type="hidden" name="registration" value="<?php echo $this->input->get('registration'); ?>">
<input type="hidden" name="list_num" value="<?php echo $list_num; ?>">
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<button type="submit" class="btn btn-success">Save</button>
                          <a href="<?php if($this->input->get('pickup') || $this->input->get('dropoff') || $this->input->get('registration')) { echo site_url('child').'/search?pickup='.$this->input->get('pickup').'&dropoff='.$this->input->get('dropoff').'&registration='.$this->input->get('registration').'&list_num='.$list_num; } else { echo site_url('child').'/index/'.$list_num; } ?>" class=" btn btn-primary">Cancel</a> 
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