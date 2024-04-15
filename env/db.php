<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'dblib:host=127.0.0.1;dbname=RO',
    'username' => '',
    'password' => '',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 86400,
    'schemaCache' => 'cache',
];
