<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

app\assets\SelectizeAsset::register($this);
app\assets\LitePickerAsset::register($this);

$this->title = 'Report Order';
$iden = Yii::$app->user->identity;
$isAdmin = $iden->isAdmin;
$template = $iden->isSysAdmin ? '{view} {update} {delete}' : '{view} &nbsp;{update}';
$count = $dataProvider->count;
?>

<div class="header report-attr">
  <span class="title"> <?= $this->title ?> </span>
  <?= Html::a("New Order", ["create"], ["id"=>"create", "class"=>"btn primary"]) ?>
</div>

<?php
Pjax::begin([
  'id'=>'pjax-con',
  'timeout'=>0,
  'linkSelector'=>'#pjax-con a',
  'formSelector'=>'.gridview-filter-form, #order-form',
  'enablePushState'=>false,
  'enableReplaceState'=>false,
  'options'=>['style'=>'opacity:0;margin:0']
]);

if(!$count) echo "<span class='null-summary'>Showing 0 Result</span>"; 
?>

<?= GridView::widget([
  'id'=>'order-grid',
  'dataProvider'=>$dataProvider,
  'filterModel'=>$searchModel,
  'tableOptions'=>['class'=>'table table-striped table-bordered'],
	'layout'=>"{summary}\n<div id='slider'>{items}</div>\n{pager}",
  'rowOptions'=>function ($model, $key, $index, $widget){
    // $uid = Yii::$app->user->id;
    // $action = ($model->initiator_id==$uid || $model->assign_to==$uid) && $model->status != $model::STATUS_COMPLETE ? 'update' : 'view';
		if($model->canAttach)
			$action = 'update';
		else
			$action = $model->canEdit ? 'update' : 'view';
    $url = \yii\helpers\Url::to(["order/$action", "id"=>$model->id], true);
    return ['data-url'=>$url];
  },
  'columns'=>[
    [
      'attribute'=>'id',
      'filterInputOptions'=>['class'=>'form-control', 'autocomplete'=>'off', 'style'=>'width:99px'],
      'contentOptions'=>['class'=>'center'],
    ],
    [
      'attribute'=>'title',
      'value'=>function ($model, $key, $index, $grid) {
        return (strlen($model->title) > 20 ? substr($model->title, 0, 20).' ..' : $model->title);
      },
      'filterInputOptions'=>['class'=>'form-control', 'autocomplete'=>'off'],
    ],
    [
      'attribute'=>'initiator_name',
      'filterInputOptions'=>['class'=>'form-control', 'autocomplete'=>'off', 'style'=>'width:100px'],
    ],
		[
      'attribute'=>'assignTo_name',
      'filterInputOptions'=>['class'=>'form-control', 'autocomplete'=>'off', 'style'=>'width:100px'],
    ],
		[
      'attribute'=>'region_name',
      'value' =>'region_name',
			'label'=>'Region',
      'filter'=>\app\models\Region::getList(),
    ],
		[
			'attribute'=>'type_name', // 'type',
			'label'=>'Type',
      'filter'=>\app\models\OrderType::getList(),
    ],
    [
      'attribute'=>'priority',
			'value'=>'priorityText',
      'filter'=>$searchModel->priorityList,
			'filterInputOptions'=>['class'=>'form-control'],
			'contentOptions'=>['class'=>'center'],
    ],
		[
      'attribute'=>'status',
      'filter'=>$searchModel->statusList,
			'value'=>'statusText',
      'options'=>['width'=>100],
      'contentOptions'=>['class'=>''],
    ],
		[
			'attribute'=>'quality_ass',
			'label'=>'Quality Assest',
			'filter'=>[1=>"No", 2=>"Yes"],
      'value'=>function ($model, $i){
				return ($model->quality_ass=='2' ? 'Yes': 'No');
      },
			'contentOptions'=>['class'=>'center'],
    ],
		[
			'attribute'=>'ehs_assest',
			'label'=>'EHS Assest',
			'filter'=>\app\models\Ehs::getList(),
			'value'=>'ehs_ass_name',
    ],
		[
      'attribute'=>'tag_num',
      // 'filterInputOptions'=>['class'=>'form-control', 'autocomplete'=>'off'],
    ],
		[
      'attribute'=>'replacement',
      // 'filter'=>$searchModel->statusList,
      'value'=>function ($model, $i) {
				return $model->replacement ? $model->replacement : "<div class='na'>N/A</div>";
			},
			'format'=>'raw',
      'contentOptions'=>['class'=>$searchModel->replacement ? '':'center'],
    ],
    [
      'attribute'=>'create_at',
      'format'=>'date',
      'contentOptions'=>['class'=>'date center'],
      'filter'=>Html::input(null, 'OrderSearch[create_at]', $searchModel->create_at, ['id'=>'d1', 'class'=>"form-control date", 'autocomplete'=>'off']),
    ],
		[
      'attribute'=>'target_dt',
      'format'=>'date',
      'contentOptions'=>['class'=>'date center'],
      'filter'=>Html::input(null, 'OrderSearch[target_dt]', $searchModel->target_dt, ['id'=>'d2', 'class'=>"form-control date", 'autocomplete'=>'off']),
    ],
    [
      'attribute'=>'complete_at',
      // 'format'=>'date',
			'value'=>function ($model, $i) {
				return $model->complete_at ? date('d-m-Y', strtotime($model->complete_at)) : "<div class='na'>N/A</div>";
			},
			'format'=>'raw',
      'contentOptions'=>['class'=>'date center'],
      'filter'=>Html::input(null, 'OrderSearch[complete_at]', $searchModel->complete_at, ['id'=>'d3', 'class'=>"form-control date", 'autocomplete'=>'off']),
    ],
		[
			'attribute' => 'attachment',
			'value' => function ($model, $i) {
				if($model->attachment){
					return $model->attachment;
				}
				return "<div class='na'>N/A</div>";
			},
			'format'=>'raw',
			'enableSorting' => false
		],
		[
			'attribute' => 'Last Comment',
			'value' => function ($model, $i) {
				if($model->comments){
					$cmt = $model->lastComment['comment'];
					return (strlen($cmt) > 20 ? substr($cmt, 0, 20).' ..' : $cmt);
				}
				return "<div class='na'>N/A</div>";
			},
			'format'=>'raw',
			// 'contentOptions' => ['class' => 'center'],
			'enableSorting' => false
		],
		// [
      // 'attribute'=>'update_at',
      // 'filter'=>Html::input(null, 'OrderSearch[update_at]', $searchModel->update_at, ['class'=>"form-control date", 'autocomplete'=>'off']),
      // 'format'=>'date',
      // 'contentOptions'=>['class'=>'date center'],
    // ],
		// [
      // 'attribute'=>'dept_id',
      // 'value' =>'initiator_dept',
      // 'filter'=>\app\models\Dept::getList(),
      // 'filterInputOptions'=>['class'=>'form-control', 'style'=>'width:153px'],
    // ],
		// [
      // 'attribute'=>'tag_desc',
      // 'filterInputOptions'=>['class'=>'form-control', 'autocomplete'=>'off'],
    // ],
    // [
      // 'attribute'=>'area_name',
      // 'filterInputOptions'=>['class'=>'form-control', 'autocomplete'=>'off'],
    // ],
    //'type_order',
    //'detail_desc:ntext',
    // 'ehs_hazard',
    // 'ehs_hazard_risk:ntext',
    [
      'class'=>'yii\grid\ActionColumn',
      'template'=>$template,
      'contentOptions'=>['class'=>'action'],
      'buttonOptions'=>['data-pjax'=>"1"],
      'buttons'=>[
        'delete'=>function ($url, $model, $key) {
          return Html::a("<span class='glyphicon glyphicon-trash text-primary'></span>", $url, [
            'title'=>'Delete',
            'data-pjax'=>'0',
            //'data-confirm'=>"Apakah Anda yakin ingin menghapus item ini?",
            //'data-method'=>"post",
            'onclick'=>"app.hapus(this);"
          ]);
        },
      ],
      'visible'=>$iden->isSysAdmin //true
    ],
  ],
  'pager'=>[
		//'class'=>'yii\widgets\LinkPager'
    'options'=>['class'=>'pagination pull-left'],
    'linkOptions'=>[],
    'firstPageLabel'=>'First', // default: false
    'lastPageLabel'=>'Last', // default: false
    'registerLinkTags'=>false, // default: false
    'hideOnSinglePage'=>true, // default: true
    'maxButtonCount'=>3,
    'prevPageCssClass'=>'prev',
    'nextPageCssClass'=>'next',
    'activePageCssClass'=>'active',
    'disabledPageCssClass'=>'disabled',
    'nextPageLabel'=>'&raquo,',
    'prevPageLabel'=>'&laquo,',
  ],
  'summary'=>'<div class="pull-left">Showing <b>{begin, number}-{end, number}</b> of <b>{totalCount, number}</b> {totalCount, plural, one {item} other {record}}</div> <span class="loader"></span>',
]) ?>

