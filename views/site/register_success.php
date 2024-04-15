<?php
$this->title = 'Registration';
?>
			
<div class="jumbotron" style="font-size:16px;margin-top:10%">
	<p style="font-size:25px">Registration Successfully</p> 
	Your account has been created.
	<br>Please check your email to verify your account
	
	<br>Or if you can't find the email click this link to 
	<?=\yii\helpers\Html::a('Resend Email', ['site/resend-mail', 'email'=>$email, 'token'=>$token], ['style'=>'text-decoration:underline;font-weight:bold'])?>
</div>