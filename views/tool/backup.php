<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$enable=0;
$this->title = 'Backup';
$this->params['breadcrumbs'][] = $this->title;
// $this->registerCss('.wrap > .container{padding:0}');
?>

<span class="title"><?= $this->title ?></span>

<div class="data" style="padding-top:10px;margin-bottom:15px">
	<p>
	<b>Location</b>&nbsp;
	<?=preg_replace("/\\\\\\\/", "\\", $backup_loc)?><br>
	<b>Last backup</b>&nbsp;
	<?=$data[0]['physical_device_name']?>
	</p>
	<button id="submit" class="btn btn-sm btn-primary" onclick="backup()">Backup Now</button>
</div>

<?php if($enable){ ?>
<span class="title" style="font-size:20px">Backup History</span>
<div class="data" style="padding-top:10px">
<?php if(count($data)){ ?>
	<table class="log">
		<tr>
		<th>Time</th>
		<th>Type</th>
		<th>File</th>
		<th>Size</th>
		<th>Duration</th>
		<th style="border-rightX:0">Recovery Model</th></tr>
		<!-- <th>End-time</th> -->
		<!-- <th>Size MB</th> -->
		<!-- <th>File Backup</th> -->
		<!-- <th>Database</th><th>Server</th>-->
		<!-- <th>User</th> -->
<?php foreach($data as $bak){ ?>
		<tr>
			<td><?=$bak['tgl']?></td>
			<td><?=$bak['BackupType']?></td>
			<td><?=$bak['physical_device_name']?></td>
			<?php
			if($bak['backup_size'] < 1000000)
				echo "<td class='dbsize'>$bak[backup_size] B</td>";
			else
				echo "<td class='dbsize'>$bak[bkSize]</td>";
			?>
			<td><?=$bak['TimeTaken']?></td>
			<td style="text-align:center"><?=$bak['recovery_model']?></td>
		</tr>
<?php } ?>
	</table>
<?php }else{ ?>
	<div>
		<i>don't have any backup</i>
	</div>
<?php 
} }

$this->registerJs("
function backup(){
	if(app.notif) app.notif.close();
	var url = app.rewrite_on ? './backup' : './index.php?r=tool/backup'
	$.post(url,{'do-backup':1}, function(data){
    console.log('DATA', data);
		if(data.success){
			app.setMsg(data.msg, 'info');
			setTimeout(function(){ window.location.reload(); }, 1000);
		}
		else app.setMsg(data.msg, 'warning');
  }, 'json');
}
",$this::POS_END);
?>
</div>