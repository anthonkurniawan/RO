<?php
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = "Request Order";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'order'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

Pjax::begin([
  'id' => 'pjax-con',
  'timeout' => 0,
  'enablePushState' => false,
  'options' => ['class' => 'animate__animated animate__fadeIn']
]);
$this->registerCss('select#order-region_id option{ font-size:20px} .search-order{display:none} #back{display:block}');
?>

<div class="region_assigned ">
  <span style="font-size:28px"><?= $this->title ?></span>
</div>

<div class="form order">
  <div class="input-group" style="margin-top:10px">
  <?php
  echo Html::dropDownList('region', null,
    \app\models\Region::getList(),
    [
      'prompt'=>[
        'text'=>'Regional Department Assignment',
        'options'=> ['value'=>'none', 'class'=>'prompt',
        'disabled'=>'disabled', 'selected'=>'selected'
        ]
      ],
      'id' => 'order-region_id',
      'class'=>'form-control',
    ]
  );
  echo Html::a('Go', ['order/create'], ['id' => 'region-link', 'class'=>'input-group-addon disabled']);
  ?>
  </div>
</div>

<?php 
if($isAjax){
  echo "<div class='cancel' style='margin-top:20px'>";
  if ($redirect) echo Html::a('Back', $redirect, ['class' => 'btn border']);
  echo "</div>";
	$this->registerJs("app.registerBtnBack($('.cancel a'))",$this::POS_READY);
} 
$this->registerJs("regionSelectHandler(); $('#search-ico').hide();", \yii\web\View::POS_READY);

Pjax::end();
?>
