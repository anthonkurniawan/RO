<?php
use yii\grid\GridView;
?>

<h3><?=$title?></h3>
<?=
		GridView::widget([
    'dataProvider' => $dataProvider,
		'tableOptions' => ['class' => 'print'],
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],
      [
      'attribute' => 'id',
      'enableSorting' => false,
			'contentOptions' => ['align' => 'center'],
			],
			[
				'attribute' => 'title',
				'enableSorting' => false
			],
			[
				'attribute' => 'detail_desc',
				'enableSorting' => false
			],
			[
				'attribute' => 'initiator_name',
				'enableSorting' => false,
				'contentOptions' => ['align' => 'center'],
			],
			[
				'attribute' => 'initiator_dept',
				'enableSorting' => false,
				'contentOptions' => ['align' => 'center'],
			],
			[
				'attribute'=>'assignTo_name',
				'enableSorting' => false
			],
			[
				'attribute' => 'assignTo_dept',
				'enableSorting' => false,
				'contentOptions' => ['align' => 'center'],
			],
			[
				'attribute'=>'region_name',
				'label'=>'Region',
				'enableSorting' => false
			],
			[
				'attribute'=>'type_name',
				'label'=>'Type',
				'enableSorting' => false
			],
			[
				'attribute'=>'priority',
				'value'=>'priorityText',
				'contentOptions' => ['class' => 'center'],
				'enableSorting' => false
			],
			[
				'attribute' => 'tag_num',
				'enableSorting' => false,
			],
			[
				'attribute' => 'area',
				'enableSorting' => false
			],
			
			[
				'attribute' => 'quality_ass',
				'label'=>'Quality Assess',
				'value' => function ($model, $i) {
					return $model->quality_ass==2 ? 'Yes' : 'No';
				},
				'contentOptions' => ['class' => 'center'],
				'enableSorting' => false
			],
			[
				'attribute' => 'mmnr',
				'enableSorting' => false,
			],
			[
				'attribute' => 'ehs_ass',
				'label'=>'EHS Assess',
				'value'=>'ehs_ass_name',
				'enableSorting' => false,
			],
			[
				'attribute' => 'ehs_hazard',
				'value' => function ($model, $i) {
					return $model->hazard_name;
				},
				'enableSorting' => false,
			],
			[
				'attribute' => 'ehs_hazard_risk',
				'value' => function ($model, $i) {
					return $model->ehs_hazard_risk ? $model->ehs_hazard_risk : 'N/A';
				},
				'enableSorting' => false,
			],
			[
				'attribute' => 'replacement',
				'enableSorting' => false,
			],
			[
				'attribute' => 'create_at',
				'format' => 'date',
				'contentOptions' => ['class' => 'center'],
				'enableSorting' => false
			],
			[
				'attribute' => 'target_dt',
				'format' => 'date',
				'contentOptions' => ['class' => 'center'],
				'enableSorting' => false
			],
			[
				'attribute' => 'update_at',
				'format' => 'date',
				'contentOptions' => ['class' => 'center'],
				'enableSorting' => false
			],
			[
				'attribute' => 'complete_at',
				'format' => 'date',
				'contentOptions' => ['class' => 'center'],
				'enableSorting' => false
			],
			[
				'attribute' => 'complete_hours',
				'contentOptions' => ['class' => 'center'],
				'enableSorting' => false
			],
			[
				'attribute' => 'complete_at_sys',
				'format' => 'date',
				'contentOptions' => ['class' => 'center'],
				'enableSorting' => false
			],
			[
				'attribute' => 'statusText',
				'label'=>'Status',
				'enableSorting' => false
			],
			[
				'attribute' => 'Last Comment',
				'value' => function ($model, $i) {
					if($model->comments)
						return $model->lastComment['comment'];
				},
				// 'contentOptions' => ['class' => 'center'],
				'enableSorting' => false
			],
    ],
    'summary' => '<h5>Show {begin, number}-{end, number} of {totalCount, number} {totalCount, plural, one {record} other {record}}</h5>',
  ]);
  ?>
