<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AreaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Area Management';
$this->params['breadcrumbs'] = $this->context->breadcrumb;
$template = Yii::$app->user->identity->isSysAdmin ? '{view} {update} {delete}' : '{view} &nbsp;{update}';
?>

<div class="header report-attr">
  <span class="title"> <?= $this->title ?> </span>
  <?= Html::a("New Area", ["create"], ["id"=>"create", "class"=>"btn primary"]) ?>
</div>

<?php
Pjax::begin([
  'id' => 'pjax-con',
  'timeout' => 0,
  'linkSelector' => '#pjax-con a',
  'formSelector' => '.gridview-filter-form, #area-form',
  'enablePushState' => false,
  'enableReplaceState' => false,
	//'options' => ['class' => 'animate__animated animate__fadeIn']
  'options'=>['style'=>'opacity:0']
]);

// $this->params['breadcrumbs'][] = $this->title;
$this->registerCss(".breadcrumb{margin-bottom:6px;}");
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
      'contentOptions' => ['class'=>'center', 'style'=>'width:90px'],
    ],
    [
      'attribute' => 'label_a',
      'filterInputOptions'=>['class'=>'form-control', 'autocomplete'=>'off'],
    ],
    // [
      // 'attribute' => 'dept_id',
      // 'filter' => \app\models\Dept::getDeptList(),
      // 'value' => function ($model, $key, $index, $column) {
        // if($model->dept) return $model->dept->label;
      // },
      // 'options' => ['width' => '200px']
    // ],
    [
      'class' => 'yii\grid\ActionColumn',
      'template' => $template,
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
  'pager' => [ //'class'=>'yii\widgets\LinkPager'
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
  'summary' => '<div class="pull-left">Showing <b>{begin, number}-{end, number}</b> of <b>{totalCount, number}</b> {totalCount, plural, one {item} other {area}}</div> <span class="loader"></span>',
]);

$this->registerJs("app.registerGridSorter();", $this::POS_END);

Pjax::end();

if($count)
	echo Html::a('Excel', ['index', 'print'=>1], ['id'=>'print', 'class'=>'report-attr btn primary pull-right']);
$this->registerJs("app.adjustPageSize();app.registerBtn();", $this::POS_READY);
?>
