<?php
//error_reporting(0);
$servername = $_SERVER['HTTP_HOST'];
$pathimg=$servername."/";
define("ROOT_PATH",$_SERVER['DOCUMENT_ROOT']);
define("UPLOAD_PATH","http://www.socialchange.company/uploads/");
define("BASE_PATH","http://www.socialchange.company/");

$DB_HOST = 'localhost';
$DB_DATABASE = 'codebrew_social';
$DB_USER = 'root';
$DB_PASSWORD = 'codebrew2015';


define('SMTP_USER','john@socialchange.company');
define('SMTP_EMAIL','john@socialchange.company');
define('SMTP_PASSWORD','Gidget12!');
define('SMTP_NAME','SocialChange');
define('SMTP_HOST','smtpout.secureserver.net');
define('SMTP_PORT','25');