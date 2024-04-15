<?php
$this->title = 'Recovery';
?>
			
<div class="jumbotron" style="font-size:16px;margin-top:10%">
	<p style="font-size:25px">Recovery Successfully</p> 
	Confirmation email already sent to <?=$email?>.
	<br>Please check your email to verify your account
	
	<br>Or if you can't find the email click this link to 
	<?=\yii\helpers\Html::a('Resend Email', ['site/resend-mail', 'uname'=>$uname, 'email'=>$email, 'token'=>$token, 'recovery'], ['style'=>'text-decoration:underline;font-weight:bold'])?>
</div>