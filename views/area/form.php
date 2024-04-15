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
      'id'=>'area-form',
      'enableClientValidation' => true,
      'options' => ['autocomplete' => "off"],
    ]);
    ?>

    <?= $form->field($model, 'label_a')->textInput() ?>

     <?php
		 // $form->field($model, 'dept_id')->dropDownList(\app\models\Dept::getDeptList(), ['prompt' => 'Select Dept', 'style' => 'width:200px']);
     // echo $form->field($model, 'dept_id', [
     // 'template' => '<div>{label}</div> <div style="float:left;margin-right:10px">{input}</div> <div id="addArea"><a class="btn" href="'.Yii::$app->homeUrl.'/departement/create" style="border:1px solid">Add New Department</a></div>  <div class="clear">{error}</div>',
     // ])
     // ->label('Departement')
     // ->dropDownList(\app\models\Dept::getDeptList(), ['prompt' => 'Select Dept', 'style' => 'width:200px']);
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
  $this->registerJs("app.registerAjaxForm($('#area-form')); app.registerBtnBack($('.submit a'))",$this::POS_READY);
}
?>
