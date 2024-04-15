<?php
use yii\helpers\Html;
use \app\models\Priority;
?>


<div class="separator"># <?= $model['id'] ?></div>
<div class="form-group col-sm-2">
  <label>Initiator</label>
  <div><?=$model['initiator_name']?></div>
</div>
<div class="form-group col-sm-2">
  <label>Departement</label>
  <div><?=$model['initiator_dept']?></div>
</div>
<div class="form-group col-sm-2">
  <label>Created</label>
  <div><?=$model['create_at'] ?></div>
</div>
<div class="form-group col-sm-2">
  <label>Assigned To</label>
  <div><?=$model['assignTo_name']?></div>
</div>
<div class="form-group col-sm-2">
  <label>Priority</label>
  <div><?=$model->priorityText?></div>
</div>
<div class="form-group col-sm-2">
  <label>Status</label>
  <div><?=$model['statusText']?></div>
</div>
<div class="form-group col-sm-2">
  <label>Title</label>
  <div class="text"><?=sub_str($model['title'],22)?></div>
</div>
<div class="form-group col-sm-10">
  <label>Request Descriptions</label>
  <div class="text"><?=sub_str($model['detail_desc'],285)?></div>
</div>
