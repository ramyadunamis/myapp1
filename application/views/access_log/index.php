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
                    <h2>Access Log List <small></small></h2>
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
<!--	<a href="<?php echo site_url('access_log/add'); ?>" class="btn btn-success">Add</a> -->
</div>

<table class="table table-striped table-bordered">
    <tr>
               <th>#</th>
<!--		<th>Alog Id</th>-->
		<th>Alog Parent Id</th>
		<th>Alog Device</th>
		<th>Alog Model</th>
		<th>Alog Os Version</th>
		<th>Alog Ip Address</th>
		<th>Alog Country</th>
		<th>Alog Time Zone</th>
		<th>Alog Updated Time</th>
<!--		<th>Alog Status</th>
		<th>Alog Delete</th>
		<th>Actions</th>-->
    </tr>
	<?php $i = $list_num+1; 
       foreach($access_log as $A){ ?>
    <tr>
                <td><?php echo $i; ?></td>
<!--		<td><?php echo $A['alog_id']; ?></td>-->
		<td><?php echo $A['alog_parent_id']; ?></td>
		<td><?php echo $A['alog_device']; ?></td>
		<td><?php echo $A['alog_model']; ?></td>
		<td><?php echo $A['alog_os_version']; ?></td>
		<td><?php echo $A['alog_ip_address']; ?></td>
		<td><?php echo $A['alog_country']; ?></td>
		<td><?php echo $A['alog_time_zone']; ?></td>
		<td><?php echo $A['alog_updated_time']; ?></td>
<!--		<td><?php echo $A['alog_status']; ?></td>
		<td><?php echo $A['alog_delete']; ?></td>
		<td>
            <a href="<?php echo site_url('access_log/edit/'.$A['alog_id']); ?>" class="btn btn-info btn-xs">Edit</a> 
            <a href="<?php echo site_url('access_log/remove/'.$A['alog_id']); ?>" class="btn btn-danger btn-xs">Delete</a>-->
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