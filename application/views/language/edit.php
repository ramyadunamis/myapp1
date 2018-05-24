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
                    <h2>EDIT LANGUAGE <small></small></h2>
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
                    
                 <?php echo form_open('language/edit/'.$language['lang_id'],array("class"=>"form-horizontal")); ?>

                      
                      
                        <div class="form-group">
		<label for="lang_country" class="col-md-4 control-label"><span class="text-danger">*</span>Country</label>
		<div class="col-md-8">
                    
            <select name="lang_country" class="form-control error_style" style="color:#555">
            <option value="">Select Country</option>
            <?php foreach($country as $key=>$value) { ?>  
            <option value="<?php echo $value['name'];?>" <?php if($language['lang_country']==$value['name']) { ?>  selected="selected" <?php } ?>><?php echo $value['name'];?></option>
            <?php }?>
            </select>
			<span class="text-danger"><?php echo form_error('lang_country');?></span>
		</div>
	</div>
                      
	<div class="form-group">
		<label for="lang_name" class="col-md-4 control-label"><span class="text-danger">*</span>Lang Name</label>
		<div class="col-md-8">
			<input type="text" name="lang_name" value="<?php echo ($this->input->post('lang_name') ? $this->input->post('lang_name') : $language['lang_name']); ?>" class="form-control" id="lang_name" />
			<span class="text-danger"><?php echo form_error('lang_name');?></span>
		</div>
	</div>
	<div class="form-group">
		<label for="lang_native" class="col-md-4 control-label">Lang Native</label>
		<div class="col-md-8">
			<input type="text" name="lang_native" value="<?php echo ($this->input->post('lang_native') ? $this->input->post('lang_native') : $language['lang_native']); ?>" class="form-control" id="lang_native" />
		</div>
	</div>
	
	<div class="form-group">
		<label for="status" class="col-md-4 control-label">Status</label>
		<div class="col-md-8">
			<input type="text" name="status" value="<?php echo ($this->input->post('status') ? $this->input->post('status') : $language['status']); ?>" class="form-control" id="status" />
		</div>
	</div>
	<div class="form-group">
		<label for="delete" class="col-md-4 control-label">Delete</label>
		<div class="col-md-8">
			<input type="text" name="delete" value="<?php echo ($this->input->post('delete') ? $this->input->post('delete') : $language['delete']); ?>" class="form-control" id="delete" />
		</div>
	</div>
	<div class="form-group">
		<label for="lang_align_type" class="col-md-4 control-label">Lang Align Type</label>
		<div class="col-md-8">
		
                      <input type="radio" name="lang_align_type" value="RTL" <?php if($language['lang_align_type']=='RTL') echo 'checked';?> checked> RTL
                    <input type="radio" name="lang_align_type" value="LTR" <?php if($language['lang_align_type']=='LTR') echo 'checked';?> > LTR
                    
                </div>
	</div>
	
                      
                        <div class="form-group">
        <label for="lang_code" class="col-md-4 control-label">Language Code</label>
        <div class="col-md-8">
          <input type="text" name="lang_code" value="<?php echo ($this->input->post('lang_code') ? $this->input->post('lang_code') : $language['lang_code']); ?>" class="form-control" id="lang_native" />
        </div>
        </div>
                      
                      
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<button type="submit" class="btn btn-success">Save</button>
                         <a href="<?php echo site_url('language/'); ?>" class="btn btn-primary">Cancel</a> 
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