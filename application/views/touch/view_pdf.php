<table width="100%" border="0" cellspacing="10" cellpadding="10" style=" left: 50px;  page-break-inside: avoid;">
<!--   
            <tr> <td> <b>TRANSPORT REPORT &nbsp;</b></td></tr>
            <tr>  <td>Date:<?php echo date(  "j F Y (l)", strtotime( $this->input->get('date') ) );?>

                </td> <td></td></tr>-->

            <tr><td style=" page-break-inside: avoid;"> <b>Bus #</b><?php echo $bus_name['bus_name'];?>       <b>Trip #</b><?php echo $trip['trip_no'];?></td></tr>
            <tr> <td style=" page-break-inside: avoid;"><b>Trip Detail:  <?php echo $trip['trip_title'];?></b></td> <td style=" page-break-inside: avoid;"></td></tr>
            <tr> <td style=" page-break-inside: avoid;"><b>Driver: </b> <?php echo $bus_name['driver_name'];?> (<?php echo $bus_name['driver_phone'];?>)
                    <b>Assistant:</b>  <?php echo $bus_name['driver_assistant'];?> (<?php echo $bus_name['assistant_phone'];?>)</td></tr> 
          
             
            <tr>
                <td style=" page-break-inside: avoid;">
                   <b>STUDENT DETAILS &nbsp;</b>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="width: 600px;  page-break-inside: avoid;"> 
                        <tr>  <td style=" page-break-inside: avoid;">#</td><td style=" page-break-inside: avoid;">STUDENT NAME</td><td style=" page-break-inside: avoid;"></td><td style=" page-break-inside: avoid;">GR #</td></tr>
                        <?php $i=1; foreach ($child_details as $key => $values) { ?>
                        <tr>  <td style=" page-break-inside: avoid;"><?php echo $i;?></td> <td style=" page-break-inside: avoid;"><?php echo $values['child_name']; ?></td><td style=" page-break-inside: avoid;"></td><td style=" page-break-inside: avoid;"><?php echo $values['child_nfc_id']; ?></td></tr>
                        <?php  $i++; } ?>
                    </table>
                </td>
            </tr>
      

        </table>

