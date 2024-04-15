<?php
$params = require __DIR__ . '/params.php';
$email = $params['mail'];
$db = require __DIR__ . '/db.php';

$config = [
  'id' => 'basic',
  'basePath' => dirname(__DIR__),
  'name' => 'RO',
  'timeZone' => "Asia/Jakarta",
  //'language' => 'en-US',
  'aliases' => [
    '@bower' => '@vendor/bower-asset',
    '@npm'   => '@vendor/npm-asset',
  ],
  'components' => [
    'assetManager' => [
      'linkAssets' => false, // set false for older windows. make sym-link to assets, instead to hard-copy the asset file
      'appendTimestamp' => true, // refresh file chache from modified time
    ],
    'cache' => [
      'class' => 'yii\caching\FileCache',
    ],
    'user' => [
      'identityClass' => 'app\models\User',
      'enableAutoLogin' => false,
      'authTimeout' => 1800,  // 1800 30 min - in sec
      'on afterLogin' => function ($event) {
        // $event->identity->updateLastLogin();
      },
    ],
    'request' => [
      // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
      'cookieValidationKey' => 'pumQEzCd6pYAXiSyhhQJ6yHdwfvuFwVb',
    ],

    'response' => [
      'class' => 'yii\web\Response',
        'on beforeSend' => function ($event) {
            $response = $event->sender;
            if(Yii::$app->request->isAjax && $response->statusCode==404 && $response->data !== null) {
             $response->format = 'json';
             $response->data = ['name' =>$response->statusText, 'message' => $response->data];
           }
        },
    ],
    'errorHandler' => [
      'errorAction' => 'site/error',
    ],
    'mailer' => [
      'class' => 'yii\swiftmailer\Mailer',
      // send all mails to a file by default.
      // You have to set 'useFileTransport' to false and configure a transportfor the mailer to send real emails.
      'useFileTransport' => false,
      'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => $email['host'],
        'port' => $email['port'],
        'encryption' => $email['encryption'],
        'username' => $email['username'],
				'password'=> $email['password'],
        'streamOptions'=>[
          'ssl'=>[
						'verify_peer'=>false,
						'verify_peer_name'=>false,
						'allow_self_signed'=>true
          ]
        ]
      ],
    ],
    'log' => [
      'traceLevel' => YII_DEBUG ? 3 : 0,
      'targets' => [
        [
          'class' => 'yii\log\FileTarget',
          'levels' => ['error', 'warning'],
        ],
      ],
    ],
    'db' => $db,
    'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false,
      'rules' => [
        'order/create/<region:\d+>'=>'order/create',
        '<controller:\w+>/<action:[\w_-]+>/<id:\d+>'=>'<controller>/<action>',
        '<controller:\w+>/<action:[\w_-]+>/<name:.*>'=>'<controller>/<action>',
        '<controller:\w+>' => '<controller>/index',
      ]
    ],
    'formatter' => [
      'class' => 'yii\i18n\Formatter',
			'defaultTimeZone' => "Asia/Jakarta",
      'nullDisplay' => '-',
			'dateFormat' => 'dd-MM-yyyy',
    ],
  ],
  'params' => $params,
];

# overide when rewrite_mod not available
if(!$params['rewrite_on']){
  $config['components']['urlManager']['enablePrettyUrl'] = false;
  $config['components']['urlManager']['showScriptName'] = true;  // if IIS 6
}

if(YII_ENV_DEV){
  // configuration adjustments for 'dev' environment
  $config['bootstrap'][] = 'log';
  $config['bootstrap'][] = 'debug';
  $config['modules']['debug'] = [
    'class' => 'yii\debug\Module',
		// 'traceLine' => '<a href="phpstorm://open?url={file}&line={line}">{file}:{line}</a>',
    // uncomment the following to add your IP if you are not connecting from localhost.
    //'allowedIPs' => ['127.0.0.1', '::1'],
  ];

  $config['bootstrap'][] = 'gii';
  $config['modules']['gii'] = [
    'class' => 'yii\gii\Module',
    # uncomment the following to add your IP if you are not connecting from localhost.
    // 'allowedIPs' => ['127.0.0.1', '::1'],
    // 'generators' => [
      // 'migrik' => [
        // 'class' => \insolita\migrik\gii\StructureGenerator::class,
        // 'templates' => [
          // 'custom' => '@backend/gii/templates/migrator_schema',
          // 'custom' => 'insolita\migrik\gii\default_structure'
        // ],
      // ],
      // 'migrikdata' => [
        // 'class' => \insolita\migrik\gii\DataGenerator::class,
        // 'templates' => [
          // 'custom' => '@backend/gii/templates/migrator_data',
          // 'custom' => 'insolita\migrik\gii\default_data'
        // ],
      // ],
    // ],
  ];
}

return $config;
