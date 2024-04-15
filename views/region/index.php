<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Region Management';;
$this->params['breadcrumbs'] = $this->context->breadcrumb;
$template = Yii::$app->user->identity->isSysAdmin ? '{view} {update} {delete}' : '{view} &nbsp;{update}';
?>

<div class="header report-attr">
  <span class="title"> <?= $this->title ?> </span>
	<?= Html::a("New Region", ["create"], ["id"=>"create", "class"=>"btn primary"]) ?>
</div>

<?php
Pjax::begin([
  'id' => 'pjax-con',
  'linkSelector' => '#pjax-con a',
  'formSelector' => '.gridview-filter-form, #region-form',
  'timeout' => 0,
  'enablePushState' => false,
  'enableReplaceState' => false,
	'options'=>['style'=>'opacity:0']
]);
$count = $dataProvider->count;
?>

<?php if (!$count)  echo "<span class='null-summary'>Showing 0 Result</span>"; ?>

<?= GridView::widget([
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel,
  'tableOptions' => ['class' => 'table table-striped table-bordered'],
  'columns' => [
    [
      'class' => 'yii\grid\SerialColumn',
      'contentOptions' => ['class'=>'center'],
    ],
    [
      'attribute' => 'nama',
      'filterInputOptions'=>['class'=>'form-control', 'autocomplete'=>'off'],
    ],
		// [
      // 'attribute' => 'id',
      // 'options' => ['width' => '50px'],
      // 'contentOptions' => ['class'=>'center'],
      // 'filterInputOptions'=>['class'=>'form-control', 'autocomplete'=>'off'],
    // ],
    [
      'class' => 'yii\grid\ActionColumn',
			'template'=>$template,
      'contentOptions' => ['class' => 'action'],
      'buttonOptions' => ['data-pjax' => "1"],
      'buttons' => [
        'delete' => function ($url, $model, $key) {
          return Html::a("<span class='glyphicon glyphicon-trash text-primary'></span>", $url, [
            'title' => 'Delete',
            'data-pjax' => '0',
            'onclick' => "app.hapus(this);"
          ]);
        },
      ],
      'visible' => true
    ],
  ],
  'pager' => [
    'options' => ['class' => 'pagination pull-left'],
    'linkOptions' => [],
    'firstPageLabel' => 'First', // default: false
    'lastPageLabel' => 'Last', // default: false
    'registerLinkTags' => false, // default: false
    'hideOnSinglePage' => true, // default: true
    'maxButtonCount' => 3,
    'prevPageCssClass' => 'prev',
    'nextPageCssClass' => 'next',
    'activePageCssClass' => 'active',
    'disabledPageCssClass' => 'disabled',
    'nextPageLabel' => '&raquo,',
    'prevPageLabel' => '&laquo,',
  ],
  'summary' => '<div class="pull-left">Showing <b>{begin, number}-{end, number}</b> of <b>{totalCount, number}</b> {totalCount, plural, one {item} other {regional}}</div> <span class="loader"></span>',
]);

$this->registerJs("app.registerGridSorter();", $this::POS_END);

Pjax::end();

if($count)
	echo Html::a('Excel', ['index', 'print'=>1], ['id'=>'print', 'class'=>'report-attr btn primary pull-right']);
$this->registerJs("app.adjustPageSize();app.registerBtn();", $this::POS_READY);
?>

