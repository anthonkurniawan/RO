<?php
// $this->registerJsFile('@web/load.js', [$this::POS_HEAD]);
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

  <?php $form = ActiveForm::begin([
    'id' => 'ldap-login',
    'options' => ['autocomplete' => "off"],
  ]); ?>

  <?php
		$option = !$showUsernameInput ? array('options'=>['style'=>'display:none']) : array();
		echo $form->field($model, 'uname', $option)->textInput(['autocomplete'=>"off", 'autofocus' =>'autofocus', 'tabindex'=>'1',"placeholder"=>'Username']);
	?>
  <?php 
	if($showUsernameInput)
		echo $form->field($model, 'pass')->passwordInput(['autocomplete'=>"new-password", 'placeholder'=>'Password', 'tabindex'=>'1']);
	else
		echo $form->field($model, 'pass', [
			"template"=>"{label}\n{input}\n{hint}\n<div class='help-block pull-left'></div><div id='switch-user'>Switch User</div>"
		])->passwordInput(['autocomplete'=>"new-password", 'placeholder'=>'Password', 'tabindex'=>'1']);
	?>
	
  <div class="form-group">
    <?= Html::submitButton('Unlock', ['id' => 'submit_btn', 'class' => 'btn btn-primary btn-block']) ?>
  </div>

  <?php ActiveForm::end(); ?>

<?php
$script = $verbose ? "app.setMsg(data.msg, 'success');" : "";
$this->registerJs("
$('#switch-user').on('click', function(){
	var el = $('.field-ldap-uname');
	if(el.is(':hidden'))
		el.slideDown()
	else el.slideUp();
});

$('#ldap-login').on('beforeSubmit', function (e, xhr, opt, a) {
  window.onbeforeunload = null;
  $.ajax({
		type: 'POST',
		url: $(this).attr('action'),
		data: $(this).serializeArray(),
		success: function(data){
			if(data.success) {
				$('#dialog').modal('hide');
				$('#user-uname').addClass('focus');
				app.ldap_users = data.msg;
				$script
				console.log(data.msg);
			} 
			else app.setMsg(data.msg, 'warning');
		}
	});
  return false; // prevent default form submission
});", \yii\web\View::POS_READY);
?>
