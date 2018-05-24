<table width="100%" border="0" cellspacing="10" cellpadding="10" style=" left: 50px;  page-break-inside: avoid;">
            <tr><td style=" page-break-inside: avoid;"> <b>Bus #</b><?php echo $bus_name['bus_name'];?>       <b>Trip #</b><?php echo $trip['trip_no'];?></td></tr>
            <tr> <td style=" page-break-inside: avoid;"><b>Trip Detail:  <?php echo $trip['trip_title'];?></b></td> <td style=" page-break-inside: avoid;"></td></tr>
            <tr> <td style=" page-break-inside: avoid;"><b>Driver: </b> <?php echo $bus_name['driver_name'];?> (<?php echo $bus_name['driver_phone'];?>)
                    <b>Assistant:</b>  <?php echo $bus_name['driver_assistant'];?> (<?php echo $bus_name['assistant_phone'];?>)</td></tr> 
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
            <tr> <td style=" page-break-inside: avoid;"><b>Trip Start Time:  </b> <?php if($time){ echo $first; } ?>   <b>Trip Finish Time:</b>  <?php if($time){ echo $last; } ?></td></tr> 
            <tr>
                <td style=" page-break-inside: avoid;">
                   <b>STUDENT ENTERED THE BUS &nbsp;</b>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="width: 600px;  page-break-inside: avoid;"> 
                        <tr>  <td style=" page-break-inside: avoid;">#</td><td style=" page-break-inside: avoid;">STUDENT NAME</td><td style=" page-break-inside: avoid;">CLASS & SECTION</td><td style=" page-break-inside: avoid;">GR #</td><td style=" page-break-inside: avoid;">PICKUP TIME</td><td style=" page-break-inside: avoid;">DROP OFF TIME</td></tr>
                        <?php $i=1; foreach ($child_present as $key => $values) { ?>
                        <tr>  <td style=" page-break-inside: avoid;"><?php echo $i;?></td> <td style=" page-break-inside: avoid;"><?php echo $values['child_name']; ?></td><td style=" page-break-inside: avoid;"><?php echo $values['child_class']; ?> & <?php echo $values['child_section']; ?></td>
                            <td style=" page-break-inside: avoid;"><?php echo $values['child_reg_no']; ?></td> <td style=" page-break-inside: avoid;"><?php echo date("H:i:s",strtotime($values['at_time_stamp'])); ?></td><td style=" page-break-inside: avoid;"><?php echo date("H:i:s",strtotime($values['at_time_stamp_device'])); ?></td></tr>
                        <?php  $i++; } ?>
                    </table>
                </td>
            </tr>
             <tr>
                <td style=" page-break-inside: avoid;">
                      <b>STUDENT NOT ON BUS &nbsp;</b>
                 <table width="100%" border="1" cellspacing="0" cellpadding="0" style="width: 600px;  page-break-inside: avoid;"> 
                     
                <tr>  <td style=" page-break-inside: avoid;">#</td><td style=" page-break-inside: avoid;">STUDENT NAME</td><td style=" page-break-inside: avoid;">CLASS & SECTION</td><td style=" page-break-inside: avoid;">GR #</td><td style=" page-break-inside: avoid;">NOT AT STOP TIME</td></tr>
               <?php $i=1; foreach ($child_not_on_the_bus as $key => $values) { ?>
                        <tr>  <td style=" page-break-inside: avoid;"><?php echo $i;?></td> <td style=" page-break-inside: avoid;"><?php echo $values['child_name']; ?></td><td style=" page-break-inside: avoid;"><?php echo $values['child_class']; ?> & <?php echo $values['child_section']; ?></td>
                            <td style=" page-break-inside: avoid;"><?php echo $values['child_reg_no']; ?></td> <td style=" page-break-inside: avoid;"><?php echo date("H:i:s",strtotime($values['at_time_stamp'])); ?></td></tr>
                        <?php  $i++; } ?>
                  
            </table> 
                </td> 
            </tr>
        </table>

