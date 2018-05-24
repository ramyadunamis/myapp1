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
    <!-- Font Awesome -->
    <link href="<?php echo base_url()."public/";?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url()."public/";?>build/css/custom.min.css" rel="stylesheet">
        <script language="javascript">
    function clear1()
   {  
         document.getElementById('dropoff').value= "" ;
         document.getElementById('registration').value= "" ;
          document.getElementById('child_name').value= "" ;
          document.getElementById('email').value= "" ;
          document.getElementById('phone').value= "" ;
   }
     function clear2()
   {  
         document.getElementById('pickup').value= "" ;
         document.getElementById('registration').value= "" ;
           document.getElementById('child_name').value= "" ;
            document.getElementById('email').value= "" ;
          document.getElementById('phone').value= "" ;
   }
     function clear3()
   {  
         document.getElementById('dropoff').value= "" ;
         document.getElementById('pickup').value= "" ;
           document.getElementById('child_name').value= "" ;
            document.getElementById('email').value= "" ;
          document.getElementById('phone').value= "" ;
   }
      function clear4()
   {  
         document.getElementById('dropoff').value= "" ;
         document.getElementById('pickup').value= "" ;
         document.getElementById('registration').value= "" ;
          document.getElementById('email').value= "" ;
          document.getElementById('phone').value= "" ;
   }
      function clear5()
   {  
         document.getElementById('dropoff').value= "" ;
         document.getElementById('pickup').value= "" ;
         document.getElementById('child_name').value= "" ;
         document.getElementById('registration').value= "" ;
         document.getElementById('phone').value= "" ;
   }
      function clear6()
   {  
         document.getElementById('dropoff').value= "" ;
         document.getElementById('pickup').value= "" ;
         document.getElementById('child_name').value= "" ;
         document.getElementById('registration').value= "" ;
         document.getElementById('email').value= "" ;
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
                    <h2>CHILD LIST <small></small></h2>
                   
<!--                    <ul class="nav navbar-right panel_toolbox">
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
                    </ul>-->
                    <div class="clearfix"></div>
                   
                  </div>
                    <div style="color: crimson;">
                        <?php echo $this->session->flashdata('error'); ?></div>
                    <div style="color: crimson;">
                        <?php echo $this->session->flashdata('msg'); ?></div>
                     <?php echo form_open('child/search',array("class"=>"form-horizontal",'method'=>"get")); ?>  
                       Bus Pickup:<select name="pickup" id="pickup"  onChange="clear1()">
                         <option value="">...select Bus Name...</option>
                        <?php foreach($bus as $B){ ?> 
                         <option value="<?php echo $B['bus_id'];?>" <?php  if( $this->input->get('pickup')==$B['bus_id']){;?> selected <?php } ?>><?php echo $B['bus_desc'];?></option>
                    <?php  } ?>
                    </select>
                       <span style="font-weight: bold;">&nbsp OR &nbsp</span> 
                      Bus Dropoff:<select name="dropoff" id="dropoff" onChange="clear2()">
                         <option value="">...select Bus Name...</option>
                        <?php foreach($bus as $B){ ?> 
                     <option value="<?php echo $B['bus_id'];?>" <?php  if( $this->input->get('dropoff')==$B['bus_id']){;?> selected <?php } ?>><?php echo $B['bus_desc'];?></option>
                    <?php  } ?>
                    </select>
                        <span style="font-weight: bold;">&nbsp; OR &nbsp;</span> 
                       Reg#:
                       <input type="text" name="registration" placeholder="Enter Register Number" id="registration" value="<?php echo $this->input->get('registration');?>" onChange="clear3()">

                         <span style="font-weight: bold;">&nbsp; OR &nbsp;</span> 
                       Child:
                       <input type="text" name="child_name" placeholder="Enter child name" id="child_name" value="<?php echo $this->input->get('child_name');?>" onChange="clear4()">
                         <span style="font-weight: bold;">&nbsp; OR &nbsp;</span> 
                      Email:
                       <input type="text" name="email" placeholder="Enter Email" id="email" value="<?php echo $this->input->get('email');?>" onChange="clear5()">
                         <span style="font-weight: bold;">&nbsp; OR &nbsp;</span> 
                       Phone:
                       <input type="text" name="phone" placeholder="Enter Phone Number" id="phone" value="<?php echo $this->input->get('phone');?>" onChange="clear6()">

                       &nbsp;
                    <button type="submit" class="btn btn-success">Search</button>
                    
                  <div class="x_content">
                 <div class="pull-right">
	 <a href="<?php echo site_url('child/add'); ?>" class="btn btn-success">Add</a> <a href="<?php echo site_url('child/download'); ?>" class="btn btn-success">Download missing image names</a> 
         <a href="<?php echo site_url('child/download_child_details_with_bus'); ?>" class="btn btn-success">Download bus number with child details</a>
         <a href="<?php echo site_url('child/download_child_details_with_bus_downloading_and_updating_with_newvalues'); ?>" class="btn btn-success">Download Student db</a>
         </div>

<table class="table table-striped table-bordered">
    <tr>
		<th>#</th>
                <th>Name <br/> Reg #</th>
                <th> Photo</th>
                <th> Status</th>
                <th> Gender</th>
                <th> Class & <br/>Section</th>
                <th>Pick-up Bus</th>
                <th>Drop-off Bus</th>
                 <th> Parent Status</th>
                <th>Father Email Id</th>
                <th> Pickup Order</th>
                <th>Drop-off Order</th>
                <th>Father Name</th>
                <th>Father Tel</th>
                <th>Mother Name</th>
                <th>Mother Tel</th>
                 
<!--		<th>Child Section</th>-->
		<th> Teacher</th>
		<th> Home Tel</th>
		<th> Mother Email Id</th>
		<th> Blood Group</th>
		<th> Address</th>
               
<!--		<th>Child Area</th>
		<th>Child City</th>
		<th>Child Pickup Lati</th>
		<th>Child Pickup Longi</th>
		<th>Child Drop Off Lati</th>
		<th>Child Drop Off Longi</th>
		<th>Child Nfc Id</th>
		<th>Child Sms</th>
		<th>Child Push Notification</th>
		<th>Child Trip No Pickup</th>
		<th>Child Trip No Drop Off</th>
		<th>Child Personal Transport Pickup</th>
		<th>Child Personal Transport Drop Off</th>-->
		
		<th>Actions</th>
    </tr>
	<?php  $i=$list_num; foreach($child as $C){ ?>
    <tr>
		<td><?php echo $i+1; ?></td>
                <td><?php echo $C['child_name']; ?><br/>
                <?php echo 'NFC: '.$C['child_nfc_id'].'<br/> '; 
                 echo 'REG: '.$C['child_reg_no'];
                ?>
                    <br/><br/>
                     <a href="<?php if($this->uri->segment(2)=='search'){ echo site_url('child/edit/'.$C['child_id'].'?pickup='.$this->input->get('pickup').'&dropoff='.$this->input->get('dropoff').'&registration='.$this->input->get('registration').'&list_num='.$list_num); } else { echo site_url('child/edit/'.$C['child_id'].'/'.$list_num); }?>" class="btn btn-info">Edit</a> 
                </td> <td><img src="<?php echo base_url()."/uploads/std/";?><?php echo $C['child_photo']; ?>" width="100" height="100" alt="<?php echo $C['child_photo']; ?>"></td>
                 <td><?php if($C['child_status']==0){ ?> <a onClick="javascript: return confirm('Are you sure you want to deactive this record?');" href="<?php echo site_url('child/change_status/'.$C['child_id'].'/'.$C['child_status'].'/'.$list_num); ?>" >
                         <li class="glyphicon glyphicon-ok-sign"></li></a> <?php } else { ?> <a onClick="javascript: return confirm('Are you sure you want to active this record?');" href="<?php echo site_url('child/change_status/'.$C['child_id'].'/'.$C['child_status'].'/'.$list_num); ?>" >
                             <li class="glyphicon glyphicon-remove-sign"></li></a> <?php } ?></td>
		<td><?php echo $C['child_gender']; ?></td>
                  <td><?php echo $C['child_class']; ?> <br/> <?php echo $C['child_section']; ?></td>
                <td><?php echo $C['child_bus_no_pickup']; ?><br/>Trip: <?php echo $C['child_trip_no_pickup']; ?>
                </td>
                <td><?php echo $C['child_bus_no_drop_off']; ?><br/>Trip: <?php echo $C['child_trip_no_drop_off']; ?>
                </td>
                 <td><?php  if($C['signed_status']==0) {echo 'Signed up'; } else { echo 'Not Signed up'; }?></td>
                <td><?php echo $C['child_father_email_id']; ?></td>
                <td><?php echo $C['child_pickup_order']; ?></td>
                <td><?php echo $C['child_drop_off_order']; ?></td>
                <td><?php echo $C['child_father_name']; ?></td>       
                <td><?php echo $C['child_father_tel']; ?></td>      
                <td><?php echo $C['child_mother_name']; ?></td>      
                <td><?php echo $C['child_mother_tel']; ?></td>       
                
              
<!--		<td><?php echo $C['child_section']; ?></td>-->
		<td><?php echo $C['child_teacher']; ?></td>
		<td><?php echo $C['child_home_tel']; ?></td>
		<td><?php echo $C['child_mother_email_id']; ?></td>
		<td><?php echo $C['child_blood_group']; ?></td>
		<td><?php echo $C['child_address']; ?></td>
		<!--<td><?php echo $C['child_area']; ?></td>
		<td><?php echo $C['child_city']; ?></td>
		<td><?php echo $C['child_pickup_lati']; ?></td>
		<td><?php echo $C['child_pickup_longi']; ?></td>
		<td><?php echo $C['child_drop_off_lati']; ?></td>
		<td><?php echo $C['child_drop_off_longi']; ?></td>
		<td><?php echo $C['child_nfc_id']; ?></td>
		<td><?php echo $C['child_sms']; ?></td>
		<td><?php echo $C['child_push_notification']; ?></td>
		<td><?php echo $C['child_trip_no_pickup']; ?></td>
		<td><?php echo $C['child_trip_no_drop_off']; ?></td>
		<td><?php echo $C['child_personal_transport_pickup']; ?></td>
		<td><?php echo $C['child_personal_transport_drop_off']; ?></td>-->
               
               <td>
           
            <a onClick="javascript: return confirm('Are you sure you want to delete this record?');" href="<?php echo site_url('child/remove/'.$C['child_id'].'/'.$list_num); ?>" class="btn btn-danger">Delete</a>
            <?php if($C['child_status']==0) { ?>
             <a onClick="javascript: return confirm('Are you sure you want to deactive this record?');" href="<?php echo site_url('child/change_status/'.$C['child_id'].'/'.$C['child_status'].'/'.$list_num); ?>" class="btn btn-success">Active</a>
            <?php  }
             else{ ?>
              <a onClick="javascript: return confirm('Are you sure you want to active this record?');" href="<?php echo site_url('child/change_status/'.$C['child_id'].'/'.$C['child_status'].'/'.$list_num); ?>" class="btn btn-danger">Deactive</a>
             <?php } ?>
        </td>
    </tr>
	<?php $i++; } ?>
</table>
                      
                      <div style=" text-align:center;"><?php echo $links; ?></div> 
                  </div>
                </div>
              </div>

            

             

 

             
            </div>
          </div>
        </div>

      <?php echo form_close(); ?>              
      
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