<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="refresh" content="5;URL='http://host.ls-dunamis.com/~safety/supervisor/'" />   
<title>Bus App - Supervisor</title>
</head>

<body>

    
    
    <?php for($i=0 ;$i<count($bus_list);$i++) { 
        
        if($i%2==0){
        ?>
    <font size="1pt" color="#FFFFFF" face="Arial">&nbsp;</font>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
      
    <?php  } ?>
      <td width="49%" <?php if($bus_list[$i]['trip_pickedup']==$bus_list[$i]['trip_total_no'] && $bus_list[$i]['trip_total_no']!=0) { ?>bgcolor="#2e8a47" <?php } else { ?>
          
bgcolor="#c20f22" <?php } ?>
          
          accesskey="">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td >
              
              <font size="1pt" color="#FFFFFF" face="Arial">&nbsp;</font>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" >
              <tr>
                <td width="40%" align="center" ><font size="20pt" color="#FFFFFF" face="Arial"><?php echo $bus_list[$i]['bus_name'];?></font></td>
                <td> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center"><font size="2pt" color="#FFFFFF" face="Arial"><?php echo $bus_list[$i]['trip_name'];?></font></td>
                  </tr>
                  <tr>
                    <td align="right"><font size="6pt" color="#FFFFFF" face="Arial"><?php echo $bus_list[$i]['trip_pickedup'];?>/<?php echo $bus_list[$i]['trip_total_no'];?></font>&nbsp;</td>
                  </tr>
                </table>
                </td>
              </tr>
            </table>
            </td>
        </tr>
        <tr>
          <td align="center" bgcolor="#ff5e10"><font size="3pt" color="#FFFFFF" face="Arial"><?php echo $bus_list[$i]['distance'];?> km (approximately) from school</font>&nbsp;</td>
          
        </tr>
      </table>
      <font size="1pt" color="#FFFFFF" face="Arial">&nbsp;</font>
</td>
 
<?php   if(($i%2!=0 && $i!=0)) {
    
    ?>
  </tr>
</table>

  <?php  } else if (($i==count($bus_list)) && ($i%2==0) || count($bus_list)==1){ ?>
    
     <td width="1%">&nbsp;</td> 
<td width="49%" bgcolor="#FFFFFF"></td>
    </tr>
</table>
    <?php    
  }
  else { ?>
    
    <td width="1%">&nbsp;</td>
   
      <?php } ?>
    
     <?php } ?>
    
   
    
    
   
</body>
</html>
