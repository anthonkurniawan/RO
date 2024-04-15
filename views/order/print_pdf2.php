<?php
use yii\helpers\Html;
use yii\helpers\Url;
$format = Yii::$app->formatter;
?>

<!DOCTYPE html>
<html xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<style type="text/css">
body{font-size:80%}
.no{font-size:20px;font-weight:700;}
.sign{border:0;border-bottom:1px solid #0082c8}
.center{text-align:center}
.separator{padding:2px 10px;color:white;font-weight:700;font-size:17px;background:#0082c8;margin-bottom:7px}
div.row{ margin:0; /*border:1px solid*/ }
div.row .col { float:left }
div.row.head { font-weight: 700; }
div.row.end { margin-bottom:10px }
div.row:before, div.row:after{ display: table; content: " ";}
div.row:after{ clear:both }
*:before, *:after {
 -webkit-box-sizing: border-box;
 -moz-box-sizing: border-box;
 box-sizing: border-box;
}
.col.col-2{width:50%}
.col.col-3{width:33%}
.col.col-4{width:25%}
table.log{border-spacing:0px}
.box{border:1px solid #9ebbce;padding:6px 12px;border-radius:5px;}
input[type=checkbox]{vertical-align:top}
</style>
</head>

<body>
<table class="log" style="width:100%">
	<tr>
		<td style="width:37%"><?=Html::img(Url::to('@web/images/logo.jpg', true), ['height'=>25, 'alt'=>'Pfizer Indonesia'])?></td>
		<td style="font-size:20px; font-weight:700;">Request Order</td>
		<td style="font-size:11px;text-align:right;font-weight:bold">
			<?php 
			echo $model->region_name ? "To:&nbsp;".$model->region_name."<br>" : "";
			echo date('F - Y') . " - " . sprintf("%03d",$model->regionTotal); 
			?>
		</td>
	</tr>
</table>

<div class="separator">Request</div>
<div class="row head">
  <div class="col col-3">Request No.</div>
  <div class="col col-3">Request Type</div>
</div>
<div class="row end">
  <div class="col col-3"><?=$model->id?></div>
  <div class="col"> <?=$model->type_name?></div>
</div>

<div class="row head">
  <div class="col">Title Description</div>
</div>
<div class="row end">
	<div style="border:0;border-bottom:1px solid #9ebbce"><?= $model->title ? $model->title : "&nbsp;<br>" ?></div>
</div>

<div class="row head">
  <div class="col col-3">Initiator</div>
  <div class="col col-3">Departement</div>
</div>
<div class="row end">
  <div class="col col-3"><?=$model->initiator_name?></div>
  <div class="col col-3"> <?=$model->initiator_dept?> </div>
</div>

<div class="row head">
  <div class="col col-3">Tag Number</div>
  <div class="col col-3">Machine / Equipment Description</div>
</div>
<div class="row end">
  <div class="col col-3"><?=$model->tag_num?></div>
  <div class="col col-3"><?=$model->item_desc?></div>
</div>

<div class="row head">
  <div class="col col-3">Area/Room</div>
  <div class="col col-3">Request Date and Time</div>
	<div class="col col-3">Propose Complete Date</div>
</div>
<div class="row end">
  <div class="col col-3"><?=$model->area ?></div>
  <div class="col col-3"><?= date('l, d-M-Y, h:i', strtotime($model->create_at)) ?></div>
	<div class="col col-3"><?= $model->target_dt ? date('l, d-M-Y', strtotime($model->target_dt)) : 'None' ?></div>
</div>

<div class="row head">Request Description</div>
<div id="desc" class="row end box">
	<?=$model->detail_desc ? $model->detail_desc : "&nbsp;<br>&nbsp;<br>" ?>
</div>

<div class="row head">
  <div class="col col-3">Assigned To</div>
  <div class="col col-3">Departement</div>
</div>
<div class="row end">
  <div class="col col-3"><?=$model->assignTo_name?></div>
  <div class="col col-3"><?=$model->assignTo_dept?></div>
</div>

<div class="row head">Request priority</div>
<div class="row end"><?=$model->priorityText?></div>

<div class="separator" style="margin-bottom:0">Quality Assessment</div>
<div class="row end">
  <div class="col">
	<?php
	echo "<b>Yes</b>&nbsp;&nbsp;", Html::checkbox(null, $model->quality_ass==2, ['label' => '']);
	if($model->quality_ass==2) echo "&nbsp;MMNR No:&nbsp;", $model->mmnr;
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<b>No</b>&nbsp;&nbsp;", Html::checkbox(null, $model->quality_ass==1, ['label' => '']);
	?>
	</div>
</div>

<div style="page-break-inside:auto;page-break-inside: avoid">
	<div class="separator">EHS Assessment</div>
	<div class="row end">
		<div class="col col-4">
			<div class="row head">EHS Assessment</div>
			<div class="row end"><?=$model->ehs_ass_name?></div>
			<div class="row head">Hazard</div>
			<div class="row end"><?= $model->ehs_hazard ? $model->hazard_name : '' ?></div>
		</div>
		
		<div class="col" style="width:78%">
			<div style="font-weight:700">Consequence of Hazard</div>
			<div id="cons_h" class="box" style="width:90%;"><?= $model->ehs_hazard_risk ? $model->ehs_hazard_risk : "&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>" ?></div>
		</div>
	</div>
</div>

<div style="page-break-inside:auto;page-break-inside: avoid">
	<div class="separator">Completion</div>
	<div class="row head">
		<div class="col col-3">Request Status</div>
		<div class="col col-3">Completion Date</div>
		<div class="col">Hours</div>
	</div>
	<div class="row end">
		<div class="col col-3"><?php //if($model->status) echo $model->statusText ?>&nbsp;</div>
		<div class="col col-3"><?=$model->complete_at?></div>
		<div class="col"><?=$model->complete_hours?></div>
	</div>

	<div class="row head">Sparepart Replacement</div>
	<div class="row end box" style="height:50px;width:96%"></div>
	
	<div class="row head">Comment</div>
	<div class="row end box" style="height:60px;width:96%"></div>
</div>

<div style="page-break-inside:auto;page-break-inside: avoid">
	<div class="separator">Approval</div>
	<div class="sign">
		<div class="row" style="height:80px">
			<div class="col col-3">&nbsp;</div>
			<div class="col col-3">&nbsp;</div>
			<div class="col">&nbsp;</div>
		</div>
		<div class="row head">
			<div class="col col-3 center">Assign Person</div>
			<div class="col col-3 center">Initiator/Area Owner</div>
			<div class="col col-3 center">Engineering Spv.</div>
		</div>
	</div>
</div>

</body>
</html>