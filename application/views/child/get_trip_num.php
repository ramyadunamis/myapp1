<select name="trip" >
     <option selected="selected">...Select Trip Number...</option>
<?php foreach($trip_num as $T){ ?>
   
 <option value="<?php echo $T['trip_id'];?>"><?php echo $T['trip_no'];?></option>
<!--  <option selected="selected">Select City</option>-->
  <?php } ?>
</select>