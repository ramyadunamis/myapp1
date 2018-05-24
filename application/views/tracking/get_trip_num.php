<select name="trip" >
     <option selected="selected">...Select Trip Number...</option>
<?php// foreach($trip_num as $T){ ?>
   
 <option value="<?php echo $trip_num['trip_id'];?>" <?php if( $this->input->post('trip')==$trip_num['trip_id']) {;?> selected <?php } ?>><?php echo $trip_num['trip_no'];?></option>
  <?php //} ?>
</select>