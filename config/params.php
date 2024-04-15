<?php
return [
	'root' => '/ro/', // '/ro/', '/ro/web/'
  'rewrite_on' => 1,
  'allow_self_register' => true,  // set true if user can create account without need to register first by admin
  'confirm_mail_onRegister' => true,
	'pagesize' => 8,   // tr:31px * 8 = 248px
	'ldap_enable' => 0,  # ldap auth login
  'ldap_server_ip' => "192.168.56.3",
	'ldap_server_port' => 389,  // default port (optional)
	'ldap_server_dns'=> 'w2003dns.comx', //'mydns.test.id',
	// 'ldap_dn'=> 'DC=mydns, DC=test, DC=ID',  // DC=w2003dns, DC=com
  // 'username_prefix' => 'w2003dns\\',
	// 'ignore_ldap_fail' => 0,  # ubah ini jika abaikan ldap auth / fail / tidak bisa konek ke ldap
  // 'backup_location' => 'D:\\\\app\\\\PHP\\\\YII2\\\\ro\\\\DB_BACKUP',
	'backup_location' => 'C:\\\\web\\\\ro\\\\DB-BACKUP', // on w2003
  'mail'=>[
    'host' => 'smtp.gmail.com',  // select * from bms3.dbo.emailcfg
    'port' => 587,
		// 'host' =>'148.168.192.85',
		// 'port' => 25, ruswendy.setiadi@pfizer.com
    'username' => 'anthon.awan@gmail.com', //'blaquecry@gmail.com',  ITS USING SANDI APP
    'password'=>'cqrswrbsomtmhddi', //'jgjtrprqoijcfujq', //'nlfqyybtclznxjig',
    'adminEmail' => 'anthon.awan@gmail.com',
    'senderEmail' => 'anthon.awan@gmail.com',
    'senderName' => 'Request Order Team', // support@example.com
		'encryption' => 'tls'
  ],
	'mail_disabled'=>true,
	'pdf_path'=>'C:\wkhtmltopdf\bin\wkhtmltopdf.exe',
];

/*
$ldap = ldap_connect("10.98.195.14");
$ldap = ldap_connect("JAKASPDOM01");
$userid = "apac\\".$username;
$ldap = ldap_connect("10.98.195.14");
$userid = "apac\\".$data['username'];
*/
