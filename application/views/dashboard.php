<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php include 'title_inc.php'; ?></title>
        <?php include 'head_inc.php'; ?>
    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">                      
                        <!-- left Panel -->
                        <?php include 'left_menu_inc.php'; ?>
                        <!-- /left panel -->
                    </div>
                </div>
                <!-- top navigation -->
                <?php include 'top_inc.php'; ?>
                <!-- /top navigation -->

                <!-- page content -->
                <div class="right_col" role="main">                 
                    
                    <div class="row tile_count">
                        <?php if($msg!=''){?>
                        <div class="alert alert-success fade in" style="clear: both;">
                             <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong> <?php echo $msg ; ?>
                    </div>
                    <?php } ?>
                         <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top" > Total students in bus</span>
              <div class="count green"><?php echo $child;?></div>
             </div>
                        
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top" > Parents Signed Up</span>
              <div class="count"><?php echo $signed.'/'.$count_parents; ?></div>
              </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top">Total number of devices</span>
              <div class="count"><?php echo $total_devices;?></div>
            </div>
           
<!--            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top" style=" font-size: large;    font-weight: bold;"> Total number of devices<br/>(IOS & Android)</span>
              <div class="count"><?php echo $count_parents;?> </div>
               </div>-->
           
              </div>
                 
                        
                  
                    
                    <div class="col-md-3">
                <div class="x_panel">
                <div class="x_title">
                <h2>Quick links</h2>
                <div class="clearfix"></div>
                </div>
                <div class="x_content">

                <article class="media event">
               
                    <div class="media-body">
                    
                     <p ><i class="fa fa-child"></i>&nbsp; <a href="<?php echo site_url('child'); ?>" >Students list</a> </p><br/>
                     
                     
                     
                    <p><i class="fa fa-user"></i>&nbsp; <a href="<?php echo site_url('parent_app_user'); ?>" >Parents Not Signed Up</a>                </p><br/>
                <p><i class="fa fa-user"></i>&nbsp; <a href="<?php echo site_url('parent_app_user/index_signedup'); ?>" >Parents Signed Up</a> </p><br/>
                <p><i class="fa  fa-hand-o-right"></i>&nbsp; <a href="<?php echo site_url('Trip'); ?>" >Trip List</a> </p><br/>
                <p> <i class="fa fa-bus"></i>&nbsp; <a href="<?php echo site_url('Bus'); ?>" >Bus & Gate List</a> </p><br/>
               <p> <i class="fa fa-bus"></i>&nbsp; <a href="<?php echo site_url('report/report_csv'); ?>" >Reports CSV</a> </p><br/>
               
<!--                <p><i class="fa  fa-hand-o-right"></i>&nbsp; <a href="<?php echo site_url('bus_app_user'); ?>">Bus App Users List</a> </p><br/>
                  <p><i class="fa  fa-hand-o-right"></i>&nbsp; <a href="<?php echo site_url('supervisor_app_user'); ?>">Supervisor App Users List</a> </p><br/>
                   <p><i class="fa  fa-hand-o-right"></i>&nbsp; <a href="<?php echo site_url('lsedit_app_user'); ?>">LSedit App Users List</a> </p><br/>-->
                </div>
                </article>
                



                </div>
                </div>
                </div>   
                    
                    
                    
                        
                <div class="col-md-3">
                <div class="x_panel">
                <div class="x_title">
                <h2>TOP Devices</h2>
                <div class="clearfix"></div>
                </div>
                <div class="x_content">

                <?php foreach ($access_log as $key => $value) {
                ?>
                <article class="media event">
                <a class="pull-left date">
                    <p class="month">Total</p>
                <p class="month"><?php echo $value['num'];?></p>
                </a>
                <div class="media-body">
                <a class="title" href="#"></a>
                <p><?php echo $value['alog_model'];?></p>
                </div>
                </article>
                <?php }?>



                </div>
                </div>
                </div>
                  
                                             
                <div class="col-md-3">
                <div class="x_panel">
                <div class="x_title">
                <h2>TOP DEVICE OS</h2>
                <div class="clearfix"></div>
                </div>
                <div class="x_content">

                <?php foreach ($access_log as $key => $value) {
                ?>
                <article class="media event">
                <a class="pull-left date">
                    <p class="month">Total</p>
                <p class="month"><?php echo $value['num'];?></p>
                </a>
                <div class="media-body">
                <a class="title" href="#"></a>
                <p><?php echo  ucfirst($value['alog_device']).' '.$value['alog_os_version'];?></p>
                </div>
                </article>
                <?php }?>



                </div>
                </div>
                </div>     
                    
                    
                    
             <?php  if($is_truncate=='Yes'){    ?> 
                              
               
                        
                         <div class="col-md-3">
                <div class="x_panel">
                <div class="x_title">
                <h2>Quick Settings</h2>
                <div class="clearfix"></div>
                </div>
                <div class="x_content">

                <article class="media event">
               
                <div class="media-body">
                <p><form method="post">
                             Do you want to clear the Database ?  <input name="submit" type="submit" value="Go" class="btn btn-success btn-sm" onclick="return confirm('Are you sure?')">
                    </form>
                </p>
                <p><form method="post">
                        Do you want to clear the Tracking Table ?   <input name="track" type="submit" value="Go"  class="btn btn-success btn-sm" onclick="return confirm('Are you sure?')"/>
                    </form>
                </p>
                <p><form method="post">
                       Do you want to Finish All Trips ?  <input name="finish_trip" type="submit" value="Go"  class="btn btn-success btn-sm" onclick="return confirm('Are you sure?')"/>
                    </form>
                </p>
                <p> <form method="post">
                       Do you want to Copy Tracking Table ?   <input name="copy_tacking_table" type="submit" value="Go"  class="btn btn-success btn-sm" onclick="return confirm('Are you sure?')"/>
                    </form>
                </p>
                <p><form method="post">
                       Do you want to Copy Attendance Table ?   <input name="copy_attendance_table" type="submit" value="Go"  class="btn btn-success btn-sm" onclick="return confirm('Are you sure?')"/>
                    </form> 
                </p>
                  <p><form method="post">
                       Do you want to clear the Push Message Id's ?   <input name="clear_push_msg" type="submit" value="Go"  class="btn btn-success btn-sm" onclick="return confirm('Are you sure?')"/> 
                    </form> 
                </p>
                <p><form method="post">
                       Do you want to clear the School Attendance ?   <input name="clear_school_attendance" type="submit" value="Go"  class="btn btn-success btn-sm" onclick="return confirm('Are you sure?')"/> 
                    </form> 
                </p>
                </div>
                </article>
                



                </div>
                </div>
                </div>
                        
                        
             <?php } ?>                
              
                    

                    
                    
                    
                    
          </div>
                
                
                <!-- /page content -->
                <!-- footer content -->
                <?php include 'footer_inc.php'; ?>
                <!-- /footer content -->
            </div>
        </div>
        <?php include 'common_js_inc.php'; ?>
    </body>
</html>
