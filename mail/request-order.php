
<div class="main">
  <div class="wrap">

  <div class="header">
    <span>PT. Pfizer Indonesia (factory)</span><br>
    <small style="color:#595656">Jl. Raya Bogor Km. 28, Pasar Rebo,Jakarta Timur 13710, Indonesia</small>
  </div>

  <div class="section">
    Dear <?=$mail_name?>,
		
		<?php 
		if(isset($note)) echo "<p>$note</p>"; 
		else echo "<p>Permohonan request order:</p>";
		?>
		
    <table>
      <tr> <th width="150">Request Number</th> <td><?=$no?></td> </tr>
      <tr> <th>Date</th> <td><?=$date?></td> </tr>
			<?php if($status==2) echo "<tr> <th>Initiator</th> <td>$initiator</td> </tr>"; ?>
      <tr> <th colspan="2">Descriptions</th> </tr>
      <tr> <td colspan="2"><?=$desc?></td> </tr>
    </table>
		<?php
		if($status == 1){
			echo '<p><b>Your request has been rejected.</b></p>';
		}else if($status == 2){
			echo '<p>Thanks And Regards.</p>';
		}else if($status == 3){
			echo '<p><b>Your request has been accepted.</b></p>';
		}else if($status == 4){
			echo '<p><b>Your request has been complete.</b></p>';
		}
		?>
    <p class="link2">Please follow this link for detail. <?=$link?> </p>
  </div>

  <div class="footer">
    This email is generated automatically, Please do not send a reply to this email.
  </div>

  </div>
</div>
