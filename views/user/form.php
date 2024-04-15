<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCss("input{max-width:700px");

if(!$isAjax){
  $this->title = $title;
  $this->params['breadcrumbs'] = $this->context->breadcrumb;
}
?>

<main>
  <span class="title"><?= $title ?></span>

  <div class="form">
    <?php
    $form = ActiveForm::begin([
      'id'=>'user-form',
      'enableClientValidation' => true,
      'options' => ['autocomplete' => "off"],
    ]);
    ?>

    <?= $form->field($model, 'uname')->textInput(['autofocus'=>'1']) ?>
		<?= $form->field($model, 'fullname')->textInput() ?>
		<?= $form->field($model, 'email')->textInput(['autocomplete'=>"off","placeholder"=>'Email']) ?>
    <?= $form->field($model, 'dept_id')->dropDownList(\app\models\Dept::getList(), ['prompt' => 'Select Dept', 'style' => 'width:200px']); ?>
    <?= $form->field($model, 'role')->dropDownList($model->getRoleList(), ['style' => 'width:200px']) ?>
    <?php
      if(!$model->isNewRecord)
        echo $form->field($model, 'status')->dropDownList($model->getStatusList(), ['style'=>'width:200px']);
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
	$this->registerJs("app.registerAjaxForm($('#user-form')); app.registerBtnBack($('.submit a'));",$this::POS_READY);
}

$this->registerJs("
app.registerPageContainer($('.container'));

var dept_list = [];
$('#user-dept_id').children().each(function(i, el){ 
	dept_list.push(el.text.toLowerCase());
});

if($ldap_enable){
	if(!Object.keys(app.ldap_users).length) {
		var url = app.rewrite_on ? './site/get-ldap-user' : './index.php?r=site/get-ldap-user'
		$('#dialog-content').load(url, function(rs, status, xhr){
			$('#dialog').modal('show'); 
		});
	}

	$('#user-uname').change(function(e){
		var user = this.value;
		if(app.ldap_users.hasOwnProperty(user)) {
			var data = app.ldap_users[user];
			$('#user-fullname').val(data.fname + ' ' + data.lname);  // data.fname
			$('#user-email').val(data.email);
			app.setDept(data.dept.toLowerCase(), $('#user-dept_id'));
		} else {
			$('#user-fullname').val('');
			$('#user-email').val('');
			$('#user-dept_id').val('');
		}
	});
}
", \yii\web\View::POS_END);
?>
