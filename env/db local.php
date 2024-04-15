<?php
return [
    'class' => 'yii\db\Connection',
		
    // 'dsn' => 'mysql:host=localhost;dbname=ro_pfizer',
    // 'username' => 'test',
    // 'password' => 'belang',
    // 'charset' => 'utf8',
		
		//'dsn' => 'sqlsrv:Server=LAPTOP-F05FA61E\SQLEXPRESS;Database=RO',
    //'dsn' => 'sqlsrv:Server=tcp:localhost,1433;Database=RO',
    //'dsn' => 'mssql:host=localhost;dbname=RO',
    'dsn' => 'dblib:host=127.0.0.1;dbname=RO',
    'username' => 'sa',
    'password' => 'belang@9',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 86400,
    'schemaCache' => 'cache',
];
