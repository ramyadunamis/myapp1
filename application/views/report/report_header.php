<table> <a href="<?php echo site_url('report/index/?date='.$this->input->get('date')).'&bus='.$this->input->get('bus').'&trip='.$this->input->get('trip').'&radio='.$this->input->get('radio') ?>">Back</a>
            &nbsp;&nbsp;
            
            <a href="<?php echo site_url('report/pdf/?date='.$this->input->get('date')).'&bus='.$this->input->get('bus').'&trip='.$this->input->get('trip').'&radio='.$this->input->get('radio'); ?>">Save as Pdf</a>

            
            <tr> <td> <font size="4pt" face="Arial"> <b>TRANSPORT REPORT &nbsp;</b></font></td></tr>
            <tr>  <td>Date:<?php echo date(  "j F Y (l)", strtotime( $this->input->get('date') ) );?>

                </td> <td></td></tr></table>