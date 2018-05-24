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
                    <h2>EDIT USER DETAILS <small></small></h2>
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
<?php echo form_open_multipart('user/edit/'.$user['id'],array("class"=>"form-horizontal")); ?>

	<div class="form-group">
		<label for="user_id" class="col-md-4 control-label">User Id<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="user_id" value="<?php echo ($this->input->post('user_id') ? $this->input->post('user_id') : $user['user_id']); ?>" class="form-control" id="user_id" />
		</div>
	</div>
	<div class="form-group">
		<label for="user_name" class="col-md-4 control-label">User Name<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="user_name" value="<?php echo ($this->input->post('user_name') ? $this->input->post('user_name') : $user['user_name']); ?>" class="form-control" id="user_name" />
		</div>
	</div>
	<div class="form-group">
		<label for="user_password" class="col-md-4 control-label">User Password<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="user_password" value="<?php echo ($this->input->post('user_password') ? $this->input->post('user_password') : $user['user_password']); ?>" class="form-control" id="user_password" />
		</div>
	</div>
	<div class="form-group">
		<label for="user_gender" class="col-md-4 control-label">User Gender<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="user_gender" value="<?php echo ($this->input->post('user_gender') ? $this->input->post('user_gender') : $user['user_gender']); ?>" class="form-control" id="user_gender" />
		</div>
	</div>
	<div class="form-group">
		<label for="user_email" class="col-md-4 control-label">User Email<span style="color: red; font-size: large;">*</span></label>
		<div class="col-md-8">
			<input type="text" name="user_email" value="<?php echo ($this->input->post('user_email') ? $this->input->post('user_email') : $user['user_email']); ?>" class="form-control" id="user_email" />
		</div>
	</div>
	<div class="form-group">
		<label for="user_phone" class="col-md-4 control-label">User Phone</label>
		<div class="col-md-8">
			<input type="text" name="user_phone" value="<?php echo ($this->input->post('user_phone') ? $this->input->post('user_phone') : $user['user_phone']); ?>" class="form-control" id="user_phone" />
		</div>
	</div>
	<div class="form-group">
		<label for="user_mobile" class="col-md-4 control-label">User Mobile</label>
		<div class="col-md-8">
			<input type="text" name="user_mobile" value="<?php echo ($this->input->post('user_mobile') ? $this->input->post('user_mobile') : $user['user_mobile']); ?>" class="form-control" id="user_mobile" />
		</div>
	</div>
	<div class="form-group">
		<label for="user_place" class="col-md-4 control-label">User Place</label>
		<div class="col-md-8">
			<input type="text" name="user_place" value="<?php echo ($this->input->post('user_place') ? $this->input->post('user_place') : $user['user_place']); ?>" class="form-control" id="user_place" />
		</div>
	</div>
<!--	<div class="form-group">
		<label for="created_date" class="col-md-4 control-label">Created Date</label>
		<div class="col-md-8">
			<input type="text" name="created_date" value="<?php echo ($this->input->post('created_date') ? $this->input->post('created_date') : $user['created_date']); ?>" class="form-control" id="created_date" />
		</div>
	</div>-->
	<div class="form-group">
		<label for="user_photo" class="col-md-4 control-label">User Photo</label>
		<div class="col-md-8">
                    <img src="http://host.ls-dunamis.com/~safety/uploads/admin/<?php echo $user['user_photo']; ?>" width="100" height="100">
			<input type="file" name="user_photo" value="<?php echo ($this->input->post('user_photo') ? $this->input->post('user_photo') : $user['user_photo']); ?>" class="form-control" id="user_photo" />
		</div>
	</div>
<!--	<div class="form-group">
		<label for="user_status" class="col-md-4 control-label">User Status</label>
		<div class="col-md-8">
			<input type="text" name="user_status" value="<?php echo ($this->input->post('user_status') ? $this->input->post('user_status') : $user['user_status']); ?>" class="form-control" id="user_status" />
		</div>
	</div>-->
	<div class="form-group">
		<label for="user_auth_code" class="col-md-4 control-label">User Auth Code</label>
		<div class="col-md-8">
			<input type="text" name="user_auth_code" value="<?php echo ($this->input->post('user_auth_code') ? $this->input->post('user_auth_code') : $user['user_auth_code']); ?>" class="form-control" id="user_auth_code" />
		</div>
	</div>
<!--	<div class="form-group">
		<label for="user_type" class="col-md-4 control-label">User Type</label>
		<div class="col-md-8">
			<input type="text" name="user_type" value="<?php echo ($this->input->post('user_type') ? $this->input->post('user_type') : $user['user_type']); ?>" class="form-control" id="user_type" />
		</div>
	</div>-->
<!--	<div class="form-group">
		<label for="user_updated_timestamp" class="col-md-4 control-label">User Updated Timestamp</label>
		<div class="col-md-8">
			<input type="text" name="user_updated_timestamp" value="<?php echo ($this->input->post('user_updated_timestamp') ? $this->input->post('user_updated_timestamp') : $user['user_updated_timestamp']); ?>" class="form-control" id="user_updated_timestamp" />
		</div>
	</div>-->
	
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<button type="submit" class="btn btn-success">Save</button>
                         <a href="<?php echo site_url('user'); ?>" class=" btn btn-primary">Cancel</a> 
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