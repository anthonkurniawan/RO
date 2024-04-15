<?php
use yii\helpers\Html;
$format = Yii::$app->formatter; 
?>
<style>.search-order{display:none}</style>
	
<div class="separator">Request</div>
<div class="form-group col-sm-3">
  <label>Request No.</label>
  <div><strong><?=$model->id?></strong></div>
</div>
<div class="form-group col-sm-9">
  <label>Request Type</label>
  <div><?= $model->type_name ?></div>
</div>
<div class="form-group col-sm-12">
  <label>Title Description</label>
  <div style="min-height:30px;border:0;border-bottom:1px solid #9ebbce"><?= $model->title ?></div>
</div>
<div class="form-group col-sm-4">
  <label>Initiator</label>
  <div><?= $model->initiator_name ?></div>
</div>

<div class="form-group col-sm-8">
  <label>Departement</label>
  <div><?= $model->initiator_dept ?></div>
</div>

<div class="form-group col-sm-4">
  <label>Tag Number</label>
  <div><?= $model->tag_num ?></div>
</div>

<div class="form-group col-sm-8">
  <label>Equipment / Machine Descripton</label>
  <div><?= $model->item_desc ?></div>
</div>

<div class="form-group col-sm-4">
  <label>Area / Room</label>
  <div><?= $model->area ?></div>
</div>

<div class="form-group col-sm-4">
  <label>Request Date and Time</label>
  <div><?= date('l, d-M-Y, h:i', strtotime($model->create_at)) ?></div>
</div><div class="form-group col-sm-4">
  <label>Propose Complete Date</label>
  <div><?= $model->target_dt ? date('l, d-M-Y', strtotime($model->target_dt)) : ' None'?></div>
</div>

<div class="form-group col-sm-12">
  <label>Request Description</label>
  <div id="desc" class="box" style="min-height:80px">		<?= $model->detail_desc ?>	</div>
</div>

<div class="form-group col-sm-6">
  <label>Assigned To</label>
  <div><?= $model->assignTo_name ?></div>
</div>

<div class="form-group col-sm-6">
  <label>Departement</label>
  <div><?= $model->assignTo_dept ?></div>
</div>

<div class="form-group col-sm-12">
  <label>Request Priority</label>
  <div><?= $model->priorityText ?></div>
</div>
<!-- HEADER OF ASSESTMENT --->
<div class="separator">Quality Assestment</div><div class="form-group col-sm-12">	<div>	<?php 	if($print){		echo $model->quality_ass==1 ? "No" : "Yes", "&nbsp;&nbsp;",			Html::checkbox(null, true, ['label' => '']);		if($model->quality_ass==2)			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>MMNR No:&nbsp;</b>", $model->mmnr;	}else {		echo "<b>", 			$model->quality_ass==1 ? "No" : "Yes", 			"<span class='chkbox'><i class='glyphicon glyphicon-ok'></i></span></b>";		if($model->quality_ass==2)			echo "<b>MMNR No:&nbsp;</b>", $model->mmnr;	}	?>	</div></div>

<div class="separator">EHS Assestment</div>
<div class="form-group col-sm-2" id="hz">
  <div class="form-group">
    <label>EHS Assestment</label>
    <div><?= $model->ehs_ass_name ?></div>
  </div>
  <div class="form-group">
    <label>Hazard</label>
    <div id="hz_txt"><?= $model->ehs_hazard ? $model->hazard_name : 'N/A'?></div>
  </div>
</div>

<div class="form-group col-sm-10" id="con_hz">
  <label>Consequence of Hazard</label>
  <div id="con_hz_txt" class="box" style="min-height:80px">	<?= $model->ehs_hazard_risk ? $model->ehs_hazard_risk : 'N/A'?>	</div>
</div>

<!-- DI ISI OLEH assign_to -->
<div class="separator">Completion</div>
<div class="form-group col-sm-4">
  <label>Request Status</label>
  <div><?php if($model->status) echo $model->statusText ?></div>
</div>

<div class="form-group col-sm-4">
  <label>Completion Date</label>
  <div><?= $model->complete_at ?></div>
</div>

<div class="form-group col-sm-4">
  <label>Hours</label>
  <div><?= $model->complete_hours ?></div>
</div>

<div class="form-group col-sm-12">
  <label>Spare Part Replacement</label>
  <div id="repl" class="box" style="min-height:80px">	<?=$model->replacement ?>	</div>
</div>
	
<?php
if(!$print && $model->attachment)
	echo "<div class='form-group col-sm-12'><label>Attachement</label><div>"
	.Html::a($model->attachment." <i class='glyphicon glyphicon-download'></i>", '@web/uploads/'.$model->attachment, ['class'=>'link','download'=>true, 'data-pjax'=>'0'])."</div></div>";
?>

<?php if(!$print) echo $model->renderComments('view',$print); ?>