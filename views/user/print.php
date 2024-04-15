<?php
use yii\grid\GridView;
?>

<h3><?=$title?></h3>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
		'tableOptions' => ['class' => 'print'],
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],
			[
        'attribute' => 'uname',
        'label' => 'Username',
				'enableSorting' => false
      ],
      [
        'attribute' => 'fullname',
				'enableSorting' => false
      ],
			[
        'attribute' => 'email',
				'enableSorting' => false
      ],
      [
        'attribute' => 'dept_id',
        'value' => 'dept_name',
				'enableSorting' => false
      ],
			[
        'attribute' => 'role',
        'value' => function($model, $i){
					return $model->getRoleText($model->role);
				},
				'enableSorting' => false
      ],
			[
        'attribute' => 'created_at',
        'value' => 'created_at',
				'format'=>'date',
				'enableSorting' => false,
				'contentOptions'=>['style'=>'text-align:center'],
      ],
			[
        'attribute' => 'updated_at',
        'value' => 'updated_at',
				'format'=>'date',
				'enableSorting' => false,
				'contentOptions'=>['style'=>'text-align:center'],
      ],
			[
        'attribute' => 'last_loged',
        'value' => 'last_loged',
				'format'=>'date',
				'enableSorting' => false,
        'contentOptions'=>['style'=>'text-align:center'],
      ],
    ],
    'summary' => '<h5>Show {begin, number}-{end, number} of {totalCount, number} {totalCount, plural, one {record} other {record}}</h5>',
  ]);
?>
