<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'User Management';
$this->params['breadcrumbs'] = $this->context->breadcrumb;
$template = Yii::$app->user->identity->isSysAdmin ? '{view} {update} {delete} {reset-password}' : '{view} {update}';
?>

<div class="header report-attr">
  <span class="title"> <?= $this->title ?> </span>
  <?= Html::a("New User", ["create"], ["id"=>"create", "class"=>"btn primary"]) ?>
</div>

<?php
Pjax::begin([
  'id' => 'pjax-con',
  'linkSelector' => '#pjax-con a',
  'formSelector' => '.gridview-filter-form, #user-form',
  'timeout' => 0,
  'enablePushState' => false,
  'enableReplaceState' => false,
	'options'=>['style'=>'opacity:0']
  // 'options' => ['class' => 'animate__animated animate__fadeIn']
]);
$count = $dataProvider->count;
?>

<?php
if (!$count)  echo "<span class='null-summary'>Showing 0 Result</span>";

echo GridView::widget([
  'id' => 'user-grid',
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel,
  'tableOptions' => ['class' => 'table table-striped table-bordered'],
  'columns' => [
    [
      'class' => 'yii\grid\SerialColumn',
      'contentOptions' => ['class'=>'center'],
    ],
    [
      'attribute' => 'uname',
      'filterInputOptions'=>['class'=>'form-control', 'autocomplete'=>'off'],
      'options' => ['width' => '100px']
    ],
    [
      'attribute' => 'fullname',
      'filterInputOptions'=>['class'=>'form-control', 'autocomplete'=>'off'],
    ],
    [
      'attribute' => 'email',
      'format'=> 'email',
      'filterInputOptions'=>['class'=>'form-control', 'autocomplete'=>'off'],
    ],
    [
      'attribute' => 'dept_id',
      'value' =>'dept_name',
      'filter' => \app\models\Dept::getList(),
      'filterInputOptions'=>['class'=>'form-control'],
			'options' => ['width' => '120px']
    ],
    //'signature',
    //'spv',
    //'priv',
    [
      'attribute' => 'role',
      'filter' => \app\models\User::getRoleList(),
      'value' => function ($model, $i) { return $model->getRoleText();},
    ],
		[
      'attribute' => 'status',
      'filter' => \app\models\User::getStatusList(),
			'filterInputOptions'=>['class'=>'form-control', 'style'=>'min-width:70px'],
      'value' => function ($model, $i) {
        return $model->getStatusText($model->status);
      },
    ],
		[
      // 'header' => 'Block status',
      'value' => function ($model) {
       if ($model->status) {
         return Html::a('Disable', ['user/disable', 'id' => $model->id], [
           'class' => 'btn btn-xs btn-danger btn-block',
					 'onclick' => "switchStatus(this, 'disable');"
					 // 'data-pjax' => '1',
           // 'data-method' => 'post',
           // 'data-confirm' => 'Are you sure you want to disable this user?',
         ]);
       } else {
         return Html::a('Activate', ['user/activate', 'id' => $model->id], [
           'class' => 'btn btn-xs btn-primary btn-block',
					 'data-pjax' => '0',
					 'onclick' => "switchStatus(this, 'activate');"
         ]);
       }
      },
      'format' => 'raw',
      'contentOptions' => ['style' => 'text-align:center'],
    ],
    [
      'attribute' => 'created_at',
      'format' => 'date',
      'contentOptions' => ['class'=>'date center'],
    ],
    [
      'attribute' => 'updated_at',
      'format' => 'date',
      'contentOptions' => ['class'=>'date center'],
    ],
    [
      'attribute' => 'last_loged',
      'value' => function ($model) {
        if ($model->last_loged) return date('d-m-Y H:i:s', $model->last_loged);
      },
      'contentOptions' => ['class'=>'date-time center'],
    ],
    [
      'class' => 'yii\grid\ActionColumn',
      'template' => $template,
      'contentOptions' => ['class' => 'action'],
      'buttonOptions' => ['data-pjax' => "1"],
      'buttons' => [
				// 'inactive' => function ($url, $model, $key) {
          // return Html::a("<span class='glyphicon glyphicon-remove text-primary'></span>", $url, [
            // 'title' => 'Inactive',
            // 'data-pjax' => '0',
            // 'onclick' => "app.inactive(this);"
          // ]);
        // },
        'reset-password' => function ($url, $model, $key) {
          return Html::a(
            "<span class='glyphicon glyphicon-qrcode text-primary'></span>",
            $url,
            ['title' => 'Reset Password', 'data-pjax' => '0']
          );
        },
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
    'firstPageLabel' => 'First',
    'lastPageLabel' => 'Last',
    'registerLinkTags' => false,
    'hideOnSinglePage' => true,
    'maxButtonCount' => 3,
    'prevPageCssClass' => 'prev',
    'nextPageCssClass' => 'next',
    'activePageCssClass' => 'active',
    'disabledPageCssClass' => 'disabled',
    'nextPageLabel' => '&raquo,',
    'prevPageLabel' => '&laquo,',
  ],
  'summary' => '<div class="pull-left">Showing <b>{begin, number}-{end, number}</b> of <b>{totalCount, number}</b> {totalCount, plural, one {item} other {Users}}</div> <span class="loader"></span>',
]);

$this->registerJs("
app.registerGridSorter();
$('.container').addClass('full');
", $this::POS_END);

Pjax::end();

$this->registerJs("
function switchStatus(url, mode){
	event.preventDefault();
	if(!confirm('Are you sure to '+mode+' this user?')) return;
  $.post(url, function(data) {
    console.log('DATA:', data);
    if(data.success){
      // app.setUrlHis(url);
      app.setMsg(data.msg, 'info');
      if(app.url_his > 1 && $.pjax.state.url.match(/view/))
				app.pjax_goback(2); //app.pjax_goto(app.url_his[0]);
      else app.pjax_goback();
    }
  });
  return false;
}
", $this::POS_END);

if ($count)
	echo Html::a('Excel', ['index', 'print'=>1], ['id'=>'print', 'class'=>'report-attr btn primary pull-right']);
$this->registerJs("app.adjustPageSize();app.registerBtn();", $this::POS_READY);
?>