<?php
$this->registerJs("
window.onbeforeunload = null;
$('.container').addClass('full');
app.registerGridSorter();
$('table tbody tr').on('click', app.openOrder);

var grid = $('#order-grid');
var create_at = makeDatePicker(document.getElementById('d1'), grid);
var target_dt = makeDatePicker(document.getElementById('d2'), grid);
var complete_at = makeDatePicker(document.getElementById('d3'), grid);
var el = document.getElementById('slider');
if(el.onwheel ==null){
	if(app.verbose) console.log('> registerSlider');
	var amount = 120;
	el.onwheel = function(){
		var direction = event.detail ? event.detail * -amount : event.wheelDelta;
    var position = $(this).scrollLeft();
    position += direction > 0 ? -amount : amount;
		//if(app.verbose) console.log(`> EVENT:\${event.type}, DELTA wheel:\${event.wheelDelta}, X:\${event.deltaX}, Y:\${event.deltaY}, Z:\${event.deltaZ}, direction:\${direction}, position:\${position}`);
    $(this).scrollLeft(position);
    event.preventDefault();
	}
}
", $this::POS_END);

Pjax::end();

if ($count)
	echo Html::a('Excel', ['index', 'print'=>1], ['id'=>'print', 'class'=>'report-attr btn primary pull-right']);

$this->registerJs("app.adjustPageSize();app.registerBtn();", $this::POS_READY);
?>
</div>
