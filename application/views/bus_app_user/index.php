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
                    <h2>BUS APP USER LIST <small></small></h2>
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
                 <div class="pull-right">
	<a href="<?php echo site_url('bus_app_user/add'); ?>" class="btn btn-success">Add</a> 
</div>

<table class="table table-striped table-bordered">
    <tr>
		<th>#</th>
		<th>Bus App User Name</th>
<!--		<th>Bus App User Password</th>-->
		<th>Bus App User Bus Number</th>
		<th>Bus User Status</th>
		<th>Actions</th>
    </tr>
	<?php $i=1; foreach($bus_app_user as $B){ ?>
    <tr>
		<td><?php echo $i; ?></td>
		<td><?php echo $B['bus_app_user_name']; ?></td>
<!--		<td><?php echo $B['bus_app_user_password']; ?></td>-->
		<td><?php echo $B['bus_name']; ?></td>
		<td><?php if($B['bus_user_status']==0){ ?><a href="<?php echo site_url('bus_app_user/change_status/'.$B['bus_app_user_id']).'/'.$B['bus_user_status']; ?>" onClick="javascript: return confirm('Are you sure you want to deactive this record?');"><li class="glyphicon glyphicon-ok-sign"></li></a> 
                     <?php } else { ?> <a href="<?php echo site_url('bus_app_user/change_status/'.$B['bus_app_user_id']).'/'.$B['bus_user_status']; ?>" onClick="javascript: return confirm('Are you sure you want to active this record?');"><li class="glyphicon glyphicon-remove-sign"></li></a> <?php } ?></td>
		
		<td>
            <a href="<?php echo site_url('bus_app_user/edit/'.$B['bus_app_user_id']); ?>" class="btn btn-info">Edit</a> 
            <a onClick="javascript: return confirm('Are you sure you want to delete this record?');" href="<?php echo site_url('bus_app_user/remove/'.$B['bus_app_user_id']); ?>" class="btn btn-danger">Delete</a>
        </td>
    </tr>
	<?php $i++; } ?>
</table>
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