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
                    <h2>LIST USERS SIGNED UP <small></small></h2>
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
                    
                     <?php echo form_open('parent_app_user/search',array("class"=>"form-horizontal",'method'=>"get")); ?>  
                    User Name:<input type="text" name="email" value="<?php echo $this->input->get('email');?>"> &nbsp; &nbsp;
                    <input type="hidden" name="direction" value="signedup"> 
                    <button type="submit" class="btn btn-success">Search</button>
                    <a href="<?php echo site_url('parent_app_user/index'); ?>" class="btn btn-success" style="position: absolute; left: 400px;">List of Parents NOT SIGNED-UP</a> 
                    <div style="font-size: x-large;"><center>Signed Up Users : <?php echo $signedup_count; ?></center></div>
                  <div class="x_content"> 
                  <div class="pull-right">
<!--	<a href="<?php echo site_url('parent_app_user/add/signedup'); ?>" class="btn btn-success">Add</a> -->
</div>
<div style="color: crimson; text-align: center" >
                        <?php echo $this->session->flashdata('error'); ?></div>
<table class="table table-striped table-bordered">
    <tr>
		<th>#</th>
		<th>Name <br/>Number<br/>User Name</th>
                <th>Child Name</th>
		<th>Number of Childs</th>
		<th>Status</th>
		<th>Actions</th>
    </tr>
	<?php $i=$list_num; foreach($parent_app_user as $P){ ?>
    <tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $P['child_father_name']. '<br/>'.$P['child_father_tel']. '<br/>'.$P['parent_app_user_name']; ?></td>
                <td><?php foreach ($P['names'] as $key => $value) {
                 echo $value['child_name'].'('.$value['child_reg_no'].')<br/>'; 
                 }?></td>
		<td><?php echo $P['count']; ?></td>
<!--		<td><?php echo $P['parent_app_user_status']; ?></td>-->
                
                
                 <td><?php if($P['parent_app_user_status']==0){ ?><a href="<?php echo site_url('parent_app_user/change_status_notsigned/'.$P['parent_app_user_id']); ?>" onClick="javascript: return confirm('Are you sure you want to disable this record?');"><li class="glyphicon glyphicon-ok-sign"></li></a> 
                     <?php } else { ?> <a href="<?php echo site_url('parent_app_user/change_status_notsigned/'.$P['parent_app_user_id']).'/'.$P['parent_app_user_status']; ?>" onClick="javascript: return confirm('Are you sure you want to enable this record?');"><li class="glyphicon glyphicon-remove-sign"></li></a> <?php } ?></td>
                 
                 
		<td>
            <a href="<?php echo site_url('parent_app_user/edit/'.$P['parent_app_user_id'].'/signedup'); ?>" class="btn btn-info">Edit</a> 
            <a href="<?php echo site_url('parent_app_user/remove/'.$P['parent_app_user_id'].'/signedup'); ?>" class="btn btn-danger" onClick="javascript: return confirm('Are you sure you want to delete this record?');">Delete</a>
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