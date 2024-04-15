<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use app\assets\SelectizeAsset;

$selectize = SelectizeAsset::register($this);

$this->title = 'Request Order';
// $this->params['breadcrumbs'] = $this->context->breadcrumb;
?>

<style>
.selectize-dropdown-content label {margin:0}
.selectize-dropdown-content .form-group {margin-bottom:4px}
.selectize-dropdown .active {background-color:#e7f7f9}
.selectize-dropdown .list {padding:3px 0; border-bottom:1px solid #89ccdb}
.selectize-dropdown-content {max-height: -moz-fit-content; max-height:fit-content}
.wrap > .container {padding-right:100px}
#order_btn{display:block}
#pjax-con{margin-top:20px}
.summary{margin-bottom:2px;color:#7a7171}
</style>

<?=Html::input('text', 'search', null, ['id'=>'search', 'class'=>'pull-left2 search-order suggest ui-search', 'autocomplete'=>'off', 'autofill'=>"no", 'title'=>'Search','style'=>'display:none'])?>
<i id="search-ico" class="glyphicon" title='Hide search'></i>

<?php
Pjax::begin([
  'id'=>'pjax-con',
  'linkSelector'=>'#pjax-con a',
  'timeout'=>0,
  'enablePushState'=>false,
  'enableReplaceState'=>false,
  'options'=>['class'=>'animate__animated animate__fadeIn']
]);
	
// $this->registerCss("div.container{ width: 100%}");
function sub_str($str, $max){
	$len = strlen($str);
	if($len > $max)
		return substr($str,0, $max) ." ..";
	return $str;
}
?>

<?= Html::a(null, ['order/create'], ['id'=>'order_btn', 'class'=>'createOrder', 'TITLE'=>'Request New Order']) ?>

<?php 
echo ListView::widget([
  'id'=>'listview',
  'dataProvider'=>$dataProvider,
  'emptyText'=>'No records order to show',
  'itemOptions'=>function ($model, $key, $index, $widget){
		if($model->canEdit || $model->canAttach){
			$action = 'update';
			$class = $model->statusText;
			if($class=='In-Progress') $class = 'inprogress';
		}else{
			$action = 'view';
			$class = '';
		}
    $url = \yii\helpers\Url::to(["order/$action", "id"=>$model['id']], true);
    return ['class'=>"list order $class clearfix", 'data-url'=>$url];
  },
  // 'itemView'=>function ($model, $key, $index, $widget) {
		// return Html::a(Html::encode($model->title), ['view', 'id'=>$model->id]);
  // },
  'itemView'=>'_order',
  'layout'=>"{summary}\n{items}",
	'summary'=>'Total {totalCount, number} Records',
  // 'viewParams'=>['uid'=>"$uid"],
]);
?>
<div id="no-data" class="col-sm-12">No more records</div>

<?php
$count = $dataProvider->count; 
$paging = $dataProvider->pagination;
$total = $paging->totalCount;
?>
<input id="total" type="hidden" value="<?= $total ?>">

<?php
$this->registerJs("
delete tagSearch; 
delete areaSearch; 
delete userSearch;
delete order_id;
$('.edited').fadeOut();
window.onbeforeunload = null;
$('.list.order').on('click', app.openOrder);
var w_pos=0, w_bottom;
var total = Number($('#total').val());
var offset = $paging->pageSize;
var last_query = null;
getSearchList();
", \yii\web\View::POS_END);

Pjax::end();
?>

<input id="uid" type="hidden" value="<?= Yii::$app->user->id ?>">
