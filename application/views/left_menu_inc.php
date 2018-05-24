<?php 
$var = $this->session->user;
//echo $var['user_type'];
 
?>
<div class="navbar nav_title" style="border: 0;">
   <a href="<?php echo base_url();?>index/dashboard" class="site_title"><i class="fa fa-paw"></i> <span style="position: absolute;font-size: small;">Lokate Student- <?php echo SCHOOL_SHORT_NAME; ?> </span></a>
     </div>
 <div class="clearfix"></div>
            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="<?php echo base_url()."uploads/admin/".$this->session->user['user_photo'];?>" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $this->session->user['user_name']; ?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->

<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <?php   if($var['user_type']==0)
    { ?>
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url();?>index/dashboard">Dashboard</a></li>                     
                    </ul>
                  </li>
                </ul>
              </div>
     <div class="menu_section">
                <h3>Trip</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-table"></i> Trip Details <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url();?>Trip">List Trips</a></li>
                       <li><a href="<?php echo base_url();?>Trip/add_csv">Upload Trip CSV</a></li>
                      <li><a href="<?php echo base_url();?>Trip/add">Add Trips</a></li> 
                     
                      
                    </ul>
                  </li>                                  
                </ul>
              </div>

     <div class="menu_section">
                <h3>Bus</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bus"></i> Bus and Gate Details <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url();?>Bus">List </a></li>
                      <li><a href="<?php echo base_url();?>Bus/add_csv">Upload CSV</a></li>
                      <li><a href="<?php echo base_url();?>Bus/add">Add</a></li> 
                     
                      
                    </ul>
                  </li>                                  
                </ul>
              </div>
    
    
    
     
    
      <div class="menu_section">
                <h3>User</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-users"></i> User Details <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url();?>user">List Users</a></li>
                      <li><a href="<?php echo base_url();?>user/add">Add Users</a></li> 
                     
                      
                    </ul>
                  </li>                                  
                </ul>
              </div>
    
     <div class="menu_section">
                <h3>Child</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-child"></i> Child Details <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url();?>child">List Child</a></li>
                      <li><a href="<?php echo base_url();?>child/add">Add Child</a></li> 
<!--                       <li><a href="<?php echo base_url();?>child/add_csv">Clear db and Add Child list CSV</a></li> -->
                       <li><a href="<?php echo base_url();?>child/append_csv">Add new Child list CSV</a></li> 
                       <li><a href="<?php echo base_url();?>child/edit_csv">Update Child list CSV</a></li> 
                     
                      
                    </ul>
                  </li>                                  
                </ul>
              </div>
    
         <div class="menu_section">
                <h3>Notification</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-book"></i> Notification Details <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url();?>notification">List Notification</a></li>
                    
                     
                      
                    </ul>
                  </li>                                  
                </ul>
              </div>
    
    
    
      
    
     <div class="menu_section">
                <h3>School Bus Attendance</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-book"></i> Bus Attendance Details <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url();?>attendance">List Attendance</a></li>
<!--                        <li><a href="<?php echo base_url();?>School_attendance">List School Attendance</a></li>-->
<!--                      <li><a href="<?php echo base_url();?>attendance/add">Add Attendance</a></li> -->
                     
                      
                    </ul>
                  </li>                                  
                </ul>
              </div>
    
    
    
      <div class="menu_section">
                <h3>Bus App User</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-user"></i> Bus App User Details <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url();?>bus_app_user">List Bus App Users</a></li>
                      <li><a href="<?php echo base_url();?>bus_app_user/add">Add Bus App User</a></li> 
                     
                      
                    </ul>
                  </li>                                  
                </ul>
              </div>
    
    
    
     <div class="menu_section">
                <h3>Parent App User</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-user"></i> Parent App User Details <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url();?>parent_app_user">List Parent App Users Not Signed Up</a></li>
                       <li><a href="<?php echo base_url();?>parent_app_user/index_signedup">List Parent App Users Signed Up</a></li>
                      <li><a href="<?php echo base_url();?>parent_app_user/add">Add Parent App User</a></li> 
                     
                      
                    </ul>
                  </li>                                  
                </ul>
              </div>
    
        
     <div class="menu_section">
                <h3>supervisor App User</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-user"></i> supervisor App User Details <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url();?>supervisor_app_user">List supervisor App Users</a></li>
                      <li><a href="<?php echo base_url();?>supervisor_app_user/add">Add supervisor App User</a></li> 
                     
                      
                    </ul>
                  </li>                                  
                </ul>
              </div>
    
         <div class="menu_section">
                <h3>Lsedit App User</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-user"></i> Lsedit App User Details <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url();?>lsedit_app_user">List Lsedit App Users</a></li>
                      <li><a href="<?php echo base_url();?>lsedit_app_user/add">Add Lsedit App User</a></li> 
                     
                      
                    </ul>
                  </li>                                  
                </ul>
              </div>
    
    <?php } if($var['user_type']==1 || $var['user_type']==0)
    {?>
    
     <div class="menu_section">
                <h3>Tracking</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-caret-square-o-right" ></i> Tracking Details <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url();?>tracking">List Tracking</a></li>
                      <li><a href="<?php echo base_url();?>tracking/map">Map</a></li> 
                      <li><a href="<?php echo base_url();?>supervisor/" target="_blank">supervisor Page</a></li> 
                     
                      
                    </ul>
                  </li>                                  
                </ul>
              </div>
    
    <div class="menu_section">
                <h3>Report</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-book" ></i> Report Details <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url();?>report">Report PDF</a></li>
                      <li><a href="<?php echo base_url();?>report/report_csv">Report CSV</a></li>
                      <li><a href="<?php echo base_url();?>report/report_count_csv">Students Report</a></li>
                      <li><a href="<?php echo base_url();?>report/touch_screen_scan_report">Touch Screen Report</a></li>
                      <li><a href="<?php echo base_url();?>report/absent_list_report">Absent List Report</a></li>
                     
                      
                    </ul>
                  </li>                                  
                </ul>
              </div>
    
    
    <?php } if($var['user_type']==0){ ?>
         <div class="menu_section">
                <h3>Setting</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-gear"></i> Setting Details <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url();?>setting">List Setting</a></li>
<!--                      <li><a href="<?php echo base_url();?>setting/add">Add Setting</a></li> -->
                     
                      
                    </ul>
                  </li>                                  
                </ul>
              </div>
    
    
     <div class="menu_section">
                <h3>Languages</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-book"></i> Language details<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url();?>language">List Languages</a></li>
                      <li><a href="<?php echo base_url();?>language/add">Add Languages</a></li> 
                     
                      
                    </ul>
                  </li>                                  
                </ul>
              </div>
    
     <div class="menu_section">
                <h3>Localization</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-book"></i> Localization details<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url();?>localization">List Localization</a></li>
                      <li><a href="<?php echo base_url();?>localization/add">Add Localization</a></li> 
                     
                      
                    </ul>
                  </li>                                  
                </ul>
              </div>
    
    
    
    <div class="menu_section">
                <h3>Logo Image</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-book"></i> Logo Image Details <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url();?>logo_image">List Logo Images</a></li>
<!--                      <li><a href="<?php echo base_url();?>attendance/add">Add Attendance</a></li> -->
                     
                      
                    </ul>
                  </li>                                  
                </ul>
              </div>
    
       <div class="menu_section">
                <h3>Logs List</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-book"></i> Logs <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url();?>touch">Touch List</a></li>
                      <li><a href="<?php echo base_url();?>access_log">Access Log</a></li> 
                     
                      
                    </ul>
                  </li>                                  
                </ul>
              </div>


    
    
    
  
    
      
    
     <div class="menu_section">
                <h3>Device Management</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-user"></i> Device Attendance Details <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url();?>School_attendance">List School Attendance</a></li>
                      <li><a href="<?php echo base_url();?>School_attendance/report_csv">Report School Attendance</a></li>
                      <li><a href="<?php echo base_url();?>attendance_device">Device List  </a></li>
                      <li><a href="<?php echo base_url();?>attendance_device/add">Add Device </a></li> 
                      <li><a href="<?php echo base_url();?>device_app_user">List Device App Users</a></li>
                      <li><a href="<?php echo base_url();?>device_app_user/add">Add Device App Users </a></li> 
                      
                    </ul>
                  </li>                                  
                </ul>
              </div>
    
    
     <?php } ?>
            </div>
        <!-- /sidebar menu -->  
            <!-- /menu footer buttons -->
<!--            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>-->
            <!-- /menu footer buttons -->