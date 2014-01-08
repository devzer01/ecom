<?php 
//sets the default timezone for the script
date_default_timezone_set('Asia/Bangkok');

//display all erros for debuging purpose
error_reporting(E_ALL);

//setup some runtime configuration
ini_set('display_errors', 1);
ini_set('error_log', '/var/log/php.log');
ini_set('memory_limit', '-1');

define('PRODUCTION', 'https://ipay.bangkokbank.com/b2c/eng/payment/payForm.jsp');
define('TEST', 'https://psipay.bangkokbank.com/b2c/eng/payment/payForm.jsp');

define('MERCHANT_ID', 2563);

//set this to false when running production in environment
define('SANDBOX', true);
