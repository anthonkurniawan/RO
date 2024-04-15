<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = "User #$model->uname";
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
      //'id',
      'uname',
      'fullname',
      'email:email',
      [
        'attribute' => 'dept_name',
        'options' => ['width' => '150px']
      ],
      [
        'attribute' => 'role',
        'value' => $model->roleText,
        'options' => ['width' => '140px']
      ],
      'created_at:dateTime',
      'updated_at:dateTime',
      [
        'attribute' => 'last_loged',
        'value' => function ($model) {
          if ($model->last_loged) return \Yii::$app->formatter->asDateTime($model->last_loged);
        },
        'contentOptions' => ['class' => 'date-time'],
      ],
      //'signature',
      //'spv',
      //'status',
      //'priv',
      //'created_at',
      //'updated_at',
      //'auth_key',
      //'password_hash',
      //'access_token',
      //'password_reset_token',
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
</div>

<?php
$this->registerJs("app.registerPageContainer($('.container'));", $this::POS_READY);
if($isAjax){
  $this->registerJs("app.registerBtnBack($('.cancel a'))",$this::POS_READY);
}
?>
