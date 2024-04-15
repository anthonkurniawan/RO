<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Modal; 
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
// use app\widgets\Alert;
use app\widgets\Notif;
use yii2mod\notify\BootstrapNotifyAsset;
use yii2mod\notify\AnimateAsset;

AppAsset::register($this);
BootstrapNotifyAsset::register($this);
AnimateAsset::register($this);
$rewrite_on = Yii::$app->params['rewrite_on'];
$root = Yii::$app->params['root'];
$pagesize = Yii::$app->params['pagesize'];
$this->registerJs("app.root='$root'; app.rewrite_on=$rewrite_on; app.pagesize=$pagesize; console.log('START APP REWRITE_ON:', app.rewrite_on)", \yii\web\View::POS_HEAD);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="<?=str_replace('index.php', '', Yii::$app->homeUrl)?>favicon.ico" />
  <!--<link rel="icon" type="image/x-icon" href="favicon.ico" />-->
  <?php $this->registerCsrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>

<body>
  <?php $this->beginBody() ?>

  <div class="wrap">
    <?php
    $controlActive = Yii::$app->controller->id;
		$isGuest = Yii::$app->user->isGuest;
		$iden = Yii::$app->user->identity;
    $isAdmin = $iden && $iden->isAdmin;
		$isSysAdmin = $iden && $iden->isSysAdmin;
		$uname = $iden ? $iden->uname : "";
    $class = $isAdmin ? 'navbar-inverse navbar-fixed-top admin' : 'navbar-inverse navbar-fixed-top';
    NavBar::begin([
      'brandLabel'=>Yii::$app->name,
      'brandImage'=>'@web/images/logo.jpg',
      'brandUrl'=>Yii::$app->homeUrl,
			'brandOptions'=>['title'=>'Home'],
      'options'=>['class'=>$class],
    ]);

    echo Nav::widget([
      'options'=>['class'=>'navbar-nav navbar-left'],
      'items'=>[
        ['label'=>'Request Order', 'url'=>['/order'], 'visible'=>!$isGuest, 'active'=>($controlActive=='order')],
				['label'=>'User', 'url'=>['/user'], 'visible'=>$isAdmin, 'active'=>($controlActive=='user')],
        ['label'=>'Tag-Number', 'url'=>['/tag'], 'visible'=>$isAdmin, 'active'=>($controlActive=='tag')],
        ['label'=>'Area', 'url'=>['/area'], 'visible'=>$isAdmin, 'active'=>($controlActive=='area')],
        ['label'=>'Departement', 'url'=>['/departement'], 'visible'=>$isSysAdmin, 'active'=>($controlActive=='departement')],
        ['label'=>'Region', 'url'=>['/region'], 'visible'=>$isSysAdmin, 'active'=>($controlActive=='region')],
				['label'=>'Audit-Trail', 'url'=>['/log'], 'visible'=>$isAdmin, 'active'=>($controlActive=='log')],
      ],
    ]);

    echo Nav::widget([
      'options'=>['class'=>'navbar-nav navbar-right'],
      'items'=>[
				'<li style="margin-right:50px"><a><label class="switch"><input type="checkbox" id="dark-mode"><span class="slider round" onclick="app.switch_theme()"></span></label></a></li>',
				$isGuest ?
					['label'=>'Login', 'url'=>['/site/login']] : 
					(
						$isAdmin ? [
							'label'=>"Admin ($uname)",
							'items'=>[
								['label'=>'Backup', 'url'=>['/tool/backup'], 'visible'=>$isAdmin],
								['label'=>'Test LDAP', 'url'=>['/tool/check_ldap'], 'visible'=>$isSysAdmin],
								['label'=>'Test Email', 'url'=>['/tool/test-mail'], 'linkOptions'=>['target'=>'_blank'], 'visible'=>$isSysAdmin],
								['label'=>'Test XLS', 'url'=>['/tool/print-xls'], 'visible'=>$isSysAdmin],
								['label'=>'Test PDF', 'url'=>['/tool/print-pdf'], 'visible'=>$isSysAdmin],
								['label'=>'Clear Cache', 'url'=>['/tool/flush'], 'linkOptions'=>['target'=>'_blank'], 'visible'=>$isSysAdmin],
								'<li>' . Html::beginForm(['/site/logout'], 'post') 
								. Html::submitButton('Logout', ['class'=>'btn btn-link logout logout_adm'])
								. Html::endForm()
								. '</li>'
							],
							'visible'=>$isAdmin
						] :
						'<li>'
							. Html::beginForm(['/site/logout'], 'post')
							. Html::submitButton('Logout (' . $uname. ')',['class'=>'btn btn-link logout'])
							. Html::endForm()
							. '</li>'
					),
        ['label'=>'Register', 'url'=>['/site/register'], 'visible'=>$isGuest && Yii::$app->params['allow_self_register']],
      ],
    ]);
    NavBar::end();
    ?>

    <?php echo Notif::widget() ?>
		
    <div class="container">
      <?= Breadcrumbs::widget([
        'links'=>isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
      ]) ?>

      <?= $content ?>
			
			<div id="dialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="dialogLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div id="dialog-content" class="modal-body"></div>
					</div>
				</div>
			</div>
			
    </div>
  </div>

  <a id="scrollUp" title="Scroll to top"></a>
  <div class="footer-line-loader"></div>

  <footer class="footer fixed">
    <div class="container">
      <span class="pull-left">&copy; Pfizer Indonesia <?= date('Y') ?></span>
			<i class="edited glyphicon glyphicon-edit pull-right" title="Edited"></i>
      <div id="debug_con" class="pull-right"></div>
    </div>
  </footer>

  <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
