<table cellspacing="10" width='100%'>
    <tr>
		
		<th>Child Name</th>
                <th>Child Class</th>
                <th>Child Section</th>
		<th>At Time Stamp</th>
		<th>Status</th>
    </tr>
	<?php
        //print_r($attendance);  
        foreach($attendance as $A){ ?>
    <tr>
		
		<td><?php echo $A['child_name']; ?></td>
		<td><?php echo $A['child_class']; ?></td>
		<td><?php echo $A['child_section']; ?></td>
		<td><?php echo $A['at_time_stamp_device']; ?></td>
		<td>
                   <?php  if($A['at_in_or_out']=='in')
                    {
                        echo 'IN ';
                    }
                    else {
                        echo 'OUT';
                    }
                        ?>
      </td>
    </tr>
	<?php  } ?>
</table>
                       