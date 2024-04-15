<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

app\assets\LitePickerAsset::register($this);

$this->title = 'Audit Trail';
$this->params['breadcrumbs'] = $this->context->breadcrumb;

Pjax::begin([
  'id' => 'pjax-con',
  'linkSelector' => '#pjax-con a',
  'formSelector' => '.gridview-filter-form',
  'timeout' => 0,
  'enablePushState' => false,
  'enableReplaceState' => false,
  'options'=>['style'=>'opacity:0']
]);

$this->registerCss(".breadcrumb{margin-bottom:6px;} .grid-view table tr td:last-child{text-align:left}");
$count = $dataProvider->count;
?>

<div class="header">
  <span class="title"> <?= $this->title ?> </span>
</div>

<?php
if (!$count)  echo "<span class='null-summary'>Showing 0 Result</span>";

echo GridView::widget([
  'id'=>'log-grid',
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel,
  'tableOptions' => ['class' => 'table table-striped table-bordered'],
  'columns' => [
    [
      'class' => 'yii\grid\SerialColumn',
      'contentOptions' => ['class'=>'center'],
    ],
		[
      'attribute' => 'date',
      'contentOptions' => ['class' => 'date center'],
      'filter' => Html::input(null, 'LogSearch[date]', $searchModel->date, ['id'=>'date', 'class'=>"form-control text-center", 'autocomplete'=>'off']),
      'options' => ['width' => '200px']
    ],
		[
      'attribute' => 'uname',
      'filterInputOptions'=>['class'=>'form-control', 'autocomplete'=>'off'],
      'options' => ['width' => '140px']
    ],
    'event',
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
  'summary' => '<div class="pull-left">Showing <b>{begin, number}-{end, number}</b> of <b>{totalCount, number}</b> {totalCount, plural, one {item} other {Record}}</div> <span class="loader"></span>',
]);

$this->registerJs("
app.registerGridSorter();
makeDatePicker(document.getElementById('date'), $('#log-grid'));
", $this::POS_END);

Pjax::end();

if ($count)
	echo Html::a('Excel', ['index', 'print'=>1], ['id'=>'print', 'class'=>'btn primary pull-right']);

$this->registerJs("app.adjustPageSize();app.registerBtn();", $this::POS_READY);
?>
