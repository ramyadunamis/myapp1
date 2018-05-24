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
<!--    datepicker-->

<link rel="stylesheet" href="<?php echo base_url()."public/";?>vendors/calendar/jquery-ui.css">
<script src="<?php echo base_url()."public/";?>vendors/calendar/jquery-1.10.2.js"></script>
<script src="<?php echo base_url()."public/";?>vendors/calendar/jquery-ui.js"></script>
<script>
$(function() {
$( "#datepicker" ).datepicker();
});
</script>
 <script>
            function gettrip(id)
            {
              // alert('this id value :'+id);
                $.ajax({
                    type: "POST",
                    url: '<?php echo site_url('tracking/ajax_list_Report').'/';?>'+id,
                    data: id='cat_id',
                    success: function(data){
                     //  alert(data);
                        $('#trip_val').html(data);
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
                    <h2>Report in PDF <small></small></h2>
                   
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                 <div class="pull">
                 <?php echo form_open('report/search',array("class"=>"form-horizontal",'method'=>"get")); ?>    
                    Date: <input type="text" id="datepicker" name="date" value="<?php echo $this->input->get('date'); ?>"><br/>
                   Choose Bus Names:<br/>  <?php
                    $buscount=count($bus);
                     $bus1=$buscount/5;
                   //  $round=round($bus1, 0, PHP_ROUND_HALF_UP); 
                     
                     for($i=0;$i<$bus1;$i++)
                     {
                     ?>
                   <input type="radio" name="radio" <?php  if( $this->input->get('radio')==(($i*5)+1).'-'.(($i*5)+5)){;?> checked <?php } ?>    value="<?php echo (($i*5)+1).'-'.(($i*5)+5);?>" class="btn btn-success" <?php if($i==0){ echo 'checked'; }?> ><?php echo (($i*5)+1).'-'.(($i*5)+5);?><br/>
                    
 <?php } ?>
                    
                  <?php  //for($i=1;$i<=$buscount;$i++)
                   // { ?>
<!--                      <input type="radio" name="radio" <?php  if( $this->input->get('radio')==($i)){ ?> checked <?php } ?>    value="<?php echo $i;?>" class="btn btn-success" <?php if($i==1){ echo 'checked'; }?> ><?php echo $i;?><br/>-->
                  <?php //} ?>
                  <br/><br/>
                  <div style="font-size: large; font-weight: bold;"> OR </div>
                  <br/><br/>
                    Bus Name:<select name="bus" id="bus" onChange="gettrip(this.value)">
                        <option selected="selected" value="">...Select Bus...</option>
<!--                         <option value="All">All</option>-->
                        <?php foreach($bus as $B){ ?> 
                      <option value="<?php echo $B['bus_id'];?>" <?php  if( $this->input->get('bus')==$B['bus_id']){;?> selected <?php } ?>><?php echo $B['bus_name'];?></option>
                    <?php  } ?>
                    </select>
                    Trip Number:<select name="trip" id="trip_val">
                        <option value="">...Select Trip Number...</option>
                        <?php if($this->input->get('trip')){?>
                        <option <?php if($this->input->get('trip')){?> selected  <?php } ?>><?php echo $this->input->get('trip'); ?></option>
                        <?php } ?>
                    </select>
                     
                     <br/><br/>
                    <button type="submit" class="btn btn-success">Search</button>
</div>
    <?php 

                        //print_r($search);
    ?>

                    
       

                  </div>
                </div>
              </div>

        <?php echo form_close(); ?>     

             

 

             
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
<!--    <script src="<?php echo base_url()."public/";?>vendors/jquery/dist/jquery.min.js"></script>-->
    <!-- Bootstrap -->
    <script src="<?php echo base_url()."public/";?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url()."public/";?>build/js/custom.min.js"></script>

   
  </body>
</html> 