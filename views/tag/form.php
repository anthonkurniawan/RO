<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
app\assets\SelectizeAsset::register($this);

if(!$isAjax){
  $this->title = $title;
  $this->params['breadcrumbs'] = $this->context->breadcrumb;
}
?>

<main style="margin-top:20px">
  <span class="title"><?= $title ?></span>

  <div class="form">
    <?php
    $form = ActiveForm::begin([
      'id'=>'tag-form',
      'enableClientValidation' => true,
      'options' => ['autocomplete' => "off"],
    ]);
    ?>

  <?= $form->field($model, 'tagnum')->textInput(['maxlength' => true]) ?>
  <?= $form->field($model, 'desct')->textInput(['maxlength' => true]) ?>

  <?php
  echo $form->field($model, 'area_id', [
    'options' => ['class' => 'suggest ui-search'],
  ])->dropDownList(\app\models\Area::getList(),[
    'prompt' => ['text' => 'Select Area', 'options' => ['class' => 'prompt', 'selected' => 'selected']],
    'autocomplete'=>'off'
  ]);
  ?>

  <div class="form-group submit">
    <?php if($redirect) echo Html::a('Back', $redirect, ['class' => 'btn border']) ?>
    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
  </div>

  <?php ActiveForm::end(); ?>

  </div>
</main>

<?php
if($isAjax){
	$this->registerJs("app.registerAjaxForm($('#tag-form')); app.registerBtnBack($('.submit a'));",$this::POS_READY);
}
$this->registerJs("var areaSearch = getSelectizeArea($('#tag-area_id'));",\yii\web\View::POS_READY);
?>
