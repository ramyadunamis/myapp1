<select name="trip" >
     <option selected="selected">...Select Trip Number...</option>
    
<?php
if($trip_num=='All')
{?>
    <option value="All"><?php echo 'All';?></option>
<?php } else
{
foreach($trip_num as $T){ ?>
   
 <option value="<?php echo $T['trip_id'];?>" <?php if( $this->input->post('trip')==$T['trip_id']) {;?>  <?php } ?>><?php echo $T['trip_no'];?></option>
<?php }  } ?>
</select>