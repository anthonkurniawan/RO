<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
  'id' => 'basic-console',
  'basePath' => dirname(__DIR__),
  'bootstrap' => ['log'],
  'controllerNamespace' => 'app\commands',
  'aliases' => [
    '@bower' => '@vendor/bower-asset',
    '@npm'   => '@vendor/npm-asset',
    '@tests' => '@app/tests',
  ],
  'components' => [
    'cache' => [
      'class' => 'yii\caching\FileCache',
    ],
    'log' => [
      'targets' => [
        [
          'class' => 'yii\log\FileTarget',
          'levels' => ['error', 'warning'],
        ],
      ],
    ],
    'db' => $db,
    'urlManager' => [
      'enablePrettyUrl' => false,
      'showScriptName' => true,
      'scriptUrl'=>'index.php',
      'hostinfo'=>'	http://localhost',
      'baseurl' => '/ro',
      'rules' => [
        'order/create/<region:\d+>' => 'order/create',
        '<controller:\w+>/<action:[\w_-]+>/<id:\d+>' => '<controller>/<action>',
        '<controller:\w+>/<action:[\w_-]+>/<name:.*>' => '<controller>/<action>',

        //'<controller:\w+>s' => '<controller>/index',
        '<controller:\w+>' => '<controller>/index',
        //'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
        'docs' => 'site/docs',
        'docs/<title:[\w_-]+>' => 'site/docs',
        //'report/<unit>/<year:\d{4}>' => 'report/index',
        'report/<unit>' => 'report/index',
        'report/<unit>/<date>' => 'report/index',
        'report/<unit>/<date>/<print>' => 'report/index',
        //'report/<title:[\w_-]+>' => 'report/index',
        //'report/<id:\d+>' => 'report/view',
        'summary/<unit>' => 'summary/index',
      ]
    ],
  ],
  'params' => $params,
  /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
  // configuration adjustments for 'dev' environment
  $config['bootstrap'][] = 'gii';
  $config['modules']['gii'] = [
    'class' => 'yii\gii\Module',
  ];
}

return $config;
