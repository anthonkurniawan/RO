<?php
// $this->registerJsFile('@web/load.js', [$this::POS_HEAD]);
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Login';
?>

<main class="login">
  <h1><?= Html::encode($this->title) ?></h1>

  <p>Please fill out the following fields to login</p>

  <?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'validateOnBlur' => false,
    'validateOnChange' => false,
    'options' => ['autocomplete' => "off"],
  ]); ?>

  <?= $form->field($model, 'uname')->textInput(['autocomplete'=>"off", 'autofocus' =>'autofocus', 'tabindex'=>'1',"placeholder"=>'Username']) ?>
  <?= $form->field($model, 'password')->passwordInput(['autocomplete'=>"new-password", 'placeholder'=>'Password', 'tabindex'=>'2']) ?>

  <?php
	if(Yii::$app->user->enableAutoLogin)
		echo $form->field($model, 'rememberMe')->checkbox([
		 'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
		]);
  ?>

  <div class="form-group">
      <?= Html::submitButton('Login', ['id' => 'submit_btn', 'class' => 'btn btn-primary btn-block']) ?>
  </div>

  <?php ActiveForm::end(); ?>

  <p class="submit">
    You should login with <strong>Computer login</strong><br>
    <?php
			if(Yii::$app->params['allow_self_register'])
				echo "Please ". Html::a('register', ['/site/register']) . " if you dont't have account already.";
		?>
  </p>
</main>

<?php
$this->registerJs("
$('#login-form')
	.on('ajaxBeforeSend', function (e, xhr, settings) { console.log('LOGIN:ajaxBeforeSend', settings, settings.timeout);
    e.preventDefault();
		// e.stopPropagation();
		if(app.notif) app.notif.close();
		$('#submit_btn').attr('disabled', true);
    $(this).yiiActiveForm('updateAttribute', 'loginform-uname', '');
    $(this).yiiActiveForm('updateAttribute', 'loginform-password', '');
	})
	.on('ajaxComplete', function (e, xhr, status) {
		// console.log('SUBMITTING', $('#login-form').yiiActiveForm('data').submitting);
		console.log('LOGIN:ajaxComplete XHR:', xhr, 'STATUS:', status, ' responseJSON:', xhr.responseJSON, xhr.responseJSON);
		if(xhr.responseText || (xhr.responseJSON && !xhr.responseJSON.success))
			$('#submit_btn').attr('disabled', false);
	});", \yii\web\View::POS_READY);
?>
