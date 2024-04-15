<?php
/*
You may define YII_ENV as one of the following values:

prod: production environment. The constant YII_ENV_PROD will evaluate as true. This is the default value of YII_ENV if you do not define it.
dev: development environment. The constant YII_ENV_DEV will evaluate as true.
test: testing environment. The constant YII_ENV_TEST will evaluate as true.
*/
// comment out the following two lines when deployed to production
set_time_limit(180);
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
