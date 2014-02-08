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

$app->get("/error", function () {
	echo "Error";
});

$app->get("/success", function () {
	echo "Success";
});

$app->get("/cancel", function () {
	echo "Cancel";
});

$app->post('/addorder', function () use ($app) {
	
	$pdo = getDbHandler();
	$sql = "INSERT INTO `order` (product_id, amount, customer_name, email, created_date) VALUES (:product_id, :amount, :customer_name, :email,now()) ";
	$sth = $pdo->prepare($sql);
	$sth->execute(array(':product_id' => $_POST['product_id'], ':amount' => $_POST['amount'], ':customer_name' => $_POST['customer_name'], ':email' => $_POST['email']));
	
	$order_id = $pdo->lastInsertId();
	
	$json = array('order_id' => $order_id);
	
	$app->contentType("application/json");
	echo json_encode($json);
});

$app->get("/product/:product_id", function ($product_id) use ($smarty) {
	$pdo = getDbHandler();
	$sql = "SELECT * FROM product WHERE id = :id ";
	$sth = $pdo->prepare($sql);
	$sth->execute(array(':id' => $product_id));
	
	$row = $sth->fetch(PDO::FETCH_ASSOC);
	
	$smarty->assign('product', $row);
	$smarty->assign('is_donation', 0);
	$smarty->display("payment_form.tpl");
});

$app->get("/donate", function () {
	$smarty->assign('is_donation', 1);
	$smarty->display("payment_form.tpl");
});

$app->get("/", function () {
	echo "ACCU ECOM GW 0.1";
});

$app->notFound(function () use ($app, $smarty) {
	$app->redirect(".");
	return true;
});

$app->run();