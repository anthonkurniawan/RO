<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
      'id'=>'dept-form',
      'enableClientValidation' => true,
      'options' => ['autocomplete' => "off"],
    ]);
    ?>

    <?= $form->field($model, 'label')->textInput() ?>

    <div class="form-group submit">
      <?php if($redirect) echo Html::a('Back', $redirect, ['class' => 'btn border']) ?>
      <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

  </div>
</main>

<?php
if($isAjax){
	$this->registerJs("app.registerAjaxForm($('#dept-form')); app.registerBtnBack($('.submit a'));",$this::POS_READY);
}
?>

