<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = 'Registration';
// $this->params['breadcrumbs'][] = $this->title; //echo "<pre>";print_r($model);echo"</pre>";die();
$this->registerCss('main.register{margin-top:-25px} .register .submit{margin-top:20px}');

$disabled = $ldap_enable;
?>

<main class="register">
  <h1><?= Html::encode($this->title) ?></h1>

  <p>Please fill out the following fields to register</p>

  <?php $form = ActiveForm::begin([
    'id' => 'register-form',
    'options' => ['autocomplete' => "off"],
  ]); ?>

	<?= $form->field($model, 'uname', ['enableAjaxValidation'=>1])->textInput(['autocomplete'=>"off", 'autofocus' =>!isset($model->uname), 'tabindex'=>'1',"placeholder"=>'Username']) ?>
  <?= $form->field($model, 'password')->passwordInput(['autocomplete'=>"new-password", 'placeholder'=>'Password', 'tabindex'=>'2']) ?>
	
	<?php
	if($ldap_enable)
		echo Html::button('Verify', ['id' => 'verify', 'class' => 'btn btn-primary btn-block']);
	$show_extra = $model->email ? '' : 'style="display:none"';
	?>
	
	<div id="extra" <?=$show_extra?>>
	<?= $form->field($model, 'fullname')->textInput(['autocomplete'=>"off", 'tabindex'=>'3',"placeholder"=>'Fullname']) ?>
	<?= $form->field($model, 'email', ['enableAjaxValidation'=>1])->textInput(['autocomplete'=>"off", 'tabindex'=>'4',"placeholder"=>'Email']) ?>
	<?= $form->field($model, 'dept_id')->dropDownList(\app\models\Dept::getList(), ['prompt' => 'Select Dept']) ?>
  <?= Html::submitButton('Sign up', ['id' => 'submit_btn', 'class' => 'btn btn-primary btn-block']) ?>
	</div>
	
  <?php ActiveForm::end(); ?>

  <p class="submit text-center">
    <?= Html::a('Already registered? Recovery', ['/site/recover']) ?>
  </p>
</main>

<?php
$this->registerJs("
var ldap_enable = $ldap_enable; console.log('ldap_enable:', ldap_enable);
var extra_el = $('#extra');
if(ldap_enable && !'$model->email'){
	extra_el.hide().find('input, select').attr('disabled', true);
} else {
	$('#verify').hide();
	extra_el.show().find('input, select').attr('disabled', false);
}

var dept_list = [];
var form = $('#register-form');
$('#registerform-dept_id').children().each(function(i, el){ 
	dept_list.push(el.text.toLowerCase());
});

$('#verify').on('click', function(ev){
	if(app.notif) app.notif.close();
	var url = app.rewrite_on ? './register-find-user' : './index.php?r=site/register-find-user'
	$.post(url,
		form.serializeArray(), function(data){
    console.log('DATA', data);
		if(data.success){
			$(ev.target).hide();
			extra_el.slideDown().find('input, select').attr('disabled', false);
			var uname = $('#registerform-uname').val();
			var user = data.msg[uname];
			if(!user) user = data.msg[uname.toLowerCase()];
			if(user){
				$('#registerform-password').attr('readonly',true);
				$('#registerform-uname').attr('readonly',true).off('blur').val(user.uname);
				$('#registerform-fullname').val(user.fname + ' ' + user.lname);
				$('#registerform-email').val(user.email);
				if(user.dept)
					app.setDept(user.dept.toLowerCase(), $('#registerform-dept_id'));
			}
		}
		else app.setMsg(data.msg, 'warning');
  }, 'json');
});

form.on('ajaxBeforeSend', function (e, xhr, settings) {
  if(app.notif) app.notif.close();
	$('#register-form button').attr('disabled', true);
  return false;
})
.on('ajaxComplete', function (e, xhr, status) {
	$('#register-form button').attr('disabled', false);
});
",\yii\web\View::POS_END);
?>