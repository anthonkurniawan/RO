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
        'attribute' => 'tagnum',
        'enableSorting' => false
      ],
      [
        'attribute' => 'desct',
        'enableSorting' => false
      ],
      [
        'attribute' => 'area_name',
        'enableSorting' => false
      ],
    ],
    'summary' => '<h5>Show {begin, number}-{end, number} of {totalCount, number} {totalCount, plural, one {record} other {record}}</h5>',
  ]);
?>
