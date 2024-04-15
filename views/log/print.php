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
        'attribute' => 'event',
				'enableSorting' => false
      ],
      [
        'attribute' => 'uname',
				'enableSorting' => false
      ],
      [
        'attribute' => 'date',
				'enableSorting' => false
      ],
    ],
    'summary' => '<h5>Show {begin, number}-{end, number} of {totalCount, number} {totalCount, plural, one {record} other {record}}</h5>',
  ]);
?>
