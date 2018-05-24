<table width="100%" border="0" cellspacing="10" cellpadding="10" style=" left: 50px;">
    <tr style="font-weight: bolder; font-size:  larger;"><td>Register number</td><td>Name</td><td>Photo</td></tr>
    <?php
    foreach ($register_number as $value) { ?>
    <tr> 
    <td><?php echo $value['child_nfc_id']; ?></td>
    <td><?php echo $value['child_name']; ?></td>
    <td><?php echo $value['child_photo']; ?></td>
    </tr> 
   <?php } ?>

        </table>

