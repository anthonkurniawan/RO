<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'CHECK LDAP';
?>

<main class="clearfix">
	<?= Html::a('Test login LDAP', ['site/login_ldap','verbose'=>1], ['class'=>'pull-right', 'target'=>'_blank'])?>
  <h1><?= Html::encode($this->title) ?></h1>
	
	<div class="pull-left" style="widthd:45%">
  <?php $form = ActiveForm::begin([
	'options' => ['autocomplete' => "off"],
		'layout' => 'horizontal',
		'fieldConfig' => [
      'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
      'horizontalCssClasses' => [
          'label' => 'col-sm-2',
          'offset' => 'col-sm-offset-8',
          'wrapper' => 'col-sm-10',
      ],
    ],
  ]); ?>
	<?= $form->field($model, 'dns')->textInput(['autofocus' =>'autofocus', 'tabindex'=>'1']) ?>
	<?= $form->field($model, 'uname')->textInput(['autofocus' =>'autofocus', 'tabindex'=>'2']) ?>
  <?= $form->field($model, 'pass')->passwordInput(['autocomplete'=>"new-password", 'tabindex'=>'3']) ?>
	<?= $form->field($model, 'search')->textInput(['tabindex'=>'4']) ?>
	<?= $form->field($model, 'filter')->textInput(['tabindex'=>'5']) ?>
	<?= $form->field($model, 'filter_opt')->dropDownList($model::getList(),['id'=>'filter_opt', 'class'=>'form-control'])?>
	
  <?= Html::submitButton('Check', ['id' => 'submit_btn', 'class' => 'btn btn-primary btn-block']) ?>
  <?php ActiveForm::end(); ?>
	</div>

	<div class="pull-right" style="max-width:600px;overflow:scroll">
		<b>LDAP ATTR:</b><br>
		<?php \yii\helpers\VarDumper::dump($model->attributes, 10, true); ?>
		<br>Errors:
		<?php \yii\helpers\VarDumper::dump($model->errors, 10, true); ?>
	</div>
</main>

<?php 
if($model->uname && !$model->hasErrors()){
?>
<div class="pull-left box-bdr" style="width:48%;min-height:200px;max-height:500px;margin-top:10px">
	<b><?= $model->search ? "" : "ALL USER SEARCH..<br>" ?></b>
	<b>Data Formated</b>
	<?php \yii\helpers\VarDumper::dump($data_format, 10, true); ?>
</div>

<div class="pull-left box-bdr" style="width:50%;min-height:200px;max-height:600px;margin:10px 10px">
	<b>Data</b>
	<?php \yii\helpers\VarDumper::dump($data, 10, true); ?>
</div>
<?php } 
elseif($model->uname){
	\yii\helpers\VarDumper::dump($this->context, 10, 1);
	$status = $this->context->testLdap($model);
}

$this->registerJs("
$('.container').addClass('full');
$('#filter_opt').change(function(){
	$('#ldap_tool-filter').val(this.options[this.selectedIndex].text);
});
",\yii\web\View::POS_READY);
?>