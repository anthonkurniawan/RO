<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = "Region #$model->nama";
if(!$isAjax){
  $this->params['breadcrumbs'] = $this->context->breadcrumb;
}
?>

<span class="title"><?= $this->title ?></span>

<div class="data">
  <?= DetailView::widget([
    'model' => $model,
    'options' => ['class' => 'table list-view'],
      'attributes' => [
        'id',
        'dept_id',
        'nama',
      ],
  ]) ?>
</div>

<div class="clearfix control-view">
  <div class="cancel">
    <?php if ($redirect) echo Html::a('Back', $redirect, ['class' => 'btn border']); ?>
  </div>

  <div class="pull-right">
    <?php
      echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary', 'style'=>'margin-right:5px']);
      if($isAjax){
        echo Html::a("Delete", ['delete', 'id' => $model->id], ['class' => 'btn btn-danger','data-pjax'=>'0','onclick'=>"app.hapus(this);"]);
      }else{
        echo Html::a('Delete', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger',
        'data' => ['confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),'method' => 'post'],
        ]);
      }
    ?>
</div>

<?php
if($isAjax){
  $this->registerJs("app.registerBtnBack($('.cancel a'))",$this::POS_READY);
}
?>