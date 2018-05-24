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
                 <?php echo validation_errors(); ?>
<?php echo form_open_multipart('logo_image/add',array("class"=>"form-horizontal")); ?>

	<div class="form-group">
		<label for="p_logo_image_andriod" class="col-md-4 control-label">Parent Logo Image Andriod</label>
		<div class="col-md-8">
			<input type="file" name="file[]" value="<?php echo $this->input->post('p_logo_image_andriod'); ?>" class="form-control" id="p_logo_image_andriod" />
		</div>
	</div>
	<div class="form-group">
		<label for="B_logo_image_andriod" class="col-md-4 control-label">Bus Logo Image Andriod</label>
		<div class="col-md-8">
			<input type="file" name="file[]" value="<?php echo $this->input->post('B_logo_image_andriod'); ?>" class="form-control" id="B_logo_image_andriod" />
		</div>
	</div>
	<div class="form-group">
		<label for="p_logo_image_ios" class="col-md-4 control-label">Parent Logo Image Ios</label>
		<div class="col-md-8">
			<input type="file" name="file[]" value="<?php echo $this->input->post('p_logo_image_ios'); ?>" class="form-control" id="p_logo_image_ios" />
		</div>
	</div>
	<div class="form-group">
		<label for="B_logo_image_ios" class="col-md-4 control-label">Bus Logo Image Ios</label>
		<div class="col-md-8">
			<input type="file" name="file[]" value="<?php echo $this->input->post('B_logo_image_ios'); ?>" class="form-control" id="B_logo_image_ios" />
		</div>
	</div>
<!--	<div class="form-group">
		<label for="status" class="col-md-4 control-label">Status</label>
		<div class="col-md-8">
			<input type="text" name="status" value="<?php echo $this->input->post('status'); ?>" class="form-control" id="status" />
		</div>
	</div>-->
	
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<button type="submit" class="btn btn-success">Save</button>
                        <a href="<?php echo site_url('logo_image'); ?>" class=" btn btn-primary">Cancel</a> 
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