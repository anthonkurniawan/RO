<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Account Recovery';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'password-recovery-form',
                    // 'enableAjaxValidation' => 0,
                    // 'enableClientValidation' => false,
                ]); ?>
                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                <?= Html::submitButton('Continue', ['class' => 'btn btn-primary btn-block']) ?><br>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
