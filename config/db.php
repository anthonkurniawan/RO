<?php
return [
    'class' => 'yii\db\Connection',
    // 'dsn' => 'mysql:host=localhost;dbname=ro_pfizer',
		// 'dsn' => 'sqlsrv:Server=LNV-WIN10\SQLEXPRESS;Database=RO',  // for local WIN-10
    // 'dsn' => 'mssql:host=localhost;dbname=RO',
    // 'dsn' => 'dblib:host=xp_tds;dbname=RO',  // LINUX remote xp
		// 'dsn' => 'mssqlnative:192.168.56.2;dbname=HISTORIAN',
		'dsn' => 'sqlsrv:Server=192.168.56.3;Database=RO',  // for win2003
    'username' => '',
    'password' => '',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 0, //86400, 0 never expired
    'schemaCache' => 'cache',
];