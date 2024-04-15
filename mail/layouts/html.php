<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
  <title><?= Html::encode($this->title) ?></title>
  <style>
    div.main {background:#f1f1f1; }
    div.wrap{padding:20px; background:white; }
    span { color: black }
    .header{ font-weight:600 }
    div.section{
      padding-top:14px; margin-top:5px; margin-bottom:5px; border-top: 1px solid #4a90e2;
    }
    .link, footer { font-weight:700 }
    table tr th{ text-align:left }
    .footer { padding:5px; margin-top:20px; background:#d9e6f1; text-align:center }
  </style>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <?= $content ?>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
