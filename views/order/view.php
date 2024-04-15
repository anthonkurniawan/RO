<?php
use yii\helpers\Html;

$this->title = "Order #$model->id";
$this->params['breadcrumbs'] = $this->context->breadcrumb;
$this->registerCss('.wrap > .container{padding-right:100px} .form-group div{min-height:18px} .printPdf{display:block}
@media(max-width: 700px){.printPdf{top:230px!important;}} .chkbox{margin-right:20px;padding:5px} .form-group div.comment-box{border:1px solid #c9c9d7;padding:3px 5px;min-height:100px;border-radius:5px;}');

if($model->status == $model::STATUS_ONPROGRESS && ($model->isAssigned || Yii::$app->user->identity->isAdmin))
	echo Html::a(null, ['order/print'], ['id'=>'order_btn', 'class'=>'printPdf', 'data-pjax'=>"0", 'title'=>'Print To PDF']);
?>

<div class="order">
  <div class="region_assigned clearfix">
    <span class="title pull-left">Request Order</span>
    <div class="link<?=$model->isNewRecord ? ' clickable" title="Change Region"':''?>">
      <p>To:&nbsp;<?= $model->region_name ?></p>
      <p><?php echo date('F - Y') . " - " . sprintf("%03d",$model->regionTotal) ?></p>
    </div>
  </div>
	<!--------------------------------------------------------->
	<?=$this->render('_view', ['model'=>$model, 'print'=>0])?>
	<!--------------------------------------------------------->
	<div class="form-group col-sm-12 submit">
    <?php if($redirect) echo Html::a('Back', $redirect, ['class'=>'btn border']) ?>
  </div>
</div>

<?php
$script = "app.registerPageOrder('$model->id'); app.registerBtnScroll(); app.registerBtnBack($('.submit a'));";
if(!$model->isNewRecord){
$script .= "reg_comment_view(); app.registerBtnScroll();";
}
$this->registerJs($script, $this::POS_READY);
?>
