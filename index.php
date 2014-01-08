<?php 
session_start();
header("Access-Control-Allow-Origin:*");
require_once('config.php');
require_once 'vendor/autoload.php';
require_once('smarty3/Smarty.class.php');
require_once('db.php');

date_default_timezone_set('Asia/Bangkok');

$app = new \Slim\Slim();

$smarty = new Smarty();
$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');
$smarty->setConfigDir('configs/');
$smarty->setCacheDir('cache/');

$app->post('/feed', function () {
	
	$successCode = $HTTP_POST_VARS[‘successcode’];
	
	$payRef = $HTTP_POST_VARS[‘PayRef’];
	
	$Ref = $HTTP_POST_VARS[‘Ref’];
		
	Echo “OK”;
	
	If ($successCode = "0") {
	
	}else{
		
	}
});

$app->notFound(function () use ($app, $smarty) {
	$app->redirect(".");
	return true;
});

$app->run();