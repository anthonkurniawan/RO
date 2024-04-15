<?php
use yii\helpers\Html;
use yii\helpers\Url;
$format = Yii::$app->formatter;
?>

<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
<head>
<meta charset="<?=Yii::$app->charset?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style type="text/css">
div.box{ margin-bottom:10px; /*border:1px solid*/}
div.row{ margin:0; /*border:1px solid*/ }
div.row .col { float:left }
div.row.head { font-weight: 700; }
div.row.end { margin-bottom:10px }
.no {
  width: 100px;
  text-align: center;
  font-size: 20px;
  padding: 10px 0px;
}

*:before, *:after {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

div.box:before, div.box:after, div.row:before, div.row:after{ display: table; content: " ";}
div.box:before, div.box:after, div.row:after{ clear:both }
div.header .col{ display:table-cell }

table.log{font-family:Arial;border-spacing:0px;border:1px solid}
table.log th{
	font-weight:bold;font-size:11px;
	background-Color:#D4D0C8;
	padding:3px 5px 3px 5px ;
	white-space:nowrap;
	width:24.8%;
}
table.log th:not(:first-child), table.log td:not(:first-child){ border-left:1px solid black}
table.log td{ border-top:1px solid black}
</style>
</head>

<body>
<table class="log" style="width:100%">
  <tr>
    <td style="width:37%"><?=Html::img(Url::to('@web/images/logo.jpg', true), ['height'=>40, 'alt'=>'Pfizer Indonesia'])?></td>
    <td style="font-size:30px; font-weight:700;">Request Order</td>
  </tr>
</table>

<div class="box">
  <div class="row head">
    <div class="col" style="width:200px">Request No.</div>
    <div class="col" style="">Request Type</div>
  </div>
  <div class="row">
    <div class="col" style="width:200px"><strong><?=sprintf("%02d", $model->id)?></strong></div>
    <div class="col" style=""> <?=$model->type_name?></div>
		<div class="col" style=""> <?=Html::input('text', null, $model->type_name)?></div>
  </div>
</div>

<div class="box">
  <div class="row head">
    <div class="col" style="width:200px">&nbsp;</div>
    <div class="col" style="">Title Description</div>
  </div>
  <div class="row">
    <div class="col" style="width:200px">&nbsp;</div>
    <div class="col" style=""> <?=$model->title?></div>
  </div>
</div>

<div class="box">
  <div class="row head">
    <div class="col" style="width:200px">Initiator</div>
    <div class="col" style="">Departement</div>
  </div>
  <div class="row end">
    <div class="col" style="width:200px"><?=$model->initiator->fullname?></div>
    <div class="col" style=""> <?=$model->dept->label ?> </div>
  </div>

  <div class="row head">
    <div class="col" style="width:200px">Tag Number</div>
    <div class="col" style="">Machine / Equipment Description</div>
  </div>
  <div class="row end">
    <div class="col" style="width:200px"><?=$model->tag_num?></div>
    <div class="col" style=""><?=$model->item_desc?></div>
  </div>

  <div class="row head">
    <div class="col" style="width:200px">Area/Room</div>
    <div class="col" style="">Request Date and Time</div>
  </div>
  <div class="row end">
    <div class="col" style="width:200px"><?=$model->area ?></div>
    <div class="col" style=""><?=$format->asDateTime($model->create_at)?></div>
  </div>

  <div class="row head">Request Description</div>
  <div class="row end" style="height:100px"><?=$model->detail_desc ?></div>

  <div class="row head">
    <div class="col" style="width:200px">Assigned To</div>
    <div class="col" style="">Departement</div>
  </div>
  <div class="row end">
    <div class="col" style="width:200px"><?=$model->assignTo_name?></div>
    <div class="col" style=""><?=$model->assignTo_dept?></div>
  </div>
  <div class="row head">Request priority</div>
  <div class="row end"><?=$model->priorityText?></div>

	<div class="row head" style="background:#007fc7">Quality Assessment</div>
	<div class="row end">
    <div class="col" style=""><?=Html::checkboxList(null, $model->quality_ass, ['Yes', 'No'])?></div>
  </div>
	
  <div class="row head" style="background:#007fc7">EHS Assessment</div>
  <div class="row head">
    <div class="col" style="width:200px">EHS Assessment</div>
    <div class="col" style="">Consequence of Hazard</div>
  </div>
  <div class="row end">
    <div class="col" style="width:200px"><?=$model->ehs_ass_name?></div>
    <div class="col" style=""><?= $model->ehs_hazard_risk ? $model->ehs_hazard_risk : 'N/A'?></div>
  </div>
  <div class="row head">Hazard</div>
  <div class="row end"><?= $model->ehs_hazard ? $model->ehs_hazard : 'N/A'?></div>

  <div class="row head" style="background:#007fc7">Completion</div>
  <div class="row head">
    <div class="col" style="width:33%">Request Status</div>
    <div class="col" style="width:33%">Completion Date</div>
		<div class="col" style="">Hours</div>
  </div>
  <div class="row end">
    <div class="col" style="width:33%"><?php if($model->status) echo $model->statusText ?></div>
    <div class="col" style="width:33%"><?=$model->complete_at?></div>
		<div class="col" style=""><?=$model->complete_hours?></div>
  </div>
  <div class="row head">Sparepart Replacement</div>
  <div class="row end"><?=$format->asText($model->replacement)?></div>
  <div class="row head">Comment </div>
  <div class="row end" style="height:100px"><?=$format->asText($model->lastCommentText)?></div>

  <div class="row head" style="background:#007fc7">Approval</div>
  <table width="100%" class="log">
			<tr style="height:80px">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<th>Assign Person</th>
				<th>Initiator/Area Owner</th>
				<th>Engineering Planner</th>
			</tr>
			<!--<tr style="height:85px">
				<td class="sign">&nbsp;</td>
				<td class="sign">&nbsp;</td>
				<td class="sign">&nbsp;</td>
				<td class="sign">&nbsp;</td>
			</tr>-->
		</table>
</div>
</body>
</html>