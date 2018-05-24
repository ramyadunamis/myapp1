<div>
        <table width="100%" border="0" cellspacing="10" cellpadding="10" style=" left: 50px;">
            <tr style="background-color: cornsilk;"><td> <font size="3pt" face="Arial"><b>Bus #</b></font> <?php echo $bus_name['bus_name'];?></td><td style="position: absolute;left: 200px;"><font size="3pt" face="Arial"><b>Trip #</b></font> <?php echo $trip['trip_no'];?></td></tr>
            <tr> <td><b>Trip Detail:  <?php echo $trip['trip_title'];?></b></td> <td></td></tr>
            <tr> <td><font size="3pt" face="Arial"><b>Driver: </b></font> <?php echo $bus_name['driver_name'];?> (<?php echo $bus_name['driver_phone'];?>)</td>
                <td style="position: absolute;left: 350px;"><font size="3pt" face="Arial"><b>Assistant:</b></font>  <?php echo $bus_name['driver_assistant'];?> (<?php echo $bus_name['assistant_phone'];?>)</td></tr> 
            <?php
           if($time)
           {
            foreach ($time as $key => $value) {
            $time_report[]= $value['tracking_time_stamp_device'];
            }
         $first = reset($time_report);
         $last = end($time_report);
           }
         //  print_r($time_report); ?>
<!--            <tr> <td><font size="3pt" face="Arial"><b>Trip Start Time:  </b></font> <?php if($time){ echo $first; } ?></td><td style="position: absolute;left: 220px;"><font size="3pt" face="Arial"><b>Trip Finish Time:</b></font>  <?php if($time){ echo $last; } ?></td></tr> -->
            <tr>
                <td>
                    <font size="4pt" face="Arial"> <b>STUDENT ENTERED THE BUS &nbsp;</b></font>
                    <table width="100%" border="1" cellspacing="0" cellpadding="0"  style="width: 600px;"> 
                        <tr>  <td>#</td><td>STUDENT NAME</td><td>CLASS & SECTION</td><td>GR #</td><td>PICKUP TIME</td><td>DROP OFF TIME</td></tr>
                        <?php $i=1; foreach ($child_present as $key => $values) { ?>
                        <tr>  <td><?php echo $i;?></td> <td><?php echo $values['child_name']; ?></td><td><?php echo $values['child_class']; ?> & <?php echo $values['child_section']; ?></td>
                            <td><?php echo $values['child_reg_no']; ?></td> <td><?php echo date("H:i:s",strtotime($values['at_time_stamp'])); ?></td><td><?php echo date("H:i:s",strtotime($values['at_time_stamp_device'])); ?></td></tr>
                        <?php  $i++; } ?>
                    </table>
                </td>
            </tr>
             <tr>
                <td>
                        <font size="4pt" face="Arial"> <b>STUDENT NOT ON BUS &nbsp;</b></font>
                 <table width="100%" border="1" cellspacing="0" cellpadding="0" style="width: 600px;"> 
                     
                <tr>  <td>#</td><td>STUDENT NAME</td><td>CLASS & SECTION</td><td>GR #</td><td>NOT AT STOP TIME</td></tr>
               <?php $i=1; foreach ($child_not_on_the_bus as $key => $values) { ?>
                        <tr>  <td><?php echo $i;?></td> <td><?php echo $values['child_name']; ?></td><td><?php echo $values['child_class']; ?> & <?php echo $values['child_section']; ?></td>
                            <td><?php echo $values['child_reg_no']; ?></td> <td><?php echo date("H:i:s",strtotime($values['at_time_stamp_device'])); ?></td></tr>
                        <?php  $i++; } ?>
                  
            </table>
                </td> 
            </tr>

        </table>
</div>


